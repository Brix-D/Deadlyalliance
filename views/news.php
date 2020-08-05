<div class="back3" id="back2">
</div>
<main class="wrapper">
	<div class="news-cont">
		<?php
		//var_dump($_SESSION["hashlog"]);
		//var_dump($_COOKIE["logged"]);
		//if(strcmp($_SESSION["hashlog"], $_COOKIE["logged"]) == 0) {
		if(@hash_equals($_SESSION["hashlog"], $_COOKIE["logged"])){
			if(@hash_equals($_COOKIE["perm"], crypt("admin", "$23$gdgsdd14"))) {
				$isadmin = true;
			}
			else {
				$isadmin = false;
			}
				if($isadmin == true){?>
				<div class="admin-tools"><button id="addnew"></button></div>
		<?php }
		}
		//$res = $DB->insertArticle(array("header" => "title23", "text" => "text111111"));
		//var_dump($res);
		foreach($news as $item) {?>
		<div class="news-item">
			<div class="title-new">
				<h3 class="tn text-font-fam"><?php echo $item["title"]?></h3>
			</div>
			<span class="date"><?php echo $item["username"]. "  " . date("d.m.Y", strtotime($item["date"]));?></span><br>
			<div class="img-new-cont">
				<div class="img-cont">
					<img src=<?php echo "/postpic/" . $item["picture"]?> alt="">
				</div>
				<?php if($isadmin == true){?>
					<div class="admin-tools2"><button class="editnew" value = "<?=$item["id"]?>"></button><button class="delnew" value = "<?=$item["id"]?>"></button></div>
				<?php } ?>
			</div>
			<div class="text-new text-font-fam"><p><?php echo $item["text"]?></p></div>
		</div>
		<?php } ?>
		<!--<div class="news-item">
			<div class="title-new">
				<h3 class="tn">Новость 2</h3>
			</div>
			<span class="date"></span>
			<div class="img-cont">
				<img src="/img/1.jpg" alt="">
			</div>
			<div class="text-new"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt quo eligendi, quod libero nobis molestiae alias sunt nam earum incidunt, doloremque, officia tenetur qui! Nesciunt adipisci vero sapiente non molestias! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt quo eligendi, quod libero nobis molestiae alias sunt nam earum incidunt, doloremque, officia tenetur qui! Nesciunt adipisci vero sapiente non molestias! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt quo eligendi, quod libero nobis molestiae alias sunt nam earum incidunt, doloremque, officia tenetur qui! Nesciunt adipisci vero sapiente non molestias!</p></div>
		</div>
		<div class="news-item">
			<div class="title-new">
				<h3 class="tn">Новость 3</h3>
			</div>
			<span class="date"></span>
			<div class="img-cont">
				<img src="/img/1.jpg" alt="">
			</div>
			<div class="text-new"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt quo eligendi, quod libero nobis molestiae alias sunt nam earum incidunt, doloremque, officia tenetur qui! Nesciunt adipisci vero sapiente non molestias! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt quo eligendi, quod libero nobis molestiae alias sunt nam earum incidunt, doloremque, officia tenetur qui! Nesciunt adipisci vero sapiente non molestias! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt quo eligendi, quod libero nobis molestiae alias sunt nam earum incidunt, doloremque, officia tenetur qui! Nesciunt adipisci vero sapiente non molestias!</p></div>	
		</div>-->
</div>
</main>