<?php
	/**
	 * Контроллер главной старницы
	 */
	class Main
	{
		private $view;
		private $model;
		private $page;
		public function __construct($page) {
			$this->view = new View();
			$this->page = $page;
		}
		public function action() {
			$title = "Гильдия Смертельный союз | сообщество World of Warcraft";
			$description = "Гильдия Смертельный союз - это сплоченное сообщество игроков World of Warcraft, основные направления которого это прохождение сложных рейдов, участие в PvP аспектах игры. Сообщество основано в 2010 году, и сейчас находится на сервере Пламегор-Орда";
			$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, вступить в гильдию WoW, Пламегор, Flamegor, Орда, Deadly Alliance";
			$data = ["page" => $this->page, "title" => $title, "description" => $description, "keywords" => $keywords];
			$this->view->render("views/template.php", "views/main.html", $data);
		}
	}

?>