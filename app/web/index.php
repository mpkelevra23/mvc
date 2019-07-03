<?php

/*
 *  Общие настройки
 *  Включаем отображение ошибок на время разработки
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
 *  Подключение файлов системы
 */
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Router.php');

$router = new Router();
$router->run();