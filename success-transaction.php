<?php 
include ("inc/config.php");

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
 } else {
    
 header('Location: index.php');
 }
 

include 'inc/function.php';
$allactions = new Actions();

$transationlist = $allactions->getSuccessTransationsList();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Success Transaction</title>
	<?php include ("inc/styles.php"); ?>
	
		<style>
	.trans-row{
	    cursor: pointer;    
	}
	.justify-content-between33 {
    justify-content: space-between;
    align-items: center;
    align-content: center;
    margin-top:20px;
    margin-bottom: 20px;
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
				          Success Transaction List
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
						    	<th class="col-2">Call type</th>
								<th class="text-center col-3">Date</th>
							</tr>
						</thead>
						<tbody >
                            
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
                                    
                                    $text = substr($mobile_no, 2);
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
                                
                                $date = date('d-m-y', strtotime($tran['TXNdatetime']));
                                $remarks = substr($tran['remarks'], -5);
                             ?>
							<tr class='trans-row' data-name="<?php echo $tran['CustName'];?>" data-id="<?php echo $tran['id'];?>" data-email="<?php echo $tran['email'];?>" data-phone="<?php echo $mobile_no;?>" data-u_location="<?php echo $tran['UserIPLocation'];?>" data-u_ip="<?php echo $tran['userIP'];?>" data-u_device="<?php echo $tran['UserDevice'];?>" data-lastremark="<?php echo $tran['id'];?>" data-calloutcome="<?php echo $tran['id'];?>" data-txnid="<?php echo $tran['txnID'];?>" data-amount="<?php echo $tran['Amount'];?>" data-datetime="<?php echo $date;?>" data-remarks="<?php echo $remarks;?>" data-info_sent="<?php echo $tran['congratulations_sent'];?>">
							    
								<td class="text-center col-1"><?php echo $i;?></td>
								<td class="col-3">
								<?php
								$string = (strlen($tran['CustName']) > 11) ? substr($tran['CustName'],0,10).'...' : $tran['CustName'];
								echo $string;
								?></td>
								<td class="col-3"><?php echo $text;?></td>
								<td class="text-center col-2"><?php echo $calltype;?></td>
								<td class="text-center col-3"><?php echo $tran['TXNdatetime'];?></td>
								
								<td class="whatsappres" style="display:none"><?php echo $tran['whatsapp_response'];?></td>
							</tr>
                            <?php 
                            
                                $mobile_array[] = $text;
                                
                            } } ?>
						</tbody>
					</table>
				</div>

			</div>
			<div class="col-5 position-relative">
	
				    
				     <div class="row justify-content-between33">
                        <div class="col-md-4">
                            Call data
                        </div>
                         <div class="col-md-8">
                             <div class="btngrouppp">
                         <a href="javascript:;" class="" id="DirectWA" title="WhatsApp"><img style="width: 52px;" src="images/whatsapp.png" alt="WhatsApp Payment Link" /></a>
                      
                         <a href="javascript:;" class="" id="CongratulationsCoures" title="WhatsApp"><img style="width: 52px;" src="images/congratulation.png" alt="WhatsApp Payment Link" /></a>
                   
                         <a  href="javascript:;" class="" id="update_number"><img style="width: 52px;" src="images/sync.png" alt="WhatsApp Payment Link" /></a>
                  
                          </div>
                         </div>
                        
				    </div>
			 
			  <!---  loader start   --->   
			    
            <div class="d-flex justify-content-center position-absolute loader" style="display:none;">
              <div class="spinner-border" role="status" style="display:none;"> 
                <span class="sr-only"></span>
              </div>
            </div>
            <div style="display:none;" class="spy"></div>
            
            <!---  loader end   --->
			    
			    
				<h6 class="mb-3">Student Details</h6>

			
					<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Call Details</button>
  </li>
   <li class="nav-item" role="presentation">
    <button class="nav-link" id="sstudent-tab-1" data-bs-toggle="tab" data-bs-target="#astudent-tab-1" type="button" role="tab" aria-controls="astudent-tab-1" aria-selected="false">Student Info</button>
  </li>
   <li class="nav-item" role="presentation">
    <button class="nav-link" id="sstudent-tab-2" data-bs-toggle="tab" data-bs-target="#astudent-tab-2" type="button" role="tab" aria-controls="astudent-tab-2" aria-selected="false">Social Link</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="sstudent-tab-3" data-bs-toggle="tab" data-bs-target="#astudent-tab-3" type="button" role="tab" aria-controls="astudent-tab-3" aria-selected="false">Transaction</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="sstudent-tab-4" data-bs-toggle="tab" data-bs-target="#astudent-tab-4" type="button" role="tab" aria-controls="astudent-tab-4" aria-selected="false">Question</button>
  </li>
  <!--li class="nav-item" role="presentation">
    <button class="nav-link" id="sstudent-tab-5" data-bs-toggle="tab" data-bs-target="#astudent-tab-5" type="button" role="tab" aria-controls="astudent-tab-5" aria-selected="false" >Lesson</button>
  </li-->
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="sstudent-tab-6" data-bs-toggle="tab" data-bs-target="#astudent-tab-6" type="button" role="tab" aria-controls="astudent-tab-6" aria-selected="false">WhatsApp Response</button>
  </li>
  
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
      
      	<form action="#">
					<div class="row  mt-4">
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

								<input type="text" class="form-control" placeholder="" aria-label="Recipient's username"
									aria-describedby="button-addon2" id="custphone" disabled="">
								
								<button class="btn btn-secondary" type="button" id="action_call"> <i class="bi bi-telephone-forward-fill"></i></button>
								
							</div>
						</div>
						<div class="col-lg-6">
							<label for="custphone_custom" class="form-label">User entered phone number</label>
							<div class="input-group mb-3">

								<input type="text" id="custphone_custom" class="form-control" placeholder="" aria-label="Recipient's username"
									aria-describedby="button-addon2">
								<button class="btn btn-secondary" type="button" id="custom_action_call">
								    <i class="bi bi-telephone-forward-fill"></i>
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
									wfd-id="id0" autocomplete="off" >
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
							<input name="trans_id" id="trans_id" type="hidden" class="form-control">
							<input name="info_sent" id="info_sent" value="" type="hidden" class="form-control">
							<button class="btn btn-sub MainColor w-100 text-white" type="button" id="submit_update">Update Details</button>
							</div>
						</div>
					</div>
      
                  
              </div>
              <div class="tab-pane fade" id="astudent-tab-1" role="tabpanel" aria-labelledby="sstudent-tab-1" tabindex="0">
                  
                  
                  <form>
                    <div class="row  mt-4">
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="StudentName" class="form-label">Student Name</label>
    								<input type="text" class="form-control" id="StudentName" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="user_id" class="form-label">Student User ID</label>
    								<input type="text" class="form-control" id="user_id" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
					</div>
					<div class="row">
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="WhatsAppNumber" class="form-label">WhatsApp Number</label>
    								<input type="text" class="form-control" id="WhatsAppNumber" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="PhoneNumber" class="form-label">Phone Number</label>
    								<input type="text" class="form-control" id="PhoneNumber" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
					</div>
										<div class="row">
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="Age" class="form-label">Age</label>
    								<input type="text" class="form-control" id="Age" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="Gender" class="form-label">Gender</label>
    								<input type="text" class="form-control" id="Gender" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
					</div>
										<div class="row">
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="CityDistrict" class="form-label">City/District</label>
    								<input type="text" class="form-control" id="CityDistrict" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="Pincode" class="form-label">Pincode</label>
    								<input type="text" class="form-control" id="Pincode" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
					</div>
										<div class="row">
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="State" class="form-label">State</label>
    								<input type="text" class="form-control" id="State" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<div class="mb-4">
    								<label for="StudentEmail" class="form-label">Student Email</label>
    								<input type="text" class="form-control" id="StudentEmail" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
					</div>
                  </form>
                  
                  
              </div>
              <div class="tab-pane fade" id="astudent-tab-2" role="tabpanel" aria-labelledby="sstudent-tab-2" tabindex="0">
                    
                     <form>
                    <div class="row   mt-4">
    						<div class="col-lg-9">
    							<div class="mb-4">
    								<label for="FacebookProfileLink" class="form-label">Facebook Profile Link</label>
    								<input type="text" class="form-control" id="FacebookProfileLink" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    							

    							
    							
    						</div>
    						    							
    							<div class="col-lg-3">
    							       <button type="button" class="btn btn-primary mt-4">Fetch New Data</button>
    							</div>
    							
    						<div class="col-lg-12">
    							<div class="mb-4">
    							        <table class="table table-bordered py-3 table-hover">
    							            <thead>
        							           <tr>
                                                    <th>Date</th>
                                                    <th>Total Follower </th>
                                                    <th>Engagement Rate</th>
                                                    <th>Total post</th>
        							            </tr>
    							            </thead>
    							             <thead>
        							          <tr>
                                                    <td>25 Mar 2024</td>
                                                    <td>555</td>
                                                    <td>50.55%</td>
                                                    <td>22</td>
        							            </tr>
    							            </thead>
    							        </table>
    							</div>
    						</div>
					</div>
					<hr/>
					  <div class="row   mt-4">
    						<div class="col-lg-9 ">
    							<div class="mb-4">
    								<label for="InstagramProfileLink" class="form-label">Instagram Profile Link</label>
    								<input type="text" class="form-control" id="InstagramProfileLink" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						    							<div class="col-lg-3">
    							       <button type="button" class="btn  btn-primary mt-4">Fetch New Data</button>
    							</div>
    						<div class="col-lg-12">
    							<div class="mb-4">
    							        <table class="table table-bordered py-3 table-hover">
    							            <thead>
        							           <tr>
                                                    <th>Date</th>
                                                    <th>Total Follower </th>
                                                    <th>Engagement Rate</th>
                                                    <th>Total post</th>
        							            </tr>
    							            </thead>
    							             <thead>
        							          <tr>
                                                    <td>25 Mar 2024</td>
                                                    <td>555</td>
                                                    <td>50.55%</td>
                                                    <td>22</td>
        							            </tr>
    							            </thead>
    							        </table>
    							</div>
    						</div>
					</div>
						<hr/>
					  <div class="row   mt-4">
    						<div class="col-lg-9 ">
    							<div class="mb-4">
    								<label for="YouTubeProfileLink" class="form-label">YouTube Profile Link</label>
    								<input type="text" class="form-control" id="YouTubeProfileLink" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						    							<div class="col-lg-3">
    							       <button type="button" class="btn  btn-primary mt-4">Fetch New Data</button>
    							</div>
    						<div class="col-lg-12">
    							<div class="mb-4">
    							        <table class="table table-bordered py-3 table-hover">
    							            <thead>
        							           <tr>
                                                    <th>Date</th>
                                                    <th>Total Follower </th>
                                                    <th>Engagement Rate</th>
                                                    <th>Total post</th>
        							            </tr>
    							            </thead>
    							             <thead>
        							          <tr>
                                                    <td>25 Mar 2024</td>
                                                    <td>555</td>
                                                    <td>50.55%</td>
                                                    <td>22</td>
        							            </tr>
    							            </thead>
    							        </table>
    							</div>
    						</div>
					</div>
						<hr/>
					  <div class="row   mt-4">
    						<div class="col-lg-9 ">
    							<div class="mb-4">
    								<label for="TwitterProfileLink" class="form-label">Twitter Profile Link</label>
    								<input type="text" class="form-control" id="TwitterProfileLink" placeholder=""
    									wfd-id="id0" autocomplete="off" disabled>
    							</div>
    						</div>
    						    							<div class="col-lg-3">
    							       <button type="button" class="btn  btn-primary mt-4">Fetch New Data</button>
    							</div>
    						<div class="col-lg-12">
    							<div class="mb-4">
    							        <table class="table table-bordered py-3 table-hover">
    							            <thead>
        							           <tr>
                                                    <th>Date</th>
                                                    <th>Total Follower </th>
                                                    <th>Engagement Rate</th>
                                                    <th>Total post</th>
        							            </tr>
    							            </thead>
    							             <thead>
        							          <tr>
                                                    <td>25 Mar 2024</td>
                                                    <td>555</td>
                                                    <td>50.55%</td>
                                                    <td>22</td>
        							            </tr>
    							            </thead>
    							        </table>
    							</div>
    						
    						</div>
					</div>
					</form>
                  
              </div>
              <div class="tab-pane fade" id="astudent-tab-3" role="tabpanel" aria-labelledby="sstudent-tab-3" tabindex="0">
                  
                  
                     <div class="row   mt-4">
    				
    						<div class="col-lg-12">
    							<div class="mb-4">
    							        <table class="table table-bordered py-3 table-hover">
    							            <thead>
        							           <tr>
        							                <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Transtion Id </th>
                                                    <th>Amt</th>
                                                    <th>PG ID</th>
                                                    <th>Status</th>
        							            </tr>
    							            </thead>
    							             <thead>
        							          <tr>
        							                <td id="trx_id_sr">-</td>
                                                    <td id="trx_date">-</td>
                                                    <td id="trx_id">-</td>
                                                    <td id="trx_amt">-</td>
                                                    <td id="trx_pgid">-</td>
                                                    <td><button type="button" class="btn btn-success">Success</button></td>
        							            </tr>

        							     
    							            </thead>
    							        </table>
    							</div>
    						
    						</div>
					</div>
                  
              </div>
              <div class="tab-pane fade" id="astudent-tab-4" role="tabpanel" aria-labelledby="sstudent-tab-4" tabindex="0">
                  
                  <form>
                      
                       <div class="row   mt-4">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques1" class="form-label">What inspired you to become an influencer in your particular niche?</label>
    								<input type="text" class="form-control" id="Ques1" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>	
    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques2" class="form-label">Could you share a bit about your journey and how you've grown your audience over time?</label>
    								<input type="text" class="form-control" id="Ques2" placeholder=""
    									wfd-id="id0" autocomplete="off">
    							</div>
    						</div>
    					</div>	
                         <div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques3" class="form-label">What sets your content apart from others in your niche?</label>
    								<input type="text" class="form-control" id="Ques3" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>	
    					    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques4" class="form-label">How do you engage with your audience and foster a sense of community around your content?</label>
    								<input type="text" class="form-control" id="Ques4" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>	
    					    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques5" class="form-label">What are some challenges you've faced as an influencer, and how have you overcome them?</label>
    								<input type="text" class="form-control" id="Ques5" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>	
    					    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques6" class="form-label">Can you highlight a particularly successful collaboration or partnership you've had with a brand?</label>
    								<input type="text" class="form-control" id="Ques6" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>	
    					    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques7" class="form-label">How do you maintain authenticity and transparency in sponsored content or brand partnerships?</label>
    								<input type="text" class="form-control" id="Ques7" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>	
    					    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques8" class="form-label">What strategies do you employ to stay relevant and adapt to changes in social media algorithms or trends?</label>
    								<input type="text" class="form-control" id="Ques8" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>	
    					    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques9" class="form-label">How do you balance personal life with the demands of being a full-time influencer?</label>
    								<input type="text" class="form-control" id="Ques9" placeholder=""
    									wfd-id="id0" autocomplete="off">
    							</div>
    						</div>
    					</div>
    					<div class="row ">
    						<div class="col-lg-12 ">
    							<div class="mb-4">
    								<label for="Ques10" class="form-label">Looking to the future, what are your goals and aspirations as an influencer?</label>
    								<input type="text" class="form-control" id="Ques10" placeholder=""
    									wfd-id="id0" autocomplete="off" >
    							</div>
    						</div>
    					</div>
    						<div class="row">
						<div class="col-lg-12">
							<div class="mb-4">
							<input name="trans_id" id="trans_id" type="hidden" class="form-control">
							<button class="btn btn-sub MainColor w-100 text-white" type="button" id="update_question">Update Details</button>
							</div>
						</div>
					</div>
                  </form>
                  
              </div>
              <div class="tab-pane fade" id="astudent-tab-5" role="tabpanel" aria-labelledby="sstudent-tab-5" tabindex="0">
                  
                     <div class="row   mt-4">
    				
    						<div class="col-lg-12">
    							<div class="mb-4">
    							        <table class="table table-bordered py-3 table-hover">
    							            <thead>
        							           <tr>
        							               <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Lesson links </th>
                                                    <th>Views</th>
                                                    <th>Eng. Rate</th>
                                                      <th>Fetch</th>
        							            </tr>
    							            </thead>
    							             <thead>
        							          <tr>
        							              <td>1</td>
                                                    <td>25 Mar 2024</td>
                                                    <td>https://www.instagram.com/reel/C42mBrULzdt/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==</td>
                                                    <td>15,000</td>
                                                     <td>50.55%</td>
                                                    <td>  <button type="button" class="btn  btn-primary"><i class="bi bi-arrow-clockwise"></i></button></td>
        							            </tr>
        							             <tr>
        							              <td>2</td>
                                                    <td>25 Mar 2024</td>
                                                    <td>https://www.instagram.com/reel/C42mBrULzdt/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==</td>
                                                    <td>15,000</td>
                                                     <td>50.55%</td>
                                                    <td>  <button type="button" class="btn  btn-primary"><i class="bi bi-arrow-clockwise"></i></button></td>
        							            </tr>
        							             <tr>
        							              <td>60</td>
                                                    <td>25 Mar 2024</td>
                                                    <td>https://www.instagram.com/reel/C42mBrULzdt/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==</td>
                                                    <td>15,000</td>
                                                     <td>50.55%</td>
                                                    <td>  <button type="button" class="btn  btn-primary"><i class="bi bi-arrow-clockwise"></i></button></td>
        							            </tr>
    							            </thead>
    							        </table>
    							</div>
    						
    						</div>
					</div>
                  
              </div>
              
              <div class="tab-pane fade" id="astudent-tab-6" role="tabpanel" aria-labelledby="sstudent-tab-6" tabindex="0">
                     <div class="row   mt-4">
    						<div class="col-lg-12 WhatsAppResponse">	  
    						</div>
					</div>
              </div>
            </div>
					
					
					
				
				</form>
			</div>
		</div>



		<?php include ("inc/footer.php"); ?>
