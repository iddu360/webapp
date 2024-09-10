<?php

/**
 * Front controller
 * User: Alexander Korus
 * Date: 2019-02-17
 */


/*
 * Laden des Autoloaders
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/*
 * Error Handling aktivieren
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$router = new Core\Router();

/*
 * GET Routes
 * Fügt GET Routen zum Router hinzu, um beim Aufruf die entsprechenden Actions im Controller zu identifizieren.
 */
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('imprint', ['controller' => 'Home', 'action' => 'imprint']);
$router->add('policy', ['controller' => 'Home', 'action' => 'dataPolicy']);
$router->add('signin', ['controller' => 'Authentication', 'action' => 'signIn']);
$router->add('signup', ['controller' => 'Authentication', 'action' => 'signUp']);
$router->add('category', ['controller' => 'Category', 'action' => 'index']);
$router->add('category/{id:\d+}', ['controller' => 'Category', 'action' => 'index']);
$router->add('category/{id:\d+}/search', ['controller' => 'Category', 'action' => 'search']);
$router->add('post/search', ['controller' => 'Post', 'action' => 'search']);
$router->add('newpost', ['controller' => 'Post', 'action' => 'newPost']);



/*
 * POST Routes
 * Fügt POST Routen zum Router hinzu, um beim Aufruf die entsprechenden Actions im Controller zu identifizieren.
 * $_POST Variable ist verfügbar
 */
$router->add('login', ['controller' => 'Authentication', 'action' => 'login']);
$router->add('register', ['controller' => 'Authentication', 'action' => 'register']);
$router->add('logout', ['controller' => 'Authentication', 'action' => 'logout']);
$router->add('post/{id:\d+}', ['controller' => 'Post', 'action' => 'index']);
$router->add('post/add', ['controller' => 'Post', 'action' => 'addPost']);


/*
 * Boostrap, den URL Query String an den Router übergeben, um den entsprechenden Controller und Action aufzurufen
 */
$router->dispatch($_SERVER['QUERY_STRING']);
