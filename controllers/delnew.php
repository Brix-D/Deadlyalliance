<?php
require_once "../models/Articles.php";
$DB = new Articles();
$res = $DB->delete_article($_POST["idnew"]);
echo json_encode($res);
?>