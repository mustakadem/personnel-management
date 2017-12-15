<?php
require_once '../vendor/autoload.php';

use Phroute\Phroute\RouteCollector;
use Illuminate\Database\Capsule\Manager as Capsule;

session_start();

$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

$baseUrl = $_SERVER['HTTP_HOST'] . $baseDir;
$protocol = (strpos($baseUrl, 'heroku')) ? "https://" : "http://";
$baseUrl = $protocol . $baseUrl;
define('BASE_URL', $baseUrl);

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
    $dotenv->load();
}

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$route = $_GET['route'] ?? "/";

$router = new RouteCollector();

$router->filter('auth', function () {
    if (!isset($_SESSION['userId'])) {
        header('Location: ' . BASE_URL);
        return false;
    }
});

//Filtro para aplicar a rutas a USUARIOS AUTENTICADOS
// en el sistema
$router->group(['before' => 'auth'], function ($router) {
    $router->get('/employed/add', ['\App\Controllers\EmployedController', 'getAdd']);
    $router->post('/employed/add', ['\App\Controllers\EmployedController', 'postAdd']);
    $router->get('/employed/list', ['\App\Controllers\EmployedController', 'getList']);
    $router->get('/employed/edit/{id}', ['\App\Controllers\EmployedController', 'getEdit']);
    $router->put('/employed/edit/{id}', ['\App\Controllers\EmployedController', 'putEdit']);
    $router->get('/employed/index/{id}',['\App\Controllers\EmployedController','getIndex']);
    $router->delete('/employed/dlt',['\App\Controllers\EmployedController','deleteDlt']);
    $router->post('/employed/search',['\App\Controllers\EmployedController','postSearch']);
    $router->get('/departament/add',['\App\Controllers\DepartamentController','getAdd']);
    $router->post('/departament/add',['\App\Controllers\DepartamentController','postAdd']);
    $router->get('/departament/list',['\App\Controllers\DepartamentController','getList']);
    $router->get('/departament/edit/{id}',['\App\Controllers\DepartamentController','getEdit']);
    $router->put('/departament/edit/{id}',['\App\Controllers\DepartamentController','putEdit']);
    $router->get('/departament/index/{id}',['\App\Controllers\DepartamentController','getIndex']);
    $router->delete('/departament/dlt',['\App\Controllers\DepartamentController','deleteDlt']);
    $router->get('/departament/404',['\App\Controllers\DepartamentController','get404']);
    $router->get('/user/home',['\App\Controllers\UserController','getHome']);
    $router->get('/user/logout',['\App\Controllers\UserController','getLogout']);
    $router->get('/user/conf',['\App\Controllers\UserController','getConf']);

});

// Filtro para aplicar a rutas a USUARIOS NO AUTENTICADOS
// en el sistema
$router->filter('noAuth', function(){
    if( isset($_SESSION['userId'])){
        header('Location: '. BASE_URL);
        return false;
    }
});

$router->group(['before' => 'noAuth'], function ($router){
    $router->get('user/login', ['\App\Controllers\UserController', 'getLogin']);
    $router->post('user/login', ['\App\Controllers\UserController', 'postLogin']);
    $router->get('user/registro', ['\App\Controllers\UserController', 'getRegistro']);
    $router->post('user/registro', ['\App\Controllers\UserController', 'postRegistro']);
});

// Rutas sin filtros


$router->controller('/api', App\Controllers\ApiController::class);
$router->get('/',['\App\Controllers\HomeController', 'getIndex']);

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];


$response = $dispatcher->dispatch($method, $route);

// Print out the value returned from the dispatched function
echo $response;
