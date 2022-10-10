<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
           // 'user_id',
           [
            'attribute' => 'title',
            'format' => 'text',
            'label' => 'title',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return substr($data->title,0,40) ;
             },
        ],
        [
            'attribute' => 'img_src',
            'format' => 'html',
            'label' => 'image',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                $options = ['alt'=>'no image','style' => ['width' => '100px', 'height' => '100px']];
                return   Html::img('../images/'.$data->img_src, $options);

             },
        ],
            [
                'attribute' => 'body',
                'format' => 'ntext',
                'label' => 'text',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return substr($data->body,0,50).'...' ;
                 }, 
            ],
            'date:datetime' ,
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action,$model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
