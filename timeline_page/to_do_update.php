<?php
    session_start();
	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
    }
    $p_id=$_SESSION['mem_id'];
    $dates1=mysqli_real_escape_string($conn,$_POST['expected_date1']);
	$type1=mysqli_real_escape_string($conn,$_POST['type1']);
	$subject1=mysqli_real_escape_string($conn,$_POST['subject_1']);

    $dates2=mysqli_real_escape_string($conn,$_POST['expected_date2']);
    $type2=mysqli_real_escape_string($conn,$_POST['type2']);
	$subject2=mysqli_real_escape_string($conn,$_POST['subject_2']);

    $dates3=mysqli_real_escape_string($conn,$_POST['expected_date3']);
    $type3=mysqli_real_escape_string($conn,$_POST['type3']);
	$subject3=mysqli_real_escape_string($conn,$_POST['subject_3']);

	$sqlip = "INSERT into to_do_list (dates,plan,Subject,projectid) VALUES ('$dates1','$type1','$subject1','$p_id'),('$dates2','$type2','$subject2','$p_id'),('$dates3','$type3','$subject3','$p_id') " ;
	if (mysqli_query($conn, $sqlip)) {
		echo "New record created successfully";
	} else {
		echo "Error: " .mysqli_error($conn);  ;
	}
	mysqli_close($conn);
	header("location:to_do_page.php");
?>