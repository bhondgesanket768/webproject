
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
<div>
            <?php 
                session_start();
				$conn=mysqli_connect("localhost","root","","testing");
				if(!$conn){
					echo "database is not connected";
                }
                $id=$_SESSION['mem_id'];
				$rough="SELECT Target_Audience,Solutions,does,Date,Address,how FROM project_details WHERE id='$id' ";		
				$rough_plan_data=mysqli_query($conn,$rough);
				$rough_data_fetch=mysqli_fetch_assoc($rough_plan_data);
			?>
            <div align="center">
			<h2> Rough Plan</h2>
            </div>
            <hr>
            <br>
            <div align="right">
			<button type="button" class="btn btn-primary" onClick="location.href='rough_plan_popup_page'">Edit</button>
			<!-- popup button -->
			<!--
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            Make a Rough Plan
            </button>  -->
 			<!-- popup button -->
            </div>
            <div class="modal fade" id="myModal">
            <div class="modal-dialog">
            <div class="modal-content">

      <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Rough plan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

      <!-- Modal body -->
            <div class="modal-body">
            
			<form class="modal-content animate" method="POST" action="roughplan.php" >
			<div align="center"><h3> Answer this simple question first.... </h3></div><br/>
				<div class="container" align="left">
					<label><b>1. what are your targeted Audiences ? </b></label><br>
					<textarea name="target_audiences" cols="30" rows="3" required="required"></textarea><br/><br/>
					<label><b>2. what are your problems ? </b></label><br>
					<textarea name="problems" cols="30" rows="3" required="required"></textarea><br/><br/>
					<label><b>3. write your solutions for the problems ? </b></label><br>
					<textarea name="solutions" cols="30" rows="3" required="required"></textarea><br/><br/>
					<label><b>4. why ? </b></label><br>
					<textarea name="why" cols="30" rows="3" required="required"></textarea><br/><br/>
					<br>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="submit" value="submit answers">Submit</button>
                    </div>
					<br>
				</div>
			</form>
            </div>
    </div>
  </div>
</div>
            <br><br><br><br><br>
            <div align="center">
			<div style="display:inline;">
			<div class="circle-text" >
                <h5> why ? </h5>
                
				<p><?php echo $rough_data_fetch['does'] ?></p>
			</div>
				&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
				
				<ul class='loading-frame'>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
					<div class='circle'></div>
				</ul>
				&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
			<div class="circle-text1" >
				<h5> who? </h5>
				<p> <?php echo $rough_data_fetch['Target_Audience'] ?> </p>
			</div>
			</div>

			<br><br><br><br>
			<div style="display:inline;">
			<div class="circle-text2" >
				<h5> what? </h5>
				<p> <?php echo $rough_data_fetch['Solutions'] ?> </p>
			</div>
			&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
				
				<ul class='loading-frame1'>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
					<div class='circle1'></div>
				</ul>
			&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
			<div class="circle-text3" >
				<h5> Where?  </h5>
				<p> <?php echo $rough_data_fetch['Address'] ?> </p>
			</div>
			</div>
			<br><br><br><br>
			<div style="display:inline;">
			<div class="circle-text4" >
				<h5> how? </h5>
				<p> <?php echo $rough_data_fetch['how'] ?> </p>
			</div>
			&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
				
				<ul class='loading-frame2'>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
					<div class='circle2'></div>
				</ul>
			&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
			<div class="circle-text5" >
				<h5> When?  </h5>
				<p> <?php echo $rough_data_fetch['Date'] ?> </p>
			</div>
			</div>
		</div>
        </div>
</body>
</html>
