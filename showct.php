<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$birds = birds($arr[show]);
		}
		catch(PDOException $e){
			die($e);
		}
	}
	function main(){
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
			if($show[show1]){
				get_color($show[show1]);
			}
			$birds = birds(val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show]);
			foreach ($birds as $bird) {
?>
<div class="tag">
<?php if($show[junior]){ ?>
		<p><?=$bird[show_num]?"JR":"OPEN"?> <?=strtoupper($color)?></p>
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
			if($color){
				$color = get_color($show[show2]);
				$birds = birds(val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show]);
				foreach ($birds as $bird) {
?>
<div class="tag">
<?php if($show[junior]){ ?>
		<p><?=$bird[show_num]?"JR":"OPEN"?> <?=strtoupper($color)?></p>
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
			}
?>
</div>
<?php
	}
?>