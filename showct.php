<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$birds = birds($arr[show]);
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
			foreach ($birds as $bird) {
?>
<div class="tag">
	<p class="name"><?=$show[name]?></p>
	<p class="class"><?=$bird[classname]?></p>
	<p class="breed"><?=$bird[breed]?></p>
	<p class="variety"><?=$bird[variety]?></p>
	<p class="id"><?=$bird[id]?></p>
	<p class="ex">Exhibitor: <?=$bird[ex_id]?></p>
</div>
<?php
			}
?>
</div>
<?php
		}
		catch(PDOException $e){
			die($e);
		}
	}
?>