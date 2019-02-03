<?php 
function db(){
	$db = new PDO("mysql:dbname=info;host=127.0.0.1",
				"root",
				"admin123");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}
function validate($uname, $pword){
	return db()->query("select * from users where password = ".$db->quote($pword)." and username = ".$db->quote($uname).";")->rowCount() != 0;
}
function check_show($usr_id,$sname){
	return db()->query("select * from shows where admin_id = $usr and id = ".$db->quote($sname).";")->rowCount() != 0;
}
function get_show($sname){
	return db()->query("select * from shows where admin_id = $usr and id = ".$db->quote($sname).";")->fetch();
}
function showdb($show){
	$showdb = new PDO("mysql:dbname=$show[name];host=127.0.0.1",
			"root",
			"admin123");
	$showdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $showdb;
}
function user($uname){
	$user = $db->query("select * from users where username = ".$db->quote($uname).";")->fetch();
}
function birds(){
	return $showdb->query("SELECT breeds.class_id, classname, breed, variety, age, birds.id, ex_id from birds JOIN breeds ON birds.breed_id = breeds.id JOIN classes on breeds.class_id = classes.id ORDER BY breeds.class_id, breed, variety, age, ex_id");
}
function val_and_showdb($uname, $pword, $sname){
	$db = db();
	if(validate($uname,$pword)){
		$user = user($uname);
		$db = db();
		$show = get_show($sname);
		$showdb = showdb($show);
		$ret = array();
		$ret[user] = $user;
		$ret[db] = $db;
		$ret[show] = $show;
		$ret[showdb] = $showdb;
		return $ret;
	}
	return;
}
?>