<?php
require_once "../models/Articles.php";
$DB = new Articles();
$res = $DB->select_edit($_POST["idnew"]);
echo json_encode($res);
?>