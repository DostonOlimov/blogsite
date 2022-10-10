<?php
use yii\helpers\Html;

?>
<section class="blog-posts">
                <div class="col-lg-12">
                  <div class="blog-post">
                    <div class="blog-thumb">
                    <?php
                        $options = ['alt'=>'no image', 'style' => 'width:100%'];
                        echo   Html::img('@web/images/'. $model->img_src, $options);
                    ?>
                    </div>
                    <div class="down-content">
                      <h2 class = "text-center">
                      <?= Html::a($model->title, ) ?>
                      </h2>
                     
                      <p><?php echo $model -> body; ?>
                
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
                          <ul class="post-info">
                        <li><a href="#">Admin</a></li>
                        <li><a href="#"><?php $formatter = \Yii::$app->formatter;
                            echo $formatter->asDate($model->date, 'long'); ?></a></li>    
                        </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
 </section>