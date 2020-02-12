// JavaScript Document
$("#logout").on('click', function(event) {
	//Show Msgbox
	$('#confirmLogout').modal({
		backdrop: 'static',
  	keyboard: false
	});
});
//Confirm btn Click
$("#btn-msg-confirm").on('click', function(event) {
	$('#confirmLogout').modal('hide');
	window.location.href = "./?action=logout";
});

$(".cancel").on('click', function(event) {
	//Show Msgbox
	var id = $(this).attr('id');
	var trx = $(this).data('trx-id');
	var type = $(this).data('type');
	
	$('#confirmCancel').on('show.bs.modal', function (e) {
		$(".modal-footer #btn-msg-confirm-cancel").attr('data-id', id);
		$(".modal-footer #btn-msg-confirm-cancel").attr('data-type', type);
		$(".modal-body #trx").text( trx );
	});
	$('#confirmCancel').modal({
		backdrop: 'static',
  	keyboard: false
	});
});
//Confirm btn Click
$("#btn-msg-confirm-cancel").on('click', function(event) {
	$('#confirmCancel').modal('hide');
	window.location.href = "./payment-report.php?type="+$(this).data('type')+"&cancel="+$(this).data('id');
});
