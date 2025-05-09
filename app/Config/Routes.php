<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('recibos/guardar', 'Recibos::guardar');
$routes->get('mis-recibos', 'ReciboController::misRecibos');
$routes->get('recibos/subir-masivo', 'ReciboController::vistaSubirMasivo');
$routes->post('recibos/subir-masivo', 'ReciboController::subirMasivo');
$routes->post('recibos/procesar-masivo', 'Recibos::procesarMasivo');
