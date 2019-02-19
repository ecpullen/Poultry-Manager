<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$birds = birds($arr[show]);
			if($_POST["final"]){
				if($_POST[password] == $_SESSION[password]){
					finalize($arr[show]);
					$err = 0;
				}
				else{
					$err = 1;
				}
				header("Location: show.php?p=birds&e=$err");
			}
		}
		catch(PDOException $e){
			die($e);
		}
	}
	function main(){
		$show = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show];
?>
<div class="popup" style="display: none;">
	<h1>Are you sure you want to finalize, this process cannot be undone.</h1>
	<form action="show.php?p=birds" method="POST">Password: <br> <input type="password" name="password">
	<br>
	<input id="finalize" type="submit" name="final" value="Finalize">
	</form>
</div>
<div class="row head">
	<p class="s">ID</p>
	<p class="s">EXHIBITOR</p>
	<p>CLASS</p>
	<p>BREED</p>
	<p class="l">VARIETY</p>
	<p class="s">FRIZZLED</p>
	<p class="s">AGE/SEX</p>
<?php if($show[junior]){ ?>
	<p class="s">JUNIOR</p>
<?php } ?>
	<form>
		<button id="final" type="button">Finalize</button>
	</form>
</div>

<div class="display">
<?php
$show = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id])[show];
$birds = birds($show);
			foreach ($birds as $bird) {
?>
<div class="row">
	<p class="s"><?=$bird[id]?></p>
	<p class="s"><?=$bird[ex_id]?></p>
	<p><?=$bird[classname]?></p>
	<p><?=$bird[breed]?></p>
	<p class="l"><?=$bird[variety]?></p>
	<p class="s"><?=$bird[frizzle]? "Frizzled" : ""?></p>
	<p class="s"><?=$bird[age]?></p>
<?php if($show[junior]){ ?>
	<p class="s"><?=$bird[show_num]?"JR":""?></p>
<?php } ?>
</div>
<?php
			}
?>
</div>
<script type="text/javascript">
	$("#final").click(function(){
		$(".popup").toggle();
	})
<?php
	if($_GET[e]){
		echo("
			alert('invalid Password');
			$('.popup').show();
			");
	}
?>
</script>
<?php
	}
?>