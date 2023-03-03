<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Reaction $model */

$this->title = Yii::t('app', 'Create Reaction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
