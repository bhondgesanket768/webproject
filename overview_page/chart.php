<?php 
    session_start();
    include("connect.php");
    error_reporting(0);
  //  include("connect1.php");
    $query="SELECT projectid, sum(money) FROM timeline group by projectid";
    $query1="SELECT projectid, sum(impact) FROM timeline group by projectid";
    $query2="SELECT projectid, sum(time) FROM timeline group by projectid";
    $query3="SELECT projectid FROM timeline group by projectid";
    $query4="SELECT projectid, sum(revenue) FROM timeline group by projectid";

    $res=$conn->query($query);
    $res1=$conn->query($query1);
    $res2=$conn->query($query2);
    $res3=$conn->query($query3);
    $res4=$conn->query($query4);

?>

<html>
  <head>
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto" >

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" 
rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" 
crossorigin="anonymous">

  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script> var count=0;</script>
  </head>
  <body>
    <div align="center"><h1><b>Overview</b></h1></div>
    <hr>
    <div align="right" style="padding: 12px;">
    <input type=button   onClick="location.href='ajax_index.php'" value='Timeline'>
    <input type=button   onClick="location.href='chart.php'" value='Chart'>
    </div>

    <div id="project-details">
      <h4 align="center">Info</h4> 
        <table align="center" border="4px;" id="info">
        <tr>
          <th>Projects</th>
          <th>Members</th>
          <th>Time spent</th>
          <th>Ppl Impacted</th>
          <th>Money Spent</th>
    </tr>
    <?php 
      foreach($res3 as $pow){
        $idn=$pow['projectid'];
        ?>
        <script type="text/javascript">
            count++;
        </script>
        <tr>
          <td align="center">Project<?php echo $pow['projectid'] ?></td>
          <td></td>
          <td align="center">
            <?php 
                $sumtime="SELECT TIME(SUM(time)) as 'sumtime' from timeline where projectid=$idn";
                $s_time=mysqli_query($conn,$sumtime);
                while($zow=mysqli_fetch_assoc($s_time)){
                  echo $zow['sumtime'];
                }
            ?>
          </td>
          <td align="center">
            <?php 
                $ppl_impact="SELECT sum(impact) from timeline where projectid=$idn";
                $s_impact=mysqli_query($conn,$ppl_impact);
                while($zow=mysqli_fetch_assoc($s_impact)){
                  echo $zow['sum(impact)'];
                }
            ?>
          </td>
          <td align="center">
            <?php 
                $money_spent="SELECT sum(money) from timeline where projectid=$idn";
                $s_money=mysqli_query($conn,$money_spent);
                while($zow=mysqli_fetch_assoc($s_money)){
                  echo $zow['sum(money)'];
                }
            ?>
          </td>
      </tr>
      <?php   
      }
    ?>
        </table>
        <br>
        <div align="center">
      <button onclick="export_TO_CSV('data.csv')">Export CSV</button>   
      </div>
  </div>
    <div>
    <hr>
    <div class="checkbox">
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

            $qu="SELECT id FROM project_details group by id ASC";
            $datacheck=mysqli_query($conn,$qu);                  
            ?>
            <form name="form" method="POST" align="center">
            <input type="checkbox" name="all" value="show all"><b>show all</b>
            <?php
            while($row1=mysqli_fetch_array($datacheck)){
              ?>
              <input type="checkbox" name="projects[]" value="<?php echo $row1['id'] ?>" <?php echo ( $_POST['projects[]']==1 ? 'checked' : '');?>/> <?php echo $row1['id'] ?>
              <?php
            }
          ?>
          <p><input type="submit" name="show" value="show"></p> 
          </form>
    </div>
    <div align="center" id="line_chart">
            <?php
            
            $arr=[];
 
              if(isset($_POST['show'])){
                if(!empty($_POST["projects"])){
                  echo "<h3>Your Selected Projects Chart </h3>";
                  foreach($_POST["projects"] as $project){
                     $arr[]=$project;
                     $_SESSION['myarray']=$arr;
                  }
                  include("sampletest.php");
                }
                elseif($_POST["all"]){
                  echo "<h3>All Projects Chart </h3>";
                  foreach($datacheck as $all){
                    $arr[]=$all['id'];
                    $_SESSION['myarray']=$arr;
                  }
                  include("sampletest.php");
              }          
                else{
                    echo "Please select the checkbox first";
                }
              }else{
                foreach($datacheck as $all){
                  $arr[]=$all['id'];
                  $_SESSION['myarray']=$arr;
                }
                include("sampletest.php");
              }
               
            ?> 
    </div>
    <hr>
    <div align="center"><h3><b>Projects Contribution</b></h3></div>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <div align="center"><button type="button" name="create_pdf1" id="create_pdf1" class="btn btn-danger btn-xs">Get PDF1</button></div>
    <div id="piechart1" style="width: 900px; height: 500px;"></div>
    <div align="center"><button type="button" name="create_pdf2" id="create_pdf2" class="btn btn-danger btn-xs">Get PDF2</button></div>
    <div id="piechart2" style="width: 900px; height: 500px;"></div>
    <div align="center"><button type="button" name="create_pdf3" id="create_pdf3" class="btn btn-danger btn-xs">Get PDF3</button></div>
    <div id="piechart3" style="width: 900px; height: 500px;"></div>
    <div align="center"><button type="button" name="create_pdf4" id="create_pdf4" class="btn btn-danger btn-xs">Get PDF4</button></div>    
  </body>
