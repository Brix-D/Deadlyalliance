<?php

session_start();
/**
 * автозагрузчик классов, ищет файл класса в паках core,
 * controllers, models, и если найден то подключает его определение
 */
function auto($class_name) {
	if (file_exists("core/" . $class_name . ".php")) {
		include_once "core/" . $class_name . ".php";
	} elseif (file_exists("controllers/" . $class_name . ".php")) {
		include_once "controllers/" . $class_name . ".php";
	} elseif (file_exists("models/" . $class_name . ".php")) {
		include_once "models/" . $class_name . ".php";
	} elseif (file_exists($class_name . ".php")) {
		include_once $class_name . ".php";
	}
}
spl_autoload_register("auto");
$router = new Router();
$router->action();
?>