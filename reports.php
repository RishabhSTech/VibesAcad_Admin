<?php 
include ("inc/config.php"); 

session_start();
$user_role = '';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
    $user_role = isset($_SESSION['login_role']) ? $_SESSION['login_role'] : '';
    if($user_role != 'Super Admin'){
        //header('Location: index.php');
    }
 } else {
    
	header('Location: index.php');
 }
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reports</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">Reports</h6>
	</section>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-3">
				<H4 class="mb-5 mt-5">Generate Reports</H4>
				<form id="excel_form" method="post">
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Report type</label>
						<select id="trx_type" name="designation" class="form-select" aria-label="Default select example" required>
							<option value="">--- Select ---</option>
							<?php if($user_role != 'Super Admin'){ ?>
							
							<option value="SuccessfulTransaction">Successful transaction</option>
							<?php }else{ ?>
							<option value="LeadCalling">Lead Calling</option>
							<option value="InboundCalling">Inbound Calling</option>
							<option value="FailedTransaction">Failed Transaction</option>
							<option value="SuccessfulTransaction">Successful transaction</option>
							<option value="EarningCalculator">Earning Calculator</option>
							<option value="AbandonedCart">Abandoned Cart</option>
							<?php } ?>
						</select>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput2" class="form-label">From</label>
						<input type="date" name="from" id="start_date" class="form-control" id="exampleFormControlInput2" required>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">To</label>
						<input type="date" name="to" id="end_date" class="form-control" id="exampleFormControlInput1" required>
					</div>
					<div class="d-grid gap-2 mt-5">
						<button class="btn btn-primry MainColor text-white" id="generatereport" type="submit" name="submit">Generate Report!</button>
					</div>
				</form>
			</div>
		</div>
	</div>




	<?php include ("inc/footer.php"); ?>
</body>


<script>
$(document).ready(function() {
    $('#excel_form').submit(function(event) {
        
        event.preventDefault();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var trx_type = $('#trx_type').val();
        
        var filename = 'Transactions';
        if(trx_type == 'LeadCalling'){
            filename = 'LeadCalling-Transactions';
        }else if(trx_type == 'InboundCalling'){
            filename = 'InboundCalling-Transactions';
        }else if(trx_type == 'FailedTransaction'){
            filename = 'Failed-Transactions';
        }else if(trx_type == 'SuccessfulTransaction'){
            filename = 'Successfull-Transactions';
        }else if(trx_type == 'EarningCalculator'){
            filename = 'Earning-Calculator';
        }else if(trx_type == 'AbandonedCart'){
            filename = 'Abandoned-Cart';
        }
        
		if (start_date === '' || end_date === '') {
            $('#error_message').text('Please select both start and end dates.');
            return false;
        } else {
            $('#error_message').text('');
        }
        //alert('The features are currently under development.');
        //return;

        $("#generatereport").prop('disabled', true);
        $("#generatereport").html('<i class="spinner-border text-light"></i>');
            
        $.post('generate_excel.php', { trx_type: trx_type, start_date: start_date, end_date: end_date,generate_excel:'1' }, function(data) {
            
            var blob = new Blob([data], { type: 'text/csv' });

            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename+'.csv';
            link.click();
            
            $('#generatereport').prop('disabled', false);
            $("#generatereport").html('Generate Report!');
        });
    });
});
</script>

</html>