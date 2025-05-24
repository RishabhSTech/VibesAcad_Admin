

<!-- Modal -->
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Inbound Call Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="addInboundCallForm" method="post">
        <div class="modal-body">
        
        
        	<div class="row">
				<div class="col-lg-12">
					<div class="mb-4">
						<label for="inbound_CustName" class="form-label">Customer Name</label>
						<input type="text" class="form-control" id="inbound_CustName" name="inbound_CustName" placeholder=""
							wfd-id="id0" autocomplete="off" required>
					</div>
				</div>
			</div>
				<div class="row">
				<div class="col-lg-12">
					<div class="mb-4">
						<label for="inbound_email" class="form-label">Email</label>
						<input type="email" class="form-control" id="inbound_email" name="inbound_email" placeholder=""
							wfd-id="id0" autocomplete="off" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="mb-4">
						<label for="inbound_mobile" class="form-label">Phone No</label>
						<input type="number" class="form-control" id="inbound_mobile" name="inbound_mobile" placeholder=""
							wfd-id="id0" autocomplete="off" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="mb-4">
						<label for="inbound_UserIPLocation" class="form-label">State Name</label>
						<input type="text" class="form-control" id="inbound_UserIPLocation" name="inbound_UserIPLocation" placeholder=""
							wfd-id="id0" autocomplete="off" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="mb-4">
						<label for="inbound_UserDevice" class="form-label">User Device</label>
						<input type="text" class="form-control" id="inbound_UserDevice" name="inbound_UserDevice" placeholder=""
							wfd-id="id0" autocomplete="off" required>
					</div>
				</div>
			</div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary MainColor" id="submit_inbound">Add Inbound Call</button>
      </div>
      </form>
    </div>
  </div>
</div>