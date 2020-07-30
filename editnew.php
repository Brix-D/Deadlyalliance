<?php 
require_once "ManagerDB.php";
$DB = new ManagerDB();
$DB->connectDB();
$res=$DB->editNew($_POST["idnew"], $_POST, $_FILES["image"]);
echo json_encode($res);
?>