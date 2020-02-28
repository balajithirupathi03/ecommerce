<?php

spl_autoload_register(
    function ($className) {
        if (substr($className, -10) == "Controller") {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/Controller/' . $className . '.php';
        } else if (substr($className, -5) == "Model") {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/Model/' . $className . '.php';
        } else {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/Core/' . $className . '.php';
        }
    }
);