</body>

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

<script>
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
                    trans_type: 'success'
                    
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
            var amount = $(this).data("amount");
            var datetime = $(this).data("datetime");
            var remarks = $(this).data("remarks");
            
            var WhatsAppRes = $(this).find(".whatsappres").text();
             
            $(".WhatsAppResponse").text(WhatsAppRes);
            
            $('#custname').val(custname);
            $('#trans_id').val(id);
            $('#custemail').val(email);
            $('#custphone').val(phone);
            $('#u_location').val(u_location);
            
            $('#trx_id_sr').text(id);
            $('#trx_date').text(datetime);
            $('#trx_id').text(txnid);
            $('#trx_amt').text(amount);
            $('#trx_pgid').text('***'+remarks);
            
            
            $('#u_ip').val(u_ip);
            $('#u_device').val(u_device);
            
            var info_sent = $(this).data("info_sent");

            if(info_sent == '1'){
                    
                //$("#CongratulationsCoures").text('Welcome Msg WhatsApp Sent!');
                //$("#CongratulationsCoures").removeClass('btn-primary');
                //$("#CongratulationsCoures").addClass('btn-secondary');
                
                
                $("#CongratulationsCoures").addClass('disabled');
                
            }else{
                //$("#CongratulationsCoures").text('Welcome Msg WhatsApp');
                //$("#CongratulationsCoures").addClass('btn-primary');
                //$("#CongratulationsCoures").removeClass('btn-secondary');
                
                $("#CongratulationsCoures").removeClass('disabled');
                
            }
            $('#info_sent').val(info_sent);
            
            $.ajax({
                url: 'fetch_call_remark.php',
                type: 'GET',
                data: { 
                        trans_id: id,
                        trans_type: 'success'
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
            
            //-- api for get Student
            
            $.ajax({
                url: 'get_student_data.php',
                type: 'POST',
                data: { phone: phone },
                success: function(response) {
                    console.log(JSON.parse(response));
                    var res = JSON.parse(response);
                    if(res.code == 200){
                        var user_id = res.user.user_id;
                        var name = res.user.custom_fields[3].field_value;
                        var email = res.user.custom_fields[3].field_value;
                        var city = res.user.custom_fields[4].field_value;
                        var state = res.user.custom_fields[5].field_value;
                        var pincode = res.user.custom_fields[6].field_value;
                        var gender = res.user.custom_fields[2].field_value;
                        var age = res.user.custom_fields[0].field_value;
                        var whatsappno = res.user.custom_fields[1].field_value;
                        var contact_number = res.user.custom_fields[3].field_value;
                        
                        var insta = res.user.custom_fields[7].field_value;
                        var facebook = res.user.custom_fields[8].field_value;
                        var youtube = res.user.custom_fields[9].field_value;
                        var twitter = res.user.custom_fields[10].field_value;
                        
                        $("#user_id").val(user_id);
                        $("#StudentName").val(name);
                        $("#StudentEmail").val(email);
                        $("#WhatsAppNumber").val(whatsappno);
                        $("#PhoneNumber").val(contact_number);
                        $("#Age").val(age);
                        $("#Gender").val(gender);
                        $("#CityDistrict").val(city);
                        $("#State").val(state);
                        $("#Pincode").val(pincode);
                        
                        $("#FacebookProfileLink").val(facebook);
                        $("#InstagramProfileLink").val(insta);
                        $("#YouTubeProfileLink").val(youtube);
                        $("#TwitterProfileLink").val(twitter);
                        
                        
                        
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    
                },
                complete: function() {
                    
                }
            });
            
            
        });
    
    
        $('#custom_action_call').click(function() {
            
            var custphone_custom = $('#custphone_custom').val();
            if(custphone_custom == ''){
                alert('Please enter phone number');
                return;
            }
            
            $(this).prop('disabled', true);
            $("#custom_action_call").html('<i class="spinner-border text-light"></i>');
            
            $.ajax({
                url: 'make_call.php',
                type: 'POST',
                data: { custphone_custom: custphone_custom },
                success: function(response) {
                    
                    $("#custom_action_call").html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.761.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/></svg>');
                    $('#callingModal').modal('show');
                    
                },
                error: function(xhr, status, error) {
                    
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
        
        //loadTransactionData();
    
        setInterval(function() {
            loadTransactionData();
        }, 60000);
    
        function loadTransactionData() {
            $.ajax({
                url: 'fetch_transaction_data.php',
                type: 'GET',
                data: { transation_type: 'success' },
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
        
    document.getElementById('CongratulationsCoures').addEventListener('click', function() {
        
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
                url: 'congratulations_sent.php',
                type: 'POST',
                data: {
                    trans_id: trans_id,
                    
                },
                success: function(response) {
                    
                    if (response.trim() == 'true' || response.trim() == '1') {
                        
                        //$("#InfoCoures").prop('disabled', true);
                        
                        
                        var custphone = $('#custphone').val();
                        var custname = $('#custname').val();
                        
                        var phoneNumber = custphone; // Replace with the customer's phone number
                        
                        var textMessage = encodeURIComponent("Hi *"+ custname +"*,\n\nCongratulations!\n\nWelcome to The Vibes Academy. You're now enrolled in the i-MBA course! You can access the course using the i-MBA app! Please follow the following steps to ensure a smooth learning experience.\n\nबधाई हो!\n\nद वाइब्स अकैडमी के i-MBA कोर्स में आपका स्वागत है! आप ये कोर्स आई-एमबीए ऐप पर देख सकते हैं। एक अच्छे अनुभव के लिए कृपया निम्नलिखित चरणों का पालन करें।\n\nStep 1:  Please download the i-MBA App via this link/ कृपया इस लिंक के माध्यम से आई-एमबीए ऐप डाउनलोड करें: https://play.google.com/store/apps/details?id=com.edmingle.thevibesacademy&pcampaignid=web_sharewe'll\n\nStep 2: Start the course on the i-MBA app. आई-एमबीए ऐप पर कोर्स शुरू करें।\n\nStep 3: Please join our WhatsApp group for course updates, highlights and more. कोर्स की बारे में, और अन्य जानकारी के लिए कृपया जॉइन करिए व्हॉट्सऐप ग्रुप: https://chat.whatsapp.com/Lb85GuN9E3a3rBV89tC1vr \n\nStep 4: Please save our support team's number/ हमारी सपोर्ट टीम के नंबर सेव कर लें: 97737-94875\n\nBest, The Vibes Academy\nधन्यवाद, द वाइब्स अकैडमी");
                        
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
  </script>

</html>