<?php
$user_name = '';
$login_role = '';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   $user_name = $_SESSION['login_name'];
   $login_role = isset($_SESSION['login_role']) ? $_SESSION['login_role'] : '';
}
?>

<nav class="navbar navbar-expand-lg MainColor p-3">
  <div class="container-fluid">


  

    <div class="row w-100 align-items-center">
     <div class="col-2">
            <a class="navbar-brand " href="#"> <img class="logomain" src="images/logo.png" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="col-9 ">
            <div class="collapse navbar-collapse justify-content-center " id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active text-white"  href="dashboard.php">Dashboard</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link active text-white"  href="lead-calling.php">Leads</a>
                    </li>
                     <li class="nav-item">
                    <a class="nav-link active text-white"  href="phonepe-status.php">PhonePe Txn Status</a>
                    </li>
                     <li class="nav-item">
                    <a class="nav-link active text-white"  href="user-info.php">Order details</a>
                    </li>
                       <li class="nav-item">
                    <a class="nav-link active text-white"  href="inbound-calling.php">Inbound</a>
                    </li>


                    <li class="nav-item">
                    <a class="nav-link active text-white"  href="failed-transaction.php">Failed Txn</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link active text-white"  href="success-transaction.php">Successful Txn</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active text-white"  href="reports.php">Reports</a>
                    </li>
                    <?php if($login_role == 'Super Admin'){ ?>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="buzz-report.php">Buzz Report</a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                         <a class="nav-link active text-white" href="employees.php">Employees</a>
                    </li>

                </ul>
        </div>
        </div>
        <div class="col-1">
        <div class="collapse navbar-collapse text-right justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                 
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       Hi, <?php echo ucwords($user_name);?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="my-profile.php">My Profile</a></li>
                        <?php if($login_role == 'Super Admin'){ ?>
                        <li><a class="dropdown-item" href="setting.php">Settings</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="inc/logout.php">Log out</a></li>
                    </ul>
                    </li>
                </ul>
        </div>
        </div>
    </div>
  </div>
</nav>