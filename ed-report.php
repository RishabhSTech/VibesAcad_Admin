<?php 
include ("inc/config.php");

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
 } else {
    
 header('Location: index.php');
 }
 
include 'inc/function.php';
$allactions = new Actions();

$stdlist = $allactions->getStudentNotEdList();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Students Edmingle Report</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">STUDENT NOT CREATED ON EDMINGLE</h6>
	</section>
	<div class="container">
		<div class="row pb-3 pt-5">

			<div class="col-3 justify-content-start">
			
			</div>
			<div class="col-6"></div>
			
		</div>
	</div>
	<div class="container">
		<table class="table2 table-bordered">
			<thead>
				<tr>
					<th>#ID</th>
					<th>Name</th>
					<th>Mobile</th>
					<th>Txn ID</th>
					<th>TXNdatetime</th>
					<th>Edmingle Response</th>
				</tr>
			</thead>
			<tbody>
			    
			    <?php foreach($stdlist as $emp){ ?>
				<tr>
					<td>EMP<?php echo $emp['id'];?></td>
					<td><?php echo $emp['CustName'];?></td>
					<td><?php echo $emp['mobile'];?></td>
					<td><?php echo $emp['txnID'];?></td>
					<td><?php echo $emp['TXNdatetime'];?></td>
					<td><?php echo $emp['admi_response'];?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<?php include ("inc/footer.php"); ?>
</body>

</html>