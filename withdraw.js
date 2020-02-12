// JavaScript Document
function validateNumber(amount) 
{
	var maintainplus = '';
	var numval = amount.value
	if ( numval.charAt(0)=='+' )
	{
			var maintainplus = '';
	}
	curphonevar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,Š\/<>?|`¬\]\[]/g,'');
	amount.value = maintainplus + curphonevar;
	var maintainplus = '';
	amount.focus;
}
//------------------
// Submit the form
//------------------
$("#withdrawForm").submit(function(e)
	{
	var result = confirm("Confirm request the withdrawal?");
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
				if(data == 1){
					alert("Withdrawal has been requested!");
					$("#amount").val("0");
					$("#password").val("");
					$('#confirm_term').prop('checked', false);
					window.location.href = './payment-report.php?type=withdraw';
				}else if(data == 2){
					alert("Invalid Account Password!");
					$("#password").focus();
					$('#confirm_term').prop('checked', false);
				}else{
					alert("Withdrawal requested error!");
				}
			},
			error: function(err) {
				$.LoadingOverlay("hide");
				alert('Error:'+err);
				//$("#info").html(data);
			}
		});
		e.preventDefault(); //STOP default action
	}else{
		e.preventDefault(); //STOP default action
	}
});	
