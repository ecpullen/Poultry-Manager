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
			$birds = $showdb->query("SELECT breeds.class_id, classname, breed, variety, age, birds.id, ex_id from birds 
				JOIN breeds ON birds.breed_id = breeds.id JOIN classes on breeds.class_id = classes.id
				ORDER BY breeds.class_id, breed, variety, age, ex_id");
			$var = "";
			$breed = "";
?>
<div>
<?php
			foreach ($birds as $bird) {
				if($var != $bird[variety] || $breed != $bird[breed]){
					$var = $bird[variety];
					$breed = $bird[breed];
					$q = "SELECT * from birds JOIN breeds ON birds.breed_id = breeds.id JOIN classes on breeds.class_id = classes.id WHERE classname = '$bird[classname]' and breed = '$breed' and variety = '$var'";
					$count = $showdb->query($q)->rowCount();
?>
</div>
<div class="page">
	<div class="row head">
	<p><?=$bird[classname]?></p>
	<p><?=$bird[breed]?></p>
	<p class="l"><?=$bird[variety]?></p>
	<p><?=$count?> entries</p>
</div>
<?php
				}
?>
<div class="row entry">
	<p class="s"><?=$bird[id]?></p>
	<p class="s"><?=$bird[ex_id]?></p>
	<p><?=$bird[age]?></p>
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