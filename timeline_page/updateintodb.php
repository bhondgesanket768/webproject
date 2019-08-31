<?php
	session_start();
	$conn = mysqli_connect("localhost", "root", "","testing");  
	if(!$conn){  
		die('Could not connect: '.mysqli_connect_error());  
	}
// take the projectid changes.....
    $p_id=$_SESSION['mem_id'];
?>
<html>
	<head></head>
	<body>
		<form  action="" method="GET">
			<div align="center"><h3> Add further details</h3></div>
			<label><b>Event id :</b></label>
                <input type="text" placeholder="Activity/Meeting" name="eid" value=<?php echo $_GET['eid']; ?>><br />
			<label><b>Activity/Meeting :</b></label>
			   <input type="text" placeholder="Activity/Meeting" name="eActivity" value=<?php echo $_GET['eActivity'];?>><br />
			<label><b>Date :</b></label>
				<input type="date" placeholder="date" name="eDate" value=<?php echo $_GET['eDate']; ?>><br />
			<label><b>Location :</b></label>
				<input type="text" placeholder="Location" name="eLocation" value=<?php echo $_GET['eLocation']; ?>><br />
			<!-- changes  -->
			<?php 
				$att="SELECT m_name FROM member WHERE p_id='$p_id' ";
				$que=mysqli_query($conn,$att);
			?>
			<label><b>Attended people list :</b></label>
				<?php 
					while($ppl=mysqli_fetch_array($que)){
						?>
							<input type="checkbox" name="Attendance[]" value="<?php echo $ppl['m_name'] ?>"/><?php echo $ppl['m_name'] ?>
						<?php 
					}
				?>
			<br>
			<!-- changes -->
			<label><b>Time spent:</b></label>
				<input type="time" placeholder="time spent" name="time" required><br />
			<label><b>People Impacted:</b></label>
				<input type="text" placeholder="people Impacted" name="impact" required><br />
			<label><b>Money Spent:</b></label>
				<input type="text" placeholder="money spent" name="money" required><br />
				<label><b>revenue generated:</b></label>
				<input type="text" placeholder="revenue generated" name="revenue" required><br />
			<label><b>Note:</b></label>
				<input type="text" placeholder="Note" name="note" required><br />
				<input type="submit"  name="submit" value="Update">
        </form>
        <?php
			if(isset($_GET['submit'])){
				$id=$_GET["eid"];
                $Activity=$_GET["eActivity"];
                $Date=$_GET["eDate"];
                $Location=$_GET["eLocation"];
                $Attendance=$_GET["Attendance"];
                $time=$_GET["time"];
                $impact=$_GET["impact"];
				$money=$_GET["money"];
				$revenue=$_GET["revenue"];
				$note=$_GET["note"];
				// imploding the array value
				$string=implode(',',$Attendance);
				$query= "UPDATE timeline SET Activity='$Activity', Date='$Date', Location='$Location', Attendance='$string', time='$time', impact='$impact', money='$money',revenue='$revenue',note='$note' WHERE timeline.id='$id'";
                if(mysqli_query($conn,$query)){
					echo "<b>Record Updated Successfully.</b>";
                }
				else{
					echo "not updated";
                }
				mysqli_close($conn);
			}
			else{
				echo "Click Update to update the info.";
            }
        ?>
	</body>
</html>