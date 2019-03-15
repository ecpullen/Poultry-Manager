<?php 
	session_start();
	if(isset($_SESSION["username"])){
		$u = $_SESSION["username"];
		$p = $_SESSION["password"];
	}
	session_destroy();
	session_start();
	$_SESSION["username"] = $u;
	$_SESSION["password"] = $p;
?>
<?php 
	include 'mysql.php';
	if(isset($_POST["username"])){
		try{
			$db = db();
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "select * from users where password = ".$db->quote($_POST["password"])." and username = ".$db->quote($_POST["username"]).";";
			//echo $query;
			$rows = $db->query($query);
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["password"] = $_POST["password"];

			if($rows->rowCount()==0){
				die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
			}
		}
		catch(PDOException $e){
			die($e);
		}
	}
	elseif(isset($_SESSION["username"])){
		try{
			$db = db();
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "select * from users where password = ".$db->quote($_SESSION["password"])." and username = ".$db->quote($_SESSION["username"]).";";
			//echo $query;
			$rows = $db->query($query);

			if($rows->rowCount()==0){
				die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
			}
		}
		catch(PDOException $e){
			die($e);
		}
	}
	else{
		die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
	}
	if(count($_POST)){
		header("Location: main.php");
	}
	?>

<!DOCTYPE html>
<html>
<head>
	<title>Poultry Manager</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="main.js"></script>
</head>
<body>
	<header id="mainheader" class="h2">
	<div id="home" class="mainlink">
		<img src="logo.png">
		<h3>The Poultry Hub</h3>
	</div>
	<div id="lo" class="mainlink">
		<h3>Logout</h3>
	</div>
</header>
	<?php
	$user = $rows->fetch();
	if($user["role"] == "admin" || $user["role"] == "manager"){
?>
	<h1>Welcome, <?=$user['username']?></h1>
<?php 
		try{
			$shows = $db->query("select * from shows where admin_id=$user[id] order by date desc;");
		}catch(PDOException $e){
			echo $e;
		}
?>
<div class="rows">
<?php
		foreach($shows as $show){
?>
	<div class="row">
		<p><?=$show['name']?></p>
		<form action="show.php" method="post">
			<input type="submit" value="Edit">
			<input type="hidden" name="show_id" value="<?=$show[id]?>">
		</form>
	</div>
<?php
		}
?>
<div class="row">
	<p>Create New Show</p>
	<form action="show.php" method="post">
		<input type="submit" name="ns" value="New Show">
	</form>
</div>
</div>
<?php
	}
	else{
?>
	<h1>You are not a manager</h1>
<?php
	}
?>
</body>
</html>