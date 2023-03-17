<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$publishedRes = Yii::$app->assetManager->publish('@vendor/hail812/yii2-adminlte3/src/web/js');
$this->registerJsFile($publishedRes[1] . '/control_sidebar.js', ['depends' => '\hail812\adminlte3\assets\AdminLteAsset']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<link rel="preload" href="https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFWJ0bbck.woff2" style="font-display: optional;">
<link rel="stylesheet" href="../plugins/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:600%7cOpen&#43;Sans&amp;display=swap" media="screen">

<link rel="stylesheet" href="../plugins/themify-icons/themify-icons.css">
<link rel="stylesheet" href="../plugins/slick/slick.css">
<script src="../plugins/jQuery/jquery.min.js"></script>

<!-- Main Stylesheet -->
<link rel="stylesheet" href="../css/style.css">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preload" href="https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFWJ0bbck.woff2" style="font-display: optional;">
    <link rel="stylesheet" href="../plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:600%7cOpen&#43;Sans&amp;display=swap" media="screen">

    <link rel="stylesheet" href="../plugins/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../plugins/slick/slick.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="../css/style.css">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <?= \diecoding\toastr\ToastrFlash::widget(); ?>
    <!-- Navbar -->
    <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
    <!-- /.navbar -->
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <section class="section">
        <div class="container">
            <!-- <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <?php
                            echo Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'options' => [
                                    'class' => 'breadcrumb float-sm-left'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div> -->
            <?php if (Yii::$app->controller->id === 'user' && Yii::$app->controller->action->id === 'author') : ?>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-lg-12 mb-5 mb-lg-0">
                        <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-lg-9  mb-5 mb-lg-0">
                        <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
                    </div>
                    <aside class="col-lg-3">
                        <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>
                    </aside>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Content Wrapper. Contains page content -->


    <?= $this->render('profile-modal') ?>
    <?= $this->render('terms-conditions') ?>

    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    <?= $this->render('footer') ?>
    <a class="fixedbutton" href="<?= Url::to(['idea/create']) ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>

    <?php $this->endBody() ?>
    <!-- JS Plugins -->

    <script src="../plugins/bootstrap/bootstrap.min.js" async></script>
    <script src="../plugins/slick/slick.min.js"></script>

    <!-- Main Script -->
    <script src="../js/script.js"></script>

</body>

</html>
<?php $this->endPage() ?>