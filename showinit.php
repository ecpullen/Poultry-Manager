<?php
session_start();

include 'mysql.php';

if(isset($_SESSION["username"])&&isset($_POST["show_name"])){
	//die("in if");
	try{
		$db = db();
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = "select * from users where password = ".$db->quote($_SESSION["password"])." and username = ".$db->quote($_SESSION["username"]).";";
		//echo $query;
		$rows = $db->query($query);
		$user = $rows->fetch();
		if($rows->rowCount()==0){
			die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
		}
		$query = "INSERT INTO shows (admin_id, name, date, junior ".($_POST["ds"]?", show1, show2":"").") VALUES ($user[id],".$db->quote($_POST[show_name]).", '$_POST[date]', $_POST[jr]".($_POST["ds"]?", $_POST[s1], $_POST[s2]":"").")";
		$db->query($query);
		$id = $db->query("select id from shows where name = ".$db->quote($_POST[show_name]).";")->fetch()[id];
		//$conn = new PDO("mysql:host=127.0.0.1","root","admin123");
		//$conn->exec("create database if not exists _$id;");
		show_init($id);
		
		
		
		// $showdb->exec("CREATE TABLE divisions LIKE info.divisions;
		// 				INSERT INTO divisions  
  //   					SELECT * FROM info.divisions;");
		// $showdb->exec("CREATE TABLE classes LIKE info.classes;
		// 				INSERT INTO classes  
  //   					SELECT DISTINCT * FROM info.classes;");
		
		
		// $showdb->exec("CREATE TABLE ages LIKE info.ages;
		// 				INSERT INTO ages  
  //   					SELECT * FROM info.ages;");
		

		echo "sucessfully created $_POST[show_name]";
	}
	catch(PDOException $e){
		die($e);
	}
}
