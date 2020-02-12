// JavaScript Document
$(function () {
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});
});

$("#login").submit(function(e)
{	
	$.ajax(
	{
		url : './process.php',
		type: "POST",
		data: $(this).serializeArray(),
		beforeSend:function(){
			$.LoadingOverlay("show");
		},
		success:function(data) 
		{ 
			if(data==0){
				//Fail Login
				//alert(data);
				$.LoadingOverlay("hide");
				$('#invalid_login_msgbox').modal();
				refreshCaptcha();
			}else if(data==1){
				//Success Login
				//alert(data);
        $(location).attr("href", "../");
			}else{//data==2
				//Invalid Classic Code
				//alert(data);
				$.LoadingOverlay("hide");
				$('#invalid_code_msgbox').modal();	
				refreshCaptcha();		
			}
		},
		error: function(data) {
			//alert(data);
			$.LoadingOverlay("hide");
			$('#error_msgbox').modal();
			refreshCaptcha();
		}
	});
	e.preventDefault(); //STOP default action
});