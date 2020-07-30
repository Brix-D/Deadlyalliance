<?php
class ManagerDB {
	private $connection;

	public function connectDB() {
		$this->connection = new PDO('mysql:host=localhost; dbname=deadlyalliance; charset=utf8', 'mysql', 'mysql');
	}

	public function selectNews() {
		$query = $this->connection->prepare("SELECT articles.id,`id_user`, `title`, `picture`, `text`, `date`, `username` FROM articles INNER JOIN users ON articles.id_user = users.id ORDER BY `date` DESC;");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}

	public function login($username, $pass)
	{
		$query = $this->connection->prepare("SELECT id, password, permissions FROM users WHERE username = :user");
		$data = array(':user' => $username);
		$query->execute($data);
		$res = $query->fetch();
		$false_message = "";
		$perm = "";
		if($res != NULL)
		{
			if(password_verify($pass, $res[1])==true)
			{
				$logged = true;
				$_SESSION["userid"] = $res[0];
				$perm = $res["permissions"];
			}
			else
			{
				$logged = false;
				$false_message = "Неверный пароль!";
			}
		}
		else
		{
			$logged = false;
			$false_message = "Неверный логин!";
		}
		return array("username"=>$username, "logged" => $logged, "false_message" => $false_message, "permissions" => $perm);
	}

	public function register($username, $e_mail, $passw)
	{
		$password = password_hash($passw, PASSWORD_BCRYPT);
		
		$query = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (:user, :email, :password)");
		$data=array(':user' => $username, ':email' => $e_mail, ':password' => $password);
		$reg = $query->execute($data);	
		if($reg == true) {
			$false_message = "Вы успешно зарегистрированы!";
		} else {
			$false_message = "Пользователь с таким логином уже существует!";	
		}
		return array("reg" => $reg, "false_message" => $false_message);
	}

	public function logout()
	{
		setcookie("logged", $hashlog, time()-3600*24);
		setcookie("perm", $hashperm, time()-3600*24);
		setcookie("user", $username, time()-3600*24);
		session_destroy();
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
			move_uploaded_file($imgtmpname, "postpic/$imgname");
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
			move_uploaded_file($imgtmpname, "postpic/$imgname");
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