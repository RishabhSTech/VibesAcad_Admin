<?php include("inc/config.php"); ?>

<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   header('Location: dashboard.php');
}

if (!empty($_POST["user"])) {
    $username = $_POST['user'];
    $password = $_POST['password'];

    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $sql = "select *from admin_users where username = '$username' and password = '$password'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    $count = mysqli_num_rows($result);

    if ($count == 1) {

        header('Location: dashboard.php');
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $row['id'];
        $_SESSION['login_name'] = $row['name'];
        $_SESSION['login_caller_id'] = $row['caller_id'];
        $_SESSION['login_role'] = $row['role'];
        
        
    } else {
        echo "<script>alert('Login failed. Invalid username or password.')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">	
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard - The Vibes Acadmy</title>
	<?php include("inc/styles.php"); ?>
</head>
<body class="MainColor">
<div class="container">
  <div class="row align-items-start justify-content-center">
    <div class="col-4 mt-5 mb-5">
	<img src="images/logo.png" alt="">
    </div>
  </div>
  <div class="row align-items-center justify-content-center mt-5 mb-5">
    
        <div class="col-4 ">
            <form action="" method="post">
    		<h2 class="mb-5 mt-3 text-white text-center">Hello!</h2>
    		<div class="mb-3">
    			<label for="exampleFormControlInput1" class="form-label text-white">Email address</label>
    			<input type="email" name="user" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
    		</div>
    		<div class="mb-3">
    			<label for="exampleFormControlInput1" class="form-label text-white">Password</label>
    			<input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
    		</div>
    		<div class="d-grid gap-2 mt-3">
    		  <button class="btn btn-light" type="submit">Login</button>
    		</div>
    		</form>
        </div>
    
  </div>
  <div class="row align-items-end justify-content-center mt-5 text-center">
    <div class="col-4 mt-5">
		<p class="text-white mt-5">Powered by The Vibes Academy</p>
    </div>
  </div>
</div>

</body>
</html>