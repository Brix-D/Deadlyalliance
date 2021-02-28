<?php
require_once "../models/Articles.php";
$DB = new Articles();
$_POST2 = json_decode(file_get_contents('php://input'), true);
$res = $DB->select_edit($_POST2["idnew"]);
echo json_encode($res);
?>