<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Data-Log</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date-Time', 'Wind', 'AC-Temperature','Temperature Outside'],
          <?php
            if(isset($_POST['FindBtn'])){
                include "connection.php";

                $name=$_POST["name-person"];

                $sql2="SELECT time,temp,windM,tempM FROM data_ac_effective WHERE name='$name';";
                $res=mysqli_query($koneksi,$sql2);

                while($data=mysqli_fetch_array($res)){
                    $time = $data['time'];
                    $temp = $data['temp'];
                    $tempM = $data['tempM'];
                    $windM = $data['windM'];
                }

            }
            ?>
            ['<?php echo $time;?>',<?php echo (float)$windM;?>,<?php echo $temp;?>,<?php echo $tempM;?>]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

</head>
<body>
    
    <div class="frame-1">
        <div class="kelas">
            <form action="index.php" method="post">
                <div class="top-left">
                <button type="submit" name="FindBtn" class="find-btn">Back</button>
                </div>
            </form>
            <h1 class="judul overlay">Data Log</h1>
            <hr class="garis">
        </div>
        
        
        <form action="" method="post">
            <div class="align-kiri">
            <div class="align-lbl">
                <labe class="lbl-font">Name &nbsp; : &nbsp; </label>
                <input type="text" name="name-person" class="form-control" placeholder="GHQ" />
            </div>

            <div class="btn-align mrgn-left-20">
            <button type="submit" name="FindBtn" class="find-btn">FIND</button>
            </div>
            </div>
        </form>

        <div id="curve_chart">

        </div>

    </div>

</body>
</html>