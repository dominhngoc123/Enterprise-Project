<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Academic $model */

$this->title = Yii::t('app', 'Create Academic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Academics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
