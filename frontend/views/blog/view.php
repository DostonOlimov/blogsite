<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Blog */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a('Back', ['index'], [
            'class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'title',
            //'img_src',
            'body:ntext',
            'date',
        ],
    ]) ;
        echo Html::tag('h3', 'rasm');
        $options = ['style' => ['width' => '300px', 'height' => '300px']];
        echo  Html::img('../images/'.$model->img_src, $options);

     
    ?>

</div>
