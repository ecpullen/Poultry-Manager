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
</head>
<body>
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
		foreach($shows as $show){
?>
	<form action="show.php" method="post">
		<input type="submit" value="<?=$show['name']?>">
		<input type="hidden" name="show_id" value="<?=$show[id]?>">
	</form>
<?php
		}
?>
	<form action="show.php" method="post">
		<input type="submit" name="ns" value="New Show">
	</form>
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