<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use yii\jui\AutoComplete;

/** @var yii\web\View $this */
/** @var frontend\models\Idea $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container">
    <div class="row idea-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col col-md-6 col-lg-6 col-sm-12">
                <?= $form->field($model, 'categoryId')->widget(Select2::classname(), [
                    'data' => $category,
                    'options' => ['placeholder' => 'Select a category ...']
                ])->label(Yii::t('app', "Category")) ?>
            </div>
            <div class="col col-md-6 col-lg-6 col-sm-12">
                <?= $form->field($model, 'campaignId')->widget(Select2::classname(), [
                    'data' => $campaign,
                    'options' => ['placeholder' => 'Select a campaign ...']
                ])->label(Yii::t("app", "Campaign")) ?>
            </div>
        </div>
        <?= $form->field($model, 'title')->textarea(['rows' => 4]) ?>
        <label for="hash-tag">Hash tag</label>
        <input type="text" id="hash-tag" class="form-control" />
        <?= $form->field($model, 'hashtag')->textArea(['rows' => 2, 'readonly' => true])->label(false); ?>
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
        <?php if ($model->isNewRecord) : ?>
            <div class="terms-conditions ml-10 row">
                <div class="col col-md-12 col-lg-12 col-sm-12">
                    <label class="control-label">Anonymous</label>
                    <?= $form->field($model, 'post_type')->widget(SwitchInput::classname(), [])->label(false); ?>
                </div>
                <div class="col col-md-12 col-lg-12 col-sm-12">
                    <?= $form->field($model, 'allowTermsConditions', [
                        'template' => '{input}',
                        'options' => ['tag' => false, 'required' => true]
                    ])->checkbox()->label(false) ?>
                    <a href="#" data-toggle="modal" data-target="#terms-conditions-modal">Terms and Conditions</a>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success disabled', 'id' => 'submit-idea', 'style' => ['width' => '100%']]) ?>
            </div>
        <?php else : ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'submit-idea', 'style' => ['width' => '100%']]) ?>
            </div>
        <?php endif; ?>

        <?php ActiveForm::end(); ?>


    </div>
</div>

<script>
    $(document).ready(function() {
        $('#hash-tag').on('keyup', function(e) {
            if (e.keyCode == 32) {
                let hashTag = $(this).val();
                if (hashTag.trim() !== "") {
                    if (hashTag.indexOf("#") == 0) {
                        hashTag = hashTag;
                    } else if (hashTag.indexOf("#") == -1) {
                        hashTag = "#" + hashTag;
                    } else {
                        hashTag = "#" + hashTag.replac("#", "");
                    }
                    if ($("#idea-hashtag").val().trim() !== "")
                    {
                        $("#idea-hashtag").val($("#idea-hashtag").val() + ", " + hashTag);
                    }
                    else
                    {
                        $("#idea-hashtag").val($("#idea-hashtag").val() + hashTag);
                    }
                    $("#hash-tag").val("");
                }
                else
                {
                    $("#hash-tag").val("");
                }
            }
        });
    });
</script>