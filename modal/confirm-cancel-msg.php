<!-- Modal -->
<style>
	.modal-backdrop {
		background: transparent;
	}
</style>
<div class="modal fade" id="confirmCancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">PPS Forex Management</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to Cancel [Trx ID:<span id="trx"></span>]?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-msg-cancel-cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="btn-msg-confirm-cancel" data-id="" data-type="" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>