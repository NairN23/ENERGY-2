# ENERGY - Plataforma de Suplementos Deportivos

Bienvenido al repositorio oficial del proyecto **ENERGY**, desarrollado para la cátedra de Taller 1.

---

## Datos del Proyecto e Integrantes

*   **Título del Proyecto:** ENERGY
*   **Integrantes:** 
    *   Mormina Daniela
    *   Nazer Nair
*   **Link del Repositorio:** [https://github.com/NairN23/ENERGY-2.git](https://github.com/NairN23/ENERGY-2.git)

---

## Credenciales de Acceso de Prueba

Para evaluar los diferentes roles de la plataforma, puede utilizar las siguientes cuentas de prueba:

*   **Perfil Administrador (`admin`):**
    *   **Email:** `admin@energy.test`
    *   **Contraseña:** `12345678`
*   **Perfil Cliente (`cliente`):**
    *   **Email:** `nana@gmail.com`
    *   **Contraseña:** `12345678`

---

## Índice General de Contenidos
1.  **Guía de Instalación y Base de Datos**
    *   Requisitos de Entorno.
    *   Importación de base de datos MariaDB (SQL Backups).
    *   Inicialización y ejecución local.
2.  **Especificación de Requisitos de Software (ERS)**
    *   Alcance del sistema, actores y roles.
    *   Requisitos Funcionales (RF) detallados.
    *   Requisitos No Funcionales (RNF).
    *   Modelo de base de datos (DER).
3.  **Manual de Usuario**
    *   Módulo del Cliente (Catálogo, carrito AJAX, checkout, cancelaciones).
    *   Módulo de Administración (Dashboard, stock rápido, logo, carrusel y usuarios).

---

## 1. Guía de Instalación y Base de Datos

Sigue estos pasos detallados para configurar y ejecutar el proyecto en tu entorno local.

### 1.1 Requisitos del Sistema
Asegúrate de contar con el siguiente software instalado:
*   **PHP** >= 8.3 (con extensiones recomendadas como `pdo_mysql`, `mbstring`, `openssl`, `xml`, `zip`)
*   **Composer** (Gestor de dependencias de PHP)
*   **Node.js** & **npm**
*   **MariaDB** o **MySQL**

### 1.2 Instrucciones para Importar la Base de Datos (MariaDB)
En el repositorio, dentro del directorio `database/backup/`, se encuentran exportadas las tablas con información precargada de prueba. Sigue estos pasos para importarla:

#### Paso A: Crear la Base de Datos Local
1. Abre tu gestor de base de datos (phpMyAdmin, DBeaver, HeidiSQL o consola MySQL/MariaDB).
2. Crea una base de datos vacía llamada `taller_1` con codificación UTF-8:
   ```sql
   CREATE DATABASE taller_1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

#### Paso B: Configurar el archivo de entorno `.env`
1. Copia el archivo de ejemplo para crear tu entorno local:
   ```bash
   cp .env.example .env
   ```
2. Abre el archivo `.env` en tu editor de código y configura tus credenciales de base de datos local:
   ```env
   DB_CONNECTION=mariadb
   DB_HOST=127.0.0.1
   DB_PORT=3306          # Cambiar si tu servidor local utiliza otro puerto (ej: 3307)
   DB_DATABASE=taller_1
   DB_USERNAME=tu_usuario_de_mariadb
   DB_PASSWORD=tu_contraseña_de_mariadb
   ```

#### Paso C: Importar los Archivos SQL
Para recrear la base de datos con toda la información de prueba cargada, debes importar los archivos `.sql` ubicados en `database/backup/`. 

*   **Opción 1: Usando la terminal (Línea de comandos rápida)**
    Puedes concatenar e importar los archivos SQL directamente en tu base de datos mediante el siguiente comando en la raíz del proyecto (reemplaza `root` por tu usuario):
    ```bash
    cat database/backup/*.sql | mysql -u root -p taller_1
    ```
*   **Opción 2: Usando tu Gestor Gráfico (HeidiSQL, phpMyAdmin, DBeaver)**
    Importa los archivos contenidos en `database/backup/`. Para evitar errores de integridad referencial durante la importación, **desactiva temporalmente las restricciones de claves foráneas** (`SET FOREIGN_KEY_CHECKS = 0;` al inicio del proceso y `SET FOREIGN_KEY_CHECKS = 1;` al finalizar) o importa en este orden recomendado:
    1.  `roles_202606212031.sql`
    2.  `users_202606212031.sql`
    3.  `categorias_202606212031.sql`
    4.  `productos_202606212031.sql`
    5.  `pedidos_202606212031.sql`
    6.  `pedido_detalles_202606212031.sql`
    7.  `direcciones_202606212031.sql`
    8.  `carritos_202606212031.sql`
    9.  `welcome_slides_202606212031.sql`
    10. `pagina_contenidos_202606212031.sql`
    11. `mensajes_202606212031.sql`
    12. `migrations_202606212031.sql`

### 1.3 Inicialización de la Aplicación
Una vez importada la base de datos, ejecuta en la consola de comandos de la raíz del proyecto:

1.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```
2.  **Instalar dependencias de Node.js (Frontend):**
    ```bash
    npm install
    ```
3.  **Generar la Clave de Laravel (si no figura en tu `.env`):**
    ```bash
    php artisan key:generate
    ```
4.  **Iniciar el compilador de recursos estáticos (Vite):**
    ```bash
    npm run dev
    ```
5.  **Iniciar el servidor local de Laravel (en otra consola paralela):**
    ```bash
    php artisan serve
    ```

Abre en tu navegador la dirección: [http://127.0.0.1:8000](http://127.0.0.1:8000)

*   **Nota de comando unificado:** Puedes usar `composer run dev` en una sola consola para levantar automáticamente el servidor web de Laravel, el compilador de Vite, la cola de tareas y el visualizador de logs.

---

## 2. Especificación de Requisitos de Software (ERS)

### 2.1 Propósito y Alcance del Sistema
El propósito del sistema es proveer una plataforma e-commerce de suplementos deportivos denominada **ENERGY**. Permite a los clientes interactuar de forma fluida con un catálogo web, gestionar un carrito con persistencia en tiempo real en la base de datos MariaDB, realizar compras seguras con múltiples medios de pago y administrar su historial. Asimismo, dota al equipo administrativo de un Dashboard de control integral para la gestión de productos, combos de productos, stock rápido, usuarios, estados de los pedidos y personalización dinámica del sitio.

### 2.2 Roles y Características de los Usuarios
El sistema implementa dos roles principales definidos en la tabla `roles`:
*   **Cliente (`cliente`):** Rol predeterminado para usuarios registrados. Tienen acceso a la compra de productos, gestión de su carrito y visualización de sus propios pedidos.
*   **Administrador (`admin`):** Rol con privilegios absolutos para gestionar la plataforma, productos, usuarios y contenidos.

### 2.3 Restricciones del Sistema
*   Los administradores no poseen un carrito de compras ni pueden simular flujos de compra para evitar inconsistencias en el panel de control.
*   No se puede vender un producto si su stock es inferior al solicitado (incluye el stock de los productos individuales si se compra un combo).
*   Debe existir al menos un administrador activo en el sistema; el panel prohíbe que el último administrador se elimine a sí mismo o degrade su rol.

### 2.4 Requisitos Funcionales (RF)

#### Módulo de Autenticación y Usuarios
*   **RF1 - Registro de Usuarios:** Permite a los visitantes crear una cuenta ingresando su nombre, email, teléfono y contraseña.
*   **RF2 - Validación de Email por AJAX:** Al registrarse, el sistema verifica en tiempo real mediante una petición AJAX si el email ya se encuentra en uso por un usuario activo.
*   **RF3 - Inicio y Cierre de Sesión:** Mecanismo seguro de inicio de sesión con control de sesiones persistidas en la base de datos.
*   **RF4 - Gestión de Usuarios (Admin):** El administrador puede ver el listado de usuarios (tanto activos como dados de baja lógicamente). Puede editarlos, registrar nuevos usuarios y forzar un restablecimiento de clave temporal autogenerada.
*   **RF5 - Soft Delete de Usuarios e Inactivación:** Al eliminar un usuario, este se oculta lógicamente (`deleted_at`).
*   **RF6 - Reuso de Email de Usuario Eliminado:** Si un usuario es eliminado por Soft Delete, su email es renombrado con un alias temporal (`deleted-user-{id}-{timestamp}@energy.local`), liberando su email original para que pueda ser registrado nuevamente por otra cuenta activa. Si el usuario eliminado es restaurado, recupera su email original si este no está ocupado.

#### Módulo de Catálogo y Combos
*   **RF7 - Catálogo Público:** Muestra los productos activos con stock mayor a cero. Los productos pueden ser individuales o combos.
*   **RF8 - Ficha de Detalle de Producto:** Vista detallada de cada suplemento con su descripción, precio, categoría y estado de stock.
*   **RF9 - Gestión de Combos:** Un administrador puede configurar un producto como un "Combo", asociándole un listado de productos individuales que lo componen.
*   **RF10 - Control de Stock de Combos:**
    *   Si un producto componente del combo se queda sin stock (stock <= 0), el combo completo se desactiva automáticamente de la tienda (`activo = false`).
    *   Si el stock del componente se reabastece y todos los componentes del combo vuelven a tener stock, el combo se reactiva de forma automática (`activo = true`).

#### Módulo de Carrito de Compras
*   **RF11 - Persistencia Inmediata en Base de Datos (AJAX):** Al agregar, cambiar cantidades o eliminar productos del carrito desde el catálogo o la vista de carrito, los cambios se guardan inmediatamente en la tabla `carritos` vinculada al usuario.
*   **RF12 - Control de Cantidades vs. Stock:** La cantidad de un producto en el carrito no puede superar el stock real disponible en MariaDB. Si se intenta incrementar por encima del límite, el sistema lo impide e informa al usuario.
*   **RF13 - Vaciar Carrito:** Permite eliminar todos los artículos del carrito en un solo paso.

#### Módulo de Compras (Checkout) y Pedidos
*   **RF14 - Proceso de Compra (Checkout):** Un cliente puede iniciar la compra de los artículos de su carrito completando sus datos de contacto y entrega.
*   **RF15 - Autoguardado de Direcciones:** Al realizar una compra, la dirección ingresada se guarda automáticamente en el perfil del cliente para futuras compras si no estaba registrada previamente. El cliente puede eliminar direcciones guardadas desde la pantalla de confirmación.
*   **RF16 - Medios de Pago y Lógica de Negocio:**
    *   *Transferencia Bancaria:* Otorga un **10% de descuento** sobre el total del pedido. Permite adjuntar un comprobante en formato **PDF** de hasta 4MB. El pedido se registra en estado *pendiente*.
    *   *Mercado Pago:* Simula el pago e integra un campo para el ID de transacción. El pedido se registra automáticamente en estado *confirmado*.
    *   *WhatsApp:* Redirige los detalles de la compra para coordinar por mensajería. El pedido se registra en estado *pendiente*.
*   **RF17 - Consolidación e Incremento/Decremento de Inventario:** Al confirmar la compra, el stock de los productos comprados (y de los componentes si se compró un combo) se reduce de la base de datos.
*   **RF18 - Historial de Compras:** El cliente tiene una sección ("Mis Compras") donde visualiza sus pedidos cronológicamente y el estado de cada uno.
*   **RF19 - Cancelación de Pedidos por el Cliente:** Un cliente puede cancelar un pedido si su estado es *pendiente*. Esto restaura de forma automática el stock de los productos al inventario y evalúa la reactivación de los combos asociados.
*   **RF20 - Gestión de Pedidos (Admin):** El administrador puede ver los detalles de todos los pedidos recibidos, descargar los comprobantes de transferencia y actualizar su estado (*pendiente, confirmado, enviado, entregado, cancelado*).

#### Módulo de Personalización e Información Dinámica
*   **RF21 - Actualización en Caliente de Páginas:** El administrador puede editar los contenidos textuales de las vistas informativas (Quiénes Somos, Comercialización, Términos) desde el panel.
*   **RF22 - Gestión del Carrusel de Inicio:** El administrador puede añadir imágenes (por archivo local o por URL), asignar títulos y definir el orden de visualización del banner principal.
*   **RF23 - Gestión del Logo de la Marca:** Permite al administrador subir un nuevo logo en formato de imagen, el cual reemplaza el nombre de texto de la marca en toda la aplicación. También puede eliminar el logo personalizado para restaurar el predeterminado.
*   **RF24 - Formulario y Gestión de Contacto:** El público puede enviar mensajes desde la sección contacto. El administrador visualiza estos mensajes en el panel y puede marcarlos como leídos.

### 2.5 Requisitos No Funcionales (RNF)
*   **RNF1 - Seguridad de Datos:** Todas las contraseñas se almacenan encriptadas con el algoritmo `bcrypt` (por medio de la clase `Hash` de Laravel).
*   **RNF2 - Robustez con Soft Deletes:** Se implementa borrado lógico en las tablas clave (`users`, `productos`, `categorias`, `pedidos`, `pedido_detalles`, `carritos`) para asegurar que la eliminación de un recurso no rompa la consistencia de reportes financieros o históricos.
*   **RNF3 - Usabilidad y Responsividad:** El diseño de la interfaz se adapta a dispositivos móviles, tablets y ordenadores mediante estilos responsive.
*   **RNF4 - Integridad Transaccional:** El flujo de compra y la restauración de stock por cancelación de pedidos se realizan dentro de transacciones de base de datos (`DB::transaction`) para evitar inconsistencias en caso de fallos intermedios.

### 2.6 Modelo de Datos (Diagrama de Relaciones)
El sistema cuenta con las siguientes entidades principales en MariaDB:

```
[roles] 1 ------- * [users] (Clave: role_id)
[users] 1 ------- * [carritos] (Clave: user_id)
[users] 1 ------- * [direccions] (Clave: user_id)
[users] 1 ------- * [pedidos] (Clave: user_id)
[categorias] 1 -- * [productos] (Clave: categoria_id)
[productos] 1 --- * [carritos] (Clave: producto_id)
[productos] 1 --- * [pedido_detalles] (Clave: producto_id)
[pedidos] 1 ----- * [pedido_detalles] (Clave: pedido_id)
```

---

## 3. Manual de Usuario

### 3.1 Experiencia del Cliente

#### A. Navegación General
Al ingresar al sitio, el cliente se encuentra con:
1.  **Carrusel Principal:** Presenta imágenes destacadas y eslóganes promocionales gestionados dinámicamente por la administración.
2.  **Sección de Recomendados al Azar:** Muestra hasta 12 productos que tienen stock disponible de forma aleatoria.
3.  **Menú (Navbar):** Permite acceder al Catálogo, Quiénes Somos, Comercialización (métodos de pago y envíos), Contacto, e iniciar sesión o registrarse.

#### B. Catálogo y Detalle del Producto
*   **Ver Productos:** En la sección "Catálogo", se listan todos los suplementos activos con stock disponible. Se muestra su precio, categoría y si corresponden a un "Combo".
*   **Detalle:** Al hacer clic en un producto se accede a su ficha detallada, que incluye la descripción del suplemento y el stock disponible.

#### C. Uso del Carrito de Compras
El carrito está diseñado con tecnología **AJAX** para que las operaciones se guarden instantáneamente en la base de datos:
*   **Agregar:** Desde el catálogo, al pulsar "Agregar al Carrito", el producto se añade con cantidad 1.
*   **Modificar Cantidades:** Dentro de la página del carrito (`/carrito`), puedes aumentar o disminuir las cantidades de cada artículo con los botones `+` y `-`.
    *   *Nota:* El sistema valida el stock en tiempo real. Si intentas agregar una cantidad superior al stock físico, recibirás una alerta y no se te permitirá exceder el límite.
*   **Quitar un Producto:** Al presionar el botón de eliminar (icono de basura) al lado del producto, se elimina del carrito de inmediato.
*   **Vaciar Carrito:** El botón "Vaciar Carrito" elimina por completo todos los suplementos seleccionados.

#### D. Proceso de Confirmación de Compra (Checkout)
Al hacer clic en "Iniciar Compra" desde el carrito, se abre el formulario de Checkout (`/compra/confirmar`):
1.  **Datos de Entrega:** Debes ingresar tu nombre, teléfono, correo y dirección exacta donde deseas recibir el pedido.
2.  **Direcciones Guardadas:** Si estás autenticado y ya realizaste compras previas, el sistema listará tus direcciones anteriores para seleccionarlas con un solo clic. Si deseas limpiar tu lista, puedes eliminar direcciones presionando el botón "Eliminar dirección".
3.  **Medios de Pago:**
    *   *Transferencia Bancaria (Descuento del 10%):* Aplica automáticamente una reducción del 10% sobre el total. Permite adjuntar tu comprobante de transferencia en formato **PDF** de hasta 4MB.
    *   *Mercado Pago:* Solicita ingresar el ID de pago de la transacción realizada y confirma el pedido automáticamente.
    *   *WhatsApp:* Registra el pedido en el sistema y te permite coordinar el pago directamente con el comercio por mensajería instantánea.

#### E. Historial de Compras y Cancelación
Desde el menú del usuario, puedes acceder a la sección "Mis Compras" (`/mis-compras`), donde podrás:
*   Ver el listado de todos tus pedidos ordenados cronológicamente.
*   Consultar el total abonado, el medio de pago seleccionado y el estado de cada pedido.
*   **Cancelar un Pedido:** Si tu pedido aún figura en estado **Pendiente**, aparecerá el botón **"Cancelar Pedido"**. Al pulsarlo, el pedido pasa a estado *cancelado*, se libera la reserva de productos y el stock se restituye automáticamente al catálogo de la tienda para que otros clientes puedan comprarlo.

---

### 3.2 Experiencia del Administrador
El panel administrativo está protegido y solo es accesible para usuarios con rol `admin` a través de la ruta `/admin/dashboard`.

#### A. Tablero Principal (Dashboard)
El panel unifica en una sola vista toda la gestión de la tienda mediante pestañas (Tabs):
*   **Estadísticas Rápidas:** En la parte superior se visualiza el total de productos, categorías creadas, usuarios registrados (desglosados por administradores y clientes), cantidad de pedidos totales y mensajes de contacto sin leer.

#### B. Gestión de Inventario (Productos y Combos)
En la pestaña **"Productos"**:
*   **Filtros y Búsqueda:** Lista todos los suplementos del sistema (incluidos los inactivos o sin stock).
*   **Crear / Editar Producto:** Abre el formulario de alta/modificación de productos donde se configuran:
    *   Nombre, precio y descripción del suplemento.
    *   Categoría (se puede seleccionar una existente o escribir una nueva categoría que se creará dinámicamente en MariaDB).
    *   Subir imagen del producto (si no se sube ninguna, se asigna una imagen por defecto).
    *   **Es Combo:** Si se activa esta casilla, se habilita un selector múltiple para elegir qué productos individuales forman parte del combo.
*   **Control de Stock Rápido:** Junto a cada producto de la lista, hay botones `+` y `-` para aumentar o disminuir el stock en 1 unidad con un solo clic.
    *   *Sincronización Automática:* Si el stock de un producto individual disminuye a cero, se marca automáticamente como inactivo. Si este producto formaba parte de algún combo, dicho combo también se desactivará para evitar la venta de combos incompletos.
*   **Eliminar Producto:** Presionando el botón "Eliminar" se da de baja lógica al producto preservando el historial de compras.

#### C. Gestión de Pedidos y Ventas
En la pestaña **"Compras"**:
*   Muestra el listado de todas las órdenes de compra ingresadas en la plataforma.
*   **Ver Detalle:** Permite abrir el modal con el detalle del pedido (nombre del cliente, dirección, teléfono, correo, productos comprados, cantidades y total).
*   **Comprobantes PDF:** Si el cliente pagó por transferencia y adjuntó su comprobante PDF, podrás descargarlo directamente desde el detalle para verificar el pago en tu cuenta bancaria.
*   **Cambiar Estado:** Permite actualizar el flujo logístico del pedido seleccionando entre los estados: *Pendiente*, *Confirmado*, *Enviado*, *Entregado* o *Cancelado*.

#### D. Gestión de Usuarios
En la pestaña **"Usuarios"**:
*   **Listar Usuarios:** Muestra todos los usuarios de la base de datos (tanto activos como dados de baja lógicamente). Permite filtrar por rol (Administradores o Clientes) y buscar por nombre o email.
*   **Crear Usuario:** Permite dar de alta cuentas de prueba u otros administradores rellenando el formulario con contraseña.
*   **Editar y Cambiar Rol:** Permite modificar los datos básicos de un usuario o cambiar su rol de administrador a cliente (y viceversa).
*   **Resetear Contraseña:** Si un usuario olvida sus datos, el botón de reset genera una **contraseña temporal autocompartida** en pantalla que el administrador puede copiar y enviarle al usuario para que vuelva a ingresar.
*   **Inactivar (Soft Delete) y Activar:**
    *   Al presionar "Dar de baja", el usuario se desactiva y no puede iniciar sesión. Su correo electrónico se libera automáticamente mediante un alias para que pueda volver a usarse en un nuevo registro.
    *   Si se pulsa "Reactivar", el usuario se restaura. Si su correo original no fue tomado por otra cuenta activa en ese lapso de tiempo, recupera su dirección de correo original automáticamente.

#### E. Personalización del Sitio y Carrusel
*   **Banner (Pestaña "Carrusel"):** Permite añadir nuevos slides a la página de inicio. Debes ingresar un título en blanco, un título destacado en rojo, el número de orden y la imagen (cargando un archivo local o pegando un enlace URL de imagen externa). También permite eliminar slides existentes.
*   **Logo de Marca:** En la cabecera del panel administrativo, el administrador puede subir una imagen de logo corporativo. El sistema la guardará y reemplazará automáticamente el título de texto por la imagen del logo en todo el sitio web. Si se elimina el logo personalizado, la web volverá a mostrar el nombre de texto por defecto.

#### F. Páginas de Contenido Informativo
En la pestaña **"Páginas"**:
*   Permite editar directamente en caliente los textos de las páginas secundarias de la web:
    *   *Quiénes Somos:* Misión, visión e historia del comercio.
    *   *Comercialización:* Explicación de los envíos, políticas de devolución y métodos de pago.
    *   *Términos:* Términos y condiciones de uso del sitio.
*   Cualquier cambio guardado aquí impactará inmediatamente en el diseño público sin necesidad de editar código fuente HTML.

#### G. Mensajes de Contacto
En la pestaña **"Mensajes"**:
*   Bandeja de entrada donde se listan las consultas enviadas por el formulario de contacto público.
*   Muestra el remitente, email, teléfono y el cuerpo del mensaje.
*   **Marcar como Leído:** Permite clasificar las consultas atendidas para mantener la bandeja organizada.
