<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			if(count($_POST) && !isset($_POST[junior])){
				$_POST[junior] = 0;
			}
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$show = $arr[show];
			if($_POST[age]){
				add_saward_r($show, $_POST[place], $_POST[div], $_POST[breed], $_POST[variety],$_POST[frizzle], $_POST[age], $_POST[junior]);
			}
			elseif($_POST[variety]){
				add_saward_v($show, $_POST[place], $_POST[div], $_POST[breed], $_POST[variety],$_POST[frizzle], $_POST[junior]);
			}
			elseif($_POST[breed]){
				add_saward_b($show, $_POST[place], $_POST[div], $_POST[breed], $_POST[junior]);
			}
			elseif($_POST['class']){
				add_saward_c($show, $_POST[place], $_POST['class'], $_POST[junior]);
			}
			elseif($_POST[div]){
				add_saward_d($show, $_POST[place], $_POST[div], $_POST[junior]);
			}
			elseif($_POST['place']){
				add_saward_s($show, $_POST[place], $_POST[junior]);
			}
			if(count($_POST)){
				header("Location: show.php?p=aw");
			}
		}
		catch(PDOException $e){
			die($e);
		}
	}

function head(){
?>
<script src = "award.js"></script>
<?php
}

function main(){
	$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
	$show = $arr[show];
?>
<fieldset>
	<legend>Add Award</legend>
	<form action="show.php?p=aw" method="POST" id="new">
<?php
	if($show[junior]){
?>
		JR:<input type="checkbox" name="junior" value="1">
<?php
	}
	else{
?>
		<input type="hidden" name="junior" value="0">
<?php
	}
?>
		Place:<input type="text" name="place" maxlength="5" size="5" required>
		Type:<select id="type" name="type" required>
			<option disabled selected>
				
			</option>
			<option value="1">
				Show
			</option>
			<option value="2">
				Division
			</option>
			<option value="3">
				Class
			</option>
			<option value="4">
				Breed
			</option>
			<option value="5">
				Variety
			</option>
			<option value="6">
				Rank
			</option>
		</select>
		<span id="info"></span>
		<input type='submit'>
	</form>
</fieldset>
<?php 
$sawards = get_sawards($show);
?>
<div class="display">
<?php
$places = ["BEST", "RESERVE", "THIRD", "FOURTH", "FIFTH"];
foreach ($sawards as $award) {
?>
	<div class="row">
		<p class="half"><?=$award[place]<6?$places[$award[place]-1]:$award[place]."th"?><?=$award[junior]?" JUNIOR":""?> <?=$award[ssho]?> <?=strtoupper($award[scla])?> <?=strtoupper($award[svar])?> <?=$award[sfri]?"FRIZZLE":""?> <?=strtoupper($award[sbre])?> <?=(($award[sdiv] != "Waterfowl" && $award[sbre] != "Call")|| !$award[sbre])?strtoupper($award[sdiv]):""?> <?=strtoupper($award[sage])?> <?=strtoupper($award[color])?></p>
		<p class="half"><?=strtoupper($award[rcla])?> <?=strtoupper($award[rvar])?> <?=$award[rfri]?"FRIZZLE":""?> <?=strtoupper($award[rbre])?> <?=strtoupper($award[rdiv])?> <?=strtoupper($award[rage])?> <?=$award[name]?"By: $award[name]":""?></p>
	</div>
<?php
}
?>
</div>
<?php
}
?>