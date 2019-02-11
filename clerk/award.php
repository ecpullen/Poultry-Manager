<?php
	session_start();
	include '../mysql.php';

	function make_dd($ranks, $id, $i){
		$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
		if($i < 6){
	?>
	<p><?=$places[$i-1]?></p>
<?php
	}
	else{
?>
	<p><?=$i?>th</p>
<?php
	}
?>
	<select class="variety" data-place="<?=$i?>">
		<option selected></option>
<?php
		for($k = 0; $k < 4;$k++){
			if(count($ranks[$k])){
				if($ranks[$k][0][bird_id] == $id){
?>
		<option selected value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_age($k+1))?>
		</option>
<?php
					array_shift($ranks[$k]);
				}
				else{
?>
		<option value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_age($k+1))?>
		</option>
<?php
				}
?>
<?php
			}
		}
?>
	</select>
<?php
		return $ranks;
	}

	function make_ddb($ranks, $id, $v_ids, $i){
		$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
		if($i < 6){
	?>
	<p><?=$places[$i-1]?></p>
<?php
		}
		else{
?>
	<p><?=$i?>th</p>
<?php
	}
?>
	<select class="breed" data-place="<?=$i?>">
		<option selected></option>
<?php
		for($k = 0; $k < count($ranks);$k++){
			if(count($ranks[$k])){
				if($ranks[$k][0][bird_id] == $id){
?>
		<option selected value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_var($v_ids[$k][0]))?>
		</option>
<?php
					array_shift($ranks[$k]);
				}
				else{
?>
		<option value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_var($v_ids[$k][0]))?>
		</option>
<?php
				}
			}
		}
?>
	</select>
<?php
		return $ranks;
	}

	if($_POST[type] == "R"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < 6; $i ++){
			if($_POST["_".$i]){
				echo $_POST["_".$i];
				$bird_id = $_POST["_".$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_r($show,$bird[breed_id],$bird[variety_id],$bird[age_id]);
		for($i = 1; $i < 6; $i ++){
			if($_POST["_".$i] != 0){
				addAward($show, "R", $bird[age_id],$i,$_POST["_".$i]);
			}
		}
	}
	if($_POST[rem_rank]!=""){
		rem_rank(get_show($_SESSION[show_id]),$_POST[rem_rank]);
	}
	if($_POST[type] == "V"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < 6; $i ++){
			if($_POST[ranks][$i]){
				$bird_id = $_POST[ranks][$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_v($show,$bird[breed_id],$bird[variety_id]);
		for($i = 1; $i < 6; $i ++){
			if($_POST[ranks][$i] != 0){
				addAward($show, "V", $bird[variety_id],$i,$_POST[ranks][$i]);
			}
		}
	}
	if($_POST[type] == "B"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < 6; $i ++){
			if($_POST[ranks][$i]){
				$bird_id = $_POST[ranks][$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_b($show,$bird[breed_id]);
		for($i = 1; $i < 6; $i ++){
			if($_POST[ranks][$i] != 0){
				addAward($show, "B", $bird[variety_id],$i,$_POST[ranks][$i]);
			}
		}
	}
	if($_POST[type] == "var"){
		$show = get_show($_SESSION[show_id]);
		$id = $_POST[id];
		$bird = get_bird($show, $id);
		$vars = get_var_ranks($show, $bird)->fetchAll();
		$ranks = array();
		for($i = 1; $i < 5; $i ++){
			$ranks[$i-1] = get_ordered_age_ranks($show,$bird,$i)->fetchAll();
		}
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_dd($ranks, $var[bird_id], $i);
				// echo $var[id];
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_dd($ranks, 0, $i);
					$i ++;
				}
			}
		}
		$ranks = make_dd($ranks, 0, $i);

	}
	if($_POST[type] == "bre"){
		$show = get_show($_SESSION[show_id]);
		$id = $_POST[id];
		$bird = get_bird($show, $id);
		$vars = get_bre_ranks($show, $bird)->fetchAll();
		$v_list = get_vars($show,$bird)->fetchAll();
		$ranks = array();
		$i = 0;
		// print_r($v_list);
		foreach ($v_list as $v_id) {
			$ranks[$i] = get_ordered_var_ranks($show,$bird,$v_id[variety_id])->fetchAll();
			$i ++;
		}
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_ddb($ranks, $var[bird_id], $v_list, $i);
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_ddb($ranks, 0, $v_list, $i);
					$i ++;
				}
			}
		}
		$ranks = make_ddb($ranks, 0, $v_list, $i);

	}
?>