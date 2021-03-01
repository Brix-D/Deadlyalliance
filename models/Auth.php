<?php
	/**
	 * Модель авторизации, аутентификации, и логаута, авторизация сделана через cookie
	 */
	class Auth
	{
		private $connection;
		public function __construct()
		{
            $port = 3306;
            $dsn = 'mysql:host=localhost:'. $port .'; dbname=deadlyalliance; charset=utf8';
            $username = 'root';
            $password = 'root';
            $this->connection = new PDO($dsn, $username, $password);
		}

		/**
		* Вход в аккаунт
         */
		public function login($username, $pass)
		{
			$query = $this->connection->prepare("SELECT id, password, permissions FROM users WHERE username = :user");
			$data = array(':user' => $username);
			$query->execute($data);
			$res = $query->fetch();
			$false_message = "";
			$perm = "";
			if($res != NULL) // если существует пользователь в БД
			{
				if(password_verify($pass, $res[1])==true) // и его пароль равен хешу в БД
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
        /**
        * Регистрация пользователя
         */
		public function register($username, $e_mail, $passw)
		{
			$password = password_hash($passw, PASSWORD_BCRYPT); // хеширование пароля для хранения в базе
			
			$query = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (:user, :email, :password)");
			// базовые привелегии для юзера - обычный пользователь
			$data=array(':user' => $username, ':email' => $e_mail, ':password' => $password);
			$reg = $query->execute($data);	
			if($reg == true) {
				$false_message = "Вы успешно зарегистрированы!";
			} else {
				$false_message = "Пользователь с таким логином уже существует!";	
			}
			return array("reg" => $reg, "false_message" => $false_message);
		}
        /**
        * Выход из аккаунта, удаляет все куки, завершает сессию
         */
		public function logout()
		{
			setcookie("logged", $hashlog, time()-3600*24);
			setcookie("perm", $hashperm, time()-3600*24);
			setcookie("user", $username, time()-3600*24);
			session_destroy();
		}
	}

?>