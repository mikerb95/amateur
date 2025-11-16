<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =========================
// 🏠 RUTA PRINCIPAL
// =========================
$routes->get('/', 'Home::index');


// =========================
// 🧍‍♂️ RUTAS DE USUARIOS
// =========================
$routes->group('usuarios', function($routes) {
    $routes->get('/', 'Usuario::dashboard_usuario');
    $routes->get('dashboard', 'Usuario::dashboard_usuario');
    $routes->get('mis_clases', 'Usuario::mis_clases');
    $routes->get('reservar', 'Usuario::reservar');
    $routes->get('perfil', 'Usuario::perfil');
});


// =========================
// 🛠️ RUTAS DE ADMINISTRADOR
// =========================
$routes->group('admin', ['namespace' => 'App\Controllers'], function($routes) {

    // Dashboard principal
    $routes->get('/', 'Admin::dashboard_admin');
    $routes->get('dashboard_admin', 'Admin::dashboard_admin');

    // Gestión general
    $routes->get('usuarios', 'Admin::usuarios');
    $routes->get('clases', 'Admin::clases');
    $routes->get('reservas', 'Admin::reservas');

    // --- Gestión de usuarios ---
    $routes->get('editar_usuario/(:num)', 'Auth::editar/$1');
    $routes->post('actualizar_usuario/(:num)', 'Admin::actualizar_usuario/$1');
    $routes->get('eliminar_usuario/(:num)', 'Admin::eliminar_usuario/$1');

    // --- Gestión de clases ---
    $routes->get('editar_clase/(:num)', 'Admin::editar_clase/$1');
    $routes->get('eliminar_clase/(:num)', 'Admin::eliminar_clase/$1');

    // --- Gestión de reservas ---
    $routes->get('editar_reserva/(:num)', 'Admin::editar_reserva/$1');
    $routes->get('eliminar_reserva/(:num)', 'Admin::eliminar_reserva/$1');
});

// =========================
// 📄 PÁGINAS DEL SITIO
// =========================
$routes->get('inicio', 'Home::index');
$routes->get('inicio/quienes_somos', 'QuienesSomos::index');
$routes->get('inicio/servicios', 'Servicios::index');
$routes->get('inicio/planes', 'Planes::index');
$routes->get('inicio/contacto', 'Contacto::index');


// =========================
// 🔐 LOGIN
// =========================
$routes->get('login', 'Auth::index');                // vista login
$routes->post('login/acceder', 'Auth::acceder');     // procesar login
$routes->get('logout', 'Auth::salir');               // cerrar sesión

// Mostrar el formulario de registro
$routes->get('pagina/registrar', 'Auth::crear_usuario');

// Procesar el formulario y guardar el usuario
$routes->post('pagina/registrar', 'Auth::registrar');
