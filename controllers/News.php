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
		private function is_ajax(){
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                $this->action();
                exit();
            }
        }

		public function add() {
		    $this->is_ajax();
            $res=$this->model->insert_article($_SESSION["userid"], $_POST, $_FILES["image"]);
            echo json_encode($res);
        }
        public function edit() {
            $this->is_ajax();
            $res=$this->model->edit_new($_POST["idnew"], $_POST, $_FILES["image"]);
            echo json_encode($res);
        }
        public function delete() {
            $this->is_ajax();
            $_POST2 = json_decode(file_get_contents('php://input'), true);
            $res = $this->model->delete_article($_POST2["idnew"]);
            echo json_encode($res);
        }
        public function select_edit() {
            $this->is_ajax();
            $_POST2 = json_decode(file_get_contents('php://input'), true);
            $res = $this->model->select_edit($_POST2["idnew"]);
            echo json_encode($res);
        }
	}

?>