<?php 
include ("inc/config.php");

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
 } else {
    
 header('Location: index.php');
 }
 
include 'inc/function.php';
$allactions = new Actions();

$transationlist = $allactions->getFailedTransationsList();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Failed Transaction</title>
	<?php include ("inc/styles.php"); ?>
	
	<style>
	.trans-row{
	    cursor: pointer;    
	}
	.justify-content-between33 {
    justify-content: space-between;
    align-items: center;
    align-content: center;
}
	.disabled{
    opacity: 0.2;
    cursor: no-drop;

	}
	.btngrouppp{
	    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 14px;
	}
	#PaymentLinkWhatsApp, #mark_success{
	    font-size: 14px;
	} 
	</style>
	
</head>

<body>
	<?php include ("inc/header.php"); ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-7">
				<h6 class="mt-5 mb-3 ">
				
				
				<div class="row align-items-baseline">
				        <div class="col-5">
				           Failed Transaction List
				        </div>
				        
				        <div class="col-2">
				         Total <b><?php echo count($transationlist);?></b>
				        </div>
				         <div class="col-5">
                            <div class="input-group mb-3">
                                 
                                <input type="text" name="result_filter" id="result_filter" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                                 <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            </div>
				        </div>
				        
				    </div>
				
				
				</h6>

				<div class="">
					<table class="table py-3 table-fixed table-hover" id="transactionTable">
						<thead>
							<tr>
								<th class="text-center col-1">ID</th>
								<th class="col-3">Name</th>
								<th class="col-3">Phone No.</th>
								<!--th class="text-center col-2">Call type</th-->
								<th class="text-center col-2">Last call remarks</th>
								<th class="text-center col-3">Lead time</th>
							</tr>
						</thead>
						<tbody id="transactionTableBody">
                             <?php 
                             $mobile_array = array();
                             $i = 0;
                             foreach($transationlist as $tran){
                             if($tran['call_attempt_count'] < 5){
                                 
                                $mobile_no = preg_replace('/\s+/', '', $tran['mobile']);
                                    
                                $text = $mobile_no;
                                if (strpos($mobile_no, '0') === 0) {
                                    
                                    $text = substr($mobile_no, 1);
                                } elseif (strpos($mobile_no, '91') === 0) {
                                    
                                    //$text = substr($mobile_no, 2);
                                }
                                
                                if(in_array($text,$mobile_array)){
                                    continue;
                                } 
                                
                                $i++;
                                
                                
                                if($tran['call_attempt_count'] < 1){
                                    $calltype = 'New Lead';    
                                }else{
                                    $calltype = 'Follow-up';
                                }
                                
                                $mobile_no = preg_replace('/[^0-9]/', '', $mobile_no);
                                $mobile_no = substr($mobile_no, -10);
                                
                             ?>
							<tr class='trans-row' data-name="<?php echo $tran['CustName'];?>" data-id="<?php echo $tran['id'];?>" data-email="<?php echo $tran['email'];?>" data-phone="<?php echo $mobile_no;?>" data-u_location="<?php echo $tran['UserIPLocation'];?>" data-u_ip="<?php echo $tran['userIP'];?>" data-u_device="<?php echo $tran['UserDevice'];?>" data-lastremark="<?php echo $tran['id'];?>"  data-calloutcome="<?php echo $tran['id'];?>" data-txnid="<?php echo $tran['txnID'];?>" data-info_sent="<?php echo $tran['info_sent'];?>">
								<td class="text-center col-1"><?php echo $i;?></td>
								<td class="col-3">
								<?php 
								$string = (strlen($tran['CustName']) > 13) ? substr($tran['CustName'],0,10).'...' : $tran['CustName'];
								echo $string;
								?></td>
								<td class="col-3"><?php echo $text;?></td>
								<td class="text-center col-2">
								    <?php //echo $calltype;
								    $call_outcome = $tran['call_outcome'];
                                    
                                        switch ($call_outcome) {
                                            case 1:
                                                echo 'Not Interested';
                                                break;
                                            case 2:
                                                echo 'Busy';
                                                break;
                                            case 6:
                                                echo 'Call back';
                                                break;
                                            case 3:
                                                echo 'Switch off';
                                                break;
                                            case 4:
                                                echo 'Enrolled';
                                                break;
                                            case 5:
                                                echo 'RNR';
                                                break;
                                            case 7:
                                                echo 'Invalid/Wrong Number';
                                                break;
                                            case 8:
                                                echo 'Follow up';
                                                break;
                                            case 9:
                                                echo 'Whatsup Follow up';
                                                break;
                                            default:
                                                echo $tran['call_outcome'] ?? "NA";
                                                break;
                                        }
								    
								    
								    ?>
								    </td>
								<td class="text-center col-3"><?php echo $tran['TXNdatetime'];?></td>
							</tr>
                            <?php 
                            
                                $mobile_array[] = $text;
                            
                            } } ?>
						</tbody>
					</table>
				</div>

			</div>
			<div class="col-5">
				<h6 class="mt-5 mb-3">
				    
				    <div class="row justify-content-between33">
                        <div class="col-md-4">
                            Call data
                        </div>
                         <div class="col-md-8">
                             <div class="btngrouppp">
                         <a href="javascript:;" class="" id="DirectWA" title="WhatsApp"><img style="width: 52px;" src="images/whatsapp.png" alt="WhatsApp" /></a>
                      
                      
                         <a href="javascript:;" class="" id="InfoCoures"><img style="width: 52px;" src="images/information.png" alt="WhatsApp Payment Link" /></a>
                   
                        
                       
                         <a href="javascript:;" class="" id="PaymentLinkWhatsApp" title="WhatsApp Payment Link"><img style="width: 52px;" src="images/rupee.png" alt="WhatsApp Payment Link" /></a>
                         
                        
                   
                         <a  href="javascript:;" class="" id="update_number"><img style="width: 52px;" src="images/sync.png" alt="WhatsApp Payment Link" /></a>
                  
                          </div>
                         </div>
                        
				    </div>
				                 <button class="btn btn-danger d-none" id="mark_success" >Mark as Success</button>
				</h6>

				<form action="#">
					<div class="row">
						<div class="col-lg-6">
							<div class="mb-4">
								<label for="custname" class="form-label">Customer Name</label>
								<input type="text" class="form-control" id="custname" placeholder=""
									wfd-id="id0" autocomplete="off" disabled>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-4">
								<label for="custemail" class="form-label">Email</label>
								<input type="text" class="form-control" id="custemail" placeholder=""
									wfd-id="id0" autocomplete="off" disabled>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<label for="custphone" class="form-label">Phone No from website</label>
							<div class="input-group mb-3">

								<input type="number" class="form-control" placeholder="" aria-label="Recipient's username"
									aria-describedby="button-addon2" id="custphone" disabled="">
								
								<button class="btn btn-secondary" type="button" id="action_call"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/>
