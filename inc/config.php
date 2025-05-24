<?php
$root_url = "https://admin.thevibes.academy/";

$con = mysqli_connect("localhost","mba","mba@123","mba");

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die();
}
?>