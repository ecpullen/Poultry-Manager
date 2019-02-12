<!DOCTYPE html>
<html>
<head>
	<title>Clerk Sign In</title>
	<link rel="stylesheet" type="text/css" href="manage.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="manager.js"></script>
</head>
<body>
<fieldset>
	<legend>
		Login
	</legend>
	<form action="clerk.php" method="POST">
		Name <input type="text" name="name">
		<br>
		<br>
		Judge <input type="text" name="judge">
		<br>
		<br>
		Show Id <input type="text" name="id">
		<br>
		<br>
		<input type="submit" name="">
	</form>
</fieldset>
</body>
</html>