</svg></i></button>
								
							</div>
						</div>
						<div class="col-lg-6">
							<label for="custphone_custom" class="form-label">User entered phone number</label>
							<div class="input-group mb-3">

								<input type="number" id="custphone_custom" class="form-control" placeholder="" aria-label="Recipient's username"
									aria-describedby="button-addon2">
								<button class="btn btn-secondary" type="button" id="custom_action_call">
								    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/>
</svg>
								</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="mb-4">
								<label for="u_location" class="form-label">User Location</label>
								<input type="text" class="form-control" id="u_location" placeholder=""
									wfd-id="id0" autocomplete="off" disabled>
							</div>
						</div>
						<div class="col-lg-6">
												<div class="col">
							<div class="mb-4">
								<label for="u_device" class="form-label">User Device</label>
								<input type="text" class="form-control" id="u_device" placeholder=""
									wfd-id="id0" autocomplete="off" disabled>
							</div>
						</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="mb-4">
								<label for="last_remark" class="form-label">Last Call remarks</label>
								<input type="text" name="last_remark" id="last_remark" class="form-control" id="exampleFormControlInput1" placeholder=""
									wfd-id="id0" autocomplete="off" disabled>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="mb-4">
								<label for="call_outcome" class="form-label">Call outcome</label>
								<select name="call_outcome" id="call_outcome" class="form-select" aria-label="Default select example" required>
								    <option value="">--- select ---</option>
									<option value="1">Not Interested</option>
									<option value="2">Busy</option>
									<option value="6">Call back</option>
									<option value="3">Switch off</option>
									<option value="4">Enrolled</option>
									<option value="5">RNR</option>
									<option value="7">Invalid/Wrong Number</option>
									<option value="8">Follow up</option>
									<!--option value="9">Whatsup Follow up</option-->
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-4">
								<label for="call_back_at" class="form-label">Call Back date & Time</label>
								<input name="call_back_at" id="call_back_at" type="datetime-local" class="form-control" placeholder=""
									wfd-id="id0" autocomplete="off" min="<?php echo date('Y-m-d\TH:i'); ?>">
							</div>
						</div> 
					</div> 
					
					<div class="row">
					
						<div class="col-lg-6">
							<div class="mb-4">
								<label for="final_status" class="form-label">Call Final Status</label>
								<select name="final_status" id="final_status" class="form-select" aria-label="Default select example" required>
								    <option value="">--- select ---</option>
									<option value="1">Open</option>
									<option value="2">Closed</option>
									<option value="3">Enrolled</option>
								</select>
							</div>
						</div>
							<div class="col-lg-6">
							<div class="mb-4">
								<label for="call_remark" class="form-label">Call remarks</label>
								<input type="text" id="call_remark" name="call_remark" class="form-control" id="exampleFormControlInput1" placeholder=""
									wfd-id="id0" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="mb-4">
							<input name="trans_id" id="trans_id" value="" type="hidden" class="form-control">
							<input name="txnid" id="txnid" value="" type="hidden" class="form-control">
							<input name="info_sent" id="info_sent" value="" type="hidden" class="form-control">
							
							<button class="btn btn-sub MainColor w-100 text-white" type="button" id="submit_update">Update Details</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>



		<?php include ("inc/footer.php"); ?>
