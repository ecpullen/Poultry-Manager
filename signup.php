<?php 
	session_start();
	include "mysql.php";
	if(isset($_GET[uname])){
		$match = db()->query("SELECT * FROM users where username =".db()->quote($_GET[uname]))->rowCount();
		if($match){
			die("bad");
		}
		die("good");
	}
	if(isset($_POST["username"])){
		try{
			$db = db();
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "insert into users (username,password,email, role) values (".$db->quote($_POST["username"]).",".$db->quote($_POST["spassword"]).",".$db->quote($_POST["email"]).",".$db->quote($_POST["role"]).");";
			$rows = $db->query($query);
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["password"] = $_POST["spassword"];
			header("Location: main.php");
		}
		catch(PDOException $e){
			die($e);
		}
	}
	else{
		echo("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
	}
?>