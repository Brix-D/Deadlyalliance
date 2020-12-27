<?php
	/**
	 * Контроллер страницы новости
	 */
	class News
	{
		
		private $view;
		private $model;
		private $page;
		public function __construct($page) {
			$this->view = new View();
			$this->model = new Articles();
			$this->page = $page;
		}
		public function action() {
			$result = $this->model->select_news(); // запрос всей нововстей из БД
			$title = "Новости | Смертельный союз";
			$description = "Последние новости сообщества Смертельный союз WoW Classic";
			$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, Новости гильдии, Пламегор, Flamegor, Орда, Deadly Alliance";
			$Data = ["page" => $this->page, "title" => $title, "description" => $description, "keywords" => $keywords];
			$Data["news"] = $result;
			$this->view->render("views/template.php", "views/news.php", $Data);
		}
	}

?>