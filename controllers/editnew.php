<?php 
require_once "../models/Articles.php";
$DB = new Articles();
$res=$DB->editNew($_POST["idnew"], $_POST, $_FILES["image"]);
echo json_encode($res);
?>