<?php

require_once 'Core/autoLoader.php';

if (isset($_SERVER['PATH_INFO'])) {
    $path = $_SERVER['PATH_INFO'];
    $splittedPath = explode('/', ltrim($path), 4);
    $role = ucfirst($splittedPath[1]);
    if ($role !== 'Api') {
        $method = isset($splittedPath[2]) ? $splittedPath[2] : exit('----Page Not Found----');
        $parameters = explode('/', ltrim($splittedPath[3]));
        $requiredFile = __DIR__ . '/Controller/' . $role . 'Controller.php';
        if (file_exists($requiredFile)) {
            executor($role, $method, $parameters);
        } else {
            exit('----Page Not Found----');
        }
    } else {
        $requestedController = ucfirst($splittedPath[2]);
        $controllerClass = $requestedController;
        $method = getMethod();
        $parameters = explode('/', ltrim($splittedPath[3]));
        executor($controllerClass, $method, $parameters);
    }
} else {
    header("Location: user/viewLoginPage");
}

function executor($role, $method, $parameters = '')
{
    $controllerClass = $role . 'Controller';
    $controllerObject = new $controllerClass();
    $controllerObject->$method($parameters);
}

function getMethod()
{
    switch ($requestMethod = $_SERVER['REQUEST_METHOD']) {
        case $requestMethod === 'POST':
            return 'create';
            break;
        case $requestMethod === 'PUT':
            return 'update';
            break;
        case $requestMethod === 'DELETE':
            return 'delete';
            break;
        case $requestMethod === 'PATCH':
            return 'update';
            break;
        default:
            return 'getData';
            break;
    }
}
