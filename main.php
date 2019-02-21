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
	<header>
	<div id="home" class="mainlink">
		<img src="logo.png">
		<h3>The Poultry Hub</h3>
	</div>
	<div id="clerklogin" class="mainlink">
		<h3>Clerk Login</h3>
	</div>
	<div id="clogin" class="login popup" style="display: none">
		<fieldset>
			<legend>Clerk Sign In</legend>
			<form action="clerk/clerk.php" method="POST">
				Name:<br />
				<input type="text" name="name" required>
				<br />
				Judge:<br />
				<input type="text" name="judge" required>
				<br />
				Show Id:<br />
				<input type="text" name="id" required>
				<br />
				<input type="submit" name="submit">
				<input class="exit" type="button" name="cancel" value = "Cancel">
			</form>
		</fieldset>
	</div>
	<div id="exlogin" class="mainlink">
		<h3>Exhibitor Login</h3>
	</div>
	<div id="seclogin" class="mainlink">
		<h3>Secretary Login</h3>
	</div>
	<div id="login" class="login popup" style="display: none">
		<fieldset>
			<legend>Secretary Sign In</legend>
			<form action="main.php" method="POST">
				Username:<br />
				<input type="text" name="username" required>
				<br />
				Password:<br />
				<input type="password" name="password" required>
				<br />
				<input type="submit" name="submit">
				<input class="exit" type="button" name="cancel" value = "Cancel">
			</form>
		</fieldset>
	</div>
	<div id="sup" class="mainlink">
		<h3>Sign Up</h3>
	</div>
	<div id="signup" class="popup" style="display: none">
		<fieldset>
			<legend>Sign Up</legend>
			<form id="signupform" action="signup.php" method="POST">
				Email:<br />
				<input type="email" name="email" required>
				<br />
				Username:<br />
				<input type="text" name="username" required>
				<br />
				Password:<br />
				<input type="password" name="spassword" required>
				<br />
				Confirm Password:<br />
				<input type="password" name="sconfirmpassword" required>
				<br />
				Role:<br />
				<select name="role" required>
					<option disabled selected></option>
					<option value="manager">Secretary</option>
					<option value="user">User</option>
				</select>
				<br>
				<input type="submit" name="submit">
				<input class="exit" type="button" name="cancel" value = "Cancel">
			</form>
		</fieldset>
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