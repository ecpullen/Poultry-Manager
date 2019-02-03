
$(document).ready(function(){
	$("#signupform").submit(function(){
		if($("input[name = \"spassword\"]").val()==$("input[name = \"sconfirmpassword\"]").val()){
			return true;
		}
		else{
			alert("Passwords must match");
			return false;
		}
	})
})