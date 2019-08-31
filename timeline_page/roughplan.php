<?php
    session_start();
	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
    }
    $p_id=$_SESSION['mem_id'];
    $Target_Audiences=mysqli_real_escape_string($conn,$_POST['target_audiences']);
    $Problems=mysqli_real_escape_string($conn,$_POST['problems']);
    $Solutions=mysqli_real_escape_string($conn,$_POST['solutions']);
    $Why=mysqli_real_escape_string($conn,$_POST['why']);
	$sqlip = "UPDATE project_details SET Target_Audience='$Target_Audiences',Problems='$Problems',Solutions='$Solutions',Why='$Why' WHERE id='$p_id'" ;
	if (mysqli_query($conn, $sqlip)) {
		echo "New record created successfully";
	} else {
		echo "Error: " .mysqli_error($conn);  ;
	}
	mysqli_close($conn);
	header("location:rough_plan.php");
?>