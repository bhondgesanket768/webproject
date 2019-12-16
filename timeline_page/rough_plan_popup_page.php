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
<div class="modal-body">
            
			<form class="modal-content animate" method="POST" action="roughplan.php" >
			<div align="center"><h3> Answer this simple question first.... </h3></div><br/>
				<div class="container" align="center">
					<label><b>1. Why (Problem statement) ? </b></label><br>
					<textarea name="Problem_statement" cols="50" rows="4" required="required"></textarea><br/><br/>
					<label><b>2. Who (Targeted Audiences) ? </b></label><br>
					<textarea name="target_audiences" cols="50" rows="4" required="required"></textarea><br/><br/>
					<label><b>3. What (Solutions) ? </b></label><br>
					<textarea name="solution" cols="50" rows="4" required="required"></textarea><br/><br/>
					<label><b>4. where (Location) ? </b></label><br>
					<textarea name="location" cols="50" rows="4" required="required"></textarea><br/><br/>
					<label><b>5. How (Approach) ? </b></label><br>
					<textarea name="approach" cols="50" rows="4" required="required"></textarea><br/><br/>
					<label><b>6. When (Time) ? </b></label><br>
					<input type="date" placeholder="Date" name="time" required><br/><br/>
					<br>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="submit" value="submit answers">Submit</button>
                    </div>
					<br>
				</div>
			</form>
            </div>
</body>
</html>