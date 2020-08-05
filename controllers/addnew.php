<?php
//die($_POST);
session_start();
require_once "../models/Articles.php";
$DB = new Articles();
//$data = array("header" => $_POST["header"], "image" => $_POST["image"], "text" => $_POST["text"]);
$res=$DB->insertArticle($_SESSION["userid"], $_POST, $_FILES["image"]);
//var_dump($res);
echo json_encode($res);
?>