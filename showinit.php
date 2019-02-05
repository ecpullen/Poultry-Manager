<?php
session_start();
if(isset($_SESSION["username"])&&isset($_POST["show_name"])){
	//die("in if");
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
		$query = "INSERT INTO shows (admin_id, name) VALUES ($user[id],".$db->quote($_POST[show_name]).")";
		$db->query($query);
		$conn = new PDO("mysql:host=127.0.0.1","root","admin123");
		$conn->exec("create database if not exists $_POST[show_name];");

		$showdb = new PDO("mysql:dbname=$_POST[show_name];host=127.0.0.1",
			"root",
			"admin123");
		$showdb->query("CREATE TABLE exhibitors(
			id int(4) NOT NULL AUTO_INCREMENT,
			name VARCHAR(30),
			address VARCHAR(60),
			city VARCHAR(30),
			state VARCHAR(20),
			zip VARCHAR(10),
			email VARCHAR(30),
			phone VARCHAR(20),
			PRIMARY KEY (id)
			);");
		$showdb->query("CREATE TABLE awards(
			type VARCHAR(5),
			number INT(3),
			place INT(2),
			bird_id INT(5)
			);");
		$showdb->query("CREATE TABLE birds(
			id int(5) NOT NULL AUTO_INCREMENT,
			ex_id int(4),
			age VARCHAR(10),
			variety VARCHAR(50),
			breed_id int(11),
			PRIMARY KEY (id)
			);");
		$showdb->exec("CREATE TABLE divisions LIKE info.divisions;
						INSERT INTO divisions  
    					SELECT * FROM info.divisions;");

		$showdb->exec("CREATE TABLE classes LIKE info.classes;
						INSERT INTO classes  
    					SELECT DISTINCT * FROM info.classes;");
		$showdb->exec("CREATE TABLE breeds LIKE info.breeds;
						INSERT INTO breeds  
    					SELECT * FROM info.breeds;");
		echo "sucessfully created $_POST[show_name]";
	}
	catch(PDOException $e){
		die($e);
	}
}
