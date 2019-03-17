<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$birds = birds($arr[show]);
		}
		catch(PDOException $e){
			die($e);
		}
	}
	function main(){
		$show = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show];
		if($show[junior] && $show[show2]){
?>
			<h3>Open Show Sheets</h3>
			<button onclick="clerk(<?=$show[show1]*2?>)">Print Clerk Sheets <?=get_color($show[show1])?></button><br>
			<button onclick="cooptag(<?=$show[show1]*2?>)">Print Coop Tags <?=get_color($show[show1])?></button><br>
			<button onclick="clerk(<?=$show[show2]*2?>)">Print Clerk Sheets <?=get_color($show[show2])?></button><br>
			<button onclick="cooptag(<?=$show[show2]*2?>)">Print Coop Tags <?=get_color($show[show2])?></button><br>
			<h3>Junior Show Sheets</h3>
			<button onclick="clerk(<?=$show[show1]*2+1?>)">Print Clerk Sheets <?=get_color($show[show1])?></button><br>
			<button onclick="cooptag(<?=$show[show1]*2+1?>)">Print Coop Tags <?=get_color($show[show1])?></button><br>
			<button onclick="clerk(<?=$show[show2]*2+1?>)">Print Clerk Sheets <?=get_color($show[show2])?></button><br>
			<button onclick="cooptag(<?=$show[show2]*2+1?>)">Print Coop Tags <?=get_color($show[show2])?></button><br>
<?php
		}
		else if($show[show2]){
?>
			<h3><?=get_color($show[show1])?> Show Sheets</h3>
			<button onclick="clerk(<?=$show[show1]*2?>)">Print Clerk Sheets <?=get_color($show[show1])?></button><br>
			<button onclick="cooptag(<?=$show[show1]*2?>)">Print Coop Tags <?=get_color($show[show1])?></button><br>
			<h3><?=get_color($show[show2])?> Show Sheets</h3>
			<button onclick="clerk(<?=$show[show2]*2?>)">Print Clerk Sheets <?=get_color($show[show2])?></button><br>
			<button onclick="cooptag(<?=$show[show2]*2?>)">Print Coop Tags <?=get_color($show[show2])?></button><br>
<?php
		}
		else if($show[junior]){
?>
			<h3>Open Show Sheets</h3>
			<button onclick="clerk(0)">Print Clerk Sheets?></button><br>
			<button onclick="cooptag(0)">Print Coop Tags?></button><br>
			<h3>Junior Show Sheets</h3>
			<button onclick="clerk(1)">Print Clerk Sheets</button><br>
			<button onclick="cooptag(1)">Print Coop Tags</button><br>
<?php
		}
		else{
?>
			<h3><?=$show[name]?> Show Sheets</h3>
			<button onclick="clerk(0)">Print Clerk Sheets</button><br>
			<button onclick="cooptag(0)">Print Coop Tags</button><br>
<?php
		}
?>
<?php 
	}
?>

<?php
	function head(){
?>
	<script src="print.js"></script>
<?php 
	}
?>