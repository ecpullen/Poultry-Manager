
$(document).ready(function(){
	// $("#main").load("showhome.php");
	$("#show").click(function(){
		console.log("here")
		$("#main").load("showhome.php");
	})
	$("#ex").click(function(){
		console.log("here")
		$("#main").load("showex.php");
	})
	$("#birds").click(function(){
		console.log("here")
		$("#main").load("showbirds.php");
	})
	$("#cs").click(function(){
		console.log("here")
		$("#main").load("showcs.php");
	})
	$("#ct").click(function(){
		console.log("here")
		$("#main").load("showct.php");
	})
})