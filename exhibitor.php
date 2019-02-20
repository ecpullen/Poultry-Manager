<?php 
	session_start();
	include 'mysql.php';
	if(isset($_SESSION["username"])){
			if(isset($_POST["show_id"])||isset($_SESSION["show_id"])||isset($_POST["show_name"])){
				if($_POST[show_name] != ""){
					$arr = val_and_showdb($_SESSION[username],$_SESSION[password],id_from_sname($_POST[show_name]));
					$show = $arr[show];
					$_SESSION["show_id"] = $show[id];
					header("Location: show.php");
				}
				elseif(isset($_POST["show_id"])){	
					$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_POST[show_id]);
					$show = $arr[show];
					$_SESSION["show_id"] = $show[id];
					$_SESSION["state"] = "home";
				}
				else{
					$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id	]);
					$show = $arr[show];
				}
				$showdb = $arr[showdb];
		break;
		}
	}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Manage <?=$show[name]?></title>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="manager.js"></script>
</head>
<body>
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
<div id="main">
<?php 
	main();
?>
</div>
<?php
			}
			else{
?>
<head>
	<title>Create Show</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="newshow.js"></script>
</head>
<body>
		<fieldset>
			<legend>New Show</legend>
			<form id = "new_show" action="show.php" method="POST">
				Show Name:
				<input id = "ns" type="text" name="show_name" required>
				<br />
				Date:
				<input id="date" type="date" name="date" required>
				<br />
				Include Junior Show:
				<input id="jr" type="checkbox" name="junior">
				<br />
				Double Show:
				<input id="ds" type="checkbox" name="double">
				<br />
				<span id="doublepick" style="display: none">
					<select id="show1" name="show1">
						<option value="2" selected>
							White
						</option>
						<option value="3" >
							Blue
						</option>
						<option value="4" >
							Green
						</option>
						<option value="5" >
							Yellow
						</option>
						<option value="6" >
							Pink
						</option>
					</select>
					<select id="show2" name="show2">
						<option value="2" >
							White
						</option>
						<option value="3" selected>
							Blue
						</option>
						<option value="4" >
							Green
						</option>
						<option value="5" >
							Yellow
						</option>
						<option value="6" >
							Pink
						</option>
					</select>
					<br>
				</span>
				<input type="submit" name="submit">
			</form>
		</fieldset>
<?php
			}
		$u = $_SESSION["username"];
		$p = $_SESSION[password];
		$s = $_SESSION[show_id];
		session_unset();
		$_SESSION[username] = $u;
		$_SESSION[password] = $p;
		$_SESSION[show_id] = $s;
		
	}
	else{
		die("<h1>An error occured</h1><a href='index.html'>Try Again</a>");
	}
?>
</body>
</html>