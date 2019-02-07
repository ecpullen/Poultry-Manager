<?php 
	session_start();
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$ex = $showdb->query("SELECT * FROM exhibitors")->rowCount();
			$bnum = $showdb->query("SELECT * FROM birds")->rowCount();
			$lf = get_LF($arr[show])->rowCount();
			$btm = get_BTM($arr[show])->rowCount();
			$wf = get_WF($arr[show])->rowCount();
?>
<p><?=$ex?> exhibitors registered.</p>
<p><?=$bnum?> birds registered.</p>
<p><?=$lf?> largefowl registered.</p>
<p><?=$btm?> bantams registered.</p>
<p><?=$wf?> waterfowl registered.</p>
<?php
		}
		catch(PDEException $e){
			echo $e;
		}
	}
?>
