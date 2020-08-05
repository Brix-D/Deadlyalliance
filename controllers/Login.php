<?php
	/**
	 * страница логина
	 */
	class Login
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
			if(isset($_POST["log"]) == true)
			{
			$status = $this->model->login($_POST["user"], $_POST["password"]);
			$false_message = $status["false_message"];
			if ($status["logged"] == true) {
					$username = $status["username"];
					$hashlog = crypt($status["logged"], "$23$gdgsdd14");
					$hashperm = crypt($status["permissions"], "$23$gdgsdd14");
					$_SESSION["hashlog"] = $hashlog;
					$_SESSION["hashperm"] = $hashperm;
					setcookie("logged", $hashlog, time()+3600*24);
					setcookie("perm", $hashperm, time()+3600*24);
					setcookie("user", $username, time()+3600*24);
					header('Location: /');
				}
			}
			$title = "Вход | Смертельный союз";
			$description = "";
			$keywords = "";
			$data = ["page" => $this->page, "title" => $title, "description" => $description, "keywords" => $keywords];
			$data["false_message"] = $false_message;
			$this->view->render("views/template.php", "views/login.php", $data);
		}
	}
?>