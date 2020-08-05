<?php
	/**
	 * Контроллер старницы вступить
	 */
	class Joinus
	{
		private $view;
		private $model;
		private $page;
		public function __construct($page) {
			$this->view = new View();
			$this->page = $page;
		}
		public function action() {
			$title = "Вступить | Смертельный союз";
			$description = "Гильдия Смертельный союз проводит набор игроков в PvE-состав";
			$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, вступить в гильдию WoW, Пламегор, Flamegor, Орда, Deadly Alliance";
			$data = ["page" => $this->page, "title" => $title, "description" => $description, "keywords" => $keywords];
			$this->view->render("views/template.php", "views/joinus.html", $data);
		}
	}

?>