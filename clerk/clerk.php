<?php 
	session_start();
	include '../mysql.php';
?>
<!DOCTYPE html>
<html>
<head>
<?php
	if(isset($_POST[id])){
		$_SESSION[show_id] = explode(" ", $_POST[id])[0];
		if(count(explode(" ", $_POST[id]))>1){
			$temp = explode(" ", $_POST[id])[1];
			$_SESSION[junior] = $temp % 2;
			$_SESSION[show_num] = ($temp - $temp % 2)/2;
			$_SESSION[color] = get_color($_SESSION[show_num]);
		}
		else{
			$_SESSION[junior] = 0;
			$_SESSION[show_num] = 0;
			$_SESSION[color] = "";
		}
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
	<title>Clerk: <?=$show[name]?><?=$_SESSION[junior]?" JR":""?><?=" ".strtoupper($_SESSION[color])?></title>
	<link rel="stylesheet" type="text/css" href="clerk.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="jquery.sticky.js"></script>
	<script src="clerk.js"></script>
</head>
<body>
<div class="row">
	<h1>Clerk: <?=$show[name]?></h1>
	<h2><?=$_SESSION[junior]?" JUNIOR":""?><?=" ".strtoupper($_SESSION[color])?></h2>
</div>
</body>
</html>
<?php
		}
		catch(PDOException $e){
			die($e);
		}
	}
?>