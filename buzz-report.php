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


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>VibesBuzz - Data</title>
	<?php include ("inc/styles.php"); ?>
	
	<style>
	    /* Pagination Container */
.pagination {
        display: flex;
    justify-content: center;
    list-style: none;
    padding: 0px;
    margin: 20px 0;
    flex-wrap: wrap;
    gap: 10px;

}

/* Pagination Links */
.pagination li {
    margin: 0 5px;
}

.pagination li a {
    display: block;
    padding: 10px 15px;
    text-decoration: none;
    color: #007bff;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

/* Hover Effect */
.pagination li a:hover {
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
}

/* Active Page */
.pagination .active a {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    pointer-events: none;
}

	</style>
</head>

<body>
	<?php include ("inc/header.php"); ?>
	<section class="title-heading bg-danger-subtle text-center text-dark py-2">
		<h6 class="mb-0">VibesBuzz - Data</h6>
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
        <?php
        // Database configuration
        $servername = "localhost";
        $username = "thevibesbuzz";
        $password = "7XmPzhGJGGKTyRRr";
        $dbname = "thevibesbuzz";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Pagination logic
        $limit = 300; // Number of rows per page
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Fetch total record count
        $count_sql = "SELECT COUNT(*) as total FROM user_insta_profile";
        $count_result = $conn->query($count_sql);
        $total_records = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_records / $limit);

        // Fetch data with LIMIT and OFFSET
        $sql = "SELECT * FROM user_insta_profile ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<thead>";
            echo "<tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Followers</th>
                <th>Created at</th>
                <th>Name</th>
                <th>Pincode</th>
                <th>WhatsApp</th>
            </tr>";
            echo "</thead>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["user_name"] . "</td>";
                echo "<td>" . $row["totalfollower"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td>" . $row["cap_name"] . "</td>";
                echo "<td>" . $row["cap_pincode"] . "</td>";
                echo "<td>" . $row["cap_whatsapp_num"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No results found</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <!-- Pagination Links -->
    <nav>
        <ul class="pagination">
            <?php
            if ($page > 1) {
                echo "<li><a href='?page=" . ($page - 1) . "'>Previous</a></li>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                $active = ($i == $page) ? "class='active'" : "";
                echo "<li $active><a href='?page=$i'>$i</a></li>";
            }

            if ($page < $total_pages) {
                echo "<li><a href='?page=" . ($page + 1) . "'>Next</a></li>";
            }
            ?>
        </ul>
    </nav>
</div>


	<?php include ("inc/footer.php"); ?>
</body>

</html>