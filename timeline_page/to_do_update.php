<?php
    session_start();
	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
    }
	$p_id=$_SESSION['mem_id'];
	$subject=mysqli_real_escape_string($conn,$_POST['task_name']);
	$leader=mysqli_real_escape_string($conn,$_POST['leader']);
    $dates=mysqli_real_escape_string($conn,$_POST['expected_date1']);
	$deadline=mysqli_real_escape_string($conn,$_POST['deadline']);
	$description=mysqli_real_escape_string($conn,$_POST['remarks']);

/*
    $dates2=mysqli_real_escape_string($conn,$_POST['expected_date2']);
    $type2=mysqli_real_escape_string($conn,$_POST['type2']);
	$subject2=mysqli_real_escape_string($conn,$_POST['subject_2']);

    $dates3=mysqli_real_escape_string($conn,$_POST['expected_date3']);
    $type3=mysqli_real_escape_string($conn,$_POST['type3']);
	$subject3=mysqli_real_escape_string($conn,$_POST['subject_3']);
*/
	$sqlip = "INSERT into to_do_list (dates,Subject,leader,deadline,projectid,remarks) VALUES ('$dates','$subject','$leader','$deadline','$p_id','$description') " ;
	if (mysqli_query($conn, $sqlip)) {
		echo "New record created successfully";
	} else {
		echo "Error: " .mysqli_error($conn);  
	}
	mysqli_close($conn);
	header("location:to_do_page.php");
?>


