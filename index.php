<?php
    require './Core/Database.php';
    require './Models/BaseModel.php';
    require './Controllers/BaseController.php';
    require './Helper/index.php';
    require './Helper/view.php';
    session_start();
    $controllerName = ucfirst((strtolower($_REQUEST['controller']) ?? 'welcome') . 'Controller');
    $actionName = $_REQUEST['action'] ?? 'index';
    
    require "./Controllers/$controllerName.php";
    
    $controllerObject = new $controllerName;

    $controllerObject->$actionName();
?>