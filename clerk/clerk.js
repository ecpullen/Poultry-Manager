$(function(){
	$("body").each(function(){
		t = this;
		$.ajax({url:"award.php",
			data:{type:"divisions"},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				console.log($(t));
				$(t).append(result);
				dodivision();
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
})

function dodivision(){
	$(".division p").unbind();
	$(".division p").click(function(){
		console.log($(this).siblings().length);
		if($(this).siblings().length){
			temp = $(this).parent().children("p")[0];
			$(this).siblings().remove();
			return;
		}
		div = $(this).parent().children("p")[0].dataset.division;
		t = this;
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
			error: function(x,y,error){
				alert("error")
                console.log(y)
				console.log(error)
                console.log(x)
		}});
	})
	$(".spick p").unbind();
	$(".spick p").click(function(){
		t = $(this)[0]
		console.log($(this).children())
		if($(t).siblings().length>0){
			$(t).siblings().remove();
		}
		else{
			listeners(this);
		}
	})
}

function doclass(){
	$(".class p").unbind();
	$(".class p").click(function(){
		console.log($(this).siblings().length);
		if($(this).siblings().length){
			temp = $(this).parent().children("p")[0];
			$(this).siblings().remove();
			return;
		}
		div = $(this).parent().children("p")[0].dataset.class;
		t = this;
		$.ajax({url:"award.php",
			data:{type:"breeds", classes:div},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				console.log(result);
				$(t).siblings().remove();
				$(t).parent().append(result);
				dobreed();
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$(".dpick p").unbind()
	$(".dpick p").click(function(){
		t = $(this)[0]
		console.log($(this).children())
		if($(t).siblings().length>0){
			$(t).siblings().remove();
		}
		else{
			listenerd(this);
		}
	})
}

function dobreed(){
	$(".breed p").unbind()
	$(".breed p").click(function(){
		console.log($(this).siblings().length);
		if($(this).siblings().length){
			temp = $(this).parent().children("p")[0];
			$(this).siblings().remove();
			return;
		}
		div = $(this).parent().children("p")[0].dataset.breed;
		t = this;
		$.ajax({url:"award.php",
			data:{type:"varieties", breeds:div, classes:$(t)[0].dataset.class},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				console.log(result);
				$(t).siblings().remove();
				$(t).parent().append(result);
				dovariety();
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$(".cpick p").unbind()
	$(".cpick p").click(function(){
		t = $(this)[0]
		console.log($(this).children())
		if($(t).siblings().length>0){
			$(t).siblings().remove();
		}
		else{
			listenerc(this);
		}
	})
}

function dovariety(){
	$(".variety p").unbind();
	$(".variety p").click(function(){
		console.log($(this).siblings().length);
		if($(this).siblings().length){
			temp = $(this).parent().children("p")[0];
			$(this).siblings().remove();
			return;
		}
		div = $(this).parent().children("p")[0].dataset.variety;
		t = this;
		$.ajax({url:"award.php",
			data:{type:"ages", varieties:div, breeds:$(t)[0].dataset.breed, classes:$(t)[0].dataset.class},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				console.log(result);
				$(t).siblings().remove();
				$(t).parent().append(result);
				doage()
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$(".bpick p").unbind()
	$(".bpick p").click(function(){
		t = $(this)[0]
		console.log($(this).children())
		if($(t).siblings().length>0){
			$(t).siblings().remove();
		}
		else{
			listenerb(this);
		}
	})
}
function doage(){
	$(".age p").unbind()
	$(".age p").click(function(){
		console.log($(this).siblings().length);
		if($(this).siblings().length){
			temp = $(this).parent().children("p")[0];
			$(this).siblings().remove();
			return;
		}
		div = $(this).parent().children("p")[0].dataset.age;
		t = this;
		$.ajax({url:"award.php",
			data:{type:"ranks", varieties:$(t)[0].dataset.variety, breeds:$(t)[0].dataset.breed, classes:$(t)[0].dataset.class, ages:div},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				console.log(result);
				$(t).siblings().remove();
				$(t).parent().append(result);
				doranks();
			},
			error: function(error){
				alert("error")
				console.log(error)
		}});
	})
	$(".vpick p").unbind()
	$(".vpick p").click(function(){
		t = $(this)[0]
		console.log($(this).children())
		if($(t).siblings().length>0){
			$(t).siblings().remove();
		}
		else{
			listenerv(this);
		}
	})
}

function doranks(){
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
}

function listenerv(t){
		d = $(t)[0].dataset;
		$.ajax({url:"award.php",
			data:{type:"var",breed:d.breed,classes:d.class,variety:d.variety},
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
							console.log(result);
							listenerv(t);	
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
		d = $(t)[0].dataset;
		$.ajax({url:"award.php",
			data:{type:"bre",breed:d.breed,classes:d.class},
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

function listenerc(t){
		console.log("listenc");
		d = $(t)[0].dataset;
		$.ajax({url:"award.php",
			data:{type:"cla",classes:d.class},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				$(t).siblings().remove();
				$(t).parent().append(result);
				$("select.class").change(function(){
					ranks = [];
					$(this).parent().children("select.class").each(function(){
						ranks[$(this)[0].dataset.place] = $(this).val()
					})
					console.log(ranks);
					ranks["type"] = "C";
					$.ajax({url:"award.php",
						data:{type:"C",ranks:ranks},
						method:"POST",
						dataType:"text",
						success:function(result){
							console.log(result);
							listenerc(t);	
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

function listenerd(t){
		console.log("listend");
		d = $(t)[0].dataset;
		console.log(d);
		$.ajax({url:"award.php",
			data:{type:"div",division:d.division},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				$(t).siblings().remove();
				$(t).parent().append(result);
				$("select.division").change(function(){
					ranks = [];
					div = $(this).parent().children("p")[0].dataset.division;
					$(this).parent().children("select.division").each(function(){
						ranks[$(this)[0].dataset.place] = $(this).val()
					})
					console.log(ranks);
					ranks["type"] = "D";
					$.ajax({url:"award.php",
						data:{type:"D",ranks:ranks, div:div},
						method:"POST",
						dataType:"text",
						success:function(result){
							console.log(result);
							listenerd(t);	
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

function listeners(t){
		console.log("listens");
		d = $(t)[0].dataset;
		console.log(d);
		$.ajax({url:"award.php",
			data:{type:"sho"},
			method:"POST",
			dataType:"HTML",
			success:function(result){
				$(t).siblings().remove();
				$(t).parent().append(result);
				$("select.show").change(function(){
					ranks = [];
					div = $(this).parent().children("p")[0].dataset.division;
					$(this).parent().children("select.show").each(function(){
						ranks[$(this)[0].dataset.place] = $(this).val()
					})
					console.log(ranks);
					ranks["type"] = "S";
					$.ajax({url:"award.php",
						data:{type:"S",ranks:ranks},
						method:"POST",
						dataType:"text",
						success:function(result){
							console.log(result);
							listeners(t);	
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











