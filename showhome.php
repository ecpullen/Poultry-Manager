<?php 
	session_start();
	
	function main(){
	if(isset($_SESSION["username"])&&$_SESSION["show_id"]){
		try{
			$arr = val_and_showdb($_SESSION[username],$_SESSION[password],$_SESSION[show_id]);
			$show = $arr[show];
			// $showdb = showdb($arr[show]);
			$ex = ex_count($arr[show]);
			$bnum = b_count($arr[show]);
			$lf = get_LF($arr[show])->rowCount();
			$btm = get_BTM($arr[show])->rowCount();
			$wf = get_WF($arr[show])->rowCount();
			}
		catch(PDOException $e){
			die($e);
		}
	}	
?>
<h3 id="ex_head"><?=$ex?> exhibitors registered.</h3>
<h4 class="id">Show IDs:</h4>
<p class="id">
<?php 
if($show[show1]){
?>
OPEN <?=strtoupper(get_color($show[show1]))?>: <?=$show[id]?> <?=2*$show[show1]?><br>
OPEN <?=strtoupper(get_color($show[show2]))?>: <?=$show[id]?> <?=2*$show[show2]?><br>
<?php
	if($show[junior]){
?>
JUNIOR <?=strtoupper(get_color($show[show1]))?>: <?=$show[id]?> <?=2*$show[show1]+1?><br>
JUNIOR <?=strtoupper(get_color($show[show2]))?>: <?=$show[id]?> <?=2*$show[show2]+1?><br>
<?php	
	}
}
else{
	if($show[junior]){
?>
	OPEN: <?=$show[id]?><br>
	JUNIOR: <?=$show[id]?> 1 <br>
<?php
	}
	else{
?>
	SHOW: <?=$show[id]?><br>
<?php
	}
}
?>
</p>
<div class="col">
<p><?=$bnum?> birds registered.</p>
<p><?=$lf?> largefowl registered.</p>
<p><?=$btm?> bantams registered.</p>
<p><?=$wf?> waterfowl registered.</p>
</div>
<?php
		if($show[junior]){
			$c = get_count($show);
			// print_r($c);
?>
<div class="col">
<p><?=$c[o]?> open birds registered.</p>
<p><?=$c[o_lf]?> open largefowl registered.</p>
<p><?=$c[o_btm]?> open bantams registered.</p>
<p><?=$c[o_wf]?> open waterfowl registered.</p>
</div>
<div class="col">
<p><?=$c[j]?> junior birds registered.</p>
<p><?=$c[j_lf]?> junior largefowl registered.</p>
<p><?=$c[j_btm]?> junior bantams registered.</p>
<p><?=$c[j_wf]?> junior waterfowl registered.</p>
</div>
<?php
		}
	}
?>
