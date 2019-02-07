
$(document).ready(function(){
	$("#show").click(function(){
		console.log("here")
		window.location.href = "show.php?p=home";
	})
	$("#ex").click(function(){
		console.log("here")
		window.location.href = "show.php?p=ex";
	})
	$("#birds").click(function(){
		console.log("here")
		window.location.href = "show.php?p=birds";
	})
	$("#cs").click(function(){
		console.log("here")
		window.location.href = "show.php?p=cs";
	})
	$("#ct").click(function(){
		console.log("here")
		window.location.href = "show.php?p=ct";
	})
	$("#lo").click(function(){
		console.log("here")
		$.ajax("logout.php");
		window.location.href = "index.html";
	})
})
