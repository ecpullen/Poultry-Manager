<?php 
	include 'mysql.php';
	if($_POST[type] == "secretary"){
		echo (validate($_POST[username],$_POST[password]) && (user($_POST[username])[role] == 'manager' || user($_POST[username])[role] == 'admin'));
	}
	elseif($_POST[type] == "exhibitor"){
		echo validate($_POST[username],$_POST[password]);
	}
?>