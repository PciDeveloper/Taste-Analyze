//design
$(function(){
	$(".design .list li a").hover(function(){
	   $(this).find('.txt').show();
	},function(){
		$(this).find('.txt').hide();
	});
});
//login
$(function(){
	$(".login input[type='text'],.login input[type='password']").click(function(){
			$(this).parent().prev().hide();
	}).blur(function(){
			var value = $(this).val();
			if(!value){
				$(this).parent().prev().show();
			}
			return false;
	});
});

//faq
$(function(){
	$(".faq .board .table a.tit").click(function(){
		var $parent = $(this).parent().parent().next(".answer");
		if($parent.is(":hidden")){
			$(".faq .board .table a.tit").removeClass("on");
			$(".answer").slideUp("fast");
			$(this).addClass("on")
			$parent.slideDown(1000);
			return false;
		}else{
			$(".faq .board .table a.tit").removeClass("on");
			$(".answer").slideUp("fast");
			return false;
		}
	});
});

$(function(){
	$(".mask").click(function(){
		popclose();
	});
});

function layer(index,gidx){
	$(".mask").fadeIn(500);
	$("."+index).show(); 
}

//기능추가 자동견적신청 상세팝업
function solution_popup(uid){
	$(".mask").fadeIn(500);
	 $(".plusoptionView").show(); 
	$.ajax({
		url: "/solution/load.solution.php",
		cache: false,
		type: "POST",
		data: "gidx=" + uid ,
		success: function(data){
			$("#solutionView").html(data);
		}
	});		
}

function estimate_popup(uid,cate){

	$(".mask").fadeIn(500);
	 $(".estimateView").show(); 
	$.ajax({
		url: "/solution/load.estimate.php",
		cache: false,
		type: "POST",
		data: "gidx=" + uid + "&cate=" + cate,
		success: function(data){
			$("#estimateView").html(data);
		}
	});		
} 


function popclose(){
	$(".mask, .popup").hide();
}




//콤마제거
function stripComma(number)
{
	var reg = /(,)*/g;
	number = String(number).replace(reg, "");
	return number;
}


/*	콤마를 추가한다	*/
function NumberFormat(numstr) {
	var numstr = String(numstr);
  	var re0 = /(\d+)(\d{3})($|\..*)/;
  	if (re0.test(numstr))
    		return numstr.replace(
      		re0,
      	function(str,p1,p2,p3) { return NumberFormat(p1) + "," + p2 + p3; }
    	);
  	else
    	return numstr;
}
 
  
