<?php 
	session_start();
	include 'mysql.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Exhibitor</title>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="manager.js"></script>
</head>
<body>
<?php
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$show = $arr[show];
?>
	<header>
		<div id="show" class="mainlink">
			<h3><?=$show[name]?></h3>
		</div>
		<div id="ex" class="mainlink">
			<h3>Exhibitors</h3>
		</div>
		<div id="birds" class="mainlink">
			<h3>Birds</h3>
		</div>
		<div id="cs" class="mainlink">
			<h3>Clerk Sheets</h3>
		</div>
		<div id="ct" class="mainlink">
			<h3>Coop Tags</h3>
		</div>
		<div id="aw" class="mainlink">
			<h3>Awards</h3>
		</div>
		<div id="lo" class="mainlink">
			<h3>Logout</h3>
		</div>
	</header>
<?php
			if(isset($_POST[name])){
				if(isset($_POST[id]) || ex_exists($show,$_POST[name])){
					if($_POST[id] != ""){
						$q = "id = ".$_POST[id];
						$_POST[ex] = $_POST[id];
					}
					else{
						$q = "name = ".db()->quote($_POST[name]);
						$_POST[ex] = get_ex_by_name($show,$_POST[name])[id];
					}
					update_ex($show, "name =".db()->quote($_POST[name]).", address =".db()->quote($_POST[address]).", city=".db()->quote($_POST[city]).", state=".db()->quote($_POST[state]).", email=".db()->quote($_POST[email]).", phone=".db()->quote($_POST[phone]),$q);
				}
				else{
						add_ex($show,$_POST[name],$_POST[address],$_POST[city],$_POST[state],$_POST[zip],$_POST[email],$_POST[phone]);
						$_POST[ex] = get_ex_by_name($show,$_POST[name])[id];
				}
			}
			if(isset($_POST[ex])){
				$ex = get_ex($show, $_POST[ex]);
				if(isset($_POST[breed]) && $_POST[age] == ""){
					$ids = get_ids($_POST[division],$_POST[breed],$_POST[variety]);
					for($i = 0; $i < $_POST[cock]; $i++){
						add_bird($show,$ex[id],$ids[breed_id],$ids[variety_id],1,$_POST[frizzle]);
					}
					for($i = 0; $i < $_POST[hen]; $i++){
						add_bird($show,$ex[id],$ids[breed_id],$ids[variety_id],2,$_POST[frizzle]);
					}
					for($i = 0; $i < $_POST[cockerel]; $i++){
						add_bird($show,$ex[id],$ids[breed_id],$ids[variety_id],3,$_POST[frizzle]);
					}
					for($i = 0; $i < $_POST[pullet]; $i++){
						add_bird($show,$ex[id],$ids[breed_id],$ids[variety_id],4,$_POST[frizzle]);
					}
				}
				elseif(isset($_POST[breed])){
					$ids = get_ids_with_class($_POST[classname],$_POST[breed],$_POST[variety]);
					update_bird($_POST[id],$show,$ex[id],$ids[breed_id],$ids[variety_id],4,$_POST[frizzle]);
				}
				elseif($_POST[delete] != ""){
					delete($show, $_POST["delete"]);
				}
?>
		<fieldset>
			<legend>Edit Exhibitor</legend>
			<form action="ex.php" method="POST">
				Name: <input type="text" name="name" value="<?=$ex[name]?>" required>
				Address: <input type="text" name="address" value="<?=$ex[address]?>" required>
				City: <input type="text" name="city" value="<?=$ex[city]?>" required>
				State: <input type="text" name="state" value="<?=$ex[state]?>" required>
				Zip: <input type="text" name="zip" value="<?=$ex[zip]?>" required>
				Email: <input type="email" name="email" value="<?=$ex[email]?>" required>
				Phone: <input type="text" name="phone" value="<?=$ex[phone]?>" required>
				<input type="hidden" name="id" value="<?=$ex[id]?>">
				<input type="submit" name="submit">
			</form>
		</fieldset>

		<fieldset>
			<legend>Add Birds</legend>
			<form action="ex.php" method="POST">
				Division: LF <input type="radio" name="division" value="Large Fowl">
						 BTM <input type="radio" name="division" value="Bantam">
						 WF <input type="radio" name="division" value="Waterfowl">
				Breed: <input type="text" name="breed" required>
				Variety: <input type="text" name="variety">
				Frizzled:<input type="checkbox" name="frizzle" value = 'TRUE'>
				Cock: <input class = "quantity" type="number" name="cock">
				Hen: <input class = "quantity" type="number" name="hen">
				Cockerel: <input class = "quantity" type="number" name="cockerel">
				Pullet: <input class = "quantity" type="number" name="pullet">
				<input type="hidden" name="ex" value="<?=$ex[id]?>">
				<input type="submit" name="submit">
			</form>
		</fieldset>
<?php
				$birds = birds_by_ex($show,$ex[id]);
?>
<div class="row head">
	<p class="s">ID</p>
	<p>CLASS</p>
	<p>BREED</p>
	<p class="l">VARIETY</p>
	<p>FRIZZLE</p>
	<p class="s">AGE/SEX</p>
</div>
<div class="display m">
<?php
				foreach ($birds as $bird) {
					if($bird[id] == $_POST[edit]){
?>
<div class="row">
	<p><?=$bird[id]?></p>
	<form action="ex.php" method="POST">
		<input type="text" name="classname" value="<?=$bird[classname]?>">
		<input type="text" name="breed" value="<?=$bird[breed]?>">
		<input type="text" name="variety" value="<?=$bird[variety]?>">
<?php
	if($bird[frizzle]){
?>
		<input type="checkbox" name="frizzle" checked>
<?php 
	}
	else{
?>
		<input type="checkbox" name="frizzled">
<?php
	}
?>
		<input type="text" name="age" value="<?=$bird[age]?>">
		<input type="hidden" name="id" = value="<?=$bird[id]?>">
		<input type="hidden" name="ex" value="<?=$ex[id]?>">
		<input type="submit" value="Save">
	</form>
</div>
<?php
					}
					else{
?>
<div class="row">
	<p class="s"><?=$bird[id]?></p>
	<p><?=$bird[classname]?></p>
	<p><?=$bird[breed]?></p>
	<p class="l"><?=$bird[variety]?></p>
	<p><?=$bird[frizzle]? "Frizzled" : ""?></p>
	<p class="s"><?=$bird[age]?></p>
	<form class="p" action="ex.php" method="POST"><input type="hidden" name="edit" value="<?=$bird[id]?>"><input type="hidden" name="ex" value="<?=$ex[id]?>"><input type="submit" value="Edit"></form>
	<form class="p" action="ex.php" method="POST"><input type="hidden" name="delete" value="<?=$bird[id]?>"><input type="hidden" name="ex" value="<?=$ex[id]?>"><input type="submit" value="Delete"></form>
</div>
<?php
					}
				}
?>
</div>
<?php
			}
			else{
?>
<fieldset>
			<legend>New Exhibitor</legend>
			<form action="ex.php" method="POST">
				Name: <input type="text" name="name" required>
				Address: <input type="text" name="address" required>
				City: <input type="text" name="city" required>
				State: <input type="text" name="state" required>
				Zip: <input type="text" name="zip" required>
				Email: <input type="email" name="email" required>
				Phone: <input type="text" name="phone" required>
				<input type="hidden" name="ex" value="<?=$ex[id]?>">
				<input type="submit" name="submit">
			</form>
		</fieldset>
<?php
			}
		}
		catch(PDOException $e){
			die($e);
		}
	}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("input[name=\"breed\"]").on('input',function(){
			$.ajax({url:"auto.php",
			data:{division: $("input[name='division']:checked").val(),breed:$("input[name=\"breed\"]").val()},
			method:"POST",
			dataType:"text",
			success:function(result){
				console.log(result)
				 $("input[name=\"breed\"]").autocomplete({
      				source: JSON.parse(result)
    			});
			},
			error: function(error){
				alert("error")
				console.log(error)
			}});
		})
		$("input[name=\"variety\"]").on('input',function(){
			$.ajax({url:"auto.php",
			data:{division: $("input[name='division']:checked").val(), breed:$("input[name=\"breed\"]").val(), variety:$("input[name=\"variety\"]").val()},
			method:"POST",
			dataType:"text",
			success:function(result){
				console.log(result)
				 $("input[name=\"variety\"]").autocomplete({
      				source: JSON.parse(result)
    			});
			},
			error: function(error){
				alert("error")
				console.log(error)
			}});
		})
	})
</script>
</body>
</html>