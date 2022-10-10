<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use common\widgets\Doston;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<div class="container">
<header 
    class="bg-image font-weight-bold px-5 pb-5 text-center"
    style=" background-repeat: no-repeat;  background-size: cover ; background-position:top center;
     background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/041.webp');">
    <?php
  //  echo Doston::widget();

    NavBar::begin([
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-light',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index'],'linkOptions' => ['style' => 'color:white;'],],
        ['label' => 'Barcha maqolalar', 'url' => ['/site/all'],'linkOptions' => ['style' => 'color:white;'],],
        ['label' => 'Contact', 'url' => ['/site/contact'],'linkOptions' => ['style' => 'color:white;'],],
        ['label' => 'Eng zo\'rlari', 'url' => ['/site/tops'],'linkOptions' => ['style' => 'color:white;'],],
        
        
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0 '],
        'options' =>['style' => 'font-size:24px;'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="mask" style	="background-color: rgba(0, 0, 0, 0.7);">
      <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-white">
          <h1 class="mb-3"><?= Yii::$app->name?></h1>
          <h5 class="mb-4"><?= Yii::$app->statustext?></h5>         
          <?php 
           if (Yii::$app->user->isGuest) {
          echo  Html::a('&nbsp &nbsp Kirish &nbsp &nbsp  ', ['/site/login'], ['class' => 'btn btn-outline-light btn-lg m-4']); 
          echo Html::a('Ro\'yxatdan o\'tish ', ['/site/signup'], ['class' => 'btn btn-outline-light btn-lg m-4']) ;
        }
        else {
            
                echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                .Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-outline-light btn-lg m-4'],
                )
                .Html::endForm();
        }
           ?>       
        </div>
      </div>
    </div>
</header>
</div>
<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
