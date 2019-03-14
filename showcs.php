<?php 
	session_start();
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
	function main(){
?>
<div class="display">
<div>
<?php
$show = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show];
$birds = birds($show);
			foreach ($birds as $bird) {
				if($var != $bird[variety] || $breed != $bird[breed] || $classname != $bird[classname] || $jr != $bird[show_num]){
					$age = $bird[age];
					$var = $bird[variety];
					$breed = $bird[breed];
					$classname = $bird[classname];
					$jr = $bird[show_num];
					$q = "SELECT * from _".$show[id]."_birds where breed_id = $bird[breed_id] and variety_id = $bird[variety_id]";
					$count = db()->query($q)->rowCount();
?>
</div>
<div class="page">
	<div class="row head">
<?php if($show[junior]){ ?>
		<p><?=$bird[show_num]?"JR":"OPEN"?></p>
<?php } ?>
		<p><?=$bird[classname]?></p>
		<p><?=$bird[breed]?></p>
		<p class="l"><?=$bird[variety].($bird[NR]?" NRB":"")?></p>
		<p><?=$count?> entries</p>
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
</div>
<?php
	}	
?>