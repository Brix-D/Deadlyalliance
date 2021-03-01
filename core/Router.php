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
			//$page = str_replace("/", "", $page);
            $page = ltrim($page, $page[0]);
            $page_parts = explode('/', $page);
			if($page_parts[0] == "") {
				$controller_name = "Main";
			} else {
				$controller_name = ucfirst($page_parts[0]);
			}
			if (isset($page_parts[1])) {
                if ($page_parts[1] == "") {
                    $method_name = "action";
                } else {
                    $method_name = $page_parts[1];
                }
            } else {
                $method_name = "action";
            }
			 // метод действия по умолчанию
			$controller = new $controller_name($controller_name); // создает объект контроллера с именем страницы
			if(method_exists($controller, $method_name)) {
				$controller->$method_name(); // если метод действия существует то вызывает его
			}
			else {
				echo "Метод не найден";
			}
		}
	}
?>