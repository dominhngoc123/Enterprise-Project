<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Hashtag $model */

$this->title = Yii::t('app', 'Create Hashtag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hashtags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hashtag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
