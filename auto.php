<?php
include 'mysql.php';
function breed($breed){
	return db()->query("SELECT DISTINCT breed as d from varieties join cbv on varieties.id = variety_id join breeds on breeds.id = breed_id join divisions on divisions.class_id = cbv.class_id where breed like '%$breed%' and division like '%$_POST[division]%'");
}
function variety($breed,$variety){
	return db()->query("SELECT DISTINCT variety as d from varieties join cbv on varieties.id = variety_id join breeds on breeds.id = breed_id join divisions on divisions.class_id = cbv.class_id where variety like '%$variety%' and breed like '%$breed%' and division like '%$_POST[division]%'");
}
if($_POST[variety] != ""){
	$rows = variety($_POST[breed],$_POST[variety]);
}
elseif($_POST[breed] != ""){
	$rows = breed($_POST[breed]);
}
else{
	die("{}");
}
$arr = array();
try{
	if($rows->rowCount() != 0){
		foreach ($rows as $row) {
			$arr[] = $row[d];
		}

		echo json_encode($arr);
	}
}
catch(PDOException $e){
	die(json_encode("{}"));
}
?>