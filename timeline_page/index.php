<?php
	error_reporting(0);
	session_start();
	$id=$_GET['in'];
	$_SESSION['mem_id']=$id;
	$conn=mysqli_connect("localhost","root","","testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	$sql = "SELECT * FROM timeline WHERE projectid='$id'";
	$stmt=mysqli_query($conn, $sql);

	$notification="SELECT E_mail FROM member WHERE p_id='$id' ";
	$noti_query=mysqli_query($conn,$notification);

?>

<html>
    <head>
        <title>Timeline</title>
        <script src="js/jquery.js"></script>
        <script src="js/timeline.min.js"></script>
		<script defer src="js/script.js"></script>
		
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/timeline.min.css" />
    </head>
    <body>
		<div class="container" align="center">
			<div><br />
				<h4>Projects <?php  echo $id=$_GET['in']; ?> Details</h4>       
			</div>
			<div><button onclick="document.getElementById('abcd').style.display='block'" type="button" class="btn btn-info btn-lg">+ Create Project</button><br /></div>
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
				<!--   changes     -->			
						<label><b>Date:</b></label>
							<input type="date" placeholder="Date" name="p_date" required>
							<br />
				<!--   changes   -->
							<input type="submit" value="Add Project" name="submit">
							<br />
					</div>
				</form>
			</div>
		</div>
		<div>
		<?php
			$id=$_GET['in'];
			$conn=mysqli_connect("localhost","root","","testing");
        	if($conn){
           	// echo "connection established <br>";
        	}else{
            	die("connection failed.reason:".mysqli_connect_error());
        	}
			$sql1="SELECT * FROM project_details WHERE id='$id' ";
			$results=mysqli_query($conn,$sql1);
			$row=mysqli_fetch_array($results);
			echo "<b>Mission : </b>$row[Mission]<br> <b>Does : </b>$row[does]<br> <b>Address : </b>$row[Address] <br/>";

			mysqli_close($conn);
			?>
			</div>
			<div align="center">
			<?php 
				$conn=mysqli_connect("localhost","root","","testing");
				if(!$conn){
					echo "database is not connected";
				}
			$sql2="select SUM(money) as 'totalmoney' from timeline WHERE projectid='$id' " ;
			$sql3="select TIME(SUM(time)) as 'totaltime' from timeline WHERE projectid='$id' " ;
			$sql4="select SUM(impact) as 'totalimpact' from timeline WHERE projectid='$id' " ;
			$sql5="select SUM(revenue) as 'totalrevenue' from timeline WHERE projectid='$id' " ;
			$res=mysqli_query($conn,$sql2);
			$res1=mysqli_query($conn,$sql3);
			$res2=mysqli_query($conn,$sql4);
			$res3=mysqli_query($conn,$sql5);
			$total=mysqli_fetch_assoc($res);
			$total1=mysqli_fetch_assoc($res1);
			$total2=mysqli_fetch_assoc($res2);
			$total3=mysqli_fetch_assoc($res3);
			echo "<b>Total Money Spent : </b>".$total['totalmoney']."<br/>";
			echo "<b>Total Time : </b>".$total1['totaltime']."<br/>";
			echo "<b>Total impact:</b>".$total2['totalimpact']."<br/>";
			echo "<b>Total revenue generated:</b>".$total3['totalrevenue']."<br/>";
		?>
		</div>
	<br>
	<!-- linking the link of user -->
		<div align="center">
		<input id="link_by_admin" placeholder="add your link here"/>
		<button onclick="Get_link()" id="save">Save</button>
		</div>
		<br>
		<div align="center">
				<button  id="drive" class="btn btn-xl btn-success" onclick="func()">google drive</button>
		</div>
	<!-- end of link -->

	<!-- addition of two button  -->
		<br>
		<div align="right">
			<button class="btn btn-xl btn-primary" onClick="location.href='rough_plan.php' " >Rough Plan</button>
			<br><br>
			<button class="btn btn-xl btn-primary" onClick="location.href='to_do_page.php'">Task</button>
		</div>
	<!-- end of the code(addition of two buttons)  -->
		<div class="container"><br />
			<h3 align="center">Roadmap</h3><br />
	<!-- addition of diseable code -->		
			<?php 
			$conn=mysqli_connect("localhost","root","","testing");
			if(!$conn){
				echo "database is not connected";
			}
			$disable="SELECT genre FROM project_details WHERE id=$id";
			$disabled=mysqli_query($conn,$disable);
			foreach($disabled as $value){
				$comp=$value['genre'];
			}
			if($comp=="Completed"){
				?>
	<!--				<div align="center"><button onclick="document.getElementById('efgh').style.display='block'" type="button" class="btn btn-info btn-lg" disabled>+ Add Activity/Meeting</button></br></div> -->
					<div align="center"><h1><b>End of Project</b></h1></div>
				<?php 
			}else{
				?>
					<div align="center"><button onclick="document.getElementById('efgh').style.display='block'" type="button" class="btn btn-info btn-lg">+ Add Activity/Meeting</button></br></div>
					<button type="button" class="btn btn-primary btn-lg" onclick="document.getElementById('end_project').style.display='block' ">End Project</button>
				<?php 
			}
			?>
	<!-- end of code -->
			
	<!-- creation of end project popup  changes  -->
			<!-- Modal -->
			<div id="end_project" class="modal" align="center">
				<form class="modal-content animate" action = "project_status.php" method="POST">
				<div class="closecontainer">
						<span onclick="document.getElementById('end_project').style.display='none'" class="close" title="close modal">&times;</span>
					</div>
				<div>
					<p> Do you want to end this project</p>
				</div>
				<input type="submit" name="end_of_project" value="yes" />
				<input type="submit" name="continue_of_project" value="No" />
				</form>
			</div>


<!-- Modal -->

	<!-- end of popup  end of changes -->
	
			<div id="efgh" class="modal" align="center">
				<form class="modal-content animate" action = "insert2.php" method="POST" id="form1">
					<div class="closecontainer">
						<span onclick="document.getElementById('efgh').style.display='none'" class="close" title="close modal">&times;</span>
					</div>
					<div><h3> Add Activity/Meeting Details here</h3></div>
					<div class="container">
						<label><b>Project ID:</b></label>
							<input type="text" placeholder="projectid" name="projectid" value=<?php echo $_GET['in'] ?>>
							<br />
						<label><b>Activity/Meeting :</b></label>
							<input type="text" placeholder="Activity/Meeting" name="Activity" required>
							<br />
						<label><b>Date :</b></label>
							<input type="date" placeholder="date" name="Date" required>
							<br />
						<label><b>Location :</b></label>
							<input type="text" placeholder="Location" name="Location" required>
							<br />
						<label><b>type:</b></label>
							<input type="radio"  name="type" value="Activity">Activity
							<input type="radio"  name="type" value="Meeting">Meeting
							<input type="radio"  name="type" value="MileStone">MileStone
							<br />
							<input type="submit" value="Insert" name="submit" id="submit1">
							<br />
					</div>
				</form>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
                    <h3 class="panel-title">Our Journey</h3>
                </div>
				<div class="panel-body">
                	<div class="timeline">
                        <div class="timeline__wrap">
                            <div class="timeline__items">
								<?php
									if(mysqli_num_rows($stmt) > 0){
										while($row = mysqli_fetch_assoc($stmt)){
											$showID=$row['id'];
											$showActivity=$row['Activity'];
											$showDate=$row['Date'];
											$showLocation=$row['Location'];
											$showpid=$row['projectid'];
							
								?>
								<div class="timeline__item">
									<div class="timeline__content">
                                    	<h2><?php echo $showActivity; ?></h2>
                                    	<p><?php echo $showLocation; ?></p>
										<p><?php echo $showDate; ?></p>
					<!--  edit button end code  -->
					<?php 
							$conn=mysqli_connect("localhost","root","","testing");
							if(!$conn){
								echo "database is not connected";
							}
							$disable="SELECT genre FROM project_details WHERE id=$id";
							$disabled=mysqli_query($conn,$disable);
							foreach($disabled as $value){
								$comp=$value['genre'];
							}
							if($comp=="Completed"){
								?>
				
								<?php 
							}else{
								?>
								<div><button onclick="centeredPopup('updateintodb.php?eid=<?php echo $showID;?>&eActivity=<?php echo $showActivity;?>&eDate=<?php echo $showDate;?>&eLocation=<?php echo $showLocation;?>','myWindow','600','400','yes');return false" type="button" class="btn btn-info btn-lg">Edit</button></div><br />
								<?php 
							}
					?>
					<!-- end of edit button code -->
									
										<div><button onclick="centeredPopup('show.php?eid=<?php echo $showID;?>','myWindow','600','400','yes');return false" type="button" class="btn btn-info btn-lg">Read more</button></div>
									</div>
								</div>
								<?php
										}
									}
									else{
										echo "0 results";
									}
									mysqli_close($conn);
								?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
    </body>  
</html>
<script>
	$(document).ready(function(){
		jQuery('.timeline').timeline();
	});
</script>
<script language="javascript">
	var popupWindow = null;
	function centeredPopup(url,winName,w,h,scroll){
		LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
		popupWindow = window.open(url,winName,settings)
	}
</script>
<script type="text/javascript"> 
// https://drive.google.com/open?id=1T9-80c9LOF6Ta47k90dAF_GvA448Zl5r
var anchor;
var str;
var dy;
	function Get_link(){
		 dy=document.getElementById("drive");
		 str = document.getElementById("link_by_admin").value;
	}
	function func(){
		anchor=document.createElement('a');
		dy.appendChild(anchor);
		anchor.href=window.open(str);
	}
</script>
