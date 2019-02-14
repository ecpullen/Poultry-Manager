<?php 
	session_start();
	include '../mysql.php';
?>
<!DOCTYPE html>
<html>
<head>
<?php
	if(isset($_POST[id])){
		$_SESSION[show_id] = $_POST[id];
		$_SESSION[clerk] = $_POST[name];
		$_SESSION[judge] = $_POST[judge];
	}
	if(isset($_SESSION[show_id])){
		try{
			$show = get_show($_SESSION[show_id]);
			$birds = birds($show);
			$var = "";
			$breed = "";
			$age = "";
			$classname = "";
?>
	<title>Clerk: <?=$show[name]?></title>
	<link rel="stylesheet" type="text/css" href="clerk.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="jquery.sticky.js"></script>
	<script src="clerk.js"></script>
</head>
<body>
<div>
	<div>
		<div>
<?php
			foreach ($birds as $bird) {
				if($breed != $bird[breed]){
					$age = "";
					$var = "none";
					$breed = $bird[breed];
					$q = "SELECT * from birds where breed_id = $bird[breed_id] and variety_id = $bird[variety_id]";
					$count = showdb($show)->query($q)->rowCount();
					$q = "SELECT * from birds where breed_id = $bird[breed_id]";
					$bcount = showdb($show)->query($q)->rowCount();
?> 
		</div>
	</div>
</div>
<div class="page">
	<div class="var pick">
		<div class="row head vhead" data-coop="<?=$bird[id]?>">
			<p class="l">Pick Best <?=$bird[breed]?></p>
		</div>	
	</div>
	<div class="row head phead">
		<p><?=$bird[classname]?></p>
		<p><?=$bird[breed]?></p>
		<p><?=$bcount?> entries</p>
	</div>
	<div>
		<div>
<?php
				}
				if($var != $bird[variety]){
					$var = $bird[variety];
					$age = "";
					$q = "SELECT * from birds where breed_id = $bird[breed_id] and variety_id = $bird[variety_id]";
					$count = showdb($show)->query($q)->rowCount();
?>
		</div>
	</div>
	
	<div class="var">
		<div class="age pick">
			<div class="row ahead" data-coop="<?=$bird[id]?>">
				<p>Pick Best <?=$bird[variety]?></p>
			</div>	
		</div>
		<div class="row head vhead">
			<p class="l"><?=strtoupper($bird[variety])?></p>
			<p><?=$count?> entries</p>
<?php
				}
				if($age != $bird[age]){
					$age = $bird[age];
					$ranksPDO = get_ranks($show,$bird);
					$ranks = array();
					for($i = 1; $i < 6; $i ++){
						$ranks[$i] = "";
					}
					foreach ($ranksPDO as $r) {
						$ranks[$r[place]] = $r[bird_id];
					}

?>

	</div>
	<div class="age">
		<form>	
			<input type="hidden" name="_1" value=<?=$ranks[1]?>>
			<input type="hidden" name="_2" value=<?=$ranks[2]?>>
			<input type="hidden" name="_3" value=<?=$ranks[3]?>>
			<input type="hidden" name="_4" value=<?=$ranks[4]?>>
			<input type="hidden" name="_5" value=<?=$ranks[5]?>>
		</form>
	<div class="row ahead">
		<p><?=strtoupper($age)?></p>
	</div>
<?php
				}
?>
	<div class="row entry">
		<p class="s">COOP: <?=$bird[id]?></p>
	</div>
	<div class="row">
		<form>
			None<input class="none" type="radio" name="place" value="<?=$bird[id]?>">
<?php $rank = get_rank($show, $bird[id]) ?>
			1<input class="_1" type="radio" name="place" value="<?=5*$bird[id]?>" <?=$rank == 1 ? "checked" : ""?>>
			2<input class="_2" type="radio" name="place" value="<?=5*$bird[id] + 1?>" <?=$rank == 2 ? "checked" : ""?>>
			3<input class="_3" type="radio" name="place" value="<?=5*$bird[id] + 2?>" <?=$rank == 3 ? "checked" : ""?>>
			4<input class="_4" type="radio" name="place" value="<?=5*$bird[id] + 3?>" <?=$rank == 4 ? "checked" : ""?>>
			5<input class="_5" type="radio" name="place" value="<?=5*$bird[id] + 4?>" <?=$rank == 5 ? "checked" : ""?>>
		</form>
	</div>
<?php
			}
?>
</div>
</div>
</div>
<?php

		}
		catch(PDOException $e){
			die($e);
		}
	}
?>
</body>
</html>