</body>


<div class="modal fade" id="updateNumberModal" tabindex="-1" aria-labelledby="updateNumberModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateNumberModalLabel">Update Mobile Number</h5>
      </div>
      <form>
          <div class="modal-body">
            
            <div class="row">
				<div class="col-md-12">
					<div class="mb-4">
						<label for="custname" class="form-label">Mobile number</label>
						<input type="text" class="form-control" id="custmobileNumber" autocomplete="off" required="">
					</div>
				</div>
			</div>
			
			<div class="row succ_msg d-none">
				<span>updated successfully!</span>
			</div>
               
          </div>
          <div class="modal-footer">
            <input type="hidden" class="form-control" id="selectentryid" autocomplete="off" required="">
            <button type="button" class="btn btn-secondary" id="" data-bs-dismiss="modal">close</button>
            <button type="button" class="btn btn-primary" id="updateModal">Update</button>
          </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="markSuccessModal" tabindex="-1" aria-labelledby="markSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="markSuccessModalLabel">Success</h5>
      </div>
      <div class="modal-body">
        The payment has been successfully marked as complete!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="closeModal" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Success</h5>
      </div>
      <div class="modal-body">
        Update successful!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="closeModal" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="callingModal" tabindex="-1" aria-labelledby="callingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Calling</h5>
      </div>
      <div class="modal-body">
        Calling in Progress
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="closeModal1" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>


