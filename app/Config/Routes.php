<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Ruta de inicio (página principal o documentación)
$routes->get('/', 'Home::index');

// =====================================================
// GRUPO PARA API (v1) - Con autenticación y CORS
// =====================================================
$routes->group('api/v1', [
    'namespace'  => 'App\Controllers\Api',  // Subcarpeta para APIs
    'filter'     => ['cors', 'auth:api'],  // Filtros aplicados
], function ($routes) {

    // --------------------------
    // Usuarios
    // --------------------------
    $routes->resource('usuarios', [
        'controller' => 'UsuarioController',
        'only'      => ['index', 'show', 'create', 'update', 'delete'],
        'except'    => ['new', 'edit']  // No necesario para API
    ]);

    // --------------------------
    // Roles
    // --------------------------
    $routes->resource('roles', [
        'controller' => 'RolController',
        'only'      => ['index', 'show', 'create', 'update', 'delete']
    ]);

    // --------------------------
    // Asignación de Roles a Usuarios
    // --------------------------
    $routes->resource('userroles', [
        'controller' => 'UserRolController',
        'only'      => ['index', 'create', 'delete']  // No requiere update
    ]);

    // --------------------------
    // Recibos (con endpoint especial para upload)
    // --------------------------
    $routes->resource('recibos', [
        'controller' => 'ReciboController',
        'only'      => ['index', 'show', 'create', 'update', 'delete']
    ]);
    $routes->post('recibos/upload', 'ReciboController::upload');  // Subida de archivos

    // --------------------------
    // Firmas Digitales
    // --------------------------
    $routes->resource('firmas', [
        'controller' => 'FirmaController',
        'only'      => ['index', 'show', 'create', 'update', 'delete']
    ]);

    // --------------------------
    // Documentación Swagger (Opcional)
    // --------------------------
    $routes->get('docs', 'DocumentationController::index');  // Ruta para Swagger UI
});

// =====================================================
// RUTAS PARA VISTAS (No requieren autenticación API)
// =====================================================
$routes->group('', function ($routes) {
    // Formulario de subida de recibos (HTML)
    $routes->get('recibos/upload', 'ReciboController::showUploadForm');

    // Autenticación (login/register) si es necesario
    $routes->get('login', 'AuthController::loginView');
    $routes->post('auth/login', 'AuthController::login');
});

// =====================================================
// CONFIGURACIÓN ADICIONAL
// =====================================================
// Manejo de errores 404
$routes->set404Override('App\Controllers\Errors::show404');

// Habilita Auto-Routing para desarrollo (desactivar en producción)
$routes->setAutoRoute(true);

$routes->get('api/recibos/usuario/(:num)', 'ReciboController::porUsuario/$1');

$routes->post('api/login', 'AuthController::login');
$routes->get('api/logout', 'AuthController::logout');
