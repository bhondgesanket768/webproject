<?php
    session_start();
	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
    }
    $p_id=$_SESSION['mem_id'];
    $Problem_statement=mysqli_real_escape_string($conn,$_POST['Problem_statement']);
    $Target_Audiences=mysqli_real_escape_string($conn,$_POST['target_audiences']);
    $Solutions=mysqli_real_escape_string($conn,$_POST['solution']);
	$location=mysqli_real_escape_string($conn,$_POST['location']);
	$Approach=mysqli_real_escape_string($conn,$_POST['approach']); //addition
	$time=mysqli_real_escape_string($conn,$_POST['time']); //addition
	
	$sqlip = "UPDATE project_details SET does='$Problem_statement',Address='$location',Target_Audience='$Target_Audiences',how='$Approach',Date='$time',Solutions='$Solutions' WHERE id='$p_id'" ;
	if (mysqli_query($conn, $sqlip)) {
		echo "New record created successfully";
	} else {
		echo "Error: " .mysqli_error($conn);  ;
	}
	mysqli_close($conn);
	header("location:rough_plan.php");
?>