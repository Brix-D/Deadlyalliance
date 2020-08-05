<?php
require_once "../models/Articles.php";
$DB = new Articles();
$res = $DB->deleteArticle($_POST["idnew"]);
echo json_encode($res);
?>