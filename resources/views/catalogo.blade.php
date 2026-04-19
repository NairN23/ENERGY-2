<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Catálogo de Suplementos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fcfaf8; /* Fondo apenas cálido para que resalten las tarjetas blancas */
        }

        /* Banner principal del catálogo con imagen oscurecida */
        .catalog-banner {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1200');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
        }
        .catalog-banner h2 {
            font-weight: 800;
            font-style: italic;
            color: white;
            text-transform: uppercase;
        }

        /* Botones de categorías con estilo de "pastilla" redondeada */
        .btn-category {
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 8px 20px;
            text-transform: uppercase;
            background-color: white;
            border: 1px solid #eee;
            color: #333;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            transition: 0.3s;
        }
        .btn-category.active, .btn-category:hover {
            border: 1px solid #ff0000;
            color: #ff0000;
        }

        /* Tarjetas de Producto: Sin bordes y con sombra suave */
        .product-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background-color: white;
        }
        .product-card:hover {
            transform: translateY(-5px); /* Efecto de elevación */
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        /* Contenedor gris para la foto del producto */
        .img-container {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Etiquetas de categoría y títulos */
        .category-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
        }
        .product-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #111;
            height: 38px; /* Altura fija para que todas las cards midan lo mismo */
            overflow: hidden;
        }

        /* Estilos de la barra de navegación */
        .nav-link { color: #333 !important; transition: 0.2s; font-size: 0.85rem; }
        .nav-link:hover { color: #ff0000 !important; }
    </style>
</head>
<body>

    <!-- Reutiliza el navbar comun para mantener el mismo menu y comportamiento responsive. -->
    @include('partials.navbar')

    <div class="container py-5">
        <div class="catalog-banner mb-5 shadow-sm">
            <h2>Nuestros <span class="text-danger">Suplementos</span></h2>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            <button class="btn btn-category active">Todos</button>
            <button class="btn btn-category">Proteínas</button>
            <button class="btn btn-category">Creatinas</button>
            <button class="btn btn-category">Ganadores</button>
            <button class="btn btn-category">Quemadores</button>
            <button class="btn btn-category">BCAA</button>
            <button class="btn btn-category">Vitaminas</button>
            <button class="btn btn-category">Pre-Entreno</button>
        </div>

        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4 mb-5">
            
            <div class="col">
                <div class="card product-card h-100 p-2 shadow-sm">
                    <div class="img-container">
                        <img src="https://via.placeholder.com/150" class="img-fluid" alt="Proteina">
                    </div>
                    <div class="card-body p-2 mt-2">
                        <div class="category-label">Proteínas</div>
                        <h6 class="product-title mt-1">Proteína Star Nutrition 2lb</h6>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price-tag fw-bold">$38.500</span>
                            <button class="btn btn-danger btn-sm rounded-2 fw-bold" style="width: 32px; height: 32px;">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card product-card h-100 p-2 shadow-sm">
                    <div class="img-container">
                        <img src="https://via.placeholder.com/150" class="img-fluid" alt="Creatina">
                    </div>
                    <div class="card-body p-2 mt-2">
                        <div class="category-label">Creatina</div>
                        <h6 class="product-title mt-1">Creatina Micronizada HTN</h6>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price-tag fw-bold">$24.000</span>
                            <button class="btn btn-danger btn-sm rounded-2 fw-bold" style="width: 32px; height: 32px;">+</button>
                        </div>
                    </div>
                </div>
            </div>

            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>