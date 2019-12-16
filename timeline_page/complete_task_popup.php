<?php 
	session_start();
	$conn = mysqli_connect("localhost", "root", "","testing");  
	if(!$conn){  
		die('Could not connect: '.mysqli_connect_error());  
	}
	$button_id=$_SESSION['but_id'];


	$query="UPDATE to_do_list SET status='completed' WHERE id='$button_id' ";
	if(mysqli_query($conn,$query)){
		echo "<b>Record Updated Successfully.</b>";
	}
	else{
		echo "not updated";
	}
	header("location:to_do_page.php");
?>
