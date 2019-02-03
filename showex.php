<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$db = new PDO("mysql:dbname=info;host=127.0.0.1",
				"root",
				"admin123");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "select * from users where password = ".$db->quote($_SESSION["password"])." and username = ".$db->quote($_SESSION["username"]).";";
			$rows = $db->query($query);
			$user = $rows->fetch();
			if($rows->rowCount()==0){
				die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
			}
			$query = "select * from shows where admin_id = $user[id] and id = ".$db->quote($_SESSION[show_id]).";";
			// echo $query;
			$rows = $db->query($query);
			if($rows->rowCount() == 0){
				die("<h1>Show not found</h1><a href='main.php'>Try Again</a>");
			}
			$show = $rows->fetch();
			$showdb = new PDO("mysql:dbname=$show[name];host=127.0.0.1",
			"root",
			"admin123");
			$showdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$exhibitors = $showdb->query("select * from exhibitors");
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
?>