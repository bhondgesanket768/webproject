<?php
	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: '.mysqli_error());
	}
	$query = "SELECT * FROM project_details";
	$stmt= mysqli_query($conn,$query);
	if(mysqli_num_rows($stmt) > 0){
		
?>
<html>
    <head>
        <title>Display Project</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		</head>
    <body>
<div class="container" align="center">
			<div><br />
			</div>
			<div><button onclick="document.getElementById('abcd').style.display='block'" style="width: auto;">+ Create Project</button><br /><br /></div>
			<div id="abcd" class="modal">

				<form class="modal-content animate" action="insertintodb.php" method="POST">
					<div class="closecontainer">
						<span onclick="document.getElementById('abcd').style.display='none'" class="close" title="Close">&times;</span>
					</div>
					<div><h3>Add your project details here</h3></div>
					<div class="container">
						<label><b>Mission/Vision:</b></label>
							<input type="text" placeholder="Mission/Vision" name="Mission" required>
							<br />
						<label><b>What we do:</b></label>
							<input type="text" placeholder="what we do" name="does" required>
							<br />
						<label><b>Address:</b></label>
							<input type="text" placeholder="Address" name="Address" required>
							<br />
							<input type="submit" value="Add Project" name="submit">
							<br />
					</div>
				</form>
			</div>
		</div>
</body>
</html>
<?php
		while($result=mysqli_fetch_assoc($stmt)){
			echo "&ensp;";
			echo "<a href='index.php?in=$result[id]'><button>Project ".$result['id']."</button></a>";
		}
	}
	else{
		echo "No records.";
	}
	mysqli_close($conn);
?>

