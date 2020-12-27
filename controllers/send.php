<?php
/**
* Отправка письма на почту администратора сайта
 */
$class = trim(addslashes(htmlspecialchars($_POST['class'])));
$level = trim(addslashes(htmlspecialchars($_POST['level'])));
$spec = trim(addslashes(htmlspecialchars($_POST['spec'])));
$nickname = trim(addslashes(htmlspecialchars($_POST['nickname'])));
$timezone = trim(addslashes(htmlspecialchars($_POST['timezone'])));
$direction = trim(addslashes(htmlspecialchars($_POST['direction'])));
$discord = trim(addslashes(htmlspecialchars($_POST['discord'])));
$aboutme = trim(addslashes(htmlspecialchars($_POST['aboutme'])));
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$message = '<html>
<head>
<title>Заявка о вступлении в гильдию</title>
</head>
<body>
<p>Ник: '. $nickname .'
</p><br>
<p>Класс:'. $class .'
</p><br>
<p>Специализация: '. $spec .'
</p><br>
<p>Уровень: '. $level .'
</p><br>';
if($timezone == "other")
{
$message .= '<p>Часовой пояс: другой
</p><br>';
}
else
{
$message .= '<p>Часовой пояс: MSK '. $timezone .'
</p><br>';
}
$message .= '
<p>Направление игры: '. $direction .'
</p><br>';
if($discord == "on")
{
	$message .= '<p> Наличие дискорда: да
</p><br>';
}
else
{
	$message .= '<p> Наличие дискорда: нет
	</p><br>';
}
$message .= '
<p>Дополнительная информация: ' . $aboutme . '
</p><br>
</body>
</html>';
mail("mortalunion20@gmail.com", "Заявка о вступлении в гильдию", $message, $headers);
?>