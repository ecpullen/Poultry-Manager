<?php 
	session_start();
	include 'mysql.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Exhibitor</title>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="manager.js"></script>
</head>
<body>
<?php
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$show = $arr[show];
			$showdb = $arr[showdb];
?>
	<header>
		<div id="show" class="mainlink">
			<h3><?=$show[name]?></h3>
		</div>
		<div id="ex" class="mainlink">
			<h3>Exhibitors</h3>
		</div>
		<div id="birds" class="mainlink">
			<h3>Birds</h3>
		</div>
		<div id="cs" class="mainlink">
			<h3>Clerk Sheets</h3>
		</div>
		<div id="ct" class="mainlink">
			<h3>Coop Tags</h3>
		</div>
		<div id="aw" class="mainlink">
			<h3>Awards</h3>
		</div>
		<div id="lo" class="mainlink">
			<h3>Logout</h3>
		</div>
	</header>
<?php
			if(isset($_POST[name])){
				if(isset($_POST[id]) || $showdb->query("SELECT * FROM exhibitors WHERE name=".$showdb->quote($_POST[name]).";")->rowCount() != 0){
					if($_POST[id] != ""){
						$q = "id = ".$_POST[id];
						$_POST[ex] = $_POST[id];
					}
					else{
						$q = "name = ".$_POST[name];
						$_POST[ex] = $showdb->query("SELECT * FROM exhibitors WHERE name=".$showdb->quote($_POST[name]).";")->fetch()[id];
					}
					$showdb->query("UPDATE exhibitors SET name =".$showdb->quote($_POST[name]).", address =".$showdb->quote($_POST[address]).", city=".$showdb->quote($_POST[city]).", state=".$showdb->quote($_POST[state]).", email=".$showdb->quote($_POST[email]).", phone=".$showdb->quote($_POST[phone])." where ".$q.";");
				}
				else{
						$showdb->query("INSERT INTO exhibitors (name,address,city,state,zip,email,phone) VALUES (".$showdb->quote($_POST[name]).",".$showdb->quote($_POST[address]).",".$showdb->quote($_POST[city]).",".$showdb->quote($_POST[state]).",".$showdb->quote($_POST[zip]).",".$showdb->quote($_POST[email]).",".$showdb->quote($_POST[phone]).");");
						$_POST[ex] = $showdb->query("SELECT * FROM exhibitors WHERE name=".$showdb->quote($_POST[name]).";")->fetch()[id];
				}
				
			}
			if(isset($_POST[ex])){
				$ex = $showdb->query("SELECT * FROM exhibitors WHERE id=".$showdb->quote($_POST[ex]).";")->fetch();
				if(isset($_POST[breed]) && $_POST[age] == ""){
					$q = "SELECT breeds.id FROM breeds JOIN divisions ON divisions.class_id = breeds.class_id WHERE divisions.division like ".$showdb->quote($_POST[division])." AND breeds.breed like ".$showdb->quote($_POST[breed]).";";
					// echo $q;
					$breed_id = $showdb->query($q)->fetch()[id];
					// print_r($_POST);
					for($i = 0; $i < $_POST[cock]; $i++){
						$q = "INSERT INTO birds (ex_id,age,variety,breed_id) VALUES ($ex[id],'cock',".$showdb->quote($_POST[variety]).",$breed_id);";
						// echo $q;
						$showdb->query($q);
					}
					for($i = 0; $i < $_POST[hen]; $i++){
						$q = "INSERT INTO birds (ex_id,age,variety,breed_id) VALUES ($ex[id],'hen',".$showdb->quote($_POST[variety]).",$breed_id);";
						$showdb->query($q);
					}
					for($i = 0; $i < $_POST[cockerel]; $i++){
						$q = "INSERT INTO birds (ex_id,age,variety,breed_id) VALUES ($ex[id],'cockerel',".$showdb->quote($_POST[variety]).",$breed_id);";
						$showdb->query($q);
					}
					for($i = 0; $i < $_POST[pullet]; $i++){
						$q = "INSERT INTO birds (ex_id,age,variety,breed_id) VALUES ($ex[id],'pullet',".$showdb->quote($_POST[variety]).",$breed_id);";
						$showdb->query($q);
					}
				}
				elseif(isset($_POST[breed])){
					$breed_id = $showdb->query("SELECT breeds.id FROM breeds JOIN classes ON breeds.class_id = classes.id WHERE breeds.breed like ".$showdb->quote($_POST[breed])." AND classname like ".$showdb->quote($_POST[classname]))->fetch()[id];
					$showdb->query("UPDATE birds SET age = ".$showdb->quote($_POST[age]).", variety = ".$showdb->quote($_POST[variety]).", breed_id = ".$showdb->quote($breed_id)." WHERE id = $_POST[id]");
				}
				elseif($_POST[delete] != ""){
					$showdb->query("DELETE FROM birds WHERE id = $_POST[delete]");
				}
?>
		<fieldset>
			<legend>Edit Exhibitor</legend>
			<form action="ex.php" method="POST">
				Name: <input type="text" name="name" value="<?=$ex[name]?>" required>
				Address: <input type="text" name="address" value="<?=$ex[address]?>" required>
				City: <input type="text" name="city" value="<?=$ex[city]?>" required>
				State: <input type="text" name="state" value="<?=$ex[state]?>" required>
				Zip: <input type="text" name="zip" value="<?=$ex[zip]?>" required>
				Email: <input type="email" name="email" value="<?=$ex[email]?>" required>
				Phone: <input type="text" name="phone" value="<?=$ex[phone]?>" required>
				<input type="hidden" name="id" value="<?=$ex[id]?>">
				<input type="submit" name="submit">
			</form>
		</fieldset>

		<fieldset>
			<legend>Add Birds</legend>
			<form action="ex.php" method="POST">
				Division: LF <input type="radio" name="division" value="Large Fowl">
						 BTM <input type="radio" name="division" value="Bantam">
						 WF <input type="radio" name="division" value="Waterfowl">
				Breed: <input type="text" name="breed" required>
				Variety: <input type="text" name="variety">
				Cock: <input class = "quantity" type="number" name="cock">
				Hen: <input class = "quantity" type="number" name="hen">
				Cockerel: <input class = "quantity" type="number" name="cockerel">
				Pullet: <input class = "quantity" type="number" name="pullet">
				<input type="hidden" name="ex" value="<?=$ex[id]?>">
				<input type="submit" name="submit">
			</form>
		</fieldset>
<?php
				$birds = $showdb->query("SELECT birds.id,classname,breed,variety,age FROM birds JOIN breeds ON breeds.id = birds.breed_id JOIN classes ON classes.id = breeds.class_id WHERE ex_id=".$_POST[ex]);
?>
<div class="row head">
	<p class="s">ID</p>
	<p>CLASS</p>
	<p>BREED</p>
	<p class="l">VARIETY</p>
	<p class="s">AGE/SEX</p>
</div>
<div class="display m">
<?php
				foreach ($birds as $bird) {
					if($bird[id] == $_POST[edit]){
?>
<div class="row">
	<p><?=$bird[id]?></p>
	<form action="ex.php" method="POST">
		<input type="text" name="classname" value="<?=$bird[classname]?>">
		<input type="text" name="breed" value="<?=$bird[breed]?>">
		<input type="text" name="variety" value="<?=$bird[variety]?>">
		<input type="text" name="age" value="<?=$bird[age]?>">
		<input type="hidden" name="id" = value="<?=$bird[id]?>">
		<input type="hidden" name="ex" value="<?=$ex[id]?>">
		<input type="submit" value="Save">
	</form>
</div>
<?php
					}
					else{
?>
<div class="row">
	<p class="s"><?=$bird[id]?></p>
	<p><?=$bird[classname]?></p>
	<p><?=$bird[breed]?></p>
	<p class="l"><?=$bird[variety]?></p>
	<p class="s"><?=$bird[age]?></p>
	<form class="p" action="ex.php" method="POST"><input type="hidden" name="edit" value="<?=$bird[id]?>"><input type="hidden" name="ex" value="<?=$ex[id]?>"><input type="submit" value="Edit"></form>
	<form class="p" action="ex.php" method="POST"><input type="hidden" name="delete" value="<?=$bird[id]?>"><input type="hidden" name="ex" value="<?=$ex[id]?>"><input type="submit" value="Delete"></form>
</div>
<?php
					}
				}
?>
</div>
<?php
			}
			else{
?>
<fieldset>
			<legend>New Exhibitor</legend>
			<form action="ex.php" method="POST">
				Name: <input type="text" name="name" required>
				Address: <input type="text" name="address" required>
				City: <input type="text" name="city" required>
				State: <input type="text" name="state" required>
				Zip: <input type="text" name="zip" required>
				Email: <input type="email" name="email" required>
				Phone: <input type="text" name="phone" required>
				<input type="hidden" name="ex" value="<?=$ex[id]?>">
				<input type="submit" name="submit">
			</form>
		</fieldset>
<?php
			}
		}
		catch(PDOException $e){
			die($e);
		}
	}
?>
</body>
</html>