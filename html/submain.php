<?php
    $id_st = $_GET['station'].'_day'; 
    $id_sthour = $_GET['station'].'_hour';
    $login = mysqli_connect("localhost","root");
    mysqli_set_charset($login,'utf8');
    $sql = "use productdb";
    $sqlhour = "use productdb";
    $result = mysqli_query($login,$sql);
    $resulthour = mysqli_query($login,$sqlhour);
    $sql = "select * from $id_st ORDER BY `day` DESC";
    $sqlhour = "select * from $id_sthour ORDER BY `id` DESC";
    $result = mysqli_query($login,$sql);
    $resulthour = mysqli_query($login,$sqlhour);
    $sqlst = "use productdb";
    #$sqaqi = "use productdb";
    $resultst = mysqli_query($login,$sqlst);
    #$resultaqi = mysqli_query($login,$sqlaqi);
    #$sqlaqi = "select * from  ORDER BY `id` DESC";
    $sqlst = "select * from latlng_st ";
    $resultst = mysqli_query($login,$sqlst);
    #$resultaqi = mysqli_query($login,$sqlaqi);
    $parameter=$_GET['parameter'];
    $ii = 0;
    $hourbox=[];
    $datebox=[];
    $stname=[];
    $stfullname=[];
    $stlat=[];
    $stlng=[];
    $aqi=[];
    $stcenlat=13;
    $stcenlng=100;
    while($dbrr = mysqli_fetch_row($resultst)){
        array_push($stname,$dbrr[2]);
        array_push($stfullname,$dbrr[3]);
        array_push($stlat,$dbrr[4]);
        array_push($stlng,$dbrr[5]);
        array_push($aqi,$dbrr[6]);
        array_push($hourbox,$dbrr[7]);
        array_push($datebox,$dbrr[1]);
        if(($_GET['station'])==$dbrr[2]){
            $stcenlat=$dbrr[4];
            $stcenlng=$dbrr[5];

        }
    }
?>

<!DOCTYPE html>
<html lang="th">
<head>  
    <title>UAVs collect PM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.4 , shrink-no-fit=no">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="myCSS.css" rel="stylesheet" type="text/css"/>
    <style type="text/css" >
        table {
            border-collapse: collapse;
            width: 100%;
            }

        th, td {
            text-align: left;
            padding: 8px;
            border-right: 2px solid white;
            text-align: center;
            }
        th :last-child {
            border-right:none;

        }

        tr:nth-child(even){
            background-color: #f2f2f2
            
            }
        tr:nth-child(odd){
            background-color: #cee3eb
            
            }

        th {
            background-color: #4CAF50;
            color: white;
            }

        #map {
            height: 400px;
            margin-left: 20px;
            margin-right: 20px;
            
            margin-bottom: 20px;
            clear: both;
        }

        #blockcontainer{
            width: 1000px;
            border: 1px solid rgb(245, 245, 245);
            text-align: center;
            background-image: url('bg2.jpg');
        }
        #mainlink {
            float: left;
            height: 100%;
            margin-top: 60px;
            margin-bottom: 20px;
            position: relative;

        }
        #mainlink li {
            float: left;
            list-style: none;
        }
        #mainlink li a{
            color: rgb(10, 0, 53);
            text-decoration: none;
            padding-left: 20px;
            padding-right: 20px;
            /*border-right: 2px solid white;*/
            font-size: 16pt;
            font-family: Kunlasatri;
        }
        #mainlink li a:hover {
            color: white;
            background: gray; 
            /*border-top-left-radius: 20px;
            border-bottom-right-radius: 20px;*/
        }
        #mainlink li:last-child a {
            border-right: none;}

        #mainright{
            color: orange;
            margin-left: 10%;
            margin-right: 10%;
            margin-top: 60px;
            margin-bottom: 20px;
        }
        #stationtopic{
            margin-left: 40px;
            margin-right: 40px;
            background-color: #46a049;
            font-size: 18pt;
            text-align: center;
            color: white;
            font-weight: bold;
            border: 2px solid black;
        }
        #graphtopic{
            float: none;
            margin-top: 60px;
            background-color: rgb(114, 189, 250);
            font-size: 18pt;
            text-align: center;
            color: white;
            font-weight: bold;
        }
        #pmtime{
            margin-top: 20px;
            margin-left: 0px;
            margin-right: 0px;
            background-color: rgb(114, 189, 250);
            font-size: 18pt;
            text-align: center;
            color: white;
            font-weight: left;
        }

        #pmtopic{
            margin-top: 20px;
            margin-left: 0px;
            margin-right: 0px;
            background-color: rgb(114, 189, 250);
            font-size: 18pt;
            text-align: center;
            color: white;
            font-weight: center;
        }

        #pmtable{
            margin-top: 20px;   
        }
        #pmtable ul li {
            float: left;
            list-style: none;
            background: rgb(114, 189, 250);
            border-right: 2px solid white;
        }

        #pmtable ul li a{
            color: rgb(255, 255, 255);
            text-decoration: none;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 20pt;
            
   
        }
        #pmtable ul li a:hover {
            color: white;
            background: rgb(233, 174, 100); 
            /*padding-bottom: 20px;
            padding-top: 5px;
            border-top-left-radius: 20px;
            border-bottom-right-radius: 20px;*/
        }
        #pmtable li:last-child a {
            border-right: none;}
    </style>


