<?php 
session_start();
$conn=mysqli_connect("localhost","root","","testing");
if(!$conn){
    die('could not connect:'.mysqli_error());
}
$arr1=json_decode($_POST['myarr']);
//$arr1=$_POST['myarr'];
//var_dump($arr1);
$aee=$arr1[0];
//print_r($arr1);
//echo (sizeof($arr1));
$sql="UPDATE set to_do_list status='completed' where id='$aee' ";
    if(mysqli_query($conn,$sql)){
    echo "successful";
 /*   
foreach($arr1 as $row){
    echo "$row \n";
    $sql="UPDATE set to_do_list status='completed' where id='$row' ";
    if(mysqli_query($conn,$sql)){
    echo "successful";
}*/
}


?>