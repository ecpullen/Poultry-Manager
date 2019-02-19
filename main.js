
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
	$("#signup form input[name=username]").change(function(){
		// alert($(this).val())
		t = this
		$.ajax({url:"signup.php",
			data:{uname: $(this).val()},
			method:"GET",
			dataType:"text",
			success:function(result){
				console.log($(t))
				if(result == "bad"){
					 console.log("add bad")
					$(t).addClass("bad")
					$(t).removeClass("good")
				}
				else{
					console.log("remove bad")
					$(t).removeClass("bad")
					$(t).addClass("good")
				}
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$("#signup form").submit(function(){
		$.ajax({url:"award.php",
			data:{type:"classes", div:div},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				console.log($(t));
				$(t).siblings().remove();
				$(t).parent().append(result);
				doclass();
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
})