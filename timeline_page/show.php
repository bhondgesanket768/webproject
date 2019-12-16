<?php
	$conn=mysqli_connect("localhost","root","","testing");
    if(!$conn){
        die("connection failed.reason:".mysqli_connect_error());
    }
	$eventid=$_GET['eid'];
	$sql="SELECT * FROM timeline WHERE timeline.id='$eventid' ";
	$results=mysqli_query($conn,$sql);
	$row=mysqli_fetch_array($results);	
	echo '<b>Project ID: </b>'.$row['projectid'].'<br />';
	echo '<b>Event ID: </b>'.$row['id'].'<br />';
	echo '<b>Activity: </b>'.$row['Activity'].'<br />';
	echo '<b>Date: </b>'.$row['Date'].'<br />';
	echo '<b>Activity_time</b>'.$row['Activity_time'].'<br />';
	echo '<b>Location: </b>'.$row['Location'].'<br />';
	echo '<b>Attendance: </b>'.$row['Attendance'].'<br />';
	echo '<b>Time Spent: </b>'.$row['time'].'<br />';
	echo '<b>People Impacted: </b>'.$row['impact'].'<br />';
	echo '<b>Money Spent: </b>'.$row['money'].'<br />';
	echo '<b>Revenue Generated: </b>'.$row['revenue'].'<br />';
	echo '<b>Note: </b>'.$row['note'].'<br />';
    mysqli_close($conn);
?>
