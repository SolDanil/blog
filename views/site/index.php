<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">
 

    <form method="post">
        <label>TAG</label><input type="text" name="tag" id="tag">
        <label style="display: none;">LAT</label><input type="hidden" name="lat" id="lat" value="43.240388">
        <label style="display: none;">LONG</label><input type="hidden" name="long" id="long" value="76.92275">
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <input type="hidden" name="do" value="search_tag">
        <input type="submit">

    </form>  

    

    <?php if (isset($images)){
            if (count($images)>0){?>

                <div id="map" style="width:100%; height:700px;margin-top: 20px"></div>

                <script src="http://code.jquery.com/jquery-3.3.1.min.js"
                    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                    crossorigin="anonymous"></script>
                <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>

                <script type="text/javascript">
                    
                    var map;
                    img=JSON.parse('<?=$json_images?>');
                    DG.then(function () {
                        map = DG.map('map', {
                            center: [<?=$lat?>, <?=$long?>],
                            zoom: 12
                        });
                        for (i=0;i<img.length;i++){
                            DG.marker([img[i]['lat'], img[i]['long']]).addTo(map).bindPopup('<a href="'+img[i]['url']+'"><img src="'+img[i]['url']+'" style="width:100px"></a>');
                        }
                    });
                
                </script>

    <?php   } 
        } ?>


</div>
