
$(document).ready(function(){
	$(".popup").hide();
	$("#signupform").submit(function(){
		if($("input[name = \"spassword\"]").val()==$("input[name = \"sconfirmpassword\"]").val()){
			return true;
		}
		else{
			alert("Passwords must match");
			return false;
		}
	})
	$("#home").click(function(){

	})
	$("#services").click(function(){
		$(".popup").not("#login").hide();
		$('#spop').toggle()
	})
	$("#clerklogin").click(function(){
		$(".popup").not("#clogin").hide();
		$('#clogin').toggle()
		//window.location.href = "clerk/"
	})
	$("#exlogin").click(function(){

	})
	$("#seclogin").click(function(){
		$(".popup").not("#login").hide();
		$('#login').toggle()
	})
	$("#sup").click(function(){
		$(".popup").not("#signup").hide();
		$('#signup').toggle()
	})
	$(".exit").click(function(){
		$(this).parent().parent().parent().hide();
	})
})