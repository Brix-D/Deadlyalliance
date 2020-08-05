<?php
	/**
	 * Модель статей
	 */
	class Articles
	{
		private $connection;
		public function __construct()
		{
			$this->connection = new PDO('mysql:host=localhost; dbname=deadlyalliance; charset=utf8', 'mysql', 'mysql');
		}
		public function selectNews() {
			$query = $this->connection->prepare("SELECT articles.id,`id_user`, `title`, `picture`, `text`, `date`, `username` FROM articles INNER JOIN users ON articles.id_user = users.id ORDER BY `date` DESC;");
			$query->execute();
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		public function insertArticle($id_user, $data, $file) {
			//var_dump($data);
			if(empty($data["header"]) || empty($data["text"])) {
				$status = "Необходимо заполнить поля заголовка и текста статьи!";
				$errorCode = false;
				return array($status, $errorCode);
			}
			if($file["error"] == 4) {
				$imgname = "1.jpg";
				$status = "Изображение не выбрано, будет загружена картинка по умолчанию";
			} else {
				if(($file["type"] != "image/jpeg") && ($file["type"] != "image/png") && ($file["type"] != "image/gif")){
					$imgname = "1.jpg";
					$status = "Допустимы изображения только форматов jpeg, png и gif";
					$errorCode = false;
					return array($status, $errorCode);
				} else {
				$imgname = str_replace(" ", "_", $file["name"]);
				$imgtmpname = $file["tmp_name"];
				move_uploaded_file($imgtmpname, "../postpic/$imgname");
				$status = "";
				}
			}
			$query = $this->connection->prepare("INSERT INTO articles (id_user, title, picture, text) VALUES (:id_u, :title, :img, :txt)");
			$dataQuery = array(":id_u" => $id_user, ":title"=>$data["header"], ":img" => $imgname, ":txt" => $data["text"]);
			$query->execute($dataQuery);
			$errorCode = true;
			return array($status, $errorCode);
		}

		public function deleteArticle($id) {
			$query = $this->connection->prepare("DELETE FROM articles WHERE id = :idnew");
			$data = array(":idnew" => $id);
			$query->execute($data);
		}

		public function selectEdit($id)
		{
			$query = $this->connection->prepare("SELECT * FROM articles WHERE id = :idnew");
			$data = array(":idnew" => $id);
			$query->execute($data);
			$result = $query->fetch(PDO::FETCH_ASSOC);
			return $result;
		}

		public function editNew($id, $data, $file) {
			if(empty($data["header"]) || empty($data["text"])) {
				$status = "Необходимо заполнить поля заголовка и текста статьи!";
				$errorCode = false;
				return array($status, $errorCode);
			}
			if($file["error"] == 4) {
				$query = $this->connection->prepare("UPDATE articles SET title = :title, text = :txt WHERE id = :idn");
				$dataQuery = array(":title"=>$data["header"], ":txt" => $data["text"], ":idn" => $id);
			} else {
				if(($file["type"] != "image/jpeg") && ($file["type"] != "image/png") && ($file["type"] != "image/gif")){
					$status = "Допустимы изображения только форматов jpeg, png и gif";
					$errorCode = false;
					return array($status, $errorCode);
				} else {
				$imgname = str_replace(" ", "_", $file["name"]);
				$imgtmpname = $file["tmp_name"];
				move_uploaded_file($imgtmpname, "../postpic/$imgname");
				$query = $this->connection->prepare("UPDATE articles SET title = :title, picture = :img, text = :txt WHERE id = :idn");
				$dataQuery = array(":title"=>$data["header"], ":img" => $imgname, ":txt" => $data["text"], ":idn" => $id);
				}
			}
			$status = "";
			
			$query->execute($dataQuery);
			$errorCode = true;
			return array($status, $errorCode);
		}
	}

?>