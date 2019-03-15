var curType = 1
var inputs
$.ajax({url:"awardhelp.php",
			data:{n:"n"},
			method:"POST",
			dataType:"text",
			success:function(result){
				inputs = result.split(",");
                $("#new #type").change(function(){
                    curType = $("#new #type").val();
                    $("#info").empty()
                    $("#info").append(inputs[curType-2])
                })
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});