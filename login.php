<div class="back4" id="back2">
</div>
<main class="wrapper4">
<div class="form">
<h1>Вход</h1>
<form method="POST" action="/login">
	<?php
	if(($_SESSION["Logged"]==false))
	{
		echo "<p class=\"message\">$false_message</p>";
	}
	?>
	<input type="text" name="user" placeholder="Ваш логин:" required autocomplete="off"><br>
	<input type="password" name="password" placeholder="Ваш пароль:" required autocomplete="off"><br>
	<button class="size_sub button-color" type="submit" name="log">Войти</button>
</form>
<a href="/register"><button class="size_sub button-color"><p>Зарегистрироваться</p></button></a>
</div>
</main>