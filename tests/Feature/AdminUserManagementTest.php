<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('asigna el rol cliente en el registro publico', function () {
    $response = $this->post(route('register.post'), [
        'name' => 'Cliente Demo',
        'email' => 'cliente@example.com',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ]);

    $response
        ->assertRedirect(route('login'))
        ->assertSessionHas('success');

    $usuario = User::where('email', 'cliente@example.com')->firstOrFail();

    expect($usuario->role)->toBe(User::ROLE_CLIENTE);
    expect($usuario->role_id)->toBe(Role::idForSlug(User::ROLE_CLIENTE));
});

it('permite al admin crear usuarios con el rol seleccionado', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.usuarios.store'), [
        'name' => 'Nuevo Admin',
        'email' => 'nuevo-admin@example.com',
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
        'role_filter' => 'todos',
    ]);

    $response->assertRedirect(route('admin.index', ['tab' => 'usuarios', 'rol' => 'todos']));

    $usuario = User::where('email', 'nuevo-admin@example.com')->firstOrFail();

    expect($usuario->role)->toBe(User::ROLE_ADMIN);
    expect($usuario->role_id)->toBe(Role::idForSlug(User::ROLE_ADMIN));
});

it('muestra mensajes de validacion en espanol al crear usuarios desde admin', function () {
    app()->setLocale('es');
    config()->set('app.locale', 'es');
    config()->set('app.fallback_locale', 'es');

    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
    ]);

    $response = $this->followingRedirects()
        ->from(route('admin.index', ['tab' => 'usuarios']))
        ->actingAs($admin)
        ->post(route('admin.usuarios.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'usuario@example.com',
            'role' => User::ROLE_CLIENTE,
            'password' => '1234',
            'password_confirmation' => '1234',
            'role_filter' => 'todos',
        ]);

    $response
        ->assertOk()
        ->assertSee('El campo contraseña debe tener al menos 8 caracteres.');
});

it('permite al admin editar datos y cambiar la clave de un usuario', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
    ]);

    $usuario = User::factory()->create([
        'role' => User::ROLE_CLIENTE,
        'password' => 'Password123',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.usuarios.update', $usuario), [
        'name' => 'Cliente Editado',
        'email' => 'cliente-editado@example.com',
        'role' => User::ROLE_CLIENTE,
        'password' => 'NuevaPassword123',
        'password_confirmation' => 'NuevaPassword123',
        'role_filter' => 'todos',
    ]);

    $response->assertRedirect(route('admin.index', ['tab' => 'usuarios', 'rol' => 'todos']));

    $usuario->refresh();

    expect($usuario->name)->toBe('Cliente Editado');
    expect($usuario->email)->toBe('cliente-editado@example.com');
    expect($usuario->role)->toBe(User::ROLE_CLIENTE);
    expect($usuario->role_id)->toBe(Role::idForSlug(User::ROLE_CLIENTE));
    expect(Hash::check('NuevaPassword123', $usuario->password))->toBeTrue();
});

it('permite al admin resetear la clave de un usuario', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
    ]);

    $usuario = User::factory()->create([
        'role' => User::ROLE_CLIENTE,
        'password' => 'Password123',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.usuarios.reset-password', $usuario), [
        'role_filter' => 'todos',
    ]);

    $response
        ->assertRedirect(route('admin.index', ['tab' => 'usuarios', 'rol' => 'todos']))
        ->assertSessionHas('generated_password');

    $generatedPassword = app('session.store')->get('generated_password.password');

    expect($generatedPassword)->not->toBeEmpty();

    $usuario->refresh();

    expect(Hash::check($generatedPassword, $usuario->password))->toBeTrue();
});

it('realiza la baja logica y libera el email para reutilizarlo', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
    ]);

    $usuario = User::factory()->create([
        'name' => 'Cliente Eliminable',
        'email' => 'reutilizable@example.com',
        'role' => User::ROLE_CLIENTE,
        'password' => 'Password123',
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.usuarios.destroy', $usuario), [
        'role_filter' => 'todos',
    ]);

    $response->assertRedirect(route('admin.index', ['tab' => 'usuarios', 'rol' => 'todos']));

    $usuarioEliminado = User::withTrashed()->findOrFail($usuario->id);

    expect($usuarioEliminado->trashed())->toBeTrue();
    expect($usuarioEliminado->deleted_email_original)->toBe('reutilizable@example.com');
    expect($usuarioEliminado->email)->not->toBe('reutilizable@example.com');

    $createResponse = $this->actingAs($admin)->post(route('admin.usuarios.store'), [
        'name' => 'Cliente Nuevo',
        'email' => 'reutilizable@example.com',
        'role' => User::ROLE_CLIENTE,
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
        'role_filter' => 'todos',
    ]);

    $createResponse->assertRedirect(route('admin.index', ['tab' => 'usuarios', 'rol' => 'todos']));

    $usuarioNuevo = User::where('email', 'reutilizable@example.com')->firstOrFail();

    expect($usuarioNuevo->trashed())->toBeFalse();
    expect($usuarioNuevo->role)->toBe(User::ROLE_CLIENTE);
    expect($usuarioNuevo->role_id)->toBe(Role::idForSlug(User::ROLE_CLIENTE));
});

it('filtra usuarios por rol en el dashboard de administracion', function () {
    $admin = User::factory()->create([
        'name' => 'Admin Visible',
        'email' => 'admin-visible@example.com',
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
    ]);

    User::factory()->create([
        'name' => 'Cliente Visible',
        'email' => 'cliente-visible@example.com',
        'role' => User::ROLE_CLIENTE,
        'password' => 'Password123',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.index', [
        'tab' => 'usuarios',
        'rol' => User::ROLE_ADMIN,
    ]));

    $response
        ->assertOk()
        ->assertSee('admin-visible@example.com')
        ->assertDontSee('cliente-visible@example.com');
});

it('muestra estado vacio al filtrar clientes sin resultados', function () {
    $admin = User::factory()->create([
        'name' => 'Admin Unico',
        'email' => 'admin-unico@example.com',
        'role' => User::ROLE_ADMIN,
        'password' => 'Password123',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.index', [
        'tab' => 'usuarios',
        'rol' => User::ROLE_CLIENTE,
    ]));

    $response
        ->assertOk()
        ->assertSee('No hay usuarios activos para el filtro seleccionado.')
        ->assertDontSee('admin-unico@example.com');
});