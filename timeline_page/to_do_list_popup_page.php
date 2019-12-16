<?php
	session_start();
	$conn=mysqli_connect("localhost","root","","testing");
	if(!$conn){
		die("could not connect:".mysqli_error());
	}
	$idp=$_SESSION['mem_id'];
	$sql="SELECT m_name from member where p_id='$idp' ";
	$query=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div align="center"><h1>Add your task </h1><div>
<hr>
<div class="modal-body">
      <form class="modal-content animate" method="POST" action="to_do_update" >
				<br>
				<div class="container" align="center">
				<!-- addition -->
					<label><b>Task Name:</b></label>
					<input type="text" name="task_name" required><br>
					<label><b>Task Lead:</b></label>
					<select name="leader" required>
						<option value="none">none</option>
						<?php
							foreach($query as $rows){
								?>
									<option value="<?php echo $rows['m_name'] ?>"><?php echo $rows['m_name'] ?></option>
								<?php
							}
						?>
					</select><br>
					<label><b>Start Date:</b></label>
					<input type="date" name="expected_date1" required>
          <br>
		  <label><b>End date:</b></label>
		  <input type="date" name="deadline" required>
		  <br>
          <label><b>Description:</b></label>
          <textarea name="remarks" cols="20" rows="1" required></textarea>
					<br>
          <div class="modal-footer">
        <button type="submit" class="btn btn-success" value="ADD" name="submit">Add</button>
        </div>
					<br>
				</div>
			</form>
      </div>
</body>
</html>