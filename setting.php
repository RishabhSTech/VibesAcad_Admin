<?php 
include ("inc/config.php");

session_start();
$user_role = '';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $user_role = isset($_SESSION['login_role']) ? $_SESSION['login_role'] : '';
    if($user_role != 'Super Admin'){
        header('Location: index.php');
    }
 } else {
    
	header('Location: index.php');
 }
 
include 'inc/function.php';
$sqlObj = new Actions();

 if (isset($_POST['submit'])) {
	  
	/*$WhatsAppGroup = $_POST['WhatsAppGroup'];	
	$BatchDate = $_POST['BatchDate'];	
	$PlaystoreLink = $_POST['PlaystoreLink'];	
	$enrollPageLink = $_POST['enrollPageLink'];	

    $sql = "UPDATE general_setting SET WhatsAppGroup = '".$WhatsAppGroup."', BatchDate = '".$BatchDate."', PlaystoreLink  = '".$PlaystoreLink."', enrollPageLink = '".$enrollPageLink."' WHERE id = '1'";
    
	if (mysqli_query($sqlObj->dbConnect, $sql)) {
	    
	} else {
	    echo "Error updating record: " . mysqli_error($connection);
	}*/
	
	$PlaystoreLink = $_POST['PlaystoreLink'];
    $enrollPageLink = $_POST['enrollPageLink'];

    $sql = "UPDATE general_setting SET PlaystoreLink = '$PlaystoreLink', enrollPageLink = '$enrollPageLink' WHERE id = '1'";
    mysqli_query($sqlObj->dbConnect, $sql);

    $BatchStartDates = $_POST['BatchStartDate'];
    $BatchEndDates = $_POST['BatchEndDate'];
    $WhatsAppGroups = $_POST['WhatsAppGroup'];

    $sql = "DELETE FROM session_details";
    if (!mysqli_query($sqlObj->dbConnect, $sql)) {
        echo "Error clearing session_details: " . mysqli_error($sqlObj->dbConnect);die();
    }
    
    foreach ($BatchStartDates as $index => $BatchStartDate) {
        $BatchEndDate = $BatchEndDates[$index];
        $WhatsAppGroup = $WhatsAppGroups[$index];

        $sql = "INSERT INTO session_details (BatchStartDate, BatchEndDate, WhatsAppGroup) 
                VALUES ('$BatchStartDate', '$BatchEndDate', '$WhatsAppGroup')";

        if (!mysqli_query($sqlObj->dbConnect, $sql)) {
            echo "Error: " . mysqli_error($sqlObj->dbConnect);
        }
    }

}

$name = '';
$caller_id = '';
$username = '';
$role = '';
if(!empty($_SESSION['userid']) && $_SESSION['userid']) {
	$emp_data = $sqlObj->getSettingdata();		
	
	$WhatsAppGroup = $emp_data['WhatsAppGroup'];	
	$BatchDate = $emp_data['BatchDate'];	
	$PlaystoreLink = $emp_data['PlaystoreLink'];	
	$enrollPageLink = $emp_data['enrollPageLink'];	
}

