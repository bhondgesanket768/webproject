<?php
    session_start();
    $host = "localhost"; /* Host name */
    $user = "root"; /* User */
    $password = ""; /* Password */
    $dbname = "testing"; /* Database name */
    
    $conn = mysqli_connect($host, $user, $password,$dbname);
    // Check connection
    if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
    }
    $p_id=$_SESSION['mem_id'];
    $field= $_POST['field'];
    $value= $_POST['value'];
    $edit_id=$_POST['col_id'];
//    echo $field;
//    echo $value;
//    echo $edit_id;
//    echo $p_id;

    $query="UPDATE table_info SET ".$field."='".$value."' WHERE rows='".$edit_id."' AND project_id=$p_id " ;

    mysqli_query($conn,$query);
?>
