<?php 
	session_start();
	
	function main(){
		if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$exhibitors = exhibitors($arr[show]);
?>
<div class="row head">
	<p>Exhibitor Number</p>
	<p>Name</p>
	<p>Address</p>
	<p>Email</p>
	<p>Phone</p>
	<p>Edit</p>
</div>
<div class="display">
<?php
			foreach($exhibitors as $ex){
?>
<div class="row">
	<p><?=$ex[id]?></p>
	<p><?=$ex[name]?></p>
	<p><?=$ex[addres]?><?=$ex[city]?>, <?=$ex[state]?> <?=$ex[zip]?></p>
	<p><?=$ex[email]?></p>
	<p><?=$ex[phone]?></p>
	<form action="ex.php" method="POST">
		<input type="submit" value="Edit">
		<input type="hidden" name="ex" value="<?=$ex[id]?>">
	</form>
</div>
<?php
			}
?>
</div>
<div class="row">
	<form action="ex.php" method="POST">
		<input type="submit" name="submit" value="New Exhibitor">
	</form>
</div>
<?php
}

		catch(PDOException $e){
			die($e);
		}
}
}
?>