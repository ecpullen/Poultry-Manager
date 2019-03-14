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
function get_age_id($age){
	return db()->query("SELECT * FROM ages where age like '$age'")->fetch()[id];
}
function get_var($variety_id){
	return db()->query("SELECT * FROM varieties where id = $variety_id")->fetch()[variety];
}
function get_bre($show,$breed_id){
	return showdb($show)->query("SELECT * FROM breeds where id = $breed_id")->fetch()[breed];
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
	return db()->query("select * from users where username = ".db()->quote($uname).";")->fetch();
}
function birds($show){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,age_id,ex_id,birds.breed_id,birds.variety_id, frizzle, NR, show_num FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id ORDER BY show_num,classes.id, breed, NR, variety, frizzle, age_id, ex_id");
}
function get_bird($show, $id){
	return showdb($show)->query("SELECT birds.*,breed,age,variety,class_id,breeds.id as breed_id,varieties.id as variety_id from birds left join cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join varieties on varieties.id = birds.variety_id join breeds on breeds.id = birds.breed_id join ages on ages.id = birds.age_id where birds.id = $id")->fetch();
}
function get_bird_str($show, $id){
	$bird = get_bird($show, $id);
	return "$bird[variety]".($bird[frizzle]?" Frizzled ":" ")."$bird[breed] $bird[age]";
}
function get_divisions($show){
	return showdb($show)->query("SELECT DISTINCT division as data, id as var_id from divisions");
}
function get_division($show, $div){
	return showdb($show)->query("SELECT DISTINCT id from divisions where division like '$div'")->fetch()[id];
}
function get_div($show,$division_id){
	return showdb($show)->query("SELECT DISTINCT division from divisions where id = $division_id")->fetch()[division];
}
function get_classes($show,$div){
	return showdb($show)->query("SELECT DISTINCT classes.classname as data, classes.id, classes.id as var_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join classes on classes.id = cbv.class_id join divisions on divisions.class_id = cbv.class_id where divisions.id = $div and birds.show_num = $_SESSION[junior] ORDER BY classes.id");
}
function get_classs($show,$cla){
	return showdb($show)->query("SELECT DISTINCT id from classes where classname like '$cla'")->fetch()[id];
}
function get_breeds($show,$cla){
	return showdb($show)->query("SELECT DISTINCT breed as data, breeds.id as var_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join classes on classes.id = cbv.class_id join breeds on breeds.id = cbv.breed_id where classes.id = $cla and birds.show_num = $_SESSION[junior] ORDER BY breed");
}
function get_breed($show,$cla, $breed){
	return showdb($show)->query("SELECT DISTINCT birds.breed_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join classes on classes.id = cbv.class_id join breeds on breeds.id = cbv.breed_id where classname like '$cla' and breed like '$breed'")->fetch()[breed_id];
}
function get_varieties($show,$bre, $cla){
	return showdb($show)->query("SELECT DISTINCT concat(variety,' ',(case when frizzle = 0 then ''when frizzle = 1 then ' Frizzle' end)) as data, (birds.variety_id*2 + frizzle) as var_id FROM birds LEFT JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id left join varieties on varieties.id = birds.variety_id left join breeds on breeds.id = birds.breed_id left join classes on classes.id = cbv.class_id where birds.show_num = $_SESSION[junior] and(breeds.id = $bre and cbv.class_id = $cla) or (ISNULL(cbv.class_id) and breeds.id = $bre) ORDER BY data");
}
function get_variety($show,$variety){
	return showdb($show)->query("SELECT DISTINCT id from varieties where variety like '$variety'")->fetch()[id];
}
function conv_variety($variety_id){
	$fri = $variety_id%2;
	$var = ($variety_id-$fri)/2;
	return db()->query("SELECT variety from varieties where id = $var")->fetch()[variety].($fri?" frizzle":"");
}
function get_ages($show,$var, $bre){
	$fri = $var%2;
	$var = ($var-$fri)/2;
	return showdb($show)->query("SELECT DISTINCT age as data, age_id FROM birds join ages on age_id = ages.id where birds.breed_id = $bre and birds.variety_id = $var and frizzle = $fri and birds.show_num = $_SESSION[junior] ORDER BY age_id");
}
function get_birds($show,$class,$breed,$var,$age){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,age_id,ex_id,birds.breed_id,birds.variety_id,frizzle FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id where classname like '$class' and breed like '$breed' and variety like '$var' and age like '$age' ORDER BY birds.id");
}
function get_birds_rev($show,$breed,$var,$age){
	$fri = $var%2;
	$var = ($var-$fri)/2;
	return showdb($show)->query("SELECT birds.*,breed,variety,age FROM birds JOIN varieties on birds.variety_id = varieties.id join breeds on birds.breed_id = breeds.id join ages on birds.age_id = ages.id where breeds.id = $breed and varieties.id = $var and frizzle = $fri and age like '$age' and birds.show_num = $_SESSION[junior] ORDER BY birds.id");
}
function get_vars($show,$breed_id){
	if(showdb($show)->query("SELECT * from cbv where breed_id = $breed_id and NR = 0")->rowCount()){
		return showdb($show)->query("SELECT DISTINCT (birds.variety_id*2 + frizzle) as variety_id, variety FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join varieties on birds.variety_id = varieties.id where birds.breed_id = $breed_id and NR = 0 ORDER BY variety");
	}
	return showdb($show)->query("SELECT DISTINCT (birds.variety_id*2 + frizzle) as variety_id, variety FROM birds JOIN cbv on birds.breed_id = cbv.breed_id join varieties on birds.variety_id = varieties.id where birds.breed_id = $breed_id ORDER BY variety");
}
function get_bres($show,$class_id){
	return showdb($show)->query("SELECT DISTINCT birds.breed_id, breed FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join breeds on birds.breed_id = breeds.id where cbv.class_id = $class_id and NR = 0 ORDER BY breed");
}
function get_clas($show,$division_id){
	return showdb($show)->query("SELECT DISTINCT cbv.class_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join breeds on birds.breed_id = breeds.id join divisions on divisions.class_id = cbv.class_id where divisions.id = $division_id ORDER BY cbv.class_id");
}
function get_divs($show){
	return showdb($show)->query("SELECT DISTINCT divisions.id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id join breeds on birds.breed_id = breeds.id join divisions on divisions.class_id = cbv.class_id ORDER BY divisions.id");
}
function birds_by_ex($show, $ex){
	return showdb($show)->query("SELECT birds.id,classname,breed,variety,age,frizzle,birds.breed_id,cbv.class_id,show_num FROM birds LEFT JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id LEFT JOIN varieties on birds.variety_id = varieties.id left join breeds on birds.breed_id = breeds.id left join classes on cbv.class_id = classes.id join ages on ages.id = age_id where ex_id=$ex ORDER BY ISNULL(cbv.class_id),cbv.class_id,breed,variety,frizzle,age,birds.id");
}
function class_by_breed($show, $breed_id){
	return showdb($show)->query("SELECT classname from cbv join classes on class_id = classes.id where breed_id = $breed_id")->fetch()[classname];
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
function get_count($show){
	$counts = array();
	$counts[o] = showdb($show)->query("SELECT * FROM birds where show_num != 1")->rowCount();
	$counts[j] = showdb($show)->query("SELECT * FROM birds where show_num = 1")->rowCount();
	$counts[o_lf] = showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 1 and birds.show_num != 1")->rowCount();
	$counts[j_lf] = showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 1 and birds.show_num = 1")->rowCount();
	$counts[o_btm] = showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 2 and birds.show_num != 1")->rowCount();
	$counts[j_btm] = showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 2 and birds.show_num = 1")->rowCount();
	$counts[o_wf] = showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 3 and birds.show_num != 1")->rowCount();
	$counts[j_wf] = showdb($show)->query("SELECT birds.id,classname,breed,variety,age_id FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join divisions ON classes.id = divisions.class_id WHERE divisions.id = 3 and birds.show_num = 1")->rowCount();
	return $counts;
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
function add_bird($show, $ex_id, $breed_id, $variety_id, $age_id, $frizzle = 0, $jr = 0){
	$f = $frizzle?"TRUE":"FALSE";
	$jr = $jr?1:0;
	showdb($show)->query("INSERT INTO birds (ex_id,age_id,variety_id,breed_id,frizzle, show_num) VALUES ($ex_id,$age_id,$variety_id,$breed_id,".$f.", $jr);");
}
function update_bird($id,$show, $ex_id, $breed_id, $variety_id, $age_id, $frizzle = 0, $jr = 0){
	if(!$frizzle){
		$frizzle = 'FALSE';
	}
	else{
		$frizzle = 'TRUE';
	}
	$jr = $jr?1:0;
	showdb($show)->query("UPDATE birds SET age_id = $age_id, variety_id = $variety_id, breed_id = $breed_id, frizzle = $frizzle, show_num = $jr WHERE id = $id");
}
function delete($show, $id){
	showdb($show)->query("DELETE FROM birds WHERE id = $id");
}
function get_ids($division,$breed,$variety){
	return db()->query("SELECT cbv.class_id, breed_id, variety_id FROM cbv join breeds on breeds.id = breed_id join varieties on varieties.id = variety_id join divisions ON divisions.class_id = cbv.class_id where division like '$division' and breed like '$breed' and variety like '$variety'")->fetch();
}
function get_ids_with_class($show,$class,$breed,$variety){
	return showdb($show)->query("SELECT cbv.class_id, breed_id, variety_id FROM cbv join breeds on breeds.id = breed_id join varieties on varieties.id = variety_id join classes ON classes.id = cbv.class_id where classes.classname like '$class' and breed like '$breed' and variety = '$variety'")->fetch();
}
function get_breed_with_div($show, $division, $breed){
	return showdb($show)->query("SELECT cbv.class_id, breed_id FROM cbv join breeds on breeds.id = breed_id join divisions ON divisions.class_id = cbv.class_id where division like '$division' and breed like '$breed'")->fetch();
}
function get_breed_no_div($breed){
	return db()->query("select id from breeds where breed like '$breed'");
}
function add_breed($show, $division_id, $breed){
	$ids = array();
	$class_id = 21 + $division_id;
	$s = showdb($show);
	$s->query("INSERT INTO breeds VALUES(0,'$breed')");
	$breed_id = $s->lastInsertId();
	$ids[class_id] = $class_id;
	$ids[breed_id] = $breed_id;
	return $ids;
}
function add_variety($show, $variety){
	showdb($show)->query("INSERT INTO varieties VALUES(0,'$variety')");
	return showdb($show)->query("SELECT * FROM varieties WHERE variety like '$variety'")->fetch()[id];
}
function add_variety_link($show, $ids, $variety){
	$variety_id = get_variety($show, $variety);
	if(!$variety_id){
		$variety_id = add_variety($show, $variety);
	}
	showdb($show)->query("INSERT INTO cbv VALUES($ids[class_id],$ids[breed_id],$variety_id,".($ids[class_id] >= 25? 0 : 1).")");
	return $variety_id;
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
						INSERT INTO temp (ex_id,age_id,variety_id,breed_id,frizzle, show_num) SELECT ex_id,birds.age_id,birds.variety_id,birds.breed_id,frizzle,show_num FROM birds JOIN cbv on birds.breed_id = cbv.breed_id and birds.variety_id =cbv.variety_id JOIN varieties on cbv.variety_id = varieties.id join breeds on cbv.breed_id = breeds.id join classes on cbv.class_id = classes.id join ages on birds.age_id = ages.id ORDER BY show_num,classes.id, breed, variety, frizzle, age_id, ex_id");
	$showdb->exec("DROP TABLE birds;");
	$showdb->exec("CREATE TABLE birds LIKE temp;
		INSERT INTO birds (ex_id,age_id,variety_id,breed_id,frizzle,show_num) SELECT ex_id,age_id,variety_id,breed_id,frizzle,show_num FROM temp");
}
function addAward($show, $type, $num, $rank, $bird){
	showdb($show)->query("INSERT INTO awards VALUES (".db()->quote($type).",$num,$rank,$bird, $_SESSION[show_num], '$_SESSION[clerk]', '$_SESSION[judge]')");
}
function get_rank($show, $bird_id){
	$row = showdb($show)->query("SELECT place from awards where bird_id = $bird_id and type = 'R' and show_num = $_SESSION[show_num]");
	if($row->rowCount() != 0){
		return $row->fetch()[place];
	}
	else{
		return 0;
	}
}
function get_ranks($show, $bird){	
	return showdb($show)->query("SELECT bird_id, place from awards join birds on birds.id = bird_id where breed_id = $bird[breed_id] and variety_id = $bird[variety_id] and age_id = $bird[age_id] and frizzle = $bird[frizzle] and type='R' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_var_ranks($show, $breed_id, $variety_id){
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where breed_id = $breed_id and variety_id = $variety_id and frizzle = $fri and type='V' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_bre_ranks($show, $breed_id){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where breed_id = $breed_id and type='B' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_cla_ranks($show, $class_id){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where number = $class_id and type='C' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_div_ranks($show, $division_id){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where number = $division_id and type='D' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_sho_ranks($show){
	return showdb($show)->query("SELECT bird_id, place, age_id from awards join birds on birds.id = bird_id where type='S' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function rem_award_r($show, $breed_id, $variety_id, $age_id){
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id where breed_id = $breed_id and variety_id = $variety_id and age_id = $age_id and frizzle = $fri and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior]");
}
function rem_award_v($show, $breed_id, $variety_id){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id where breed_id = $breed_id and number = $variety_id and type ='V' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior]");
}
function rem_award_b($show, $breed_id){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id where breed_id = $breed_id and type ='B' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior]");
}
function rem_award_c($show, $class_id){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id join cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id where class_id = $class_id and type ='C' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior]");
}
function rem_award_d($show, $division_id){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = bird_id where number = $division_id and type ='D' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior]");
}
function rem_award_s($show){
	showdb($show)->query("DELETE awards FROM awards inner join birds on birds.id = awards.bird_id where type ='S' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior]");
}
function get_ordered_age_ranks($show, $breed_id, $variety_id, $age){
	$fri = $variety_id%2;
	$variety_id = ($variety_id-$fri)/2;
	return showdb($show)->query("SELECT DISTINCT bird_id, place from awards join birds on birds.id = bird_id where breed_id = $breed_id and variety_id = $variety_id and age_id = $age and frizzle = $fri and type='R' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_var_ranks($show, $breed_id, $var){
	return showdb($show)->query("SELECT DISTINCT bird_id, place from awards join birds on birds.id = bird_id where breed_id = $breed_id and number = $var and type='V' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_bre_ranks($show, $class_id, $var){
	return showdb($show)->query("SELECT DISTINCT bird_id, place from awards join birds on birds.id = bird_id join cbv on birds.breed_id = cbv.breed_id and birds.variety_id = cbv.variety_id where class_id = $class_id and number = $var and type='B' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_cla_ranks($show, $division_id, $var){
	return showdb($show)->query("SELECT DISTINCT bird_id, place from awards join birds on birds.id = awards.bird_id where number = $var and type='C' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function get_ordered_div_ranks($show, $var){
	return showdb($show)->query("SELECT DISTINCT bird_id, place from awards join birds on birds.id = awards.bird_id where number = $var and type='D' and awards.show_num = $_SESSION[show_num] and birds.show_num = $_SESSION[junior] order by place");
}
function rem_rank($show, $id){
	showdb($show)->query("DELETE FROM awards WHERE bird_id = $id and awards.show_num = $_SESSION[show_num]");
}
function add_saward_s($show,$place, $junior){
	showdb($show)->query("INSERT INTO sawards (type, place, show_num) values ('S',$place,$junior)");
}
function add_saward_d($show,$place, $div, $junior){
	$division_id = get_division($show,$div);
	showdb($show)->query("INSERT INTO sawards (type, place, division_id, show_num) values ('D',$place,$division_id,$junior)");
}
function add_saward_c($show,$place, $cla, $junior){
	$class_id = get_classs($show, $cla);
	showdb($show)->query("INSERT INTO sawards (type, place, class_id, show_num) values ('C',$place,$class_id,$junior)");
}
function add_saward_b($show,$place, $div, $bre, $junior){
	$division_id = get_division($show,$div);
	$breed_id = get_breed_with_div($show, $div,$bre)[breed_id];
	showdb($show)->query("INSERT INTO sawards (type, place, division_id, breed_id, show_num) values ('B',$place,$division_id,$breed_id,$junior)");
}
function add_saward_v($show,$place, $div, $bre, $var, $fri, $junior){
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
	showdb($show)->query("INSERT INTO sawards (type, place, division_id, breed_id, variety_id, show_num) values ('V',$place,$division_id, $breed_id, $variety_id,$junior)");
}
function add_saward_r($show,$place, $div, $bre, $var, $fri, $age, $junior){
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
	showdb($show)->query("INSERT INTO sawards (type, place, division_id, breed_id, variety_id, age_id, show_num) values ('R',$place,$division_id, $breed_id, $variety_id, $age,$junior)");
}
function get_saward_s($show){
	return showdb($show)->query("SELECT DISTINCT sawards.place, breed as rbre, variety as rvar, age as rage, name, frizzle as rfri, sawards.type, ' IN SHOW' as ssho, sawards.show_num as junior, color FROM sawards LEFT JOIN awards on sawards.type = awards.type and sawards.place = awards.place left join info.show_color on awards.show_num = info.show_color.id left join birds on birds.id = awards.bird_id and sawards.show_num = birds.show_num left join breeds on breeds.id = birds.breed_id left join varieties on varieties.id = birds.variety_id left join ages on ages.id = birds.age_id left join exhibitors on birds.ex_id = exhibitors.id where sawards.type = 'S';")->fetchAll();
}
function get_saward_d($show){
	return showdb($show)->query("SELECT DISTINCT sawards.place, breed as rbre, variety as rvar, age as rage, name, frizzle as rfri, sawards.type ,division as sdiv, sawards.show_num as junior, color FROM sawards join divisions on divisions.id = sawards.division_id LEFT JOIN awards on sawards.type = awards.type and sawards.place = awards.place and number = divisions.id  left join info.show_color on awards.show_num = info.show_color.id left join birds on birds.id = awards.bird_id and sawards.show_num = birds.show_num left join breeds on breeds.id = birds.breed_id left join varieties on varieties.id = birds.variety_id left join ages on ages.id = birds.age_id left join exhibitors on birds.ex_id = exhibitors.id where sawards.type = 'D';")->fetchAll();
}
function get_saward_c($show){
	return showdb($show)->query("SELECT DISTINCT sawards.place, breed as rbre, variety as rvar, age as rage, name, frizzle as rfri, sawards.type, classname as scla, classes.id , sawards.show_num as junior, color FROM sawards join classes on sawards.class_id = classes.id LEFT JOIN awards on sawards.type = awards.type and sawards.place = awards.place and number = classes.id  left join info.show_color on awards.show_num = info.show_color.id left join birds on birds.id = awards.bird_id and sawards.show_num = birds.show_num left join breeds on breeds.id = birds.breed_id left join varieties on varieties.id = birds.variety_id left join ages on ages.id = birds.age_id left join exhibitors on birds.ex_id = exhibitors.id where sawards.type = 'C' order by classes.id;")->fetchAll();
}
function get_saward_b($show){
	return showdb($show)->query("SELECT DISTINCT sawards.place, b.breed as rbre, breeds.breed as sbre, variety as rvar, age as rage, name, frizzle as rfri, sawards.type, division as sdiv, d.class_id, sawards.show_num as junior, color FROM sawards join (select min(class_id) as class_id, breed_id, min(variety_id) as variety_id from cbv group by breed_id) as cbv on cbv.breed_id = sawards.breed_id join (SELECT min(id) as id, min(division) as division, class_id from divisions group by class_id) as d on d.class_id = cbv.class_id LEFT JOIN awards on sawards.type = awards.type and sawards.place = awards.place and number = sawards.breed_id  left join info.show_color on awards.show_num = info.show_color.id left join birds on birds.id = awards.bird_id and sawards.show_num = birds.show_num join breeds on breeds.id = sawards.breed_id left join breeds b on b.id = birds.breed_id left join varieties on varieties.id = birds.variety_id left join ages on ages.id = birds.age_id left join exhibitors on birds.ex_id = exhibitors.id where sawards.type = 'B' order by d.class_id, b.breed;")->fetchAll();
}
function get_saward_v($show){
	return showdb($show)->query("SELECT DISTINCT sawards.place, breeds.breed, breeds.breed as sbre, b.breed as rbre, varieties.variety, varieties.variety as svar, v.variety as rvar, age, name, sawards.variety_id MOD 2 as frizzle, frizzle as sfri, sawards.type,sawards.breed_id, classname, division as sdiv, sawards.show_num as junior, color FROM sawards join cbv on cbv.breed_id = sawards.breed_id and cbv.variety_id = sawards.variety_id DIV 2 join classes on classes.id = cbv.class_id join (SELECT min(id) as id, min(division) as division, class_id from divisions group by class_id) as d on d.class_id = cbv.class_id LEFT JOIN awards on sawards.type = awards.type and sawards.place = awards.place and number = sawards.variety_id  left join info.show_color on awards.show_num = info.show_color.id left join birds on birds.id = awards.bird_id and sawards.show_num = birds.show_num and birds.breed_id = sawards.breed_id join breeds on breeds.id = sawards.breed_id left join varieties on sawards.variety_id DIV 2=varieties.id left join ages on ages.id = birds.age_id left join breeds b on b.id = birds.breed_id left join varieties v on v.id = birds.variety_id left join exhibitors on birds.ex_id = exhibitors.id where sawards.type = 'V';")->fetchAll();
}
function get_saward_r($show){
	return showdb($show)->query("SELECT DISTINCT sawards.place, breed, breed as sbre, variety, variety as svar, age, age as sage, name, sawards.variety_id MOD 2 as frizzle, sawards.variety_id MOD 2 as sfri, sawards.type,sawards.breed_id, a.id, classname,rbre,rvar,rage, sawards.show_num as junior, color FROM sawards JOIN breeds on sawards.breed_id = breeds.id JOIN varieties ON varieties.id = sawards.variety_id DIV 2 join cbv on cbv.breed_id = sawards.breed_id and cbv.variety_id = sawards.variety_id DIV 2 join classes on cbv.class_id = classes.id join ages on ages.id = sawards.age_id LEFT JOIN (SELECT birds.breed_id as breed_id, birds.variety_id as variety_id, name, awards.type as type, awards.number as number, birds.id as id, frizzle, place, b.breed as rbre, v.variety as rvar, a.age as rage, color, birds.show_num as show_num FROM awards  left join info.show_color on awards.show_num = info.show_color.id join birds on birds.id = awards.bird_id  join breeds b on b.id = birds.breed_id join varieties v on v.id = birds.variety_id join ages a on a.id = birds.age_id join exhibitors on birds.ex_id = exhibitors.id where type = 'R') as a on a.breed_id = sawards.breed_id and a.variety_id = sawards.variety_id DIV 2 and frizzle = sawards.variety_id MOD 2 and a.number = sawards.age_id and a.place = sawards.place and sawards.show_num = a.show_num where sawards.type = 'R';")->fetchAll();
}
function get_sawards($show){
	return array_merge(get_saward_s($show),get_saward_d($show),get_saward_c($show),get_saward_b($show),get_saward_v($show),get_saward_r($show));
}
?>