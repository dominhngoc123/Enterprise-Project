<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\IdeaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="idea-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'parentId') ?>

    <?= $form->field($model, 'userId') ?>

    <?php // echo $form->field($model, 'attachmentId') ?>

    <?php // echo $form->field($model, 'categoryId') ?>

    <?php // echo $form->field($model, 'academicId') ?>

    <?php // echo $form->field($model, 'upvote_count') ?>

    <?php // echo $form->field($model, 'downvote_count') ?>

    <?php // echo $form->field($model, 'post_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
