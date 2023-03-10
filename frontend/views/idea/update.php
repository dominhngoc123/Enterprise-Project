<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Idea $model */

$this->title = Yii::t('app', 'Update Idea: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ideas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

    <?= $this->render('_form', [
        'all_files' => $all_files,
        'all_files_preview' => $all_files_preview,
        'files_type' => $files_type,
        'model' => $model,
        'category' => $category,
        'campaign' => $campaign,
        'department' => $department,
        'ideaType' => $ideaType,
    ]) ?>
