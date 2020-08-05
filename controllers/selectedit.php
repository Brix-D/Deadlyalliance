<?php
require_once "../models/Articles.php";
$DB = new Articles();
$res = $DB->selectEdit($_POST["idnew"]);
echo json_encode($res);
?>