<?php
/**
 * This is the main index file, best not to touch this...
 */

session_start();
require_once('../lib/helper_functions.php');

//See if we have some info :-)
if (!isset($_REQUEST['page']))
    $controller = 'Home';
else
    $controller = $_REQUEST['page'];

//Set the controllername
$controllerName = ucfirst(strtolower($controller)).'Controller';

//Check if controller file exists
if (!file_exists('../controllers/'.$controllerName.'.php'))
    die('No such controller....'.$controllerName);

//Find the controller and 'run' it.
require_once('../controllers/'.$controllerName.'.php');
new $controllerName($controller);