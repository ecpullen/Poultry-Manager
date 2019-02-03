// alert("here")
$(document).ready(function(){
	// alert("here")
	$("#new_show").submit(function(){
		suc = false;
		$.ajax({url:"showinit.php",
		data:{"show_name":$("input[name = \"show_name\"]").val()},
		method:"POST",
		dataType:"text",
		async:true,
		success:function(result){
			// alert("Show created");
		},
		error: function(){
		}});
		return true;
	})
})