 // $(document).ready(function(){
 //    $(".phead").sticky({topSpacing:0});
 //    $(".vhead").sticky({topSpacing:50});
 //  });

 function UpdateTableHeaders() {
   $(".page").each(function() {
   
       var el             = $(this),
           offset         = el.offset(),
           scrollTop      = $(window).scrollTop(),
           floatingHeader = $(".floatingHeader", this)
       if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {

           console.log("here");
           floatingHeader.css({
            "visibility": "visible"
           });
       } else {
           floatingHeader.css({
            "visibility": "hidden"
           });      
       };
   });
}

// DOM Ready      
$(function() {

   var clonedHeaderRow;

   $(".page").each(function() {
       clonedHeaderRow = $(".phead", this);
       clonedHeaderRow
         .before(clonedHeaderRow.clone())
         .css("width", "584px")
         .addClass("floatingHeader");
         
   });
   
   $(window)
    .scroll(UpdateTableHeaders)
    .trigger("scroll");
   
});

 function UpdateTableHeaders2() {
   $(".var").each(function() {
   
       var el             = $(this),
           offset         = el.offset(),
           scrollTop      = $(window).scrollTop(),
           floatingHeader = $(".floatingHeader2", this)
       if ((scrollTop > offset.top-50) && (scrollTop < offset.top + el.height()-100)) {
           floatingHeader.css({
            "visibility": "visible"
           });
       } else {
           floatingHeader.css({
            "visibility": "hidden"
           });      
       };
   });
}

// DOM Ready      
$(function() {

   var clonedHeaderRow;

   $(".var").each(function() {
       clonedHeaderRow = $(".vhead", this);
       clonedHeaderRow
         .before(clonedHeaderRow.clone())
         .css("width", "584px")
         .addClass("floatingHeader2");
         
   });
   
   $(window)
    .scroll(UpdateTableHeaders2)
    .trigger("scroll");
   
});

$(document).ready(function(){
	$(".pick").children(".vhead").each(function(){
		console.log($(this).children())
		if($(this).siblings().length>0){
			$(this).siblings().remove();
		}
	})
	$('input[name="place"]').not('.none').on("change",function() {
		$(document).children('input[name="place"]').attr("disabled",true);
		v = $(this).val();
		id = Math.floor(v/5);
		rank = v % 5 + 1;
		ranks = [];
		for($i = 1; $i < 6; $i ++){
			ranks[$i] = 0;
		}
		for (i=1;i<6;i++){
			if($(this).parent().parent().parent().children("form").children("input[name=_"+i+"]").val()!="" && 
				!$(this).parent().parent().parent().children(".row").children("form").children("._"+i).is(":checked")){
				$(this).parent().parent().parent().children("form").children("input[name=_"+i+"]").val("");
			}
		}
		$(this).parent().parent().parent().children("form").children("input[name=_"+rank+"]").val(id);
		$(this).parent().parent().parent().children(".row").children("form").children("input").attr("disabled",false)
		for (i=1;i<6;i++){
			if($(this).parent().parent().parent().children("form").children("input[name=_"+i+"]").val()!=""){
				$(this).parent().parent().parent().children(".row").children("form").children("._"+i).attr("disabled",true)
			}
		}
		for (i=1;i<6;i++){
			val = $(this).parent().parent().parent().children("form").children("input[name=_"+i+"]").val()
			if(val!=""){
				ranks[i] = val;
			}
		}
		console.log({type:"R",_1:ranks[1],_2:ranks[2],_3:ranks[3],_4:ranks[4],_5:ranks[5]});
		$(this).parent().parent().parent().children(".row").children("form").children("input:checked").attr("disabled",false)
		$.ajax({url:"award.php",
			data:{type:"R",_1:ranks[1],_2:ranks[2],_3:ranks[3],_4:ranks[4],_5:ranks[5]},
			method:"POST",
			dataType:"text",
			success:function(result){
				console.log(result);
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$('.none').on("change",function(){
		id = $(this).val();
		$.ajax({url:"award.php",
			data:{rem_rank:id},
			method:"POST",
			dataType:"text",
			success:function(result){
				console.log(result);
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$(".phead").click(function(){
		$(this).parent().children(".var").children(".vhead").toggle();
		if($(this).parent().children(".var").children(".vhead").is(":hidden")){
			console.log("here");
			$(this).parent().children(".var").children(":visible").hide()
			$(this).parent().children(".var").children(".age").children().hide()

		}
	})
	$(".vhead").click(function(){
		console.log("here");
		$(this).parent().children(".age").toggle();
		if($(this).parent().children(".age").is(":visible")){
			$(this).parent().children(".age").children().hide();
			$(this).parent().children(".age").children(".ahead").show();
		}
		
	})
	$(".ahead").click(function(){
		$(this).parent().children(".row").not(".ahead").toggle();
	})
	$(".pick").children(".ahead").click(function(){
		console.log($(this).children())
		if($(this).siblings().length>0){
			$(this).siblings().remove();
		}
		else{
			listener(this);
		}
	})
	$(".pick").children(".vhead").click(function(){
		console.log($(this).children())
		if($(this).siblings().length>0){
			$(this).siblings().remove();
		}
		else{
			listenerb(this);
		}
	})
	$(".pick").each(function(){
		$(this).parent().append(this);
	})
})

function listener(t){
		id = $(t)[0].dataset.coop;
		$.ajax({url:"award.php",
			data:{type:"var",id:id},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				$(t).siblings().remove();
				$(t).parent().append(result);
				$("select.variety").change(function(){
					ranks = [];
					$(this).parent().children("select.variety").each(function(){
						ranks[$(this)[0].dataset.place] = $(this).val()
					})
					ranks["type"] = "V";
					$.ajax({url:"award.php",
						data:{type:"V",ranks:ranks},
						method:"POST",
						dataType:"text",
						success:function(result){
							// console.log(result);
							listener(t);	
						},
						error: function(error){
							alert("error")
							console.log(error)
					}});
				})
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
}

function listenerb(t){
		id = $(t)[0].dataset.coop;
		$.ajax({url:"award.php",
			data:{type:"bre",id:id},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				$(t).siblings().remove();
				$(t).parent().append(result);
				$("select.breed").change(function(){
					ranks = [];
					$(this).parent().children("select.breed").each(function(){
						ranks[$(this)[0].dataset.place] = $(this).val()
					})
					ranks["type"] = "B";
					$.ajax({url:"award.php",
						data:{type:"B",ranks:ranks},
						method:"POST",
						dataType:"text",
						success:function(result){
							// console.log(result);
							listenerb(t);	
						},
						error: function(error){
							alert("error")
							console.log(error)
					}});
				})
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
}








