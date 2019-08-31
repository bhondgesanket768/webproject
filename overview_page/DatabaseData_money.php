<?php
session_start();
header('Content-Type: application/json');

$arr1=$_SESSION['myarray'];

$con = mysqli_connect("localhost","root","","testing");

// Check connection
if (mysqli_connect_error($con))
{
    echo "Failed to connect to Database: " . mysqli_connect_error();
}else
{   
    $data_points = array();
  //  $query = "SELECT projectid,Date,money,revenue FROM timeline order by projectid";
   $query = "SELECT projectid,Date,money FROM timeline WHERE projectid in (".implode(',', $arr1).") ";
 //  $query = "SELECT projectid,Date,money,revenue FROM timeline WHERE projectid in (5,6,7) ";
    $result = mysqli_query($con,$query);
    
    while($row = mysqli_fetch_array($result))
    {        
        $point = array("x_p" => $row['Date'] , "y_p" =>  $row['money'],"ids"=> $row['projectid']);

        array_push($data_points, $point);        
    }
    
    echo json_encode($data_points, JSON_NUMERIC_CHECK);
    
}
mysqli_close($con);

?>