<script>

    document.addEventListener('DOMContentLoaded', function () {
        var callOutcomeSelect = document.getElementById('call_outcome');
        var callBackInput = document.getElementById('call_back_at');

        function handleCallOutcomeChange() {
            if (callOutcomeSelect.value === '6') {
                callBackInput.disabled = false;
            } else {
                callBackInput.disabled = true;
            }
        }

        callOutcomeSelect.addEventListener('change', handleCallOutcomeChange);

        handleCallOutcomeChange();
    });
    
    jQuery(document).ready(function($) {
        
        $('#result_filter').on('keyup', function(){
            
            var searchText = $(this).val().toLowerCase();
            $('tbody tr').hide();
            
            $('.trans-row').each(function(){
                var product = $(this).text().toLowerCase();
                if(product.indexOf(searchText) !== -1 || searchText === ''){
                    $(this).closest('tr').show();
                }
            });
        });
        
        $('#submit_update').click(function() {
            
            var trans_id = $('#trans_id').val();
            if(trans_id == ''){
                alert('Please select entry');
                return;
            }
            
            
            var call_outcome = $('#call_outcome').val();
            var call_back_at = $('#call_back_at').val();
            var call_remark = $('#call_remark').val();
            var final_status = $('#final_status').val();
            
            if(call_outcome == ''){
                alert('Please select Call outcome.');
                return;
            }
            
            if(final_status == ''){
                alert('Please select Call Final Status.');
                return;
            }
            
            $("#submit_update").text('Updating...');
            $(this).prop('disabled', true);
             
            $.ajax({
                url: 'insert_call_attempt.php',
                type: 'POST',
                data: {
                    trans_id: trans_id,
                    call_outcome: call_outcome,
                    call_back_at: call_back_at,
                    call_remark: call_remark,
                    final_status: final_status,
                    trans_type: 'failed'
                    
                },
                success: function(response) {
                    $("#submit_update").text('Update Details');
                    if (response.trim() == 'true' || response.trim() == '1') {
                        $('#successModal').modal('show');
                    } else {
                        console.error('Error occurred during insertion');
                    }
                    window.location.reload();
                    
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    
                },
                complete: function() {
                   // $('#submit_update').prop('disabled', false);
                }
            });
        });

        $('#closeModal').click(function() {
            window.location.reload();
        });

        $(document).on("click", ".trans-row", function() {
            
            var custname = $(this).data("name");
            var id = $(this).data("id");
            var email = $(this).data("email");
            var phone = $(this).data("phone");
            var u_location = $(this).data("u_location");
            var u_ip = $(this).data("u_ip");
            var u_device = $(this).data("u_device");
            var txnid = $(this).data("txnid");
            var info_sent = $(this).data("info_sent");

            if(info_sent == '1'){
                    
                //$("#InfoCoures").text('Course Info Sent!');
                //$("#InfoCoures").removeClass('btn-primary');
                //$("#InfoCoures").addClass('btn-secondary');
                
                $("#InfoCoures").addClass('disabled');
                
            }else{
                //$("#InfoCoures").text('Course Info');
                //$("#InfoCoures").addClass('btn-primary');
                //$("#InfoCoures").removeClass('btn-secondary');
                
                $("#InfoCoures").removeClass('disabled');
            }
            
            $('#custname').val(custname);
            $('#trans_id').val(id);
            $('#custemail').val(email);
            $('#custphone').val(phone);
            $('#u_location').val(u_location);
            $('#u_ip').val(u_ip);
            $('#u_device').val(u_device);
            $('#txnid').val(txnid);
            $('#info_sent').val(info_sent);
            
            
            $.ajax({
                url: 'fetch_call_remark.php',
                type: 'GET',
                data: { 
                    trans_id: id,
                    trans_type: 'failed'
                },
                success: function(response) {
                    
                    var res = JSON. parse(response);
                    $('#last_remark').val(res.call_outcome);
                    $('#call_remark').val(res.call_remark);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    
    
        $('#custom_action_call').click(function() {
            
            var custphone_custom = $('#custphone_custom').val();
            if(custphone_custom == ''){
                alert('Please enter phone number');
                return;
            }
            $("#custom_action_call").html('<i class="spinner-border text-light"></i>');
            
            $(this).prop('disabled', true);
            
            $.ajax({
                url: 'make_call.php',
                type: 'POST',
                data: { custphone_custom: custphone_custom },
                success: function(response) {
                    $("#custom_action_call").html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/></svg>');
                    $('#callingModal').modal('show');
                    
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $("#custom_action_call").html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/></svg>');
                    
                },
                complete: function() {
                    $("#custom_action_call").html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/></svg>');
                    $('#custom_action_call').prop('disabled', false);
                }
            });
        });
        
        $('#action_call').click(function() {
            
            
            var custphone = $('#custphone').val();
            if(custphone == ''){
                alert('Please enter phone number');
                return;
            }
            $(this).prop('disabled', true);
            
            $("#action_call").html('<i class="spinner-border text-light"></i>');
            
            $.ajax({
                url: 'make_call.php',
                type: 'POST',
                data: { custphone: custphone },
                success: function(response) {
                    console.log(response);
                    $("#action_call").html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/></svg>');
                    $('#callingModal').modal('show');
                    
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $("#action_call").html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/></svg>');
                },
                complete: function() {
                    
                    $("#action_call").html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/></svg>');
                    $('#action_call').prop('disabled', false);
                }
            });
        });
        
        
        $('#update_number').click(function() {
            
            var trans_id = $('#trans_id').val();
            if(trans_id == ''){
                alert('Please select entry');
                return;
            }
            
            var custphone = $('#custphone').val();
            $('#selectentryid').val(trans_id);
            $('#custmobileNumber').val(custphone);
            $('#updateNumberModal').modal('show');
            
        });
        
        $('#updateModal').click(function() {
            
            var trans_id = $('#selectentryid').val();
            if(trans_id == ''){
                alert('Please select entry');
                return;
            }
            
            var custmobileNumber = $('#custmobileNumber').val();
            
            $("#updateModal").text('Updating...');
            $(this).prop('disabled', true);
             
            $.ajax({
                url: 'update_mobile_number.php',
                type: 'POST',
                data: {
                    trans_id: trans_id,
                    custmobileNumber: custmobileNumber
                },
                success: function(response) {
                    $(".succ_msg").removeClass('d-none');
                    $("#updateModal").text('Update');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    
                },
                complete: function() {
                    $('#updateModal').prop('disabled', false);
                }
            });
        });
        
        
        $('#mark_success').click(function() {
            
            var trans_id = $('#trans_id').val();
            if(trans_id == ''){
                alert('Please select entry');
                return;
            }
            
            $("#mark_success").text('Updating...');
            $(this).prop('disabled', true);
             
            $.ajax({
                url: 'convert_to_success_payment.php',
                type: 'POST',
                data: {
                    trans_id: trans_id,
                    
                },
                success: function(response) {
                    $('#markSuccessModal').modal('show');
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    
                },
                complete: function() {
                    $('#mark_success').prop('disabled', false);
                }
            });
        });
    
        setInterval(function() {
            loadTransactionData();
        }, 60000);
    
        function loadTransactionData() {
            $.ajax({
                url: 'fetch_transaction_data.php',
                type: 'GET',
                data: { transation_type: 'failed' },
                success: function(response) {
                    $('#transactionTableBody').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    });


</script>
<script>


    document.getElementById("DirectWA").addEventListener("click", function() {
        
        var trans_id = $('#trans_id').val();
        if(trans_id == ''){
            alert('Please select entry');
            return;
        }
        var custphone = $('#custphone').val();
        var custname = $('#custname').val();
         
        var phoneNumber = '+91'+custphone;//"9772846161";//
        var message = encodeURIComponent("Hello *"+ custname +"*");
        
        window.open("https://api.whatsapp.com/send?phone=" + phoneNumber + "&text=" + message, '_blank');
    });
    

    document.getElementById("PaymentLinkWhatsApp").addEventListener("click", function() {
        
        var trans_id = $('#trans_id').val();
        if(trans_id == ''){
            alert('Please select entry');
            return;
        }
        var txnid = $('#txnid').val();
        var custphone = $('#custphone').val();
        var custname = $('#custname').val();
        
        
        console.log(txnid);
        
        var phoneNumber = '+91'+custphone;//"9772846161";
        var message = encodeURIComponent("Hello *"+ custname +"*\n\nThanks for speaking to us. You are one-step away from becoming a popular social media influencer.\n\nहमसे संपर्क करने के लिए धन्यवाद!\nसोशल मीडिया इन्फ्लुएंसर बनने के सपने को पूरा करने से आप बस एक कदम दूर हैं|\n\n*Payment link / पेमेंट लिंक:\n https://thevibes.academy/payment.php?txnID=" + txnid + "&tid=" + trans_id + "*\n\n");
        
        
        
        window.open("https://api.whatsapp.com/send?phone=" + phoneNumber + "&text=" + message, '_blank');
    });
</script>
  <script>
    document.getElementById('InfoCoures').addEventListener('click', function() {
        
        var trans_id = $('#trans_id').val();
        if(trans_id == ''){
            alert('Please select entry');
            return;
        }
        var info_sent = $('#info_sent').val();
        if(info_sent == '1'){
                
            return;
        }
        
        $.ajax({
                url: 'info_coures_sent.php',
                type: 'POST',
                data: {
                    trans_id: trans_id,
                    
                },
                success: function(response) {
                    
                    if (response.trim() == 'true' || response.trim() == '1') {
                        
                        //$("#InfoCoures").prop('disabled', true);
                        
                        
                        var custphone = $('#custphone').val();
                        var custname = $('#custname').val();
                        
                        var phoneNumber = '+91'+custphone; // Replace with the customer's phone number
                        var videoUrl = 'https://youtu.be/NV3MXTaRcMM';
                        
                        var textMessage = encodeURIComponent("Hi *"+ custname +"*,\n\nGreetings from The Vibes Academy\n\nWe're so happy that you showed interest in our Influencers' MBA course. In this course you will learn about content creation, how to shoot, edit & follow trends, storytelling, analytics, monetization and much more!\n\nDo not miss the opportunity to be a part of an exclusive influencers’ community. You can enroll now by clicking the link below -\nwww.thevibes.academy/become-an-insta-influencer-within-a-week\n\nOur team will also be reaching out to you shortly to guide you through this exciting process!\n\nBest Wishes,\nThe Vibes Academy");
                        
                        var whatsappUrl = 'https://wa.me/' + phoneNumber + '?text=' + textMessage;
                        
                        window.open(whatsappUrl, '_blank');
                        window.location.reload();
                        
                    } else {
                        console.error('Error occurred during insertion');
                    }
                    
                    
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    
                },
                complete: function() {
                   
                }
            });
        
    });
  </script>

</html>