$sessions = [];
$sql = "SELECT BatchStartDate, BatchEndDate, WhatsAppGroup FROM session_details";
$result = mysqli_query($sqlObj->dbConnect, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $sessions[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>General Setting</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">General Setting</h6>
	</section>
	<!--div class="container">
		<div class="row justify-content-center">
			<div class="col-6">
				<H4 class="mb-5 mt-5">Edit Setting</H4>
				<form action="" method="POST">
					<div class="mb-4">
						<label for="WhatsAppGroup" class="form-label">WhatsAppGroup</label>
						<input type="text" name="WhatsAppGroup" value="<?php //echo $WhatsAppGroup;?>" class="form-control" id="WhatsAppGroup"
							placeholder="" required>
					</div>
					<div class="mb-4">
						<label for="BatchDate" class="form-label">Batch Date Update</label>
						<input type="text" name="BatchDate" value="<?php //echo $BatchDate;?>" class="form-control" id="BatchDate"
							placeholder="">
					</div>
					<div class="mb-4">
						<label for="PlaystoreLink" class="form-label">PlaystoreLink</label>
						<input type="text" name="PlaystoreLink" value="<?php //echo $PlaystoreLink;?>" class="form-control" id="PlaystoreLink" placeholder=" ">
					</div>
					 
					<div class="mb-4">
						<label for="enrollPageLink" class="form-label">enrollPageLink</label>
						<input type="text" name="enrollPageLink" value="<?php //echo $enrollPageLink;?>" class="form-control" id="enrollPageLink">
					</div>
					<div class="d-grid gap-2 mt-5">
						
						<input class="btn btn-primry MainColor text-white" type="submit" name="submit" value="Update">
					</div>
				</form>
			</div>
		</div>
	</div-->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h4 class="mb-5 mt-5">Edit Setting</h4>
            <form action="" method="POST" id="sessionForm">
                <!-- Single fields (Vertical Layout) -->
                <div class="mb-4">
                    <label for="PlaystoreLink" class="form-label">Playstore Link</label>
                    <input type="text" name="PlaystoreLink" value="<?php echo $PlaystoreLink; ?>" class="form-control" id="PlaystoreLink" placeholder="Enter Playstore Link">
                </div>
                <div class="mb-4">
                    <label for="enrollPageLink" class="form-label">Enroll Page Link</label>
                    <input type="text" name="enrollPageLink" value="<?php echo $enrollPageLink; ?>" class="form-control" id="enrollPageLink" placeholder="Enter Enroll Page Link">
                </div>

                <!-- Dynamic fields (Horizontal Layout) -->
                <div id="sessionContainer">
                    <?php if (!empty($sessions)) { ?>
                        <?php foreach ($sessions as $session) { ?>
                            <div class="session row align-items-center mb-3">
                                <div class="col-2">
                                    <label for="BatchStartDate" class="form-label">Batch Start Date</label>
                                    <input type="date" name="BatchStartDate[]" value="<?php echo $session['BatchStartDate']; ?>" class="form-control" placeholder="Start Date" required>
                                </div>
                                <div class="col-2">
                                    <label for="BatchEndDate" class="form-label">Batch End Date</label>
                                    <input type="date" name="BatchEndDate[]" value="<?php echo $session['BatchEndDate']; ?>" class="form-control" placeholder="End Date" required>
                                </div>
                                <div class="col">
                                    <label for="WhatsAppGroup" class="form-label">WhatsApp Group</label>
                                    <input type="text" name="WhatsAppGroup[]" value="<?php echo $session['WhatsAppGroup']; ?>" class="form-control" placeholder="Enter WhatsApp Group Link" required>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-danger mt-4" onclick="removeSession(this)">Remove</button>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <button type="button" class="btn btn-secondary mb-3" onclick="addSession()">Add More</button>

                <!-- Submit Button -->
                <div class="gap-2 mt-5 mb-5 text-center">
                    <input class="btn btn-primary" type="submit" name="submit" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>


	<?php include ("inc/footer.php"); ?>
</body>
<script>
    // Function to dynamically add new session row
    function addSession() {
        const container = document.getElementById('sessionContainer');
        const sessionTemplate = `
            <div class="session row align-items-center mb-3">
                <div class="col-2">
                    <label for="BatchStartDate" class="form-label">Batch Start Date</label>
                    <input type="date" name="BatchStartDate[]" class="form-control" placeholder="Start Date" required>
                </div>
                <div class="col-2">
                    <label for="BatchEndDate" class="form-label">Batch End Date</label>
                    <input type="date" name="BatchEndDate[]" class="form-control" placeholder="End Date" required>
                </div>
                <div class="col">
                    <label for="WhatsAppGroup" class="form-label">WhatsApp Group</label>
                    <input type="text" name="WhatsAppGroup[]" class="form-control" placeholder="Enter WhatsApp Group Link" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger mt-4" onclick="removeSession(this)">Remove</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', sessionTemplate);
    }

    // Function to remove a session row
    function removeSession(button) {
        button.closest('.session').remove();
    }
</script>
</html>