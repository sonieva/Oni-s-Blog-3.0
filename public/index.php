<?php
// Santi Onieva
require_once __DIR__ . '/../vendor/autoload.php';

use Utils\Router;
use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configura la zona horària i el local de la pàgina per a la zona horària de Madrid i el català
ini_set('date.timezone', 'Europe/Madrid');
date_default_timezone_set('Europe/Madrid');
setlocale(LC_ALL, 'ca_ES.UTF-8');

// Definir les rutes de la web
require_once __DIR__ . '/../routes/web.php';

// Definir les rutes de l'API
require_once __DIR__ . '/../routes/api.php';

// Ejecutar el router
Router::dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);