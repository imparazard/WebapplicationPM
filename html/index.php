<?php
    $login = mysqli_connect("localhost","XX","XXX");
    mysqli_set_charset($login,'utf8');
    $sqlst = "use productdb";
    #$sqaqi = "use productdb";
    $resultst = mysqli_query($login,$sqlst);
    #$resultaqi = mysqli_query($login,$sqlaqi);
    #$sqlaqi = "select * from  ORDER BY `id` DESC";
    $sqlst = "select * from latlng_st ";
    $resultst = mysqli_query($login,$sqlst);
    #$resultaqi = mysqli_query($login,$sqlaqi);

    $ii = 0;
    $stname=[];
    $stfullname=[];
    $stlat=[];
    $stlng=[];
    $aqi=[];
    $hourbox=[];
    $datebox=[];
    while($dbrr = mysqli_fetch_row($resultst)){
        array_push($hourbox,$dbrr[7]);
        array_push($datebox,$dbrr[1]);
        array_push($stname,$dbrr[2]);
        array_push($stfullname,$dbrr[3]);
        array_push($stlat,$dbrr[4]);
        array_push($stlng,$dbrr[5]);
        array_push($aqi,$dbrr[6]);
        
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
        #map {
            height: 1000px;
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
        #pmtopic{
            margin-left: 40px;
            margin-right: 40px;
            background-color: rgb(114, 189, 250);
            font-size: 20pt;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        #pmtable{
            margin-top: 20px;
            padding-bottom: 20px;
            position: relative;
        }
        #pmtable li {
            float: left;
            list-style: none;
            background: rgb(1, 73, 25);
            border-top-left-radius: 20px;
            border-bottom-right-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        #pmtable li a{
            color: rgb(255, 255, 255);
            text-decoration: none;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 12pt;
            
   
        }
        #pmtable li a:hover {
            color: white;
            background: rgb(233, 174, 12); 
            /*border-top-left-radius: 20px;
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
        const centermap = new google.maps.LatLng(13.254254600294727,100.93771862480598);
        //const secretMessages = ["<a href='?pmdata=2.5' class='btn btn-info' role='button'>AQI </a>", "is", "the", "secret", "message"];
        const map = new google.maps.Map(document.getElementById("map"), {
          center: centermap,
          zoom: 12,
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

        <!--div id="pmtopic"><p>คุณภาพอากาศ 7 วันที่ผ่านมา</p></div>
        <div id="pmtable">
            <ul>
                <li><a href="#" class="btn btn-info" role="button">PM 1 (ug/m<sup>3</sup>)</a></li>
                <li><a href="#" class="btn btn-info" role="button">PM 2.5 (ug/m<sup>3</sup>)</a></li>
                <li><a href="#" class="btn btn-info" role="button">PM 10 (ug/m<sup>3</sup>)</a></li>
                <li><a href="?pmdata=2.5" class="btn btn-info" role="button">AQI </a></li>
            </ul>          
        </div-->
    </div>
</body>
</html>
