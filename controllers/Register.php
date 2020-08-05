<?php
	/**
	 * страница регистрация
	 */
	class Register
	{
		private $view;
		private $model;
		private $page;
		public function __construct($page) {
			$this->view = new View();
			$this->model = new Auth();
			$this->page = $page;
		}
		public function action() {
			if(isset($_POST["reg"]) == true)
			{
				$Registred = $this->model->register($_POST["user"], $_POST["email"], $_POST["password"]);
			}
			$title = "Регистрация | Смертельный союз";
			$description = "";
			$keywords = "";
			$data = ["page" => $this->page, "title" => $title, "description" => $description, "keywords" => $keywords];
			$data["Registred"] = $Registred;
			$this->view->render("views/template.php", "views/register.php", $data);
		}
	}
?>