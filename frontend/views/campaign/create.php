<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Campaign $model */

$this->title = Yii::t('app', 'Create Campaign');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaigns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>