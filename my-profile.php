<?php 
include ("inc/config.php");

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
 } else {
    
	header('Location: index.php');
 }
 
include 'inc/function.php';
$sqlObj = new Actions();

 if (isset($_POST['submit'])) {
	
	$username = $_POST["username"];
	$name = $_POST["name"];
	$caller_id = $_POST["caller_id"];
	$password = $_POST["password"];
	$role = $_POST["designation"];

    if($password != ''){
	    $sql = "UPDATE admin_users SET name = '".$name."', caller_id = '".$caller_id."', username  = '".$username."', password = '".$password."', role = '".$role."' WHERE id = '".$_SESSION['userid']."'";
    }else{
        $sql = "UPDATE admin_users SET name = '".$name."', caller_id = '".$caller_id."', username  = '".$username."', role = '".$role."' WHERE id = '".$_SESSION['userid']."'";
    }
    
	if (mysqli_query($sqlObj->dbConnect, $sql)) {
	    
	} else {
	    echo "Error updating record: " . mysqli_error($connection);
	}

}

$name = '';
$caller_id = '';
$username = '';
$role = '';
if(!empty($_SESSION['userid']) && $_SESSION['userid']) {
	$emp_data = $sqlObj->getEmployeedata($_SESSION['userid']);		
	
	$name = $emp_data['name'];	
	$caller_id = $emp_data['caller_id'];	
	$username = $emp_data['username'];	
	$role = $emp_data['role'];	
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Profile</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">My Profile</h6>
	</section>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-6">
				<H4 class="mb-5 mt-5">Edit Profile</H4>
				<form action="" method="POST">
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Name</label>
						<input type="text" name="name" value="<?php echo $name;?>" class="form-control" id="exampleFormControlInput1"
							placeholder="" required>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Email</label>
						<input type="email" name="username" value="<?php echo $username;?>" class="form-control" id="exampleFormControlInput1"
							placeholder="" required readonly>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Caller ID</label>
						<input type="tel" name="caller_id" value="<?php echo $caller_id;?>" class="form-control" id="exampleFormControlInput1" placeholder=" " required>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Designation</label>
						<select class="form-select" name="designation" aria-label="Default select example" required>
							<option valuie="">Designation</option>
							<option <?php if($role == 'Caller'){echo 'selected';};?> value="Caller">Caller</option>
							<option <?php if($role == 'Manager'){echo 'selected';};?> value="Manager">Manager</option>
							<option <?php if($role == 'Super Admin'){echo 'selected';};?> value="Super Admin">Super Admin</option>
						</select>
					</div>
					<div class="mb-4">
						<label for="exampleFormControlInput1" class="form-label">Password</label>
						<input type="password" name="password" class="form-control" id="exampleFormControlInput1">
					</div>
					<div class="d-grid gap-2 mt-5">
						
						<input class="btn btn-primry MainColor text-white" type="submit" name="submit" value="Update Profile">
					</div>
				</form>
			</div>
		</div>
	</div>




	<?php include ("inc/footer.php"); ?>
</body>

</html>