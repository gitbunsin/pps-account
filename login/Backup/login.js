// JavaScript Document
$("#login").submit(function(e)
{	
	$.ajax(
	{
		url : 'process.php',
		type: "POST",
		data: $(this).serializeArray(),
		beforeSend:function(){
			$.LoadingOverlay("show");
		},
		success:function(data) 
		{
			if(data==1){
				//Success Login
				var domain = location.protocol+ '//' + location.hostname;
				if(domain=='http://localhost'){
					$(location).attr("href", domain+'/pps-forex/admin/');
				}else{
					$(location).attr("href", domain);
				}
			}else if(data==0){
				$.LoadingOverlay("hide");
				$('#invalid_login_msgbox').modal();
				grecaptcha.reset();
			}else{
				$.LoadingOverlay("hide");
				$('#you_are_robot_msgbox').modal();
			}
		},
		error: function(data) {
			$.LoadingOverlay("hide");
			$('#error_msgbox').modal();
		}
	});
	
//	$.ajax(
//	{
//		url : $(this).attr("action"),
//		type: "POST",
//		data : $(this).serializeArray(),
//		beforeSend:function(){
//			$.LoadingOverlay("show");
//		},
//		success:function(data) 
//		{
//			//alert(data);
//			if(data==1){
//				var domain = location.protocol+ '//' + location.hostname;
//				if(domain=='http://localhost'){
//					$(location).attr("href", domain+'/pps-forex/admin/');
//				}else{
//					$(location).attr("href", domain);
//				}
//			}else if(data==0){
//				$.LoadingOverlay("hide");
//				$('#invalid_login_msgbox').modal();
//				refreshCaptcha();
//			}else{
//				$.LoadingOverlay("hide");
//				$('#invalid_code_msgbox').modal();
//				refreshCaptcha();
//			}
//		},
//		error: function() {
//			$.LoadingOverlay("hide");
//			$('#error_msgbox').modal();
//		}
//	});
	e.preventDefault(); //STOP default action
});