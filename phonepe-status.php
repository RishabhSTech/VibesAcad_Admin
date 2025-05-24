<?php 
include ("inc/config.php"); 

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
} else {
    
	header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Phonepe Txn Info</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">Phonepe Txn Info</h6>
	</section>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-6">
				<H4 class="mb-5 mt-5">Phonepe Txn Search Info</H4>
				<form id="orderIdForm">
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Enter Txn ID</label>
						<input type="text" name="actiondata" class="form-control" id="orderId" name="orderId" required>
					</div>
					
					<div class="d-grid gap-2 mt-5">
					     <button class="btn btn-primry MainColor text-white"  type="button" onclick="checkStatus()">Check Status</button>
				
					</div>
				</form>
			</div>
		</div>
	</div>
	

    <div class="container">
		<div class="row justify-content-center">
			<div class="col-6">
		
            <div id="response" class="mt-5"></div>
			  
    
            </div>
        </div>
    </div>




	<?php include ("inc/footer.php"); ?>
	<script>
      function checkStatus() {
    var orderId = document.getElementById("orderId").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var responseDiv = document.getElementById("response");
            responseDiv.innerHTML = this.responseText; // Set HTML directly
        }
    };
    xhttp.open("GET", "status_check.php?orderId=" + orderId, true);
    xhttp.send();
}
    </script>
</body>

</html>