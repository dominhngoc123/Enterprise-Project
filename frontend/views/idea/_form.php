<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var frontend\models\Idea $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container">
    <div class="row idea-form">
        <h1>Create post</h1>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col col-md-6 col-lg-6 col-sm-12">
                <?= $form->field($model, 'categoryId')->widget(Select2::classname(), [
                    'data' => $category,
                    'options' => ['placeholder' => 'Select a category ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col col-md-6 col-lg-6 col-sm-12">
                <?= $form->field($model, 'campaignId')->widget(Select2::classname(), [
                    'data' => $campaign,
                    'options' => ['placeholder' => 'Select an campaign ...'],
                    'pluginOptions' => [
                        'allowClear' => true
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
            <div class="col col-md-12 col-lg-12 col-sm-12">
                <label class="control-label">Anonymous</label>
                <?= $form->field($model, 'post_type')->widget(SwitchInput::classname(), [])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Post idea'), ['class' => 'btn btn-success', 'style' => ['width' => '100%']]) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>
</div>