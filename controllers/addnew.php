<?php
session_start();
require_once "../models/Articles.php";
$DB = new Articles();
$res=$DB->insert_article($_SESSION["userid"], $_POST, $_FILES["image"]);
echo json_encode($res);
?>