<?php 
	session_start();

	include 'mysql.php';

	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$birds = birds($arr[show]);
			$var = "";
			$breed = "";
			$age = "";
			$classname = "";
			$jr = "";
		}
		catch(PDOException $e){
			die($e);
		}
	}
?>
<style>
<?php include 'manage.css'; ?>
</style>
<?php
	if($_GET[query] == 'clerk'){
?>
<div class="display">
<?php
$show = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show];
$color = "";
			if($_GET[num]/2 >= 1){
				$color = strtoupper(get_color(($_GET[num]-$_GET[num]%2)/2))." SHOW".($_GET[num]%2?" JUNIOR":"");

			}
			$birds = get_birds_by_num($show, $_GET[num]);
			foreach ($birds as $bird) {
				if($var != $bird[variety] || $breed != $bird[breed] || $classname != $bird[classname] || $jr != $bird[show_num]){
					$age = $bird[age];
					$var = $bird[variety];
					$breed = $bird[breed];
					$classname = $bird[classname];
					$jr = $bird[show_num];
					$q = "SELECT * from _".$show[id]."_birds where breed_id = $bird[breed_id] and variety_id = $bird[variety_id] and show_num=$bird[show_num]";
					$count = db()->query($q)->rowCount();
?>
</div>
<div class="page">
	<div class="row head">
		<p><?=strtoupper($bird[classname])?></p>
		<p><?=strtoupper($bird[breed])?></p>
		<p><?=strtoupper($bird[variety]).($bird[NR]?" NRB":"")?></p>
		<p><?=$count?> ENTRIES</p>
		<p><?=$color?></p>
	</div>
	<div class="row">
		<p><?=strtoupper($age)?></p>
	</div>
<?php
				}
				if($age != $bird[age]){
					$age = $bird[age];
?>
	<div class="row">
		<p><?=strtoupper($age)?></p>
	</div>
<?php
				}
?>
	<div class="row entry">
		<p class="s"><?=$bird[id]?></p>
		<p class="s"><?=$bird[ex_id]?></p>
	</div>
<?php
	}
?>
</div>
<?php
	}
	else if($_GET[query] == "cooptag"){
		$show = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show];
?>
<style type="text/css">
	@media print {
		@page{
			margin: none;
			padding: none;
			border:none;
		}
	}
</style>
<div class="tags">
<?php

			$color = "";
			if($_GET[num]/2 >= 1){
				$color = get_color(($_GET[num]-$_GET[num]%2)/2);

			}
			$birds = get_birds_by_num($show, $_GET[num]);
			foreach ($birds as $bird) {
?>
<div class="tag">
<?php if($show[junior]){ ?>
		<p><?=$bird[show_num]?"JR":"OPEN"?> <?=strtoupper($color)?></p>
<?php } else{?>
		<p><?=strtoupper($color)?></p>
<?php } ?>
	<p class="name"><?=$show[name]?></p>
	<p class="class"><?=$bird[classname]?></p>
	<p class="breed"><?=$bird[breed]?></p>
	<p class="variety"><?=$bird[variety].($bird[NR]?" NRB":"")?></p>
	<p class="id"><?=$bird[id]?></p>
	<p class="ex">Exhibitor: <?=$bird[ex_id]?></p>
</div>
<?php
			}
?>
</div>
<?php
	}
?>