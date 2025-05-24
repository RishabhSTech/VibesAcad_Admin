<?php 
include ("inc/config.php"); 

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
 } else {
    
	header('Location: index.php');
 }
 
 if (isset($_POST['submit'])) {
	$username = $_POST["email"];
	$name = $_POST["name"];
	$caller_id = $_POST["caller_id"];
	$password = $_POST["password"];
	$role = $_POST["designation"];
	
	include 'inc/function.php';
	$sqlObj = new Actions();

	$sql = "INSERT INTO admin_users (name, caller_id, username, password, role) VALUES ('$name', '$caller_id', '$username', '$password', '$role')";

	if (mysqli_query($sqlObj->dbConnect, $sql)) {
	    
	} else {
	    echo "Error updating record: " . mysqli_error($connection);
	}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add New Employee</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">Add New Employee</h6>
	</section>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-6">
				<H4 class="mb-5 mt-5">Add New Employee</H4>
				<form action="" method="POST">
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Name</label>
						<input type="text" name="name" class="form-control" id="exampleFormControlInput1"
							placeholder="" required>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Email</label>
						<input type="email" name="email" class="form-control" id="exampleFormControlInput1"
							placeholder="" required>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Caller ID</label>
						<input type="tel" name="caller_id" class="form-control" id="exampleFormControlInput1" placeholder=" " required>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Designation</label>
						<select name="designation" required  class="form-select" aria-label="Default select example">
							<option selected>Designation</option>
							<option value="Caller">Caller</option>
							<option value="Manager">Manager</option>
							<option value="Super Admin">Super Admin</option>
						</select>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Password</label>
						<input type="password" name="password" class="form-control" id="exampleFormControlInput1" required>
					</div>
					<div class="d-grid gap-2 mt-5">
						<input class="btn btn-primry MainColor text-white" type="submit" name="submit" value="Create a Employee">
					</div>
				</form>
			</div>
		</div>
	</div>




	<?php include ("inc/footer.php"); ?>
</body>

</html>