</html>

<script type="text/javascript"> 

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data1 = google.visualization.arrayToDataTable([
          ['projectid', 'money'],
          <?php 
            while($row=$res->fetch_assoc()){
              echo "['".$row['projectid']."',".$row['sum(money)']."],";
            }
          ?>
        ]);

        var options1 = {
          title: 'Total Money Spent',
          is3D: true,
        };

        var chart_area1=document.getElementById('piechart');
        var chart1 = new google.visualization.PieChart(chart_area1);
        var btnSave1 = document.getElementById('create_pdf1');
        google.visualization.events.addListener(chart1, 'ready', function () {
            btnSave1.disabled = false;
        });

        btnSave1.addEventListener('click', function () {
        var doc = new jsPDF();
        doc.addImage(chart1.getImageURI(), 0, 0);
        doc.save('chart1.pdf');
        }, false);
   
        chart1.draw(data1, options1);

        // for chart 2(impact)
        var data2=google.visualization.arrayToDataTable([
          ['projectid','impact'],
          <?php 
            while($row=mysqli_fetch_assoc($res1)){
              echo "['".$row['projectid']."',".$row['sum(impact)']."],";
            }
          ?>
        ]);

        var options2 = {
          title: 'Total People Impacted',
          is3D: true,
        };

        var chart_area2=document.getElementById('piechart1');
        var chart2 = new google.visualization.PieChart(chart_area2);
        var btnSave2 = document.getElementById('create_pdf2');
        google.visualization.events.addListener(chart2, 'ready', function () {
            btnSave2.disabled = false;
        });

        btnSave2.addEventListener('click', function () {
        var doc = new jsPDF();
        doc.addImage(chart2.getImageURI(), 0, 0);
        doc.save('chart2.pdf');
        }, false);

        chart2.draw(data2, options2);

        // for chart 3(time spent)
        var data3=google.visualization.arrayToDataTable([
          ['projectid','time'],
          <?php 
            while($row=mysqli_fetch_assoc($res2)){
              echo "['".$row['projectid']."',".$row['sum(time)']."],";
            }
          ?>
        ]);

        var options3 = {
          title: 'Total time spent',
          is3D: true,
        };

        var chart_area3=document.getElementById('piechart2');
        var chart3 = new google.visualization.PieChart(chart_area3);
        var btnSave3 = document.getElementById('create_pdf3');
        google.visualization.events.addListener(chart3, 'ready', function () {
            btnSave3.disabled = false;
        });

        btnSave3.addEventListener('click', function () {
        var doc = new jsPDF();
        doc.addImage(chart3.getImageURI(), 0, 0);
        doc.save('chart3.pdf');
        }, false);

        chart3.draw(data3, options3);

        // for chart 4 (revenue generated)

        var data4=google.visualization.arrayToDataTable([
          ['projectid','revenue'],
          <?php 
            while($row=mysqli_fetch_assoc($res4)){
              echo "['".$row['projectid']."',".$row['sum(revenue)']."],";
            }
          ?>
        ]);

        var options4 = {
          title: 'Total revenue generated',
          is3D: true,
        };

        var chart_area4=document.getElementById('piechart3');
        var chart4 = new google.visualization.PieChart(chart_area4);
        var btnSave4 = document.getElementById('create_pdf4');
        google.visualization.events.addListener(chart4, 'ready', function () {
            btnSave4.disabled = false;
        });

        btnSave4.addEventListener('click', function () {
        var doc = new jsPDF();
        doc.addImage(chart4.getImageURI(), 0, 0);
        doc.save('chart4.pdf');
        }, false);

        chart4.draw(data4, options4);
      }
</script>
<script type="text/javascript">

    function downloadcsv(csv, filename){
      var csvfile;
      var downloadlink;
      
      csvfile=new Blob([csv],{type: "text/csv"});
      downloadlink=document.createElement("a");
      downloadlink.download = filename;
      downloadlink.href = window.URL.createObjectURL(csvfile);
      downloadlink.style.display= "none";

      document.body.appendChild(downloadlink);
      downloadlink.click();
   }

   function export_TO_CSV(filename){
      var len=count+1;
      var csv=[];
      var rows=document.querySelectorAll("table tr");

      for(var i=0; i<len; i++){
        var row=[];
        var cols=rows[i].querySelectorAll("td, th");
        for(var j=0; j<cols.length; j++){
          row.push(cols[j].innerText);
            
        }
        csv.push(row.join(",")); 
      }
      
      downloadcsv(csv.join("\n"),filename);
   }
</script>
