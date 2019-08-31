<?php
    session_start();
    $conn=mysqli_connect("localhost","root","","testing");
    if(!$conn){
        die('could not connect:'.mysqli_connect_error());
    }
    $p_id=$_SESSION['mem_id'];
    $ended_project=mysqli_real_escape_string($conn,$_POST['end_of_project']);
    $continue_project=mysqli_real_escape_string($conn,$_POST['continue_of_project']);
    if(isset($ended_project)){
        $status_update="UPDATE project_details SET genre='Completed' WHERE id='$p_id' ";
    	if(mysqli_query($conn,$status_update)){
    		echo "<b>Record Updated Successfully.</b>";
    	}
    	header("location:display.php");
    }
    if(isset($continue_project)){
    	header("location:display.php");
    }
    mysqli_close($conn);

?>