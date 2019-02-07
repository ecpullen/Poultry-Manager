<?php 
function db(){
	$db = new PDO("mysql:dbname=info;host=127.0.0.1",
				"root",
				"admin123");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}
function validate($uname, $pword){

	return db()->query("select * from users where password = ".db()->quote($pword)." and username = ".db()->quote($uname).";")->rowCount() != 0;
}
function check_show($usr_id,$sname){
	return db()->query("select * from shows where admin_id = $usr and id = ".db()->quote($sname).";")->rowCount() != 0;
}
function get_show($sname){
	return db()->query("select * from shows where id = ".$sname.";")->fetch();
}
function showdb($show){
	$showdb = new PDO("mysql:dbname=_$show[id];host=127.0.0.1",
			"root",
			"admin123");
	$showdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $showdb;
}
function id_from_sname($sname){
	return db()->query("select * from shows where name = ".db()->quote($sname).";")->fetch()[id];
}
function user($uname){
	$user = db()->query("select * from users where username = ".db()->quote($uname).";")->fetch();
}
function birds($show){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,ex_id,birds.breed_id,birds.variety_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id ORDER BY classes.id, breed, variety, age_id, ex_id");
}
function birds_by_ex($show, $ex){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on ages.id = age_id where ex_id=".$ex);
}
function get_LF($show){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 1");
}
function get_BTM($show){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 2");
}
function get_WF($show){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 3");
}
function exhibitors($show){
	return showdb($show)->query("SELECT * FROM exhibitors");
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
function add_bird($show, $ex_id, $breed_id, $variety_id, $age_id, $frizzle = 0){
	$f = $frizzle?"1":"0";
	showdb($show)->query("INSERT INTO birds (ex_id,age_id,variety_id,breed_id,frizzle) VALUES ($ex_id,$age_id,$variety_id,$breed_id,".$f.");");
}
function update_bird($id,$show, $ex_id, $breed_id, $variety_id, $age_id, $frizzle = 0){
	showdb($show)->query("UPDATE birds SET age_id = $age_id, variety_id = $variety_id, breed_id = $breed_id frizzle = $frizzle WHERE id = $id");
}
function delete($show, $id){
	showdb($show)->query("DELETE FROM birds WHERE id = $id");
}
function get_ids($division,$breed,$variety){
	return db()->query("SELECT cbv.class_id, breed_id, variety_id FROM cbv join breeds on breeds.id = breed_id join varieties on varieties.id = variety_id join divisions ON divisions.class_id = cbv.class_id where division like '$division' and breed like '$breed' and variety like '$variety'")->fetch();
}
function get_ids_with_class($class,$breed,$variety){
	return db()->query("SELECT cvb.class_id, breed_id, variety_id FROM cbv join breeds on breeds.id = breed_id join varieties on varieties.id = varieties_id join classes ON classes.id = cbv.class_id where classes.name like '$class' and breed like '$breed' and variety = '$variety'")->fetch();
}
function get_ex($show, $id){
	return showdb($show)->query("SELECT * FROM exhibitors WHERE id=$id;")->fetch();
}
function ex_exists($show, $name){
	return showdb($show)->query("SELECT * FROM exhibitors WHERE name like ".db()->quote($name).";")->rowCount() != 0;
}
function get_ex_by_name($show,$name){
	return showdb($show)->query("SELECT * FROM exhibitors WHERE name like ".db()->quote($name).";")->fetch();
}
function update_ex($show,$values,$cond){
	showdb($show)->query("UPDATE exhibitors SET $values where $cond;");
}
function add_ex($show,$name,$address,$city,$state,$zip,$email,$phone){
	showdb($show)->query("INSERT INTO exhibitors (name,address,city,state,zip,email,phone) VALUES (".db()->quote($name).",".db()->quote($address).",".db()->quote($city).",".db()->quote($state).",".db()->quote($zip).",".db()->quote($email).",".db()->quote($phone).");");
}
function finalize($show){
	$showdb = showdb($show);
	$showdb->exec("DROP TABLE IF EXISTS temp");
	$showdb->exec("CREATE TABLE temp LIKE birds;
						INSERT INTO temp (ex_id,age_id,variety_id,breed_id,frizzle) SELECT ex_id,birds.age_id,birds.variety_id,birds.breed_id,frizzle FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id =cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id ORDER BY classes.id, breed, variety, age_id, ex_id");
	$showdb->exec("DROP TABLE birds;");
	$showdb->exec("CREATE TABLE birds LIKE temp;
		INSERT INTO birds (ex_id,age_id,variety_id,breed_id,frizzle) SELECT ex_id,age_id,variety_id,breed_id,frizzle FROM temp");
}

?>