<script type="text/javascript">
    const stnamejs = <?php echo json_encode($stname); ?>;
    const stfullnamejs = <?php echo json_encode($stfullname); ?>;
    const stlatjs = <?php echo json_encode($stlat); ?>;
    const stlngjs = <?php echo json_encode($stlng); ?>;
    const staqijs = <?php echo json_encode($aqi); ?>;
    const stcenlatjs = <?php echo json_encode($stcenlat); ?>;
    const stcenlngjs = <?php echo json_encode($stcenlng); ?>;
    const hourboxjs = <?php echo json_encode($hourbox); ?>;
    const dateboxjs = <?php echo json_encode($datebox); ?>;
    //alert(stname[0]);
    let map;
    function attachSecretMessage(marker, secretMessage,stname,stfullname,mshourboxjs,msdateboxjs) {
        const assayMessage = "<h6>"+ stfullname +"</br>" +
                              "AQI : "+ secretMessage + "</br>" +
                              "last: " + msdateboxjs +" "+ mshourboxjs +"</h6>"+
                              "<a href='/submain.php?station="+stname+"'> Enter to station </a>";
        const infowindow = new google.maps.InfoWindow({
          content: assayMessage ,
        });
        marker.addListener("click", () => {
          infowindow.open(marker.get("map"), marker);
        });
      }

    function initMap() {
        const centermap = new google.maps.LatLng(stcenlatjs ,stcenlngjs );
        //const secretMessages = ["<a href='?pmdata=2.5' class='btn btn-info' role='button'>AQI </a>", "is", "the", "secret", "message"];
        const map = new google.maps.Map(document.getElementById("map"), {
          center: centermap,
          zoom: 16,
        });

 
        let image = "/levelpm/Blue.png";
        for (let i = 0; i < staqijs.length; ++i) {
            let zz = parseInt(staqijs[i])
            if(zz <= 50){
                image = "/levelpm/Blue.png";
            } else if (zz <= 100){
                image = "/levelpm/Green.png";
            } else if (zz <= 150){
                image = "/levelpm/Yellow.png";
            } else if (zz <= 200){
                image = "/levelpm/Purple.png";
            } else { image = "/levelpm/Red.png";}

            const marker = new google.maps.Marker({
            position: {
              lat: parseFloat(stlatjs[i]),
              lng: parseFloat(stlngjs[i]),
            },
            map: map,
            icon: image,

          });
          attachSecretMessage(marker, staqijs[i], stnamejs[i],stfullnamejs[i],hourboxjs[i],dateboxjs[i]);
        }

    }
   
  </script>

