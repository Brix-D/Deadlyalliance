<?php

session_start();
function auto($className) {
	if (file_exists("core/" . $className . ".php")) {
		include_once "core/" . $className . ".php";
	} elseif (file_exists("controllers/" . $className . ".php")) {
		include_once "controllers/" . $className . ".php";
	} elseif (file_exists("models/" . $className . ".php")) {
		include_once "models/" . $className . ".php";
	} elseif (file_exists($className . ".php")) {
		include_once $className . ".php";
	}
}
spl_autoload_register("auto");
$router = new Router();
$router->action();
?>