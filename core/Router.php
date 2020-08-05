<?php
	/**
	 * Маршрутизатор страниц
	 */
	class Router
	{
		public function action() {
			$page = $_SERVER["REQUEST_URI"];
			$page = str_replace("/", "", $page);
			if($page == "") {
				$controllerName = "Main";
			} else {
				$controllerName = ucfirst($page);
			}
			$methodName = "action";
			$controller = new $controllerName($page);
			if(method_exists($controller, $methodName)) {
				$controller->$methodName();
			}
			else {
				echo "Метод не найден";
			}
		}
	}
?>