<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$db = new PDO("mysql:dbname=info;host=127.0.0.1",
				"root",
				"admin123");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "select * from users where password = ".$db->quote($_SESSION["password"])." and username = ".$db->quote($_SESSION["username"]).";";
			$rows = $db->query($query);
			$user = $rows->fetch();
			if($rows->rowCount()==0){
				die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
			}
			$query = "select * from shows where admin_id = $user[id] and id = ".$db->quote($_SESSION[show_id]).";";
			// echo $query;
			$rows = $db->query($query);
			if($rows->rowCount() == 0){
				die("<h1>Show not found</h1><a href='main.php'>Try Again</a>");
			}
			$show = $rows->fetch();
			$showdb = new PDO("mysql:dbname=$show[name];host=127.0.0.1",
			"root",
			"admin123");
			$showdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$ex = $showdb->query("SELECT * FROM exhibitors")->rowCount();
			$bnum = $showdb->query("SELECT * FROM birds")->rowCount();
			$lf = $showdb->query("SELECT * FROM birds JOIN breeds ON breeds.id = birds.breed_id JOIN divisions ON breeds.class_id = divisions.class_id where divisions.id = 1;")->rowCount();
			$btm = $showdb->query("SELECT * FROM birds JOIN breeds ON breeds.id = birds.breed_id JOIN divisions ON breeds.class_id = divisions.class_id where divisions.id = 2;")->rowCount();
			$wf = $showdb->query("SELECT * FROM birds JOIN breeds ON breeds.id = birds.breed_id JOIN divisions ON breeds.class_id = divisions.class_id where divisions.id = 3;")->rowCount();
?>
<p><?=$ex?> exhibitors registered.</p>
<p><?=$bnum?> birds registered.</p>
<p><?=$lf?> largefowl registered.</p>
<p><?=$btm?> bantams registered.</p>
<p><?=$wf?> waterfowl registered.</p>
<?php
		}
		catch(PDEException $e){
			echo $e;
		}
	}
?>
