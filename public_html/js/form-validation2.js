// ---------xfactor html5 template -----------//
// ---------created for pixelglimpse----------//
// -------author : gokul raghu aka AJ---------//
// -----------version 1.0---------------------//
// ------------created on 25-june-2014--------//

$(document).ready(function($) {

	// hide messages 
	$(".error").hide();
	$(".failure").hide();
	$(".success").hide();
	
	$('#contactForm input').click(function(e) {
        $(".error").fadeOut();
    });
	
	// on submit...
	$("#submit").click(function(event) {
		event.stopPropagation();   
        event.preventDefault();
		$(".error").hide();

		//required:
		
		//name
		var name = $("input#name").val();
		if(name == ""){
			//$("#error").fadeIn().text("Name required.");
			$('#fname').fadeIn('slow');
			$("input#name").focus();
			return false;
		}

		var name = $("input#phone").val();
		if(name == ""){
			//$("#error").fadeIn().text("Name required.");
			$('#ftel').fadeIn('slow');
			$("input#phone").focus();
			return false;
		}
		
		//email (check if entered anything)
		var email = $("input#email").val();
		//email (check if entered anything)
		if(email == ""){
			//$("#error").fadeIn().text("Email required");
			$('#fmail').fadeIn('slow');
			$("input#email").focus();
			return false;
		}

		var zsfCode = $("input#zsfCode").val();
		//email (check if entered anything)
		if(zsfCode == ""){
			//$("#error").fadeIn().text("Email required");
			$('#fzsfCode').fadeIn('slow');
			$("input#zsfCode").focus();
			return false;
		}
		
		//email (check if email entered is valid)

		if (email !== "") {  // If something was entered
			if (!isValidEmailAddress(email)) {
				$('#fmail2').fadeIn('slow'); //error message
				$("input#email").focus();   //focus on email field
				return false;  
			}
		} 

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};

		
		
		
		// comments
		var comments = $("#msg").val();
		
		if(comments == ""){
			//$("#error").fadeIn().text("Email required");
			$('#fmsg').fadeIn('slow');
			$("input#msg").focus();
			return false;
		}
 
  var frm = $('#contactForm');
        var stringData = frm.serialize();

      frm.ajaxSubmit({
		type: "post",
		url: "sendcontact.act.php",
		data: stringData,
		success: function(data) {
		if(data == 'success')
		{
           $(".success").fadeIn();
		   $(".failure").hide();        
	 	   $("#contactForm").fadeOut();
		
		}else if(data == 'error1'){
		  $("#num_error").fadeIn();
		  $(".success").hide();
		}else{
		  $(".failure").fadeIn();
		  $(".success").hide();
		  
		}

		}
		});






	});  
		
		
	// on success...
	 function success(){

	 	//alert('test');

	 }
	
    return false;
});

