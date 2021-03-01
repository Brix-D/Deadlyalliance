<html>
<head>
	<meta charset="utf-8">
	<meta name="google-site-verification" content="adeF51NInTrQLVSklvou80hJkzQQoGs2cLo18R9xfOU" />
	<meta name="description" content="<?=$description?>">
	<meta name="keywords" content="<?=$keywords?>">
	<link rel="stylesheet" href="/styles/slick.css">
	<?php
	if($page == "Main" || $page == "")
	{
	?>
	<link rel="stylesheet" type="text/css" href="/styles/onepage-scroll.css">
	<?php
	}
	?>
	<link rel="stylesheet" type="text/css" href="/styles/style.css">
	<link href="https://fonts.googleapis.com/css?family=EB+Garamond|Maitree:500|Permanent+Marker&display=swap&subset=cyrillic" rel="stylesheet">
	<link href="//db.onlinewebfonts.com/c/3ade034999153f8110b40724ad74f00e?family=Pacifica" rel="stylesheet" type="text/css"/>
	<link href="//db.onlinewebfonts.com/c/3ad0fc99253e9a25029a8b33686e46fa?family=GeographicaScriptW01-Rg" rel="stylesheet" type="text/css"/>
	<script src="/js/jquery-3.4.1.min.js"></script>
<!--    <link rel="stylesheet" href="styles/swiper-bundle.css">-->
    <link rel="stylesheet" href="/styles/swiper-bundle.min.css">
	<meta name="viewport" content="width=device-width">
	<title><?=$title?></title>
</head>
<body>
	<header>
		<h2 class = "title title-font-fam nowrap">Deadly Alliance</h2>
		<div class = "wrapper-head inline">
		<nav>
			<ul class = "menu">
				<?php
				$first = true;
				$pages  = array("Главная" => "/", "Новости" => "News", "Устав" => "Regulations", "Вступить" => "Joinus");
				$mpages  = array("Главная" => "/", "Новости" => "News", "Устав" => "Regulations", "Вступить" => "Joinus");
				if(@!hash_equals($_SESSION["hashlog"], $_COOKIE["logged"])) {
					$mpages["Вход"] = "login";
					$mpages["Регистрация"] = "register";
				} else {
					$mpages["Выйти"] = "logout";
				}
				foreach ($pages as $key => $value) {
					?>
					<li class = "menu-item text-font-fam"><a class =
					<?php
					if($page == "Main" && $first == true)
					{
						echo "\"link-pressed\"";
						$first = false;
					}
					if($value == $page)
					{
						echo "\"link-pressed\"";
					}
					else
					{
						echo "\"\"";
					}
					?>
					href = <?php echo $value ?>> <?php echo $key ?></a></li>
				<?php
				}
				?>
				  
				<!--<li class = "menu-item text-font-fam"><a href = "regulations">Устав</a></li>
				<li class = "menu-item text-font-fam"><a href = "joinus">Как вступить</a></li>
			-->
			</ul>
		</nav>
		</div>
		<div class="burger-menu-icon" id="bm"></div>
		<div class="burger-menu" id="bm-block">
			<ul class="bm-list">
				<?php
				$first = true;
				foreach ($mpages as $key => $value) {
					?>
					<li class = "bm-item text-font-fam"><a class =
					<?php
					if($page == "" && $first == true)
					{
						echo "\"link-pressed\"";
						$first = false;
					}
					if($value == $page)
					{
						echo "\"link-pressed\"";
					}
					else
					{
						echo "\"\"";
					}
					?>
					href = <?php echo $value ?>> <?php echo $key ?></a></li>
				<?php
				}
				?>
			</ul>
		</div>
		<div class="author">
		<?php if(@!hash_equals($_SESSION["hashlog"], $_COOKIE["logged"])) {?>
		<a href="/login">Вход</a><span> | </span><a href="/register">Регистрация</a>
	<?php } else { ?>
		<span><?=$_COOKIE["user"]." | "?></span><a href="/logout">Выйти</a>
	<?php } ?> 
	</div>
	</header>
		<?php 
		include_once $view;
		?>
	<footer id = "footer">
		<div class = "foot">
			<span class = "inline foot-span-size foot-span-text text-font-fam">Гильдия Смертельный союз - Пламегор &copy;2010-2020</span>
			<span class = "inline foot-span-size foot-span-text text-font-fam">BattleTag: Теринама#2832</span>
		</div>
	</footer>
<script type="text/javascript" src="/js/slick.min.js"></script>
<!--<script src="js/swiper-bundle.js"></script>-->
<script src="/js/swiper-bundle.min.js"></script>
<script type="text/javascript" src="/js/jquery.onepage-scroll.min.js"></script>
<script type="text/javascript" src="/js/mainPage.js"></script>
<script type="text/javascript" src="/js/newsManger.js"></script>
</body>
</html>