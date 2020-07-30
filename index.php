<?php
$page = $_SERVER["REQUEST_URI"];
$page = str_replace("/", "", $page);
session_start();
require_once "ManagerDB.php";
$DB = new ManagerDB();
$DB->connectDB();
if(@hash_equals($_SESSION["hashlog"], $_COOKIE["logged"]) && ($page == "login" || $page == "register")){
	header('Location: /');
}
if(isset($_POST["log"]) == true)
{
$status = $DB->login($_POST["user"], $_POST["password"]);
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
if(isset($_POST["reg"]) == true)
{
$Registred = $DB->register($_POST["user"], $_POST["email"], $_POST["password"]);
}
if($page == "logout")
{
	$DB->logout();
	header('Location: /');
}
if($page == "news") {
	$news = $DB->selectNews();
	//extract($news);
}
switch ($page) {
	case '':
		$title = "Гильдия Смертельный союз | сообщество World of Warcraft";
		$description = "Гильдия Смертельный союз - это сплоченное сообщество игроков World of Warcraft, основные направления которого это прохождение сложных рейдов, участие в PvP аспектах игры. Сообщество основано в 2010 году, и сейчас находится на сервере Пламегор-Орда";
		$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, вступить в гильдию WoW, Пламегор, Flamegor, Орда, Deadly Alliance";
		break;
	case 'regulations':
		$title = "Устав | Смертельный союз";
		$description = "Устав - это сбор правил, обязательных для соблюдения всеми игроками сообщества Смертельный союз";
		$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, Устав гильдии, Пламегор, Flamegor, Орда, Deadly Alliance";
		break;
	case 'joinus':
		$title = "Вступить | Смертельный союз";
		$description = "Гильдия Смертельный союз проводит набор игроков в PvE-состав";
		$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, вступить в гильдию WoW, Пламегор, Flamegor, Орда, Deadly Alliance";
		break;
	case 'news':
		$title = "Новости | Смертельный союз";
		$description = "Последние новости сообщества Смертельный союз WoW Classic";
		$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, Новости гильдии, Пламегор, Flamegor, Орда, Deadly Alliance";
		break;
	case 'login':
		$title = "Вход | Смертельный союз";
		$description = "";
		$keywords = "";
		break;
	case 'register':
		$title = "Регистрация | Смертельный союз";
		$description = "";
		$keywords = "";
		break;
	default:
		$title = "Гильдия Смертельный союз | сообщество World of Warcraft";
		$description = "";
		$keywords = "WoW Classic, Гильдия WoW, Смертельный Союз, вступить в гильдию WoW, Пламегор, Flamegor, Орда, Deadly Alliance";
		break;
}
include_once ("header.php");
//var_dump($page);
if(file_exists($page.'.html') == true)
{
include_once($page.'.html');
}
else if(file_exists($page.'.php') == true)
{
	include_once($page.'.php');
}
else if($page == "")
{
include_once('main.html');
}
else
{
	echo "Ошибка 404";
}
include_once("footer.html");
?>