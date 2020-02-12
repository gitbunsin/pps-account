// JavaScript Document
$("#form-invitation").submit(function(e){
	if(document.getElementById('to').value==""){
		alert("Please write email address of recipients!");
		document.getElementById('to').focus();
		return false;
	}else if(tinyMCE.get('content').getContent()==""){
		alert("Please write an zulutrade invitation email!");
		tinyMCE.get('content').focus();
		return false;
	}

	//Submit the form
	tinyMCE.triggerSave();

	//var postData = $(this).serializeArray();
	//var formURL = $(this).attr("action");
	var result = confirm("Are you ready to send?");
	if (result) {
		$.ajax(
		{
			url : $(this).attr('action'),
			type: "POST",
			data : $(this).serializeArray(),
			cache: false,
			beforeSend:function(){
				$.LoadingOverlay("show");
				//alert('waiting');
			},
			success:function(data) 
			{
				$.LoadingOverlay("hide");
				if(data > 0){
					//alert(data);
					alert("Your email has been sent!"); 
					tinyMCE.get('content').focus();
				}else{
					//alert(data);
					alert("Error sending email!\nPlease contact PPS I.T!");
				}
			}
		});
		e.preventDefault(); //STOP default action
	}else{
		e.preventDefault(); //STOP default action
	}
});