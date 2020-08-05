<?php
	/**
	 * Выход
	 */
	class Logout
	{
		private $model;
		public function __construct($page) {
			$this->model = new Auth();
		}
		public function action() {
			$this->model->logout();
			header('Location: /');
		}
	}

?>