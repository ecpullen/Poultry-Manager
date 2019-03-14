<?php 
$db;

function db(){
	if(!isset($db))
	{$db = new PDO("mysql:dbname=main;host=127.0.0.1",
				"root",
				"admin123");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
	return $db;
}
function show_init($id){
	$showdb = db();
	$name = "_".$id."_";
	$showdb->query("CREATE TABLE ".$name."exhibitors(
			id int(4) NOT NULL AUTO_INCREMENT,
			name VARCHAR(30),
			address VARCHAR(60),
			city VARCHAR(30),
			state VARCHAR(20),
			zip VARCHAR(10),
			email VARCHAR(30),
			phone VARCHAR(20),
			PRIMARY KEY (id));");
	$showdb->query("CREATE TABLE ".$name."awards(
			type VARCHAR(5),
			number INT(3),
			place INT(2),
			bird_id INT(5),
			show_num INT(2),
			clerk VARCHAR(50),
			judge VARCHAR(50));");
	$showdb->query("CREATE TABLE ".$name."birds(
			id int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			ex_id int(4),
			age_id VARCHAR(10),
			variety_id VARCHAR(50),
			breed_id int(11),
			frizzle BOOLEAN, 
			show_num INT(2));");
	$showdb->exec("CREATE TABLE ".$name."breeds LIKE info.breeds;
						INSERT INTO ".$name."breeds  
    					SELECT * FROM info.breeds;");
	$showdb->exec("CREATE TABLE ".$name."varieties LIKE info.varieties;
						INSERT INTO ".$name."varieties  
    					SELECT * FROM info.varieties;");
	$showdb->exec("CREATE TABLE ".$name."cbv LIKE info.cbv;
						INSERT INTO ".$name."cbv  
    					SELECT * FROM info.cbv;");
	$showdb->exec("CREATE TABLE ".$name."sawards LIKE info.sawards;");
}
function ex_count($show){
	$name = "_".$show[id]."_";
	db()->query("SELECT * FROM ".$name."exhibitors")->rowCount();
}
function b_count($show){
	$name = "_".$show[id]."_";
	db()->query("SELECT * FROM ".$name."birds")->rowCount();
}
function get_age($age_id){
	return db()->query("SELECT * FROM ages where id = $age_id")->fetch()[age];
}
function get_age_id($age){
	return db()->query("SELECT * FROM ages where age like '$age'")->fetch()[id];
}
function get_var($variety_id){
	return db()->query("SELECT * FROM varieties where id = $variety_id")->fetch()[variety];
}
function get_bre($show,$breed_id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT * FROM ".$name."breeds where id = $breed_id")->fetch()[breed];
}
function get_cla($class_id){
	return db()->query("SELECT * FROM classes where id = $class_id")->fetch()[classname];
}
function get_color($color_id){
	return db()->query("SELECT * from show_color where id = $color_id")->fetch()[color];
}
function get_all_cla(){
	return db()->query("SELECT * from classes");
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
// function db(){
// 	$showdb = new PDO("mysql:dbname=_$show[id];host=127.0.0.1",
// 			"root",
// 			"admin123");
// 	$showdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	return $showdb;
// }
function id_from_sname($sname){
	return db()->query("select * from shows where name = ".db()->quote($sname).";")->fetch()[id];
}
function user($uname){
	return db()->query("select * from users where username = ".db()->quote($uname).";")->fetch();
}
function birds($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.id,classname,breed,variety,age,age_id,ex_id,".$name."birds.breed_id,".$name."birds.variety_id, frizzle, NR, show_num FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join ages on ".$name."birds.age_id = ages.id ORDER BY show_num,classes.id, breed, NR, variety, frizzle, age_id, ex_id");
}
function get_bird($show, $id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.*,breed,age,variety,class_id,".$name."breeds.id as breed_id,".$name."varieties.id as variety_id from ".$name."birds left join ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join ".$name."varieties on ".$name."varieties.id = ".$name."birds.variety_id join ".$name."breeds on ".$name."breeds.id = ".$name."birds.breed_id join ages on ages.id = ".$name."birds.age_id where ".$name."birds.id = $id")->fetch();
}
function get_bird_str($show, $id){
	$bird = get_bird($show, $id);
	return "$bird[variety]".($bird[frizzle]?" Frizzled ":" ")."$bird[breed] $bird[age]";
}
function get_divisions($show){
	return db()->query("SELECT DISTINCT division as data, id as var_id from divisions");
}
function get_division($show, $div){
	return db()->query("SELECT DISTINCT id from divisions where division like '$div'")->fetch()[id];
}
function get_div($show,$division_id){
	return db()->query("SELECT DISTINCT division from divisions where id = $division_id")->fetch()[division];
}
function get_classes($show,$div){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT classes.classname as data, classes.id, classes.id as var_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join classes on classes.id = ".$name."cbv.class_id join divisions on divisions.class_id = ".$name."cbv.class_id where divisions.id = $div and ".$name."birds.show_num = $_SESSION[junior] ORDER BY classes.id");
}
function get_classs($show,$cla){
	return db()->query("SELECT DISTINCT id from classes where classname like '$cla'")->fetch()[id];
}
function get_breeds($show,$cla){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT breed as data, ".$name."breeds.id as var_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join classes on classes.id = ".$name."cbv.class_id join ".$name."breeds on ".$name."breeds.id = ".$name."cbv.breed_id where classes.id = $cla and ".$name."birds.show_num = $_SESSION[junior] ORDER BY breed");
}
function get_breed($show,$cla, $breed){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."birds.breed_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join classes on classes.id = ".$name."cbv.class_id join ".$name."breeds on ".$name."breeds.id = ".$name."cbv.breed_id where classname like '$cla' and breed like '$breed'")->fetch()[breed_id];
}
function get_varieties($show,$bre, $cla){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT concat(variety,' ',(case when frizzle = 0 then ''when frizzle = 1 then ' Frizzle' end)) as data, (".$name."birds.variety_id*2 + frizzle) as var_id FROM ".$name."birds LEFT JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id left join ".$name."varieties on ".$name."varieties.id = ".$name."birds.variety_id left join ".$name."breeds on ".$name."breeds.id = ".$name."birds.breed_id left join classes on classes.id = ".$name."cbv.class_id where ".$name."birds.show_num = $_SESSION[junior] and(".$name."breeds.id = $bre and ".$name."cbv.class_id = $cla) or (ISNULL(".$name."cbv.class_id) and ".$name."breeds.id = $bre) ORDER BY data");
}
function get_variety($show,$variety){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT id from ".$name."varieties where variety like '$variety'")->fetch()[id];
}
function conv_variety($show,$variety_id){
	$fri = $variety_id%2;
	$var = ($variety_id-$fri)/2;
	$name = "_".$show[id]."_";
	return db()->query("SELECT variety from ".$name."varieties where id = $var")->fetch()[variety].($fri?" frizzle":"");
}
function get_ages($show,$var, $bre){
	$fri = $var%2;
	$var = ($var-$fri)/2;
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT age as data, age_id FROM ".$name."birds join ages on age_id = ages.id where ".$name."birds.breed_id = $bre and ".$name."birds.variety_id = $var and frizzle = $fri and ".$name."birds.show_num = $_SESSION[junior] ORDER BY age_id");
}
function get_birds($show,$class,$breed,$var,$age){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.id,classname,breed,variety,age,age_id,ex_id,".$name."birds.breed_id,".$name."birds.variety_id,frizzle FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join ages on ".$name."birds.age_id = ages.id where classname like '$class' and ".$name."breed like '$breed' and ".$name."variety like '$var' and age like '$age' ORDER BY ".$name."birds.id");
}
function get_birds_rev($show,$breed,$var,$age){
	$fri = $var%2;
	$var = ($var-$fri)/2;
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.*,breed,variety,age FROM ".$name."birds JOIN ".$name."varieties on ".$name."birds.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."birds.breed_id = ".$name."breeds.id join ages on ".$name."birds.age_id = ages.id where ".$name."breeds.id = $breed and ".$name."varieties.id = $var and frizzle = $fri and age like '$age' and ".$name."birds.show_num = $_SESSION[junior] ORDER BY ".$name."birds.id");
}
function get_vars($show,$breed_id){
	$name = "_".$show[id]."_";
	if(db()->query("SELECT * from ".$name."cbv where breed_id = $breed_id and NR = 0")->rowCount()){
		return db()->query("SELECT DISTINCT (".$name."birds.variety_id*2 + frizzle) as variety_id, variety FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join ".$name."varieties on ".$name."birds.variety_id = ".$name."varieties.id where ".$name."birds.breed_id = $breed_id and NR = 0 ORDER BY variety");
	}
	return db()->query("SELECT DISTINCT (".$name."birds.variety_id*2 + frizzle) as variety_id, variety FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id join ".$name."varieties on ".$name."birds.variety_id = ".$name."varieties.id where ".$name."birds.breed_id = $breed_id ORDER BY variety");
}
function get_bres($show,$class_id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."birds.breed_id, breed FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join ".$name."breeds on ".$name."birds.breed_id = ".$name."breeds.id where ".$name."cbv.class_id = $class_id and NR = 0 ORDER BY breed");
}
function get_clas($show,$division_id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."cbv.class_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join ".$name."breeds on ".$name."birds.breed_id = ".$name."breeds.id join divisions on divisions.class_id = ".$name."cbv.class_id where divisions.id = $division_id ORDER BY ".$name."cbv.class_id");
}
function get_divs($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT divisions.id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id join ".$name."breeds on ".$name."birds.breed_id = ".$name."breeds.id join divisions on divisions.class_id = ".$name."cbv.class_id ORDER BY divisions.id");
}
function birds_by_ex($show, $ex){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.id,classname,breed,variety,age,frizzle,".$name."birds.breed_id,".$name."cbv.class_id,show_num FROM ".$name."birds LEFT JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id LEFT JOIN ".$name."varieties on ".$name."birds.variety_id = ".$name."varieties.id left join ".$name."breeds on ".$name."birds.breed_id = ".$name."breeds.id left join classes on ".$name."cbv.class_id = classes.id join ages on ages.id = age_id where ex_id=$ex ORDER BY ISNULL(".$name."cbv.class_id),".$name."cbv.class_id,breed,variety,frizzle,age,".$name."birds.id");
}
function class_by_breed($show, $breed_id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT classname from ".$name."cbv join classes on class_id = classes.id where breed_id = $breed_id")->fetch()[classname];
}
function get_LF($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 1");
}
function get_BTM($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 2");
}
function get_WF($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 3");
}
function get_count($show){
	$counts = array();
	$name = "_".$show[id]."_";
	$counts[o] = db()->query("SELECT * FROM ".$name."birds where show_num != 1")->rowCount();
	$counts[j] = db()->query("SELECT * FROM ".$name."birds where show_num = 1")->rowCount();
	$counts[o_lf] = db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 1 and ".$name."birds.show_num != 1")->rowCount();
	$counts[j_lf] = db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 1 and ".$name."birds.show_num = 1")->rowCount();
	$counts[o_btm] = db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 2 and ".$name."birds.show_num != 1")->rowCount();
	$counts[j_btm] = db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 2 and ".$name."birds.show_num = 1")->rowCount();
	$counts[o_wf] = db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 3 and ".$name."birds.show_num != 1")->rowCount();
	$counts[j_wf] = db()->query("SELECT ".$name."birds.id,classname,breed,variety,age_id FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 3 and ".$name."birds.show_num = 1")->rowCount();
	return $counts;
}
function exhibitors($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT * FROM ".$name."exhibitors");
}
function val_and_showdb($uname, $pword, $sname){
	$db = db();
	if(validate($uname,$pword)){
		$user = user($uname);
		$db = db();
		$show = get_show($sname);
		$showdb = db();
		$ret = array();
		$ret[user] = $user;
		$ret[db] = $db;
		$ret[show] = $show;
		$ret[showdb] = $showdb;
		return $ret;
	}
	return;
}
function add_bird($show, $ex_id, $breed_id, $variety_id, $age_id, $frizzle = 0, $jr = 0){
	$f = $frizzle?"TRUE":"FALSE";
	$jr = $jr?1:0;
	$name = "_".$show[id]."_";
	db()->query("INSERT INTO ".$name."birds (ex_id,age_id,variety_id,breed_id,frizzle, show_num) VALUES ($ex_id,$age_id,$variety_id,$breed_id,".$f.", $jr);");
}
function update_bird($id,$show, $ex_id, $breed_id, $variety_id, $age_id, $frizzle = 0, $jr = 0){
	$name = "_".$show[id]."_";
	if(!$frizzle){
		$frizzle = 'FALSE';
	}
	else{
		$frizzle = 'TRUE';
	}
	$jr = $jr?1:0;
	db()->query("UPDATE ".$name."birds SET age_id = $age_id, variety_id = $variety_id, breed_id = $breed_id, frizzle = $frizzle, show_num = $jr WHERE id = $id");
}
function delete($show, $id){
	$name = "_".$show[id]."_";
	db()->query("DELETE FROM ".$name."birds WHERE id = $id");
}
function get_ids($show,$division,$breed,$variety){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."cbv.class_id, breed_id, variety_id FROM ".$name."cbv join ".$name."breeds on ".$name."breeds.id = breed_id join ".$name."varieties on ".$name."varieties.id = variety_id join divisions ON divisions.class_id = ".$name."cbv.class_id where division like '$division' and breed like '$breed' and variety like '$variety'")->fetch();
}
function get_ids_with_class($show,$class,$breed,$variety){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."cbv.class_id, breed_id, variety_id FROM ".$name."cbv join ".$name."breeds on ".$name."breeds.id = breed_id join ".$name."varieties on ".$name."varieties.id = variety_id join classes ON classes.id = ".$name."cbv.class_id where classes.classname like '$class' and breed like '$breed' and variety = '$variety'")->fetch();
}
function get_breed_with_div($show, $division, $breed){
	$name = "_".$show[id]."_";
	return db()->query("SELECT ".$name."cbv.class_id, breed_id FROM ".$name."cbv join ".$name."breeds on ".$name."breeds.id = breed_id join divisions ON divisions.class_id = ".$name."cbv.class_id where division like '$division' and breed like '$breed'")->fetch();
}
function get_breed_no_div($breed){
	$name = "_".$show[id]."_";
	return db()->query("select id from ".$name."breeds where breed like '$breed'");
}
function add_breed($show, $division_id, $breed){
	$ids = array();
	$class_id = 21 + $division_id;
	$s = db();
	$name = "_".$show[id]."_";
	$s->query("INSERT INTO ".$name."breeds VALUES(0,'$breed')");
	$breed_id = $s->lastInsertId();
	$ids[class_id] = $class_id;
	$ids[breed_id] = $breed_id;
	return $ids;
}
function add_variety($show, $variety){
	$name = "_".$show[id]."_";
	db()->query("INSERT INTO ".$name."varieties VALUES(0,'$variety')");
	return db()->query("SELECT * FROM ".$name."varieties WHERE variety like '$variety'")->fetch()[id];
}
function add_variety_link($show, $ids, $variety){
	$name = "_".$show[id]."_";
	$variety_id = get_variety($show, $variety);
	if(!$variety_id){
		$variety_id = add_variety($show, $variety);
	}
	db()->query("INSERT INTO ".$name."cbv VALUES($ids[class_id],$ids[breed_id],$variety_id,".($ids[class_id] >= 25? 0 : 1).")");
	return $variety_id;
}
function get_ex($show, $id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT * FROM ".$name."exhibitors WHERE id=$id;")->fetch();
}
function ex_exists($show, $exname){
	$name = "_".$show[id]."_";
	return db()->query("SELECT * FROM ".$name."exhibitors WHERE name like ".db()->quote($exname).";")->rowCount() != 0;
}
function get_ex_by_name($show,$exname){
	$name = "_".$show[id]."_";
	return db()->query("SELECT * FROM ".$name."exhibitors WHERE name like ".db()->quote($exname).";")->fetch();
}
function update_ex($show,$values,$cond){
	$name = "_".$show[id]."_";
	db()->query("UPDATE ".$name."exhibitors SET $values where $cond;");
}
function add_ex($show,$exname,$address,$city,$state,$zip,$email,$phone){
	$name = "_".$show[id]."_";
	db()->query("INSERT INTO ".$name."exhibitors (name,address,city,state,zip,email,phone) VALUES (".db()->quote($exname).",".db()->quote($address).",".db()->quote($city).",".db()->quote($state).",".db()->quote($zip).",".db()->quote($email).",".db()->quote($phone).");");
}
function finalize($show){
	$name = "_".$show[id]."_";
	$showdb = db();
	$showdb->exec("DROP TABLE IF EXISTS ".$name."temp");
	$showdb->exec("CREATE TABLE ".$name."temp LIKE ".$name."birds;
						INSERT INTO ".$name."temp (ex_id,age_id,variety_id,breed_id,frizzle, show_num) SELECT ex_id,".$name."birds.age_id,".$name."birds.variety_id,".$name."birds.breed_id,frizzle,show_num FROM ".$name."birds JOIN ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id JOIN ".$name."varieties on ".$name."cbv.variety_id = ".$name."varieties.id join ".$name."breeds on ".$name."cbv.breed_id = ".$name."breeds.id join classes on ".$name."cbv.class_id = classes.id join ages on ".$name."birds.age_id = ages.id ORDER BY show_num,classes.id, breed, variety, frizzle, age_id, ex_id");
	$showdb->exec("DROP TABLE ".$name."birds;");
	$showdb->exec("CREATE TABLE ".$name."birds LIKE ".$name."temp;
		INSERT INTO ".$name."birds (ex_id,age_id,variety_id,breed_id,frizzle,show_num) SELECT ex_id,age_id,variety_id,breed_id,frizzle,show_num FROM ".$name."temp");
}
function addAward($show, $type, $num, $rank, $bird){
	$name = "_".$show[id]."_";
	db()->query("INSERT INTO ".$name."awards VALUES (".db()->quote($type).",$num,$rank,$bird, $_SESSION[show_num], '$_SESSION[clerk]', '$_SESSION[judge]')");
}
function get_rank($show, $bird_id){
	$name = "_".$show[id]."_";
	$row = db()->query("SELECT place from ".$name."awards where bird_id = $bird_id and type = 'R' and show_num = $_SESSION[show_num]");
	if($row->rowCount() != 0){
		return $row->fetch()[place];
	}
	else{
		return 0;
	}
}
function get_ranks($show, $bird){
	$name = "_".$show[id]."_";
	return db()->query("SELECT bird_id, place from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where breed_id = $bird[breed_id] and variety_id = $bird[variety_id] and age_id = $bird[age_id] and frizzle = $bird[frizzle] and type='R' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_var_ranks($show, $breed_id, $variety_id){
	$name = "_".$show[id]."_";
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	return db()->query("SELECT bird_id, place, age_id from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where breed_id = $breed_id and variety_id = $variety_id and frizzle = $fri and type='V' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_bre_ranks($show, $breed_id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT bird_id, place, age_id from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where breed_id = $breed_id and type='B' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_cla_ranks($show, $class_id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT bird_id, place, age_id from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where number = $class_id and type='C' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_div_ranks($show, $division_id){
	$name = "_".$show[id]."_";
	return db()->query("SELECT bird_id, place, age_id from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where number = $division_id and type='D' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_sho_ranks($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT bird_id, place, age_id from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where type='S' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function rem_award_r($show, $breed_id, $variety_id, $age_id){
	$name = "_".$show[id]."_";
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	db()->query("DELETE ".$name."awards FROM ".$name."awards inner join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id where breed_id = $breed_id and variety_id = $variety_id and age_id = $age_id and frizzle = $fri and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior]");
}
function rem_award_v($show, $breed_id, $variety_id){
	$name = "_".$show[id]."_";
	db()->query("DELETE ".$name."awards FROM ".$name."awards inner join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id where breed_id = $breed_id and number = $variety_id and type ='V' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior]");
}
function rem_award_b($show, $breed_id){
	$name = "_".$show[id]."_";
	db()->query("DELETE ".$name."awards FROM ".$name."awards inner join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id where breed_id = $breed_id and type ='B' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior]");
}
function rem_award_c($show, $class_id){
	$name = "_".$show[id]."_";
	db()->query("DELETE ".$name."awards FROM ".$name."awards inner join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id join ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id where class_id = $class_id and type ='C' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior]");
}
function rem_award_d($show, $division_id){
	$name = "_".$show[id]."_";
	db()->query("DELETE ".$name."awards FROM ".$name."awards inner join ".$name."birds on ".$name."birds.id = bird_id where number = $division_id and type ='D' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior]");
}
function rem_award_s($show){
	$name = "_".$show[id]."_";
	db()->query("DELETE ".$name."awards FROM ".$name."awards inner join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id where type ='S' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior]");
}
function get_ordered_age_ranks($show, $breed_id, $variety_id, $age){
	$name = "_".$show[id]."_";
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	return db()->query("SELECT DISTINCT bird_id, place from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where breed_id = $breed_id and variety_id = $variety_id and age_id = $age and frizzle = $fri and type='R' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_var_ranks($show, $breed_id, $var){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT bird_id, place from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id where breed_id = $breed_id and number = $var and type='V' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_bre_ranks($show, $class_id, $var){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT bird_id, place from ".$name."awards join ".$name."birds on ".$name."birds.id = bird_id join ".$name."cbv on ".$name."birds.breed_id = ".$name."cbv.breed_id and ".$name."birds.variety_id = ".$name."cbv.variety_id where class_id = $class_id and number = $var and type='B' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_cla_ranks($show, $division_id, $var){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT bird_id, place from ".$name."awards join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id where number = $var and type='C' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_div_ranks($show, $var){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT bird_id, place from ".$name."awards join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id where number = $var and type='D' and ".$name."awards.show_num = $_SESSION[show_num] and ".$name."birds.show_num = $_SESSION[junior] order by place");
}
function rem_rank($show, $id){
	$name = "_".$show[id]."_";
	db()->query("DELETE FROM ".$name."awards WHERE bird_id = $id and ".$name."awards.show_num = $_SESSION[show_num]");
}
function add_saward_s($show,$place, $junior){
	$name = "_".$show[id]."_";
	db()->query("INSERT INTO ".$name."sawards (type, place, show_num) values ('S',$place,$junior)");
}
function add_saward_d($show,$place, $div, $junior){
	$name = "_".$show[id]."_";
	$division_id = get_division($show,$div);
	db()->query("INSERT INTO ".$name."sawards (type, place, division_id, show_num) values ('D',$place,$division_id,$junior)");
}
function add_saward_c($show,$place, $cla, $junior){
	$name = "_".$show[id]."_";
	$class_id = get_classs($show, $cla);
	db()->query("INSERT INTO ".$name."sawards (type, place, class_id, show_num) values ('C',$place,$class_id,$junior)");
}
function add_saward_b($show,$place, $div, $bre, $junior){
	$name = "_".$show[id]."_";
	$division_id = get_division($show,$div);
	$breed_id = get_breed_with_div($show, $div,$bre)[breed_id];
	db()->query("INSERT INTO ".$name."sawards (type, place, division_id, breed_id, show_num) values ('B',$place,$division_id,$breed_id,$junior)");
}
function add_saward_v($show,$place, $div, $bre, $var, $fri, $junior){
	$name = "_".$show[id]."_";
	$division_id = get_division($show,$div);
	$breed_id = get_breed_with_div($show, $div, $bre)[breed_id];
	if(!$breed_id){
		$breed_id = add_breed($show, $division_id, $bre);
	}
	$variety_id = get_variety($show, $var);
	if(!$variety_id){
		$variety_id = add_variety($show, $var);
	}
	$variety_id = 2*$variety_id + $fri;
	db()->query("INSERT INTO ".$name."sawards (type, place, division_id, breed_id, variety_id, show_num) values ('V',$place,$division_id, $breed_id, $variety_id,$junior)");
}
function add_saward_r($show,$place, $div, $bre, $var, $fri, $age, $junior){
	$name = "_".$show[id]."_";
	$division_id = get_division($show,$div);
	$breed_id = get_breed_with_div($show, $div, $bre)[breed_id];
	if(!$breed_id){
		$breed_id = add_breed($show, $division_id, $bre)[breed_id];
	}
	$variety_id = get_variety($show, $var);
	if(!$variety_id){
		$variety_id = add_variety($show, $var);
	}
	$variety_id = 2*$variety_id + $fri;
	db()->query("INSERT INTO ".$name."sawards (type, place, division_id, breed_id, variety_id, age_id, show_num) values ('R',$place,$division_id, $breed_id, $variety_id, $age,$junior)");
}
function get_saward_s($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."sawards.place, breed as rbre, variety as rvar, age as rage, name, frizzle as rfri, ".$name."sawards.type, ' IN SHOW' as ssho, ".$name."sawards.show_num as junior, color FROM ".$name."sawards LEFT JOIN ".$name."awards on ".$name."sawards.type = ".$name."awards.type and ".$name."sawards.place = ".$name."awards.place left join show_color on ".$name."awards.show_num = show_color.id left join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id and ".$name."sawards.show_num = ".$name."birds.show_num left join ".$name."breeds on ".$name."breeds.id = ".$name."birds.breed_id left join ".$name."varieties on ".$name."varieties.id = ".$name."birds.variety_id left join ages on ages.id = ".$name."birds.age_id left join ".$name."exhibitors on ".$name."birds.ex_id = ".$name."exhibitors.id where ".$name."sawards.type = 'S';")->fetchAll();
}
function get_saward_d($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."sawards.place, breed as rbre, variety as rvar, age as rage, name, frizzle as rfri, ".$name."sawards.type ,division as sdiv, ".$name."sawards.show_num as junior, color FROM ".$name."sawards join divisions on divisions.id = ".$name."sawards.division_id LEFT JOIN ".$name."awards on ".$name."sawards.type = ".$name."awards.type and ".$name."sawards.place = ".$name."awards.place and number = divisions.id  left join show_color on ".$name."awards.show_num = show_color.id left join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id and ".$name."sawards.show_num = ".$name."birds.show_num left join ".$name."breeds on ".$name."breeds.id = ".$name."birds.breed_id left join ".$name."varieties on ".$name."varieties.id = ".$name."birds.variety_id left join ages on ages.id = ".$name."birds.age_id left join ".$name."exhibitors on ".$name."birds.ex_id = ".$name."exhibitors.id where ".$name."sawards.type = 'D';")->fetchAll();
}
function get_saward_c($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."sawards.place, breed as rbre, variety as rvar, age as rage, name, frizzle as rfri, ".$name."sawards.type, classname as scla, classes.id , ".$name."sawards.show_num as junior, color FROM ".$name."sawards join classes on ".$name."sawards.class_id = classes.id LEFT JOIN ".$name."awards on ".$name."sawards.type = ".$name."awards.type and ".$name."sawards.place = ".$name."awards.place and number = classes.id  left join show_color on ".$name."awards.show_num = show_color.id left join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id and ".$name."sawards.show_num = ".$name."birds.show_num left join ".$name."breeds on ".$name."breeds.id = ".$name."birds.breed_id left join ".$name."varieties on ".$name."varieties.id = ".$name."birds.variety_id left join ages on ages.id = ".$name."birds.age_id left join ".$name."exhibitors on ".$name."birds.ex_id = ".$name."exhibitors.id where ".$name."sawards.type = 'C' order by classes.id;")->fetchAll();
}
function get_saward_b($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."sawards.place, b.breed as rbre, ".$name."breeds.breed as sbre, variety as rvar, age as rage, name, frizzle as rfri, ".$name."sawards.type, division as sdiv, d.class_id, ".$name."sawards.show_num as junior, color FROM ".$name."sawards join (select min(class_id) as class_id, breed_id, min(variety_id) as variety_id from ".$name."cbv group by breed_id) as ".$name."cbv on ".$name."cbv.breed_id = ".$name."sawards.breed_id join (SELECT min(id) as id, min(division) as division, class_id from divisions group by class_id) as d on d.class_id = ".$name."cbv.class_id LEFT JOIN ".$name."awards on ".$name."sawards.type = ".$name."awards.type and ".$name."sawards.place = ".$name."awards.place and number = ".$name."sawards.breed_id  left join show_color on ".$name."awards.show_num = show_color.id left join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id and ".$name."sawards.show_num = ".$name."birds.show_num join ".$name."breeds on ".$name."breeds.id = ".$name."sawards.breed_id left join ".$name."breeds b on b.id = ".$name."birds.breed_id left join ".$name."varieties on ".$name."varieties.id = ".$name."birds.variety_id left join ages on ages.id = ".$name."birds.age_id left join ".$name."exhibitors on ".$name."birds.ex_id = ".$name."exhibitors.id where ".$name."sawards.type = 'B' order by d.class_id, b.breed;")->fetchAll();
}
function get_saward_v($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."sawards.place, ".$name."breeds.breed, ".$name."breeds.breed as sbre, b.breed as rbre, ".$name."varieties.variety, ".$name."varieties.variety as svar, v.variety as rvar, age, name, ".$name."sawards.variety_id MOD 2 as frizzle, frizzle as sfri, ".$name."sawards.type,".$name."sawards.breed_id, classname, division as sdiv, ".$name."sawards.show_num as junior, color FROM ".$name."sawards join ".$name."cbv on ".$name."cbv.breed_id = ".$name."sawards.breed_id and ".$name."cbv.variety_id = ".$name."sawards.variety_id DIV 2 join classes on classes.id = ".$name."cbv.class_id join (SELECT min(id) as id, min(division) as division, class_id from divisions group by class_id) as d on d.class_id = ".$name."cbv.class_id LEFT JOIN ".$name."awards on ".$name."sawards.type = ".$name."awards.type and ".$name."sawards.place = ".$name."awards.place and number = ".$name."sawards.variety_id  left join show_color on ".$name."awards.show_num = show_color.id left join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id and ".$name."sawards.show_num = ".$name."birds.show_num and ".$name."birds.breed_id = ".$name."sawards.breed_id join ".$name."breeds on ".$name."breeds.id = ".$name."sawards.breed_id left join ".$name."varieties on ".$name."sawards.variety_id DIV 2=".$name."varieties.id left join ages on ages.id = ".$name."birds.age_id left join ".$name."breeds b on b.id = ".$name."birds.breed_id left join ".$name."varieties v on v.id = ".$name."birds.variety_id left join ".$name."exhibitors on ".$name."birds.ex_id = ".$name."exhibitors.id where ".$name."sawards.type = 'V';")->fetchAll();
}
function get_saward_r($show){
	$name = "_".$show[id]."_";
	return db()->query("SELECT DISTINCT ".$name."sawards.place, breed, breed as sbre, variety, variety as svar, age, age as sage, name, ".$name."sawards.variety_id MOD 2 as frizzle, ".$name."sawards.variety_id MOD 2 as sfri, ".$name."sawards.type,".$name."sawards.breed_id, a.id, classname,rbre,rvar,rage, ".$name."sawards.show_num as junior, color FROM ".$name."sawards JOIN ".$name."breeds on ".$name."sawards.breed_id = ".$name."breeds.id JOIN ".$name."varieties ON ".$name."varieties.id = ".$name."sawards.variety_id DIV 2 join ".$name."cbv on ".$name."cbv.breed_id = ".$name."sawards.breed_id and ".$name."cbv.variety_id = ".$name."sawards.variety_id DIV 2 join classes on ".$name."cbv.class_id = classes.id join ages on ages.id = ".$name."sawards.age_id LEFT JOIN (SELECT ".$name."birds.breed_id as breed_id, ".$name."birds.variety_id as variety_id, name, ".$name."awards.type as type, ".$name."awards.number as number, ".$name."birds.id as id, frizzle, place, b.breed as rbre, v.variety as rvar, a.age as rage, color, ".$name."birds.show_num as show_num FROM ".$name."awards  left join show_color on ".$name."awards.show_num = show_color.id join ".$name."birds on ".$name."birds.id = ".$name."awards.bird_id  join ".$name."breeds b on b.id = ".$name."birds.breed_id join ".$name."varieties v on v.id = ".$name."birds.variety_id join ages a on a.id = ".$name."birds.age_id join ".$name."exhibitors on ".$name."birds.ex_id = ".$name."exhibitors.id where type = 'R') as a on a.breed_id = ".$name."sawards.breed_id and a.variety_id = ".$name."sawards.variety_id DIV 2 and frizzle = ".$name."sawards.variety_id MOD 2 and a.number = ".$name."sawards.age_id and a.place = ".$name."sawards.place and ".$name."sawards.show_num = a.show_num where ".$name."sawards.type = 'R';")->fetchAll();
}
function get_sawards($show){
	return array_merge(get_saward_s($show),get_saward_d($show),get_saward_c($show),get_saward_b($show),get_saward_v($show),get_saward_r($show));
}
?>