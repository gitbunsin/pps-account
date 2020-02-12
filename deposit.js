// JavaScript Document
$(function() {
  //Auto Default Selection
  var $radios = $('input:radio[name=payment]');
  if($radios.is(':checked') === false) {
    $radios.filter('[value=bank]').prop('checked', true);
    $("#bank-section").show();
    $("#card-section").hide();
  }
});
$('input[type=radio][name=payment]').change(function() {
    if (this.value == 'bank') {
      //alert("Bank");
      $("#bank-section").show();
      $("#card-section").hide();
    }
    else if (this.value == 'card') {
      //alert("Card");
      $("#bank-section").hide();
      $("#card-section").show();
    }
});

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
$("#cardForm").submit(function(e)
	{
	var result = confirm("Confirmed to submit deposit?");
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
					//alert(data);
					alert("Deposit has been submitted!");
					$("#amount").val("1000");//Set Default
					$('#confirm_term').prop('checked', false);//Unchecked
					window.location.href = './payment-report.php?type=deposit';
				}else{
					alert(data);
					alert("Deposit Request error!");
					$('#confirm_term').prop('checked', false);//Unchecked
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
//------------------
// Submit the form
//------------------
$("#depositForm").submit(function(e)
	{
	var result = confirm("Want to submit deposit?");
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
					//alert(data);
					alert("Deposit has been submitted!");
					$("#amount").val("1000");//Set Default
					$('#confirm_term').prop('checked', false);//Unchecked
					window.location.href = './payment-report.php?type=deposit';
				}else{
					alert(data);
					alert("Deposit Request error!");
					$('#confirm_term').prop('checked', false);//Unchecked
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
