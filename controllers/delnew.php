<?php
//header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
//header('Access-Control-Allow-Headers: Content-Type');
//header('Access-Control-Allow-Credentials: true');
require_once "../models/Articles.php";
$DB = new Articles();
$_POST2 = json_decode(file_get_contents('php://input'), true);
$res = $DB->delete_article($_POST2["idnew"]);
echo json_encode($res);
?>