<?php
	session_start();
	include '../mysql.php';

	function make_dd($show, $ranks, $id, $i){
		$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
		$exit = 1;
		foreach($ranks as $rank){
			if(count($rank) > 0){
				$exit = 0;
			}
		}
		if($exit){
			return;
		}
		if($i < 6){
	?>
	<p class = "sel"><?=$places[$i-1]?></p>
<?php
	}
	else{
?>
	<p class = "sel"><?=$i?>th</p>
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
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
		</option>
<?php
					array_shift($ranks[$k]);
				}
				else{
?>
		<option value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
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

	function make_ddb($show, $ranks, $id, $v_ids, $i){
		$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
		$exit = 1;
		foreach($ranks as $rank){
			if(count($rank) > 0){
				$exit = 0;
			}
		}
		if($exit){
			return;
		}
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
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
		</option>
<?php
					array_shift($ranks[$k]);
				}
				else{
?>
		<option value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
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
	function make_ddc($show, $ranks, $id, $v_ids, $i){
		$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
		$exit = 1;
		foreach($ranks as $rank){
			if(count($rank) > 0){
				$exit = 0;
			}
		}
		if($exit){
			return;
		}
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
	<select class="class" data-place="<?=$i?>">
		<option selected></option>
<?php
		for($k = 0; $k < count($ranks);$k++){
			if(count($ranks[$k])){
				if($ranks[$k][0][bird_id] == $id){
?>
		<option selected value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
		</option>
<?php
					array_shift($ranks[$k]);
				}
				else{
?>
		<option value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
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
	function make_ddd($show, $ranks, $id, $v_ids, $i){
		$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
		$exit = 1;
		foreach($ranks as $rank){
			if(count($rank) > 0){
				$exit = 0;
			}
		}
		if($exit){
			return;
		}
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
	<select class="division" data-place="<?=$i?>">
		<option selected></option>
<?php
		for($k = 0; $k < count($ranks);$k++){
			if(count($ranks[$k])){
				if($ranks[$k][0][bird_id] == $id){
?>
		<option selected value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
		</option>
<?php
					array_shift($ranks[$k]);
				}
				else{
?>
		<option value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
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
	function make_dds($show, $ranks, $id, $v_ids, $i){
		$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
		$exit = 1;
		foreach($ranks as $rank){
			if(count($rank) > 0){
				$exit = 0;
			}
		}
		if($exit){
			return;
		}
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
	<select class="show" data-place="<?=$i?>">
		<option selected></option>
<?php
		for($k = 0; $k < count($ranks);$k++){
			if(count($ranks[$k])){
				if($ranks[$k][0][bird_id] == $id){
?>
		<option selected value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
		</option>
<?php
					array_shift($ranks[$k]);
				}
				else{
?>
		<option value="<?=$ranks[$k][0][bird_id]?>">
			<?=$ranks[$k][0][bird_id]?> <?=strtoupper(get_bird_str($show, $ranks[$k][0][bird_id]))?>
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
	function make_drop_down(){

	}
	function heads($cla,$names, $data, $cdata){
		foreach($names as $name){
?>
<div class="row <?=$cla?>">
	<p <?=$data?> <?=$cdata.db()->quote(isset($name[var_id])?$name[var_id]:$name[data])?>><?=strtoupper($name[data])?></p>
</div>		
<?php
		}
	}

	function pick($cla, $name, $data){
?>
<div class="row <?=$cla?>">
	<p <?=$data?>> Best <?=strtoupper($name)?></p>
</div>	
<?php
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
	else if($_POST[rem_rank]!=""){
		rem_rank(get_show($_SESSION[show_id]),$_POST[rem_rank]);
	}
	else if($_POST[type] == "V"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i]){
				$bird_id = $_POST[ranks][$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_v($show,$bird[breed_id],$bird[variety_id]*2 + $bird[frizzle]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i] != 0){
				addAward($show, "V", $bird[variety_id]*2 + $bird[frizzle],$i,$_POST[ranks][$i]);
			}
		}
	}
	else if($_POST[type] == "B"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i]){
				$bird_id = $_POST[ranks][$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_b($show,$bird[breed_id]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i] != 0){
				addAward($show, "B", $bird[breed_id],$i,$_POST[ranks][$i]);
			}
		}
	}
	else if($_POST[type] == "C"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i]){
				$bird_id = $_POST[ranks][$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_c($show,$bird[class_id]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i] != 0){
				addAward($show, "C", $bird[class_id],$i,$_POST[ranks][$i]);
			}
		}
	}
	else if($_POST[type] == "D"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i]){
				$bird_id = $_POST[ranks][$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_d($show,$_POST[div]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i] != 0){
				addAward($show, "D", $_POST[div],$i,$_POST[ranks][$i]);
			}
		}
	}
	else if($_POST[type] == "S"){
		$show = get_show($_SESSION[show_id]);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i]){
				$bird_id = $_POST[ranks][$i];
			}
		}
		if(!isset($bird_id)){
			die("error");
		}
		$bird = get_bird($show,$bird_id);
		rem_award_s($show);
		for($i = 1; $i < count($_POST[ranks]); $i ++){
			if($_POST[ranks][$i] != 0){
				addAward($show, "S", 0,$i,$_POST[ranks][$i]);
			}
		}
	}
	else if($_POST[type] == "var" && $_POST[breed] == ""){
		$show = get_show($_SESSION[show_id]);
		$id = $_POST[id];
		$bird = get_bird($show, $id);
		$vars = get_var_ranks($show, $bird[breed_id], $bird[variety_id])->fetchAll();
		$ranks = array();
		for($i = 1; $i < 5; $i ++){
			$ranks[$i-1] = get_ordered_age_ranks($show,$bird[breed_id],$bird[variety_id],$i)->fetchAll();
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
	else if($_POST[type] == "var"){
		$show = get_show($_SESSION[show_id]);
		$id = $_POST[id];
		$breed_id = $_POST[breed];
		$variety_id = $_POST[variety];
		$vars = get_var_ranks($show, $breed_id, $variety_id)->fetchAll();
		$ranks = array();
		for($i = 1; $i < 5; $i ++){
			$ranks[$i-1] = get_ordered_age_ranks($show,$breed_id,$variety_id,$i)->fetchAll();
		}
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_dd($show,$ranks, $var[bird_id], $i);
				// echo $var[id];
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_dd($show,$ranks, 0, $i);
					$i ++;
				}
			}
		}
		$ranks = make_dd($show,$ranks, 0, $i);

	}
	else if($_POST[type] == "bre" && $_POST[breed] == ""){
		$show = get_show($_SESSION[show_id]);
		$id = $_POST[id];
		$bird = get_bird($show, $id);
		$vars = get_bre_ranks($show, $bird[breed_id])->fetchAll();
		$v_list = get_vars($show,$bird[breed_id])->fetchAll();
		$ranks = array();
		$i = 0;
		// print_r($v_list);
		foreach ($v_list as $v_id) {
			$ranks[$i] = get_ordered_var_ranks($show,$bird[breed_id],$v_id[variety_id])->fetchAll();
			$i ++;
		}
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_ddb($show,$ranks, $var[bird_id], $v_list, $i);
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_ddb($show,$ranks, 0, $v_list, $i);
					$i ++;
				}
			}
		}
		$ranks = make_ddb($show,$ranks, 0, $v_list, $i);

	}
	else if($_POST[type] == "bre"){
		$show = get_show($_SESSION[show_id]);
		$id = $_POST[id];
		$breed_id = $_POST[breed];
		$vars = get_bre_ranks($show, $breed_id)->fetchAll();
		$v_list = get_vars($show,$breed_id)->fetchAll();
		$ranks = array();
		$i = 0;
		// print_r($v_list);
		foreach ($v_list as $v_id) {
			$ranks[$i] = get_ordered_var_ranks($show,$breed_id,$v_id[variety_id])->fetchAll();
			$i ++;
		}
		// print_r($ranks);
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_ddb($show,$ranks, $var[bird_id], $v_list, $i);
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_ddb($show,$ranks, 0, $v_list, $i);
					$i ++;
				}
			}
		}
		$ranks = make_ddb($show,$ranks, 0, $v_list, $i);
	}
	else if($_POST[type] == "cla"){
		$show = get_show($_SESSION[show_id]);
		$class_id = $_POST[classes];
		$vars = get_cla_ranks($show, $class_id)->fetchAll();
		$v_list = get_bres($show,$class_id)->fetchAll();
		$ranks = array();
		$i = 0;
		foreach ($v_list as $v_id) {
			$ranks[$i] = get_ordered_bre_ranks($show,$class_id,$v_id[breed_id])->fetchAll();
			$i ++;
		}
		// print_r($ranks);
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_ddc($show,$ranks, $var[bird_id], $v_list, $i);
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_ddc($show,$ranks, 0, $v_list, $i);
					$i ++;
				}
			}
		}
		$ranks = make_ddc($show,$ranks, 0, $v_list, $i);
	}
	else if($_POST[type] == "div"){
		$show = get_show($_SESSION[show_id]);
		$division_id = $_POST[division];
		$vars = get_div_ranks($show, $division_id)->fetchAll();
		$v_list = get_clas($show,$division_id)->fetchAll();
		$ranks = array();
		$i = 0;
		foreach ($v_list as $v_id) {
			$ranks[$i] = get_ordered_cla_ranks($show,$div_id,$v_id[class_id])->fetchAll();
			$i ++;
		}
		// print_r($vars);
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_ddd($show,$ranks, $var[bird_id], $v_list, $i);
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_ddd($show,$ranks, 0, $v_list, $i);
					$i ++;
				}
			}
		}
		$ranks = make_ddd($show,$ranks, 0, $v_list, $i);
	}
	else if($_POST[type] == "sho"){
		$show = get_show($_SESSION[show_id]);
		$vars = get_sho_ranks($show, $division_id)->fetchAll();
		$v_list = get_divs($show,$division_id)->fetchAll();
		$ranks = array();
		$i = 0;
		foreach ($v_list as $v_id) {
			$ranks[$i] = get_ordered_div_ranks($show,$v_id[id])->fetchAll();
			$i ++;
		}
		// print_r($vars);
		$i = 1;
		foreach($vars as $var){
			if($var[place] == $i){
				$ranks = make_dds($show,$ranks, $var[bird_id], $v_list, $i);
				$i ++;
			}
			else{
				while($i < $var[place]){
					$ranks = make_dds($show,$ranks, 0, $v_list, $i);
					$i ++;
				}
			}
		}
		$ranks = make_dds($show,$ranks, 0, $v_list, $i);
	}
	else if($_POST[type] == "divisions"){
		$show = get_show($_SESSION[show_id]);
		$divs = get_divisions($show)->fetchAll();
		heads("division", $divs, "", "data-division = ");
		pick("spick", "in show", "");
	}
	else if($_POST[type] == "classes"){
		$show = get_show($_SESSION[show_id]);
		$divs = get_classes($show,$_POST[div])->fetchAll();
		heads("class", $divs, "", "data-class = ");
		pick("dpick", get_div($show,$_POST[div]),"data-division = '$_POST[div]'");
	}
	else if($_POST[type] == "breeds"){
		$show = get_show($_SESSION[show_id]);
		$divs = get_breeds($show,$_POST[classes])->fetchAll();
		heads("breed", $divs, "data-class = '$_POST[classes]'", "data-breed = ");
		pick("cpick", get_cla($_POST[classes]),"data-class = '$_POST[classes]'");
	}
	else if($_POST[type] == "varieties"){
		$show = get_show($_SESSION[show_id]);
		$divs = get_varieties($show,$_POST[breeds], $_POST[classes])->fetchAll();
		for($i = 0; $i < count($divs); $i ++){
			if($divs[$i][data] == " "){
				$divs[$i][data] = get_bre($_POST[breeds]);
			}
		}
		heads("variety", $divs, "data-class = '$_POST[classes]'' data-breed = '$_POST[breeds]'","data-variety = ");
		pick("bpick", get_bre($_POST[breeds]),"data-class = '$_POST[classes]' data-breed = '$_POST[breeds]'");
	}
	else if($_POST[type] == "ages"){
		$show = get_show($_SESSION[show_id]);
		$divs = get_ages($show,$_POST[varieties], $_POST[breeds])->fetchAll();
		heads("age", $divs, "data-class = '$_POST[classes]' data-breed = '$_POST[breeds]' data-variety= '$_POST[varieties]'", "data-age = ");
		pick("vpick", conv_variety($_POST[varieties]),"data-class = '$_POST[classes]' data-breed = '$_POST[breeds]' data-variety= '$_POST[varieties]'");
	}
	else if($_POST[type] == "ranks"){
		$show = get_show($_SESSION[show_id]);
		$birds = get_birds_rev($show,$_POST[breeds],$_POST[varieties],$_POST[ages])->fetchAll();
		$bird = $birds[0];
		$ranksPDO = get_ranks($show,$bird);
		$ranks = array();
		for($i = 1; $i < 6; $i ++){
			$ranks[$i] = "";
		}
		foreach ($ranksPDO as $r) {
			$ranks[$r[place]] = $r[bird_id];
		}
?>
<form>	
	<input type="hidden" name="_1" value=<?=$ranks[1]?>>
	<input type="hidden" name="_2" value=<?=$ranks[2]?>>
	<input type="hidden" name="_3" value=<?=$ranks[3]?>>
	<input type="hidden" name="_4" value=<?=$ranks[4]?>>
	<input type="hidden" name="_5" value=<?=$ranks[5]?>>
</form>
<?php
		foreach ($birds as $bird) {
?>
<div class="row entry">
		<p class="s">COOP: <?=$bird[id]?></p><br>
		<form>
			None<input class="none" type="radio" name="place" value="<?=$bird[id]?>">
<?php $rank = get_rank($show, $bird[id]) ?>
			1<input class="_1" type="radio" name="place" value="<?=5*$bird[id]?>" <?=$rank == 1 ? "checked" : ""?>>
			2<input class="_2" type="radio" name="place" value="<?=5*$bird[id] + 1?>" <?=$rank == 2 ? "checked" : ""?>>
			3<input class="_3" type="radio" name="place" value="<?=5*$bird[id] + 2?>" <?=$rank == 3 ? "checked" : ""?>>
			4<input class="_4" type="radio" name="place" value="<?=5*$bird[id] + 3?>" <?=$rank == 4 ? "checked" : ""?>>
			5<input class="_5" type="radio" name="place" value="<?=5*$bird[id] + 4?>" <?=$rank == 5 ? "checked" : ""?>>
		</form>
	</div>
<?php
		}
	}
?>











