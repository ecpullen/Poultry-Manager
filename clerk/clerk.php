<?php 
	session_start();
	include 'mysql.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Exhibitor</title>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="manager.js"></script>
</head>
<body>
<?php
	if(isset($_SESSION[show_id])){
		try{
			$show = get_show($_SESSION[show_id]);
			

		}
		catch(PDOException $e){
			die($e);
		}
?>
</body>
</html>