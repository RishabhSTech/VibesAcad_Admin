<?php 
include ("inc/config.php");

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
 } else {
    
 header('Location: index.php');
 }
 
include 'inc/function.php';
$allactions = new Actions();

$emplyeelist = $allactions->getEmployeeList();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Employees</title>
	<?php include ("inc/styles.php"); ?>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">EMPLOYEE MANAGEMENT</h6>
	</section>
	<div class="container">
		<div class="row pb-3 pt-5">

			<div class="col-3 justify-content-start">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Search Employee" aria-label="Search Employee"
						aria-describedby="button-addon2">
					<button class="btn  MainColor text-white" type="button" id="button-addon2">Search</button>
				</div>
			</div>
			<div class="col-6"></div>
			<div class="col-3 justify-content-end text-end"><a href="employee-add.php"  class="btn  MainColor text-white"> + Add New Employee</a>
			</div>
		</div>
	</div>
	<div class="container">
		<table class="table2 table-bordered">
			<thead>
				<tr>
					<th>Emp ID</th>
					<th>Name</th>
					<th >Caller ID</th>
					<th >Designation</th>
					<th>Email Id</th>
					<th class="text-center">Modify</th>
				</tr>
			</thead>
			<tbody>
			    
			    <?php foreach($emplyeelist as $emp){ ?>
				<tr>
					<td>EMP<?php echo $emp['id'];?></td>
					<td><?php echo $emp['name'];?></td>
					<td><?php echo $emp['caller_id'];?></td>
					<td><?php echo $emp['role'];?></td>
					<td><?php echo $emp['username'];?></td>
					<td class="text-center"><a href="employee-edit.php?id=<?php echo $emp['id'];?>">Edit</a> | <a href="#" class="delete_user" data-uid="<?php echo $emp['id'];?>">Delete</a> </td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>




	<?php include ("inc/footer.php"); ?>
</body>


<script>

jQuery(document).ready(function($) {
    
  
    $('.delete_user').click(function() {
        
        if(confirm('Are you sure want to delete?')){
            
            var uid = $(this).data('uid');
        
            if(uid == ''){
            
                return;
            }
            
            
            $(".delete_user").text('removing...');
            $(this).prop('disabled', true);
            var mythis = $(this);
             
            $.ajax({
                url: 'remove-user.php',
                type: 'POST',
                data: {
                    uid: uid,
                    
                },
                success: function(response) {
                    mythis.closest('tr').remove();
                    alert('User successfully deleted.');
                }
            });
        }  
        
    });
});
</script>

</html>