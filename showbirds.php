<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$birds = birds($arr[show]);
?>
<div class="row head">
	<p class="s">ID</p>
	<p class="s">EXHIBITOR</p>
	<p>CLASS</p>
	<p>BREED</p>
	<p class="l">VARIETY</p>
	<p class="s">AGE/SEX</p>
</div>
<div class="display">
<?php
			foreach ($birds as $bird) {
?>
<div class="row">
	<p class="s"><?=$bird[id]?></p>
	<p class="s"><?=$bird[ex_id]?></p>
	<p><?=$bird[classname]?></p>
	<p><?=$bird[breed]?></p>
	<p class="l"><?=$bird[variety]?></p>
	<p class="s"><?=$bird[age]?></p>
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