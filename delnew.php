<?php
	require_once "ManagerDB.php";
	$DB = new ManagerDB();
	$DB->connectDB();
$res = $DB->deleteArticle($_POST["idnew"]);
echo json_encode($res);
?>