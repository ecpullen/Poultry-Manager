<?php 
	session_start();
	include '../mysql.php';
?>
<!DOCTYPE html>
<html>
<head>
<?php
	if(isset($_POST[id])){
		$_SESSION[show_id] = $_POST[id];
		$_SESSION[clerk] = $_POST[name];
		$_SESSION[judge] = $_POST[judge];
	}
	if(isset($_SESSION[show_id])){
		try{
			$show = get_show($_SESSION[show_id]);
			$birds = birds($show);
			$var = "";
			$breed = "";
			$age = "";
			$classname = "";
?>
	<title>Clerk: <?=$show[name]?></title>
	<link rel="stylesheet" type="text/css" href="clerk_1.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="jquery.sticky.js"></script>
	<script src="clerk_1.js"></script>
</head>
<body>
</body>
</html>
<?php
		}
		catch(PDOException $e){
			die($e);
		}
	}
?>