// JavaScript Document
$('#change_pass').change(function() { 
	if (this.checked) {
		$("#pass0").prop('disabled', false);
		$("#pass1").prop('disabled', false);
		$("#pass2").prop('disabled', false);
		$('#pass0').focus();
		$("#btn_change").prop('disabled', false);
	} else {
		$("#pass0").prop('disabled', true);
		$("#pass1").prop('disabled', true);
		$("#pass2").prop('disabled', true);
		$("#btn_change").prop('disabled', true);
	}
});

//------------------
// Submit the form
//------------------
$("#securityForm").submit(function(e)
	{
	var result = confirm("Confirm change password?");
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
					alert("Password has been changed!");
					//Reset Form
					$('#change_pass').prop('checked', false);
					$("#pass0").val(''); $("#pass0").prop('disabled', true);
					$("#pass1").val(''); $("#pass1").prop('disabled', true);
					$("#pass2").val(''); $("#pass2").prop('disabled', true);
					$("#btn_change").prop('disabled', true);
				}else if(data == 2){
					alert("Wrong Old Password!");
					$('#pass0').focus();
				}else{//data == 0
					alert("Error updating Password, Please ask Support!");
				}
			}
		});
		e.preventDefault(); //STOP default action
	}else{
		e.preventDefault(); //STOP default action
	}
});	
