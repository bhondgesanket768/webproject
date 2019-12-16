<?php
    session_start();
    error_reporting(0);
    $conn=mysqli_connect("localhost","root","","testing");
    if(!$conn){
        die('could not connect:'.mysqli_error());
    }
    $idp=$_SESSION['mem_id'];
    $query="SELECT * FROM to_do_list WHERE projectid='$idp' ORDER BY dates ASC";
    $to_do_fetch=mysqli_query($conn,$query);
    $check=mysqli_num_rows($to_do_fetch);

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.column {
  float: left;
  width: 25%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}
</style>
</head>
<body>

<div align="center"><h2>Your TO-DO List</h2></div>

<br>
<div align="center" style="">
        Activity : <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="25" width="25" > 
        &nbsp &nbsp &nbsp 
        Meeting : <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="25" width="25" > 
        &nbsp  &nbsp  &nbsp  
        MileStone :<img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="25" width="25" > 
    </div>
<!--
<div align="right">
  <button class="btn btn-xl btn-primary" onclick="document.getElementById('view_rough_plan').style.display='block'" type="button"></button>
</div> -->
<!-- bootstrap model -->
<br>
<div align="right">
<button type="button" class="btn btn-primary" onClick="location.href='to_do_list_popup_page.php'">Add Task</button>
<!-- popup button  -->
<!--
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Add Task
</button>  -->
<!-- popup button -->
</div>
<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add your Task</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form  method="POST" action="to_do_update" >
				<div class="container" align="center">
					<label><b>Date1:</b></label>
					<input type="date" name="expected_date1">
					<select name="type1">
						<option value="activity">Activity</option>
						<option value="meeting">Meeting</option>
						<option value="milestone">MileStone</option>
					</select>
          <br>
          <label><b> Subject :</b></label>
          <textarea name="subject_1" cols="20" rows="1"></textarea>
					<br>
          <hr>
					<label><b>Date2:</b></label>
					<input type="date" name="expected_date2">
					<select name="type2">
						<option value="activity">Activity</option>
						<option value="meeting">Meeting</option>
						<option value="milestone">MileStone</option>
					</select>
					<br>
          <label><b> Subject :</b></label>
          <textarea name="subject_2" cols="20" rows="1"></textarea>
					<br>
          <hr>
					<label><b>Date3:</b></label>
					<input type="date" name="expected_date3">
					<select name="type3">
						<option value="activity">Activity</option>
						<option value="meeting">Meeting</option>
						<option value="milestone">MileStone</option>
					</select>
          <br>
          <label><b> Subject :</b></label>
          <textarea name="subject_3" cols="20" rows="1"></textarea>
					<br>
          <div class="modal-footer">
        <button type="submit" class="btn btn-success" value="ADD" name="submit">Add</button>
        </div>
					<br>
				</div>
			</form>
      </div>
    </div>
  </div>
</div>

<!-- end of bootstrap model -->

<!-- 
  START OF MODAL
  -->
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Do you really want to mark this task as complete ?
      </div>
      <form method="POST" action="complete_task_popup.php">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- END  -->  

<br><br>
<div class="row">
<?php 
    if($check){
      foreach($to_do_fetch as $data){
        ?>
            <div class="column">
            <i class="fa fa-long-arrow-right" style="font-size:36px; display:flex;"></i>
            <div class="card">
            <?php 
                if($data['plan']=="Activity"){
                    ?>
                    <div align="center">
                     <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="25" width="25" >
                    </div>
                    <?php 
                }else if($data['plan']=="MileStone"){
                    ?>
                    <div align="center">
                     <img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="25" width="25" >
                    </div>
                    <?php 
                }else{
                    ?>
                    <div align="center">
                     <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="25" width="25" >
                    </div>
                    <?php 
                }
            ?>
            <br>
            <p><b>Task Name: </b><?php echo $data['Subject']?></p>
            <p><b>Description: </b><?php echo $data['remarks'] ?>
            <p><b>Start Date: </b><?php echo $data['dates'] ?></p>
            <p><b>Responsible person: </b><?php echo $data['leader'] ?></p>
            <p><b>End Date: </b><?php echo $data['deadline'] ?></p>
            <?php
              $present_date = date('Y-m-d');
              $present_date=date('Y-m-d', strtotime($present_date));

              $DateBegin = date('Y-m-d', strtotime($data['dates']));
              $DateEnd = date('Y-m-d', strtotime($data['deadline']));
              if($data['status']=="added"){
                if($present_date<$DateBegin){
                  ?>
                  <div align="right"><button  class="btn btn-warning"><?php echo "Yet to start...." ?></button></div>
                  <?php 
                }elseif(($DateBegin<=$present_date) && ($present_date <= $DateEnd)){
                  ?>
                        <button type="button" id="<?php echo $data['id'] ?>" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        <?php $tbutton_id=$data['id']; ?>
                         Task in progress
                        </button>
                  <?php 
                }else{
                  ?>
                    <div align="right"><button  class="btn btn-warning" name="<?php echo $data['id'] ?>" ><?php echo "period over" ?></button></div>  
                  <?php 
                }
              }
              
              elseif($data['status']=="completed"){
                ?>
                <div align="right"><button id="" class="btn btn-success" name="<?php echo $data['id'] ?>" ><?php echo "completed" ?></button></div>
                <?php 
              }
               $_SESSION['but_id']=$tbutton_id; 
            ?>
            </div>
            </div>
        <?php
        }
    }else{
      echo "Nothing is in the to-do list....";
    }
?>
  
</div>
</body>
</html>
