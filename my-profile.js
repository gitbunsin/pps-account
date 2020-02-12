// JavaScript Document
$("#verify-email").click(function() {
	var result = confirm("Start verifying your email now?");
	if (result) {
		$.ajax({
			url 	: './ajax/verify-email-request.php',
			type	: "POST",
			data 	: {'id':$(this).data("id"), 'email':$.trim($('#email').val())},
			cache	: false,
			beforeSend:function(){
				$.LoadingOverlay("show");
				//alert('waiting');
			},
			success:function(data){
				//alert(data);
				$.LoadingOverlay("hide");
				if(data > 0){
					alert("Verification Email has been sent!\n Please check your email.");
				}else{
					alert("Verification Email Error!\n Please contact PPS by phone.");
				}
			}
		});
		e.preventDefault();
	}else{
		e.preventDefault();
	}
});

$.fn.capitalise = function() {
	return this.each(function() {
		var $this = $(this),
			text = $this.val(),
			tokens = text.split(" ").filter(function(t) {return t != ""; }),
			res = [],
			i,
			len,
			component;
		for (i = 0, len = tokens.length; i < len; i++) {
			component = tokens[i];
			res.push(component.substring(0, 1).toUpperCase());
			res.push(component.substring(1));
			res.push(" "); // put space back in
		}
		$this.val(res.join(""));
	});
};

$( document ).ready(function() {
	$('#showModal').modal();
});

//Validation

function validateNumber(account) 
{
	var maintainplus = '';
	var numval = account.value
	if ( numval.charAt(0)=='+' )
	{
			var maintainplus = '';
	}
	curphonevar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
	account.value = maintainplus + curphonevar;
	var maintainplus = '';
	account.focus;
}

// validates text only
function Validate(txt) {
   txt.value = txt.value.replace(/[^a-zA-Z-'\s\n\r.]+/g, '');
}

//------------------
// Submit the form
//------------------
$("#profileForm").submit(function(e)
	{
	var result = confirm("Confirm updating profile?");
	if (result) {
		//Start Submit Form
		$.ajax({
			url 	: $(this).attr('action'),
			type	: "POST",
			data 	: $(this).serializeArray(),
			cache	: false,
			beforeSend:function(){
				$.LoadingOverlay("show");
				//alert('waiting');
			},
			success:function(data){
				//alert(data);
				$.LoadingOverlay("hide");
				if(data > 0){
					alert("Profile has been updated!");
				}else{
					//alert(data);
					//alert("Profile updated errors!");
				}
			}
		});
		e.preventDefault(); //STOP default action
	}else{
		e.preventDefault(); //STOP default action
	}
});	
