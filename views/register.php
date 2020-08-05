<div class="back4" id="back2">
</div>
<main class="wrapper4">
	<div class="form" id="regi">
	<h1>Регистрация</h1>
	<form method="POST" action="/register">
		<?php if((isset($Registred["reg"])==true))
				{
				echo "<p class=\"message\">". $Registred["false_message"] . "</p>";
				}
		?>
		<input type="text" name="user" placeholder="Ваш логин:" required autocomplete="off"><br>
		<input type="text" name="email" placeholder="Ваш Email:" required autocomplete="off"><br>
		<input type="password" name="password" placeholder="Ваш пароль:" required autocomplete="off"><br>
		<button class="size_sub button-color" type="submit" name="reg">Зарегистрироваться</button>
	</form>
	<a href="/login"><button class="size_sub button-color">Войти</button></a>
	</div>
</main>