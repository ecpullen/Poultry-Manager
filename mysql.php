<?php 
function db(){
	$db = new PDO("mysql:dbname=info;host=127.0.0.1",
				"root",
				"admin123");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}
function get_age($age_id){
	return db()->query("SELECT * FROM ages where id = $age_id")->fetch()[age];
}
function get_var($variety_id){
	return db()->query("SELECT * FROM varieties where id = $variety_id")->fetch()[variety];
}
function get_bre($breed_id){
	return db()->query("SELECT * FROM breeds where id = $breed_id")->fetch()[breed];
}
function get_cla($class_id){
	return db()->query("SELECT * FROM classes where id = $class_id")->fetch()[breed];
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
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,age_id,ex_id,birds.breed_id,birds.variety_id, frizzle FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id ORDER BY classes.id, breed, variety, frizzle, age_id, ex_id");
}
function get_bird($show, $id){
	return showdb($show)->query("SELECT * from birds join cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join varieties on varieties.id = cbv.variety_id join breeds on breeds.id = cbv.breed_id join ages on ages.id = birds.age_id where birds.id = $id")->fetch();
}
function get_bird_str($show, $id){
	$bird = get_bird($show, $id);
	return "$bird[variety]".($bird[frizzle]?" Frizzled ":" ")."$bird[breed] $bird[age]";
}
function get_divisions($show){
	return showdb($show)->query("SELECT DISTINCT division as data from divisions");
}
function get_division($show, $div){
	return showdb($show)->query("SELECT DISTINCT id from divisions where division like '$div'")->fetch()[id];
}
function get_classes($show,$div){
	return showdb($show)->query("SELECT DISTINCT classes.classname as data, classes.id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join classes on classes.id = cbv.class_id join divisions on divisions.class_id = cbv.class_id where division like '$div' ORDER BY classes.id");
}
function get_classs($show,$cla){
	return showdb($show)->query("SELECT DISTINCT id from classes where classname like '$cla'")->fetch()[id];
}
function get_breeds($show,$cla){
	return showdb($show)->query("SELECT DISTINCT breed as data FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join classes on classes.id = cbv.class_id join breeds on breeds.id = cbv.breed_id where classname like '$cla' ORDER BY breed");
}
function get_breed($show,$cla, $breed){
	return showdb($show)->query("SELECT DISTINCT birds.breed_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join classes on classes.id = cbv.class_id join breeds on breeds.id = cbv.breed_id where classname like '$cla' and breed like '$breed'")->fetch()[breed_id];
}
function get_varieties($show,$bre, $cla){
	return showdb($show)->query("SELECT DISTINCT concat(variety,' ',(case when frizzle = 0 then ''
             when frizzle = 1 then ' Frizzle' end)) as data, (birds.variety_id*2 + frizzle) as var_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join varieties on varieties.id = cbv.variety_id join breeds on breeds.id = cbv.breed_id join classes on classes.id = cbv.class_id where breed like '$bre' and classname like '$cla' ORDER BY data");
}
function get_variety($show,$variety){
	return showdb($show)->query("SELECT DISTINCT id from varieties where variety like '$variety'")->fetch()[id];
}
function conv_variety($variety_id){
	$fri = $variety_id%2;
	$var = ($variety_id-$fri)/2;
	return db()->query("SELECT variety from varieties where id = $var")->fetch()[variety].($fri?" frizzle":"");
}
function get_ages($show,$var, $bre, $cla){
	$fri = $var%2;
	$var = ($var-$fri)/2;
	return showdb($show)->query("SELECT DISTINCT age as data, age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join varieties on varieties.id = cbv.variety_id join breeds on breeds.id = cbv.breed_id join classes on classes.id = cbv.class_id join ages on ages.id = birds.age_id where breed like '$bre' and classname like '$cla' and birds.variety_id = $var and frizzle = $fri ORDER BY age_id");
}
function get_birds($show,$class,$breed,$var,$age){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,age_id,ex_id,birds.breed_id,birds.variety_id,frizzle FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id where classname like '$class' and breed like '$breed' and variety like '$var' and age like '$age' ORDER BY birds.id");
}
function get_birds_rev($show,$class,$breed,$var,$age){
	$fri = $var%2;
	$var = ($var-$fri)/2;
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,age_id,ex_id,birds.breed_id,birds.variety_id,frizzle FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id where classname like '$class' and breed like '$breed' and varieties.id = $var and frizzle = $fri and age like '$age' ORDER BY birds.id");
}
function get_vars($show,$breed_id){
	return showdb($show)->query("SELECT DISTINCT (birds.variety_id*2 + frizzle) as variety_id, variety FROM birds JOIN cbv on birds.breed_id = cbv.breed_id join varieties on birds.variety_id = varieties.id where birds.breed_id = $breed_id ORDER BY variety");
}
function get_bres($show,$class_id){
	return showdb($show)->query("SELECT DISTINCT birds.breed_id, breed FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join breeds on birds.breed_id = breeds.id where cbv.class_id = $class_id ORDER BY breed");
}
function get_clas($show,$division_id){
	return showdb($show)->query("SELECT DISTINCT cbv.class_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join breeds on birds.breed_id = breeds.id join divisions on divisions.class_id = cbv.class_id where divisions.id = $division_id ORDER BY cbv.class_id");
}
function get_divs($show){
	return showdb($show)->query("SELECT DISTINCT divisions.id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join breeds on birds.breed_id = breeds.id join divisions on divisions.class_id = cbv.class_id ORDER BY divisions.id");
}
function birds_by_ex($show, $ex){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,frizzle FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on ages.id = age_id where ex_id=".$ex);
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
	$f = $frizzle?"TRUE":"FALSE";
	showdb($show)->query("INSERT INTO birds (ex_id,age_id,variety_id,breed_id,frizzle) VALUES ($ex_id,$age_id,$variety_id,$breed_id,".$f.");");
}
function update_bird($id,$show, $ex_id, $breed_id, $variety_id, $age_id, $frizzle = 0){
	if(!$frizzle){
		$frizzle = 'FALSE';
	}
	else{
		$frizzle = 'TRUE';
	}
	showdb($show)->query("UPDATE birds SET age_id = $age_id, variety_id = $variety_id, breed_id = $breed_id, frizzle = $frizzle WHERE id = $id");
}
function delete($show, $id){
	showdb($show)->query("DELETE FROM birds WHERE id = $id");
}
function get_ids($division,$breed,$variety){
	return db()->query("SELECT cbv.class_id, breed_id, variety_id FROM cbv join breeds on breeds.id = breed_id join varieties on varieties.id = variety_id join divisions ON divisions.class_id = cbv.class_id where division like '$division' and breed like '$breed' and variety like '$variety'")->fetch();
}
function get_ids_with_class($class,$breed,$variety){
	return db()->query("SELECT cbv.class_id, breed_id, variety_id FROM cbv join breeds on breeds.id = breed_id join varieties on varieties.id = variety_id join classes ON classes.id = cbv.class_id where classes.classname like '$class' and breed like '$breed' and variety = '$variety'")->fetch();
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
						INSERT INTO temp (ex_id,age_id,variety_id,breed_id,frizzle) SELECT ex_id,birds.age_id,birds.variety_id,birds.breed_id,frizzle FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id =cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id ORDER BY classes.id, breed, variety, frizzle, age_id, ex_id");
	$showdb->exec("DROP TABLE birds;");
	$showdb->exec("CREATE TABLE birds LIKE temp;
		INSERT INTO birds (ex_id,age_id,variety_id,breed_id,frizzle) SELECT ex_id,age_id,variety_id,breed_id,frizzle FROM temp");
}
function addAward($show, $type, $num, $rank, $bird){
	showdb($show)->query("INSERT INTO awards VALUES (".db()->quote($type).",$num,$rank,$bird)");
}
function get_rank($show, $bird_id){
	$row = showdb($show)->query("SELECT place from awards where bird_id = $bird_id and type = 'R'");
	if($row->rowCount() != 0){
		return $row->fetch()[place];
	}
	else{
		return 0;
	}
}
function get_ranks($show, $bird){	
	return showdb($show)->query("SELECT bird_id, place from awards join birds on birds.id = bird_id where breed_id = $bird[breed_id] and variety_id = $bird[variety_id] and age_id = $bird[age_id] and frizzle = $bird[frizzle] and type='R' order by place");
}
function get_var_ranks($show, $breed_id, $variety_id){
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where breed_id = $breed_id and variety_id = $variety_id and frizzle = $fri and type='V' order by place");
}
function get_bre_ranks($show, $breed_id){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where breed_id = $breed_id and type='B' order by place");
}
function get_cla_ranks($show, $class_id){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where number = $class_id and type='C' order by place");
}
function get_div_ranks($show, $division_id){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where number = $division_id and type='D' order by place");
}
function get_sho_ranks($show){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where type='S' order by place");
}
function rem_award_r($show, $breed_id, $variety_id, $age_id){
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id where breed_id = $breed_id and variety_id = $variety_id and age_id = $age_id and frizzle = $fri");
}
function rem_award_v($show, $breed_id, $variety_id){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id where breed_id = $breed_id and variety_id = $variety_id and type ='V'");
}
function rem_award_b($show, $breed_id){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id where breed_id = $breed_id and type ='B'");
}
function rem_award_c($show, $class_id){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id join cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id where class_id = $class_id and type ='C'");
}
function rem_award_d($show, $division_id){
	showdb($show)->query("DELETE awards FROM awards where number = $division_id and type ='D'");
}
function rem_award_s($show){
	showdb($show)->query("DELETE awards FROM awards where type ='S'");
}
function get_ordered_age_ranks($show, $breed_id, $variety_id, $age){
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	return showdb($show)->query("SELECT bird_id, place from awards join birds on birds.id = bird_id where breed_id = $breed_id and variety_id = $variety_id and age_id = $age and frizzle = $fri and type='R' order by place");
}
function get_ordered_var_ranks($show, $breed_id, $var){
	return showdb($show)->query("SELECT bird_id, place from awards join birds on birds.id = bird_id where breed_id = $breed_id and number = $var and type='V' order by place");
}
function get_ordered_bre_ranks($show, $class_id, $var){
	return showdb($show)->query("SELECT bird_id, place from awards join birds on birds.id = bird_id join cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id where class_id = $class_id and number = $var and type='B' order by place");
}
function get_ordered_cla_ranks($show, $division_id, $var){
	return showdb($show)->query("SELECT bird_id, place from awards where number = $var and type='C' order by place");
}
function get_ordered_div_ranks($show, $var){
	return showdb($show)->query("SELECT bird_id, place from awards where number = $var and type='D' order by place");
}
function rem_rank($show, $id){
	showdb($show)->query("DELETE FROM awards WHERE bird_id = $id");
}
?>












