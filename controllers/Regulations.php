<?php
	/**
	 * Контроллер старницы устава
	 */
	class Regulations
	{
		private $view;
		private $model;
		private $page;
		public function __construct($page) {
			$this->view = new View();
			$this->page = $page;
		}
		public function action() {
			$title = "Устав | Смертельный союз";
			$description = "Устав - это сбор правил, обязательных для соблюдения всеми игроками сообщества Смертельный союз";
			$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, Устав гильдии, Пламегор, Flamegor, Орда, Deadly Alliance";
			$data = ["page" => $this->page, "title" => $title, "description" => $description, "keywords" => $keywords];
			$this->view->render("views/template.php", "views/regulations.html", $data);
		}
	}

?>