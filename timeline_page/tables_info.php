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
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Table_Info</title>
        <link rel="stylesheet" href="css/styletable.css" />
        <script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div align="center"><h1> information </h1></div>
        <div class="table-responsive">
            <table border="1" class="table" style="width:100%;">
                <tr>
                    <th width="20%" scope="col">Rows</th>
                    <th width="20%" scope="col">Description</th>
                    <th width="20%" scope="col">Objective</th>
                    <th width="20%" scope="col">Sources</th>
                    <th width="20%" scope="col">Assumptions</th>
                </tr>
                <?php
                    $query="SELECT * FROM table_info WHERE project_id=$p_id ";
                    $result=mysqli_query($conn,$query);
                    $count=1;
                    while($row=mysqli_fetch_array($result)){
                        $col=$row['rows'];
                        $Description=$row['description'];
                        $objective=$row['objectively'];
                        $sources=$row['sources'];
                        $Assumptions=$row['Assumptions'];
                        ?>
                        <tr>
                            <td><b><?php echo $col; ?></b></td>
                            <td>
                                <div  style="overflow:auto; height: 100px;"  contentEditable="true" class="edit" id="description_<?php echo $col ?>">
                                    <?php echo $Description ?>
                                </div>
                            </td>
                            <td>
                                <div style=" overflow:auto; height: 100px;"  contentEditable="true" class="edit" id="objectively_<?php echo $col ?>">
                                    <?php echo $objective ?>
                                </div>
                            </td>
                            <td>
                                <div  style=" overflow:auto; height: 100px;"  contentEditable="true" class="edit" id="sources_<?php echo $col ?>">
                                    <?php echo $sources ?>
                                </div>
                            </td>
                            <td>
                                <div  style=" overflow:auto; height: 100px;"  contentEditable="true" class="edit" id="Assumptions_<?php echo $col ?>">
                                    <?php echo $Assumptions ?>
                                </div>
                            </td>
                        </tr>
                        <?php 
                    }
                ?>
            <table>
        </div>
    </body>
</html> 
<script>
    $(document).ready(function(){

        $('.edit').click(function(){
            $(this).addClass('editMode');
        });
        $(".edit").focusout(function(){
            $(this).removeClass("editMode");
            var col = this.id;
            var split_rows = col.split("_");
            var edit_name = split_rows[0];
            var edit_id = split_rows[1];
            console.log(col);
            console.log(split_rows);
            console.log(edit_name);
            console.log(edit_id);

            var value = $(this).text();

            $.ajax({
                url:"table_update.php",
                type: "post",
                data:{ field:edit_name, value:value, col_id:edit_id },
                success:function(response){
                    console.log("save successfully");
                }
            });
        });
    });
</script>


