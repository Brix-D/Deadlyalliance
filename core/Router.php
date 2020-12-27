<?php
	/**
	 * Маршрутизатор страниц
	 */
	class Router
	{
	    /**
	    * Метод основного действия класса
         */
		public function action() {
			$page = $_SERVER["REQUEST_URI"]; // получает путь от корня сайта
			$page = str_replace("/", "", $page);
			if($page == "") {
				$controller_name = "Main";
			} else {
				$controller_name = ucfirst($page);
			}
			$method_name = "action"; // метод действия по умолчанию
			$controller = new $controller_name($page); // создает объект контроллера с именем страницы
			if(method_exists($controller, $method_name)) {
				$controller->$method_name(); // если метод действия существует то вызывает его
			}
			else {
				echo "Метод не найден";
			}
		}
	}
?>