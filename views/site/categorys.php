<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                foreach($categories as $category):?>

                    <div class="col-md-4 col-sm-6">

                        <!--Item blog post-->
                        <div class="item-blog-post" style="background: #fff;
    text-align: center;">
                            <div class="tz-post-thumbnail">
                                <img src="<?=$category->getImage();?>" alt="">
                            </div>
                            <div class="tz-post-info" style="    word-break: break-all;
    min-height: 60px;">
                                <h3><a href="<?= Url::toRoute(['site/category','id'=>$category->id]);?>"><?= $category->title?></a></h3>
                            </div>
                        </div>
                        <!--End Item blog post-->

                    </div>


                <?php endforeach;?>


            </div>
            <?= $this->render('/partials/sidebar', [
                'popular'=>$popular,
                'recent'=>$recent,
                'categories'=>$categories
            ]);?>
        </div>
    </div>
</div>
<!-- end main content-->