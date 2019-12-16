<?php
	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	$name=mysqli_real_escape_string($conn,$_POST["Name"]); //addition
	$Mission = mysqli_real_escape_string($conn, $_POST["Mission"]);
	$why=mysqli_real_escape_string($conn,$_POST["Why"]); //addition
	$who=mysqli_real_escape_string($conn,$_POST["Who"]); //addition
	$what = mysqli_real_escape_string($conn,$_POST["does"]);
	$where = mysqli_real_escape_string($conn,$_POST["Address"]);
	$how=mysqli_real_escape_string($conn,$_POST["how"]); //addition
	$when= mysqli_real_escape_string($conn,$_POST['p_date']);
	$sql = "INSERT INTO project_details (name,Mission, does, Address,Date,Target_Audience,how,Solutions) VALUES ('$name','$Mission', '$why', '$where','$when','$who','$how','$what')";
	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " .mysqli_error($conn);  
	}
	// addition of columns to last inserted projects.
	$latest_projects="SELECT id FROM project_details  
	ORDER BY id DESC  
	LIMIT 1 ";
	$result=mysqli_query($conn,$latest_projects);
	foreach($result as $value){
		$selected_id=$value['id'];
		$insert_table="INSERT INTO table_info (project_id,rows,description,objectively,sources,Assumptions) VALUES ('$selected_id','Goal','','','','') , ('$selected_id','Purpose','','','','') , ('$selected_id','Outputs','','','','') , ('$selected_id','Activites','','','','')";
			if (mysqli_query($conn, $insert_table)) {
				//echo "New record created successfully";
			} else {
				echo "Error: " .mysqli_error($conn);  
			}
	}
	// end of addition of last inserted records.
	mysqli_close($conn);
	header("location:display.php");
?>

