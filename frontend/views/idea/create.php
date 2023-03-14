<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Idea $model */

$this->title = Yii::t('app', 'Create Idea');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ideas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= $this->render('_form', [
    'all_files' => $all_files,
    'all_files_preview' => $all_files_preview,
    'files_type' => $files_type,
    'model' => $model,
    'category' => $category,
    'department' => $department,
    'ideaType' => $ideaType,
]) ?>