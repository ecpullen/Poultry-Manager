function clerk(num){
	$.ajax({url:"print.php",
			data:{query:"clerk", num:num},
			method:"GET",
			dataType:"HTML",
			success:function(result){
				console.log(result)
				var WindowObject = window.open("", "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		        WindowObject.document.writeln(result);
		        WindowObject.document.close();
		        WindowObject.focus();
		        WindowObject.print();
		        WindowObject.close();
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
}
function cooptag(num){
	$.ajax({url:"print.php",
			data:{query:"cooptag", num:num},
			method:"GET",
			dataType:"HTML",
			success:function(result){
				var WindowObject = window.open("", "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		        WindowObject.document.writeln(result);
		        WindowObject.document.close();
		        WindowObject.focus();
		        WindowObject.print();
		        WindowObject.close();
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
}