</head>
<body>
    <div id="blockcontainer" class="container">
        <div id="mainlink">
            <ul>
                <li><a href="index.php"><i class="fas fa-home"> </i> หน้าแรก</a></li>
                <li><a href="#"><i class="fas fa-info"> </i> เกี่ยวกับเว็บไซต์</a></li>
            </ul>
        </div>
        <div id="mainright"><i class="fas fa-robot"> </i> Laboratory UAVs and Robots</div>
        <form action="/submain.php">
        <label for="stations">Choose a station:</label>
        <select name="station" id="stations">
        <option >---สถานีวัดค่าฝุ่น---</option>

        <?php
        for($ii=0;$ii<count($stfullname);$ii++){   
        echo'<option value="'.$stname[$ii].'">'.$stfullname[$ii].'</option>';}
        ?>

        </select>
        <input type="submit" value="Submit">
        </form>
        <div id="map"></div>
        <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBOAjSob8Nf1DPmY95ItbxxwpChWf6_l8&callback=initMap&libraries=&v=weekly"
            async
        ></script>

        <div id="stationtopic">
            <i class="fas fa-thumbtack"></i>
            <?php
            $id_st = $_GET['station'];
            $key = array_search($id_st, $stname);
            echo " สถานี" .$stfullname[$key] ;

            ?>
        </div>
        <div id="pmtopic">
            ตารางแสดงคุณภาพอากาศ 7 วันล่าสุด
        </div>
        
        <?php
            //get current url
            
            #$dbrr = mysqli_fetch_row($result);
            #$numrow = mysqli_num_rows($result);
            $li_ppm = array('pm1'=>3,'pm2.5'=>4,'pm10'=>5,'aqi'=>6,''=>6);
            echo "<table>
            <tr>
              <th>วันที่</th>
              <th>เวลา</th>
              <th>PM 1 (ug/m<sup>3</sup>)</th>
              <th>PM 2.5 (ug/m<sup>3</sup>)</th>
              <th>PM 10 (ug/m<sup>3</sup>)</th>
              <th> AQI </th>
            </tr>
            ";
            $ii = 0;
            $pmdata=[];
            $pmdata_20=[];
            $pmdata_40=[];
            $daydata=[];
            $dayt = [];
            $timet = [];
            $pm1t = [];
            $pm2_5t = [];
            $pm10t = [];
            $aqit = [];
            while($dbrr = mysqli_fetch_row($result)){
              if($ii == 7){
                  break;
              }
              array_push($pmdata,$dbrr[$li_ppm[$_GET['parameter']]]);
              array_push($pmdata_20,$dbrr[$li_ppm[$_GET['parameter']]+4]);
              array_push($pmdata_40,$dbrr[$li_ppm[$_GET['parameter']]+8]);
              $datecv = date_create($dbrr[1]);
              $datecv = date_format($datecv,"D d M");
              array_push($daydata,$datecv);
              array_push($dayt,$dbrr[1]);
              array_push($timet,$dbrr[2]);
              array_push($pm1t,$dbrr[3]);
              array_push($pm2_5t,$dbrr[4]);
              array_push($pm10t,$dbrr[5]);
              array_push($aqit,$dbrr[6]);
              $ii++; }
              
              #$daydata = array_reverse($daydata);
              #$pmdata = array_reverse($pmdata);
              #$pmdata_20 = array_reverse($pmdata_20);
              #$pmdata_40 = array_reverse($pmdata_40);
              $dayt= array_reverse($dayt);
              $timet= array_reverse($timet);
              $pm1t= array_reverse($pm1t);
              $pm2_5t= array_reverse($pm2_5t);
              $pm10t= array_reverse($pm10t);
              $aqit= array_reverse($aqit);

          for($ii=0;$ii<count($dayt);$ii++){
            echo "
            <tr>
            <td>$dayt[$ii]</td>
            <td>$timet[$ii]</td>
            <td>$pm1t[$ii]</td>
            <td>$pm2_5t[$ii]</td>
            <td>$pm10t[$ii]</td>
            <td>$aqit[$ii]</td>
            </tr> ";
          }

          if($_GET['rangetime']=='hour'){
                $ii = 0;
                $pmdata_hour=[];
                $pmdata_hour20=[];
                $pmdata_hour40=[];
                $hourdata=[];
                while($tbrr = mysqli_fetch_row($resulthour)){
                    if($ii == 24){
                        break;
                    } 
                    $datetran = substr($tbrr[2],0,-3);
                    array_push($hourdata,$datetran);
                    array_push($pmdata_hour,$tbrr[$li_ppm[$_GET['parameter']]]);
                    array_push($pmdata_hour20,$tbrr[$li_ppm[$_GET['parameter']]+4]);
                    array_push($pmdata_hour40,$tbrr[$li_ppm[$_GET['parameter']]+8]);
                    $ii++;}
                $daydata = $hourdata;#array_reverse($hourdata);
                $pmdata = $pmdata_hour;#array_reverse($pmdata_hour);
                $pmdata_20 = $pmdata_hour20;#array_reverse($pmdata_hour20);
                $pmdata_40 = $pmdata_hour40;#array_reverse($pmdata_hour40);

              }
            //echo $pmdata[0];
            //echo $daydata[0];
            //$values = [[$daydata[6]=> $pmdata=[6], $daydata[5] => $pmdata=[5], $daydata[4] => $pmdata=[4], $daydata[3] => $pmdata=[3], $daydata[2] => $pmdata=[2], $daydata[1] => $pmdata=[1], $daydata[0] => $pmdata=[0]]]
            
            /*  
            
            $values = [[$daydata[6]=> $pmdata[6], $daydata[5] => $pmdata[5], $daydata[4] => $pmdata[4], $daydata[3] => $pmdata[3], $daydata[2] => $pmdata[2], $daydata[1] => $pmdata[1], $daydata[0] => $pmdata[0]]
                       //,[$daydata[6]=> $pmdata_20[6], $daydata[5] => $pmdata_20[5], $daydata[4] => $pmdata_20[4], $daydata[3] => $pmdata_20[3], $daydata[2] => $pmdata_20[2], $daydata[1] => $pmdata_20[1], $daydata[0] => $pmdata_20[0]]
                       //,[$daydata[6]=> $pmdata_40[6], $daydata[5] => $pmdata_40[5], $daydata[4] => $pmdata_40[4], $daydata[3] => $pmdata_40[3], $daydata[2] => $pmdata_40[2], $daydata[1] => $pmdata_40[1], $daydata[0] => $pmdata_40[0]]
                     ];*/
            $values=[];
            $values[0]=  array_fill_keys(array_reverse($daydata) ,NULL);
            $values[1]=  array_fill_keys(array_reverse($daydata) ,NULL);
            $values[2]=  array_fill_keys(array_reverse($daydata) ,NULL);
            $pmdata=$pmdata;
            $pmdata_20=$pmdata_20;
            $pmdata_40=$pmdata_40;
            for($ii=count($pmdata)-1;$ii>=0;$ii--){
                $values[0][$daydata[$ii]]=$pmdata[$ii];
                $values[1][$daydata[$ii]]=$pmdata_20[$ii];
                $values[2][$daydata[$ii]]=$pmdata_40[$ii];
            }

         
            echo "</table>";
            //print_r($values);
            //echo $numrow;
                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                    $link = "https";
                else
                    $link = "http";
                $link .= "://";
                $link .= $_SERVER['HTTP_HOST'];
                /*$link .= $_SERVER['REQUEST_URI'];
                echo $link;(ug/m<sup>3</sup>)*/
            if($_GET['parameter']==''){
                    $id_sttime = $link.'/submain.php?station='.$_GET['station'].'&parameter=aqi';}
            else{
                $id_sttime = $link.'/submain.php?station='.$_GET['station'].'&parameter='.$_GET['parameter'];}
            echo" 
                <div>";
                if($_GET['rangetime']=='day'||$_GET['rangetime']==''){echo"<a href=$id_sttime&rangetime=day class='btn btn-warning' role='button'> DAY </a>";}
                    else{echo"<a href=$id_sttime&rangetime=day class='btn btn-info' role='button'> DAY </a>";};

                if($_GET['rangetime']=='hour'){echo"<a href=$id_sttime&rangetime=hour class='btn btn-warning' role='button'>HOUR </a>";}
                    else{echo"<a href=$id_sttime&rangetime=hour class='btn btn-info' role='button'>HOUR </a></div>";};
                


            if($_GET['rangetime']=='day'||$_GET['rangetime']=='hour'){
               $id_st = $link.'/submain.php?station='.$_GET['station'].'&rangetime='.$_GET['rangetime'];}
            else{
               $id_st = $link.'/submain.php?station='.$_GET['station'].'&rangetime=day';
            }
            //echo $id_st;
            echo" 
            <div id='pmtable' >
                <ul>";
               
                    if($_GET['parameter']=='pm1'){echo"<li><a href=$id_st&parameter=pm1 class='btn btn-warning' role='button'> PM 1 </a></li>";}
                    else{echo"<li><a href=$id_st&parameter=pm1 class='btn btn-info' role='button'> PM 1 </a></li>";};

                    if($_GET['parameter']=='pm2.5'){echo"<li><a href=$id_st&parameter=pm2.5 class='btn btn-warning' role='button'>PM 2.5 </a></li>";}
                    else{echo"<li><a href=$id_st&parameter=pm2.5 class='btn btn-info' role='button'>PM 2.5 </a></li>";};

                    if($_GET['parameter']=='pm10'){echo"<li><a href=$id_st&parameter=pm10 class='btn btn-warning' role='button'>PM 10 </a></li>";}
                    else{echo"<li><a href=$id_st&parameter=pm10 class='btn btn-info' role='button'>PM 10 </a></li>";}; 
                
                    if($_GET['parameter']=='aqi' || $_GET['parameter']==''){
                        $parameter='aqi';echo"<li><a href=$id_st&parameter=aqi class='btn btn-warning' role='button'>AQI </a></li>";}
                    else{echo"<li><a href=$id_st&parameter=aqi class='btn btn-info' role='button'>AQI </a></li>";};
                
                echo"
                </ul>           
            </div>
            <br>";
            if($_GET['rangetime']=='hour'){
                echo"
            <div id='graphtopic'>
                กราฟแสดงคุณภาพอากาศ 24 ชั่วโมงล่าสุด
            </div>";} 
            if($_GET['rangetime']=='day'){
                echo"
            <div id='graphtopic'>
                กราฟแสดงคุณภาพอากาศ 7 วันล่าสุด
            </div>";}

        ?>
        
        <?php
// MultiLineGraph
require_once 'SVGGraph/autoloader.php';


$settings = [
    'auto_fit' => true,
    'back_colour' => '#eee',
    'back_stroke_width' => 0,
    'back_stroke_colour' => '#eee',
    'stroke_colour' => ['blue', 'red', 'orange'],
    'axis_colour' => '#333',
    'axis_overlap' => 2,
    'grid_colour' => '#666',
    'label_colour' => '#000',
    'axis_font' => 'Arial',
    'axis_font_size' => 10,
    'fill_under' => [false, false],
    'pad_right' => 20,
    'pad_left' => 20,
    'marker_type' => ['circle', 'square', 'triangle'],
    'marker_size' => 7,
    'marker_colour' => ['blue', 'red', 'orange'],
    'marker_stroke_colour' => ['blue', 'red', 'orange'],
    'link_base' => '/',
    'link_target' => '_top',
    'minimum_grid_spacing' => 20,
    'show_subdivisions' => false,
    'show_grid_subdivisions' => false,
    'grid_subdivision_colour' => '#ccc',
    'label_font_size' => 20,
    #'best_fit' => 'straight',
    #'best_fit_colour' => ['red', 'blue', 'green', 'orange'],
    #'best_fit_dash' => '2,2',
  ];

$width = 1000;
$height = 500;
$type = 'MultiLineGraph';
$settings['line_dataset'] = array(2, 3);
if($parameter=='aqi'){
    $settings['label_v'] = "AQI";
}
else{
    $settings['label_v'] = $parameter.'(ug/m^3)';
}
$settings['label_h'] = "TIME";
//$settings['marker_colour'] = 'black';
$colours = [ [ 'red', 'yellow' ], [ 'blue', 'white' ] ];
$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
$graph->colours($colours);

$graph->values($values);
$graph->render($type);
echo'
<table style="width:100px">

  <tr>
    <td> <svg width="30" height="30"><rect width="30" height="30" style="fill:blue" /></svg> </td>
    <td>0meter</td>
    <td></td>
    <td> <svg width="30" height="30"><rect width="30" height="30" style="fill:red" /></svg> </td>
    <td>20meters</td>
    <td></td>
    <td> <svg width="30" height="30"><rect width="30" height="30" style="fill:orange" /></svg> </td>
    <td>40meters</td>    
  </tr>

</table>';
?>
    </div>
</body>
</html>
