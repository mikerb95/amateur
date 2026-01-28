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
    $routes->post('hacer_reserva/(:num)', 'Usuario::hacer_reserva/$1');
    $routes->post('cancelar_reserva/(:num)', 'Usuario::cancelar_reserva/$1');

    $routes->get('perfil', 'Usuario::perfil');
    $routes->get('perfil/editar', 'Usuario::editarPerfil');
    $routes->post('perfil/actualizar', 'Usuario::actualizarPerfil');

    // ✅ paquete del usuario
    $routes->get('mi-paquete', 'Usuario::mi_paquete');
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

    // =========================
    // 🛠 CRUD PLANES (ADMIN)
    // =========================
    $routes->get('planes', 'Admin::planes');
    $routes->post('planes/guardar', 'Admin::guardarPlan');
    $routes->get('planes/editar/(:num)', 'Admin::editarPlan/$1');
    $routes->post('planes/actualizar/(:num)', 'Admin::actualizarPlan/$1');
    $routes->post('planes/toggle/(:num)', 'Admin::togglePlan/$1');
    $routes->post('planes/eliminar/(:num)', 'Admin::eliminarPlan/$1');

    // =========================
    // 📦 ASIGNAR PLAN POR CÉDULA (ADMIN)  ✅ (tu botón usa /admin/asignar_plan)
    // =========================
    $routes->get('asignar_plan', 'AdminPaquetes::planes');
    $routes->post('asignar_plan/buscar', 'AdminPaquetes::buscarPorCedula');
    $routes->post('asignar_plan/asignar', 'AdminPaquetes::asignarPlan');

    // --- Gestión de usuarios ---
    $routes->get('editar_usuario/(:num)', 'Auth::editar/$1');
    $routes->post('actualizar_usuario/(:num)', 'Admin::actualizar_usuario/$1');
    $routes->post('guardar_usuario', 'Auth::guardar_usuario');
    $routes->get('eliminar_usuario/(:num)', 'Auth::eliminar/$1');
    $routes->get('Crear_usuario', 'Auth::Crear_usuarioAd');

    // --- Gestión de clases ---
    $routes->get('crear_clase', 'Admin::crear_clase');

    // ⚠️ Nota: si tu guardar está en el mismo método, esto sirve.
    // Si tienes otro método tipo guardar_clase(), cámbialo.
    $routes->post('guardar_clase', 'Admin::crear_clase');

    $routes->get('editar_clase/(:num)', 'Admin::editar_clase/$1');
    $routes->post('actualizar_clase/(:num)', 'Admin::actualizar_clase/$1');

    $routes->get('eliminar_clase/(:num)', 'Admin::eliminar_clase/$1');
    $routes->get('toggle_disponibilidad/(:num)', 'Admin::toggle_disponibilidad/$1');

    // --- Gestión de reservas ---
    $routes->get('editar_reserva/(:num)', 'Admin::editar_reserva/$1');
    $routes->get('eliminar_reserva/(:num)', 'Admin::eliminar_reserva/$1');

    // --- Gestión de pagos (ADMIN) ---
    $routes->get('pagos', 'Pagos::index');
    $routes->post('pagos/buscar', 'Pagos::buscar');
    $routes->post('pagos/guardar', 'Pagos::guardar');
    $routes->post('pagos/actualizar', 'Pagos::actualizarEstadoPago');

    // Exportar (ADMIN)
    $routes->get('exportar/excel-pagos', 'Exportar::excelPagos');

    // =========================
    // 📦 PAQUETES (ADMIN)
    // =========================

    // (Opcional) ruta vieja si la sigues usando en algún form:
    $routes->post('paquetes/asignar', 'AdminPaquetes::asignar');

    // paquetes por usuario
    $routes->get('usuarios/(:num)/paquetes', 'AdminPaquetes::index/$1');

    // asignar/crear paquete
    $routes->get('usuarios/(:num)/paquetes/nuevo', 'AdminPaquetes::create/$1');
    $routes->post('usuarios/(:num)/paquetes', 'AdminPaquetes::store/$1');

    // editar paquete
    $routes->get('paquetes/(:num)/editar', 'AdminPaquetes::edit/$1');
    $routes->post('paquetes/(:num)/update', 'AdminPaquetes::update/$1');

    // eliminar paquete
    $routes->post('paquetes/(:num)/delete', 'AdminPaquetes::delete/$1');
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

// Formulario de registro
$routes->get('pagina/registrar', 'Auth::crear_usuario');
$routes->post('pagina/registrar', 'Auth::registrar');
$routes->get('pagina/olvidarContr', 'OlvidarContra::index');
$routes->post('perfil/cambiar_contrasena', 'PerfilController::cambiar_contrasena');
