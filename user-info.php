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
	<title>Search User Info</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">Search User Info</h6>
	</section>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-6">
				<H4 class="mb-5 mt-5">Search User Info</H4>
				<form action="" method="POST">
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Search Via TXN id and Mobile number</label>
						<input type="text" name="actiondata" class="form-control" id="exampleFormControlInput1"
							placeholder="txn id and mobile number" required>
					</div>
					
					<div class="d-grid gap-2 mt-5">
						<input class="btn btn-primry MainColor text-white" type="submit" name="submit" value="Search">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<?php
	if (isset($_POST['submit'])) {
	$actiondata = $_POST["actiondata"];
	
	
	$servername = "localhost";
    $username = "mba";
    $password = "mba@123";
    $dbname = "mba";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `payments` 
        WHERE `txnID` = '".$actiondata."' 
        OR `mobile` LIKE '%".$actiondata."%' 
        OR `CustName` = '".$actiondata."' 
        OR `email` = '".$actiondata."' 
        LIMIT 1";
    
    $result = $conn->query($sql);
    
    $row = $result->fetch_assoc();
    
    ?>
    <div class="container">
		<div class="row justify-content-center">
			<div class="col-8">
			    
			    <table class="table table-bordered mt-1 px-5">
    
    <?php
    if(NULL != $row){
        foreach($row as $key => $data){
            echo '<tr>';
            echo '<td>'.$key .'</td>';
            echo '<td width="300">'.$data .'</td>';
            echo '</tr>';
        }
    }else{
        echo '<tr><td>No record found!<td></tr>';
    }
    
    ?>
    </table>
    
            </div>
        </div>
    </div>

<?php } ?>


	<?php include ("inc/footer.php"); ?>
</body>

</html>