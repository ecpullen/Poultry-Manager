
$(document).ready(function(){

	console.log($("input[name='double']"))
	$("input[name='double']").change(function(){
		$("#doublepick").toggle();
	})
	$("#new_show").submit(function(){
		suc = false;
		// alert($("#date").val())
		$.ajax({url:"showinit.php",
		data:{show_name:$("input[name = \"show_name\"]").val(),
				date: $("#date").val(),
				jr: $("#jr").is( ':checked' ) ? 1: 0,
				ds: $("#ds").is( ':checked' ) ? 1: 0,
				s1: $("#show1").val(),
				s2: $("#show2").val()},
		method:"POST",
		dataType:"text",
		async:true,
		success:function(result){
			console.log(result);
			alert(result)
		},
		error: function(r,d,error){
			alert(error);
			return false;
		}});
		alert("here");
		return true;
	})
})