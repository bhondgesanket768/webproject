<?php
	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	$Mission = mysqli_real_escape_string($conn, $_POST["Mission"]);
	$does = mysqli_real_escape_string($conn,$_POST["does"]);
	$Address = mysqli_real_escape_string($conn,$_POST["Address"]);
	$p_date= mysqli_real_escape_string($conn,$_POST['p_date']);
	$sql = "INSERT INTO project_details (Mission, does, Address,Date) VALUES ('$Mission', '$does', '$Address','$p_date')";
	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " .mysqli_error($conn);  ;
	}
	mysqli_close($conn);
	header("location:display.php");
?>

