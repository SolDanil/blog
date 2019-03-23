

<!DOCTYPE html>
<html>
<head>
    <title>VK to 2GIS</title>
    <script
        src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
</head>
<body>

<?php

if (isset($_POST["do"]) && $_POST["do"]!=''){
    $tag=$_POST["tag"];
    $lat=$_POST["lat"];
    $long=$_POST["long"];
    // print_r($_POST);

    $token ='*****';

    $url='https://api.vk.com/method/photos.search?q='.$tag.'&sort=0&count=5&long='.$long.'&lat='.$lat.'&start_time=&end_time=&offset=0&radius=10000&v=5.92&access_token='.$token;



    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // отправляем запрос
    $response = curl_exec($ch);
    // закрываем соединение
    curl_close($ch);

    $array=json_decode($response);

    $i=0;
    $images=array();

    foreach ($array->response->items as $key => $item) {

        foreach ($item->sizes as $key2 => $size) {
            if ($size->type=='x'){
                $url=$size->url;
            }
        }

        $lat1=$item->lat;
        $long1=$item->long;

        $images[$i]=array('url'=>$url,'lat'=>$lat1,'long'=>$long1);

        $i++;


    }



    // print_r($images);

    $json_images=json_encode($images);




}
?>

<form method="post">
    <label>TAG</label><input type="text" name="tag" id="tag">
    <label>LAT</label><input type="text" name="lat" id="lat" value="43.240388">
    <label>LONG</label><input type="text" name="long" id="long" value="76.92275">
    <input type="hidden" name="do" value="search_tag">
    <input type="submit">

</form>

<? if (count($images)>0){?>

    <div id="map" style="width:1000px; height:700px;margin-top: 20px"></div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(window).resize(function() {
                width=$(window).width()-20;
                height=$(window).height()-70;
                $("#map").css('width',width);
                $('#map').css('height',height);
            });

            $(window).resize();
        });
        $(window).load(function(){

            width=$(window).width()-20;
            height=$(window).height()-70;
            $("#map").css('width',width);
            $('#map').css('height',height);
        });
    </script>

    <script type="text/javascript">



        var map;

        img=JSON.parse('<?=$json_images?>');

        DG.then(function () {
            map = DG.map('map', {
                center: [<?=$lat?>, <?=$long?>],
                zoom: 12
            });

            for (i=0;i<img.length;i++){
                DG.marker([img[i]['lat'], img[i]['long']]).addTo(map).bindPopup('<img src="'+img[i]['url']+'" style="width:100px">');

            }


        });


    </script>

<? } ?>
</body>
</html>




