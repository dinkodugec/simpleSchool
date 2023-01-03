<?php

/**
 * Front controller
 *
 * 
 */



/**
 * Twig
 */
require_once '../vendor/Autoload.php';

/**
 * Autoloader
 */
/* spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
}); */

/**
 * Error and Exception handling
 */
error_reporting(E_ALL); //to see very single error
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

 /* 
Sessions
*/
session_start();

/* 
RewriteEngine On
RewriteCond %{REQUEST_URI} !public/
RewriteRule (.*) public/$1 [L] 
  */

/**
 * Routing
 */
//require 'Core/Router.php';

$router = new Core\Router();



// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('students', ['controller' => 'Students', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('login', ['controller'=>'Login', 'action'=>'new']);



    
$router->dispatch($_SERVER['QUERY_STRING']);