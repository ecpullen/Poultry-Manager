<?php 
	session_start();
	include 'mysql.php';
?>

<!DOCTYPE html>
<html>
<?php 
	if(isset($_SESSION["username"])){
		try{
			$db = new PDO("mysql:dbname=info;host=127.0.0.1",
				"root",
				"admin123");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "select * from users where password = ".$db->quote($_SESSION["password"])." and username = ".$db->quote($_SESSION["username"]).";";
			//echo $query;
			$rows = $db->query($query);
			$user = $rows->fetch();
			if($rows->rowCount()==0){
				die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
			}

			if(isset($_POST["show_name"])||isset($_SESSION["show_id"])){
				if(isset($_POST["show_name"])){
					$query = "select * from shows where admin_id = $user[id] and name = ".$db->quote($_POST[show_name]).";";
					// echo($query);
					$rows = $db->query($query);
					if($rows->rowCount() == 0){
						die("<h1>Show not found</h1><a href='main.php'>Try Again</a>");
					}
					$show = $rows->fetch();
					$_SESSION["show_id"] = $show[id];
					$_SESSION["state"] = "home";
				}
				else{
					$show = $db->query("SELECT * FROM shows WHERE id = $_SESSION[show_id]")->fetch();
				}
				$showdb = new PDO("mysql:dbname=$show[name];host=127.0.0.1",
				"root",
				"admin123");
				$showdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
?>
<head>
	<title>Manage <?=$show[name]?></title>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="manager.js"></script>
</head>
<body>
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
<div id="main">
<?php 
	if(isset($_GET['p'])){
		switch ($_GET['p']) {
			case 'home':
				require("showhome.php");
				break;
			case 'ex':
				require("showex.php");
				break;
			case 'birds':
				require("showbirds.php");
				break;
			default:
				break;
		}
	}
?>
</div>
<?php
			}
			else{
?>
<head>
	<title>Create Show</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="newshow.js"></script>
</head>
<body>
		<fieldset>
			<legend>New Show</legend>
			<form id = "new_show" action="show.php" method="POST">
				Show Name:<br />
				<input id = "ns" type="text" name="show_name" required>
				<br />
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
	else{
		die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
	}
?>
</body>
</html>