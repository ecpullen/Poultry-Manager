<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
</head>
<body>
	
<?php 
	if(isset($_POST["username"])){
		try{
			$db = new PDO("mysql:dbname=info;host=127.0.0.1",
				"root",
				"admin123");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "insert into users (username,password,email) values (".$db->quote($_POST["username"]).",".$db->quote($_POST["spassword"]).",".$db->quote($_POST["email"]).");";
			$rows = $db->query($query);
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["password"] = $_POST["spassword"];

?>
		You have successfully logged in.
<?php
		}
		catch(PDOException $e){
			die($e);
		}
	}
	else{
		echo("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
	}
?>

</body>
</html>