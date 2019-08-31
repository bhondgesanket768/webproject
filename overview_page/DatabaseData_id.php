<?php
session_start();
header('Content-Type: application/json');

$con = mysqli_connect("localhost","root","","testing");

$arr1=$_SESSION['myarray'];

// Check connection
if (mysqli_connect_error($con))
{
    echo "Failed to connect to Database: " . mysqli_connect_error();
}else
{   //$data=array();
    $projects_points = array();
  //  $query = "SELECT id FROM project_details order by id";
    $query = "SELECT id FROM project_details WHERE id in (".implode(',', $arr1).")";
  // $query = "SELECT id FROM project_details WHERE id in (5,6,7)";
    $result = mysqli_query($con,$query);
    
    foreach($result as $sam){
        $projects_points[]=$sam;
    }
    
    echo json_encode($projects_points, JSON_NUMERIC_CHECK);
}
mysqli_close($con);

?>