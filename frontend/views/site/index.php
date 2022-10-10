<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap\BootstrapAsset;
use yii\web\Application;


$model = $dataProvider ->getModels();
$i = 0;
foreach ($model as $item){
    if ($i == 4) break;
    $i= $i + 1;
?>
 <section class="blog-posts">

                <div class="col-lg-12">
                  <div class="blog-post">
                    <div class="blog-thumb">
                    <?php
                        $options = ['alt'=>'no image'];
                        echo   Html::img('@web/images/'. $item->img_src, $options);
                    ?>
                    </div>
                    <div class="down-content">
                      <span>Qizaqarli maqolalar</span>
                      <h4>
                      <?= Html::a($item->title, ['details', 'id' => $item->id]) ?>
                      </h4>
                      <ul class="post-info">
                        <li><a href="#">Admin</a></li>
                        <li><a href="#"><?php $formatter = \Yii::$app->formatter;
                    echo $formatter->asDate($item->date, 'long'); ?></a></li>
                        
                      </ul>
                      <p><?php echo substr($item->body,0,1000) ; ?>
                
                      <div class="post-options">
                        <div class="row">
                          <div class="col-6">
                            <ul class="post-tags">
                              <li><i class="fa fa-tags"></i></li>
                              <li><a href="#">Best Blogs</a>,</li>
                              <li><a href="#">blogs.uz</a></li>
                            </ul>
                          </div>
                          <div class="col-6">
                            <ul class="post-share">
                              <li><i class="fa fa-share-alt"></i></li>
                              <li><a href="#">Facebook</a>,</li>
                              <li><a href="#">Twitter</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
 </section>
                <?php }?>

                <div class="col-lg-12" id ="fblock">
                  <div class="main-button">
                    <a href="\site\all">View All Posts</a>
                  </div>
                </div>
               
                
                
              


 