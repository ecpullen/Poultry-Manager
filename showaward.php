<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$birds = birds($arr[show]);
?>
<fieldset>
	<legend>Add Award</legend>
	<form action="show.php?p=aw" method="POST" id="new">
		Place:<input type="text" name="Place" maxlength="5" size="5">
		Type:<select>
			<option default value="0">
				
			</option>
			<option value="1">
				Rank
			</option>
			<option value="2">
				Variety
			</option>
			<option value="3">
				Breed
			</option>
			<option value="4">
				Class
			</option>
			<option value="5">
				Division
			</option>
			<option value="6">
				Show
			</option>
		</select>
	</form>
</fieldset>
<script type="text/javascript">
	curType = 0;
	$("#new select").change(function(){
		type = $("#new select").val();
	})

</script>

<?php
		}
		catch(PDOException $e){
			die($e);
		}
	}
?>