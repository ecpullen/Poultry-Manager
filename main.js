
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
		window.location.href ="index.html"
	})
	$("#services").click(function(){
		$(".popup").not("#spop").hide();
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
		$("#login form input").each(function(){
		t = this;
		console.log($(this).parent().children("input[name=username]"));
		$.ajax({url:"signin.php",
			data:{type:"secretary",
				username: $(this).parent().children("input[name=username]").val(),
				password: $(this).parent().children("input[name=password]").val()},
			method:"POST",
			dataType:"text",
			success:function(result){
				console.log(result)
				console.log($(t).parent().children("input[type=hidden]"))
				$(t).parent().children("input[type=hidden]").val(result);
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
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
	$("#login form input").keyup(function(){
		t = this;
		console.log($(this).parent().children("input[name=username]").val());
		$.ajax({url:"signin.php",
			data:{type:"secretary",
				username: $(this).parent().children("input[name=username]").val(),
				password: $(this).parent().children("input[name=password]").val()},
			method:"POST",
			dataType:"text",
			success:function(result){
				console.log(result)
				console.log($(t).parent().children("input[type=hidden]"))
				$(t).parent().children("input[type=hidden]").val(result);
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$("#login form").submit(function(){
		if($(this).children("input[type=hidden]").val() != 1){
			alert("Invalid Login")
			return false;
		}
		return true;
	})
	$("#lo").click(function(){
		console.log("here")
		$.ajax("logout.php");
		window.location.href = "index.html";
	})
})