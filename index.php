<?php

// Единая точка входа или FRONT CONTROLLER

// 1. Общие настройки

    // отображение ошибок
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

// Открываем сессию
    session_start();

// 2. Подключение файлов системы

    // полный путь к файлу на диске
    define('ROOT', dirname(__FILE__));
    require_once(ROOT . '/components/Autoload.php');



// 3. Установка соединения с БД


// 4. Вызов Router

    //Вызываем экземпляр класса Router и его метод run()
    $router = new Router();
    $router->run();