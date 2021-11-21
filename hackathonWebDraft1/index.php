<!DOCTYPE html>
    <! –– PHP SUMBIT ––>
            <?php
                $tempHasil = "";
                $message = "";
                $message2 = "";
                $message3 = "";
                $message4 ="";
                $namePrsn="";
                $humid="";
                $wind=0.0;
                $tempM="";
                $co2="";
                if(isset($_POST['SubmitBtn'])){
                    include "connection.php";
                    include "connection-api.php";

                    $humid= $data['main']['humidity'];
                    $tempM= $data['main']['feels_like'];
                    $wind= $data['wind']['speed'];
                    
                    $tempM=$tempM-273.15;

                    $name=$_POST["name-person"];
                    $temp=$_POST["temp"];
                    $hrs=$_POST["hrs"];
                    $mnt=$_POST["mnt"];
                    $cmb_hrs=$hrs . ':' . $mnt;

                    
                        $sql="INSERT INTO data_ac_effective (name, temp, hours, time, tempM, windM) values
                            ('$name','$temp','$cmb_hrs', (SELECT CURRENT_TIMESTAMP()),'$tempM','$wind')";

                    
                        $hasil=mysqli_query($koneksi,$sql);

                    
                        if ($hasil) {
                        $sql2="SELECT * FROM data_ac_effective WHERE pk_auto=(SELECT IFNULL(MAX(pk_auto),0) FROM data_ac_effective);";
                        $query = mysqli_query($koneksi, $sql2);
                        

                        while ($row = mysqli_fetch_array($query))
                            {

                                $tempHasil= $row['temp'];
                                $co2=(int)$hrs*12385;

                                if($tempHasil < 25){
                                    $message="Hey you should increase your AC temperature, above 25° will be good since every temperature will reduce   electricity   consumption by 3-5%.";
                                    $firstAct=(int)$hrs*109;
                                    $secondAct=(int)$hrs*113;
                                    
                                    $lastAct=$secondAct-$firstAct;
                                    $message2="If you stay at ".$tempHasil."° Celcius it will consume ".$secondAct." kWh. If you try to use the temperature above 25° you can reduce about ".$lastAct." kWh.";
                                }

                                if($tempHasil >= 25){
                                    $message="Keep it up with ".$tempHasil."° Celcius because it help to reduce a tiny portion of climate change.";
                                }

                                if($wind > 2){
                                    $message2="Your wind was around ".$wind."m/s maybe you can open your window and turn on your ac";
                                    $message="";
                                }

                                $message4="Still Remember! you need to reduce your use of AC since you already produce about ".$co2." carbon dioxide.";
                            }
                        }
                        else {
                            echo "<script type='text/javascript'>alert('Can't Insert Data');</script>";
                        exit;
                        }

                }
            ?>
    <! –– PHP SUMBIT END ––>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&family=Bebas+Neue&display=swap" rel="stylesheet">
    <title>Effective AC</title>
   
</head>
<body>
    <div class="frame-1">
        
        <div class="line-1">
            <h1 class="judul">Effective &nbsp; AC</h1>
            <h2 class="description-judul">Air conditioning is a big contributor to climate change. Our website are trying to change that</h2>
        </div>

        <div class="line-2">
            <div class="kanan-l2">
                
                <form action="" method="post">

                    <div class="align-lbl margin-36">
                        <labe class="lbl-font">Name &nbsp; : &nbsp; </label>
                        <input type="text" name="name-person" class="form-control" placeholder="GHQ" />
                    </div>

                    <div class="align-lbl margin-36">
                        <label class="lbl-font">Temperature &nbsp; : &nbsp; </label>
                        <input type="text" name="temp" class="form-control sz-45" />
                        <a class="txt-gray">&nbsp; ° Celcius</a>
                    </div>

                    <div class="align-lbl margin-36">
                        <label class="lbl-font">Hours &nbsp; : &nbsp; </label>
                        <div class="hours-input">
                            <input type="text" name="hrs" class="form-control sz-45" />
                            <a>:</a>
                            <input type="text" name="mnt" class="form-control sz-45" />
                            <a class="txt-gray">&nbsp; 24H Format eg.20:11</a>
                        </div>
                    </div>
                    <div class="btn-align">
                    <button type="submit" name="SubmitBtn" class="btn">SUMBIT</button>
                    </div>
                </form>

            </div>
            <div class="kiri-l2">
                <h1>Temperature :&nbsp; <?php echo $tempHasil ?> ° Celcius</h1>
                <h1 class="humid">Humidity : <?php echo $humid ?> %</h1>
                <h1 class="wind">Wind : <?php echo $wind ?> m/s</h1>
                <?php echo '<a class="description-judul">'.$message.'</a>' ?>
                <br>
                <?php echo '<a class="description-judul">'.$message2.'</a>' ?>
                <br>
                <?php echo '<a class="description-judul">'.$message3.'</a>' ?>
                <br>
                <?php echo '<a class="description-judul">'.$message4.'</a>' ?>
            </div>
        </div>

        <div class="line-3">
            <div class="kanan-l3">
                <h1 class="judul-l3">Data-Log</h1>
                <h2 class="desc-l3">Find your past data by search your name</h2>
                <form action="form.php" method="post">
                <button type="submit" name="Next" class="btn-l3">NEXT</button>
                </form>
            </div>

            <div class="kiri-l3">
                <h1 class="judul-l3">Climate Change</h1>
                <h2 class="desc-l3">Explanation of what is climate change</h2>
                    <form action="climate-change.html" method="post">
                        <button type="submit" name="Next" class="btn-l3">NEXT</button>
                    </form>
            </div>
        </div>

        <div class="empty-color"></div>

    </div>

</body>
</html>
