<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\Idea $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="idea-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col col-md-6 col-lg-6 col-sm-12">
            <?= $form->field($model, 'categoryId')->widget(Select2::classname(), [
                'data' => $category,
                'options' => ['placeholder' => 'Select a category ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>
        <div class="col col-md-6 col-lg-6 col-sm-12">
            <?= $form->field($model, 'campaignId')->widget(Select2::classname(), [
                'data' => $campaign,
                'options' => ['placeholder' => 'Select an campaign ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-6 col-lg-6 col-sm-12">
            <?= $form->field($model, 'departmentId')->widget(Select2::classname(), [
                'data' => $department,
                'options' => ['placeholder' => 'Select an campaign ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>
        <div class="col col-md-6 col-lg-6 col-sm-12">
            <?= $form->field($model, 'post_type')->widget(Select2::classname(), [
                'data' => $ideaType,
                'options' => ['placeholder' => 'Select an idea type ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'title')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic',
        'clientOptions' => [
            'height' => 400,
            'toolbarGroups' => [
                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
                ['name' => 'forms'],
                '/',
                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors', 'cleanup']],
                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi']],
                ['name' => 'links'],
                ['name' => 'insert'],
                '/',
                ['name' => 'styles'],
                ['name' => 'blocks'],
                ['name' => 'colors'],
                ['name' => 'tools'],
                ['name' => 'others'],
            ],
        ]
    ]) ?>

    <div class="row">
        <div class="col col-md-12 col-lg-12 col-sm-12">
            <?= $form->field($model, 'file[]')->widget(FileInput::classname(), [
                'options' => [
                    'multiple' => true,
                    'accept' => 'img/*', 'doc/*', 'file/*',
                    'class' => 'form-control',
                    'placeholder' => 'maximum size is 4 MB',
                ],
                'pluginOptions' => [
                    'minFileCount' => 0,
                    'maxFileCount' => 5,
                    'maxFileSize' => '4096',
                    'initialPreview' => $all_files,
                    'initialPreviewAsData' => true,
                    'initialPreviewConfig' => $all_files_preview,
                    'fileActionSettings' => [
                        'showDownload' => false,
                        'showRemove' => true,
                    ],
                    'showUpload' => false,
                    // 'defaultPreviewContent' => yii\helpers\Url::to(["/common-files/images/empty-file.png"]),
                    'overwriteInitial' => true,
                    'showRemove' => TRUE,
                ]
            ]); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>