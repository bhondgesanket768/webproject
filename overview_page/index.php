<?php
error_reporting(0);
require 'connect2.php';
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>horizontal timeline</title>

<link rel="stylesheet" type="text/css" href="styles.css" />


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

 <script type="text/javascript" src="script2.js"></script> 

</head>

<body>
<?php 
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "testing";
   
   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   } 
//   $project_query="SELECT projectid FROM timeline group by projectid DESC";
    $project_query="SELECT id FROM project_details order by Date DESC";
   $data=mysqli_query($conn,$project_query);
?>

<div id="main">
	<h1>Road Map</h1>
    <div align="right" style="padding: 12px;">
    <input type=button class="btn btn-xl btn-success"  onClick="location.href='index.php'" value='Timeline'>
    <input type=button class="btn btn-xl btn-success"  onClick="location.href='chart.php'" value='Chart'>
    <div align="center" style="">
        Activity : <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="25" width="25" > 
        &nbsp 
        Meeting : <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="25" width="25" > 
        &nbsp  
        MileStone :<img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="25" width="25" > 
    </div>
    </div>
    <div class="select_genere">
    <form method="POST" action="">
    <b>Choose Genre:</b>
    <select name="genre" onchange="myfunc(this.value)">
         <option value="All" <?php echo $_POST['genre']=="All" ? "selected" : "" ?>>All</option>
        <option value="On Going" <?php echo $_POST['genre']=="On Going" ? "selected" : "" ?>>On Going</option>
        <option value="Completed" <?php echo $_POST['genre']=="Completed" ? "selected" : "" ?>>Completed</option>
    <!--    <option value="Completed" selected>Completed</option>  -->
    </select>
    <input type="submit" name="submit_filter" value="submit"/>
    </form>
    </div>
    <!-- LOGIC OF FILTER -->

    <!-- -->
        <div id="dataget">
        </div>
        <script type="text/javascript">
            function myfunc(datavalue){
                $.ajax({
                    url: 'ajax_timeline.php',
                    type: 'post',
                    data:{datapost: datavalue},

                    success: function(result){
                        $('#dataget').html(result);
                    }
                });
            };
        </script>
    <!-- -->
    
    <?php 
        $submit_filter=mysqli_real_escape_string($conn,$_POST['submit_filter']);
        if(isset($submit_filter)){
            if($_POST['genre']=='Completed'){
                $completed=$_POST['genre'];
                $completed_query="SELECT id from project_details where genre='$completed' order by Date DESC ";
                $c_data=mysqli_query($conn,$completed_query);
                foreach($c_data as $roo){
                    $idn= $roo['id'];
                    ?>
                        <div id="timelineLimiter"> <!-- Hides the overflowing timelineScroll div -->
            <br>
            <div align="center" sytle="margin: 0px 0px auto;"><h1><b><?php echo "project".$roo['id']; ?></b></h1></div>
            <div id="horizontal_scroll" style="overflow:auto;width:1690px; height:210px; overflow-x:scroll; overflow-y:hidden;">
            <div id="timelineScroll"  class="faltu"> <!-- Contains the timeline and expands to fit -->
                <?php
                // We first select all the events from the database ordered by date:
                $dates = array();
                $query2="SELECT * FROM timeline WHERE projectid=$idn";
                $res=mysqli_query($conn,$query2);
               // $res = mysql_query("SELECT * FROM timeline ORDER BY Date ASC");

                while($row=mysqli_fetch_assoc($res))
                {
                    // Store the events in an array, grouped by years:
                    $dates[date('M/Y',strtotime($row['Date']))][] = $row;
                }

                $colors = array('green','blue','chreme');
                $scrollPoints = '';

                $i=0;
                foreach($dates as $year=>$array)
                {
                    // Loop through the years:
                    echo '
                    <div class="event">
                        <div class="eventHeading '.$colors[$i++%3].'">'.$year.'</div>
                        <ul class="eventList">
                        ';
                    ?>
                        <div class="vertical_scroll" id="vertical_scroll" style="width:310px; height:138px; overflow: auto;">
                        <?php
                    foreach($array as $event)
                    {
                        // Loop through the events in the current year:
                        $tet= $event['type'];
                        if($tet=="Activity"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                        }
                        elseif($tet=="Meeting"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
  
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                            
                        }else{

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';    
                        }   
                    }
                    ?>
                        </div>
                    <?php
                    echo '</ul></div>';   
                }
                ?>
                <br>
        <div class="clear"></div>
            </div>
            <br>
            </div>
    </div>
                    <?php
                }
            //    echo "compleated projects are selected";
            }else if($_POST['genre']=='On Going'){
                $on_going=$_POST['genre'];
                $going_query="SELECT id  from project_details  where genre='$on_going' order by Date DESC ";
                $g_data=mysqli_query($conn,$going_query);
                foreach($g_data as $goo){
                    $idn=$goo['id'];
                    ?>
                        <div id="timelineLimiter"> <!-- Hides the overflowing timelineScroll div -->
            <br>
            <div align="center" sytle="margin: 0px 0px auto;"><h1><b><?php echo "project".$goo['id']; ?></b></h1></div>
            <div id="horizontal_scroll" style="overflow:auto;width:1690px; height:210px; overflow-x:scroll; overflow-y:hidden;">
            <div id="timelineScroll"  class="faltu"> <!-- Contains the timeline and expands to fit -->
                <?php
                // We first select all the events from the database ordered by date:
                $dates = array();
                $query2="SELECT * FROM timeline WHERE projectid=$idn";
                $res=mysqli_query($conn,$query2);
               // $res = mysql_query("SELECT * FROM timeline ORDER BY Date ASC");

                while($row=mysqli_fetch_assoc($res))
                {
                    // Store the events in an array, grouped by years:
                    $dates[date('M/Y',strtotime($row['Date']))][] = $row;
                }

                $colors = array('green','blue','chreme');
                $scrollPoints = '';

                $i=0;
                foreach($dates as $year=>$array)
                {
                    // Loop through the years:
                    echo '
                    <div class="event">
                        <div class="eventHeading '.$colors[$i++%3].'">'.$year.'</div>
                        <ul class="eventList">
                        ';
                    ?>
                        <div class="vertical_scroll" id="vertical_scroll" style="width:310px; height:138px; overflow: auto;">
                        <?php
                    foreach($array as $event)
                    {
                        // Loop through the events in the current year:
                        $tet= $event['type'];
                        if($tet=="Activity"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                        }
                        elseif($tet=="Meeting"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
  
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                            
                        }else{

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';    
                        }   
                    }
                    ?>
                        </div>
                    <?php
                    echo '</ul></div>';   
                }
                ?>
                <br>
        <div class="clear"></div>
            </div>
            <br>
            </div>
    </div>
                    <?php 
                }
            //    echo "on_going projects are selected";
            }else{
                foreach($data as $pow){
                    $idn=$pow['id'];
                    ?>
                         <div id="timelineLimiter"> <!-- Hides the overflowing timelineScroll div -->
            <br>
            <div align="center" sytle="margin: 0px 0px auto;"><h1><b><?php echo "project".$pow['id']; ?></b></h1></div>
            <div id="horizontal_scroll" style="overflow:auto;width:1690px; height:210px; overflow-x:scroll; overflow-y:hidden;">
            <div id="timelineScroll"  class="faltu"> <!-- Contains the timeline and expands to fit -->
                <?php
                // We first select all the events from the database ordered by date:
                $dates = array();
                $query2="SELECT * FROM timeline WHERE projectid=$idn";
                $res=mysqli_query($conn,$query2);
               // $res = mysql_query("SELECT * FROM timeline ORDER BY Date ASC");

                while($row=mysqli_fetch_assoc($res))
                {
                    // Store the events in an array, grouped by years:
                    $dates[date('M/Y',strtotime($row['Date']))][] = $row;
                }

                $colors = array('green','blue','chreme');
                $scrollPoints = '';

                $i=0;
                foreach($dates as $year=>$array)
                {
                    // Loop through the years:
                    echo '
                    <div class="event">
                        <div class="eventHeading '.$colors[$i++%3].'">'.$year.'</div>
                        <ul class="eventList">
                        ';
                    ?>
                        <div class="vertical_scroll" id="vertical_scroll" style="width:310px; height:138px; overflow: auto;">
                        <?php
                    foreach($array as $event)
                    {
                        // Loop through the events in the current year:
                        $tet= $event['type'];
                        if($tet=="Activity"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                        }
                        elseif($tet=="Meeting"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
  
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                            
                        }else{

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';    
                        }   
                    }
                    ?>
                        </div>
                    <?php
                    echo '</ul></div>';   
                }
                ?>
                <br>
        <div class="clear"></div>
            </div>
            <br>
            </div>
    </div>
                    <?php 
                }
            }
        }else{
            foreach($data as $pow){
                $idn=$pow['id']; 
                ?>
                                <div id="timelineLimiter"> <!-- Hides the overflowing timelineScroll div -->
            <br>
            <div align="center" sytle="margin: 0px 0px auto;"><h1><b><?php echo "project".$pow['id']; ?></b></h1></div>
            <div id="horizontal_scroll" style="overflow:auto;width:1690px; height:210px; overflow-x:scroll; overflow-y:hidden;">
            <div id="timelineScroll"  class="faltu"> <!-- Contains the timeline and expands to fit -->
                <?php
                // We first select all the events from the database ordered by date:
                $dates = array();
                $query2="SELECT * FROM timeline WHERE projectid=$idn";
                $res=mysqli_query($conn,$query2);
               // $res = mysql_query("SELECT * FROM timeline ORDER BY Date ASC");

                while($row=mysqli_fetch_assoc($res))
                {
                    // Store the events in an array, grouped by years:
                    $dates[date('M/Y',strtotime($row['Date']))][] = $row;
                }

                $colors = array('green','blue','chreme');
                $scrollPoints = '';

                $i=0;
                foreach($dates as $year=>$array)
                {
                    // Loop through the years:
                    echo '
                    <div class="event">
                        <div class="eventHeading '.$colors[$i++%3].'">'.$year.'</div>
                        <ul class="eventList">
                        ';
                    ?>
                        <div class="vertical_scroll" id="vertical_scroll" style="width:310px; height:138px; overflow: auto;">
                        <?php
                    foreach($array as $event)
                    {
                        // Loop through the events in the current year:
                        $tet= $event['type'];
                        if($tet=="Activity"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/975/975392.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                        }
                        elseif($tet=="Meeting"){

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/584/584504.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
  
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';
                            
                        }else{

                            echo '<li class="">
                        <img src="https://image.flaticon.com/icons/svg/1021/1021081.svg" height="15" width="15"> 
                         <span class="icon" title="'.ucfirst($event['type']).'"></span>
                        '.htmlspecialchars($event['Activity']).'
                    
                        <div class="content" >
                            <div class="body">'.nl2br($event['note']).'<br>'.nl2br($event['Location']).'</div>
                            <div class="title">'.htmlspecialchars($event['Activity']).'</div>
                            <div class="date">'.date("F j, Y",strtotime($event['Date'])).'</div>
                        </div>
                        
                        </li>';    
                        }   
                    }
                    ?>
                        </div>
                    <?php
                    echo '</ul></div>';   
                }
                ?>
                <br>
        <div class="clear"></div>
            </div>
            <br>
            </div>
    </div>  
                <?php
            }
        }
    ?>

</div>

</body>
</html>

