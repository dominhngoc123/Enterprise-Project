<?php

use common\models\constant\UserRolesConstant;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($isUpdate): ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => true]) ?>
    <?php else: ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>


    <div class="row">
        <div class="col col-md-6 col-lg-6 col-sm-12">
            <?= $form->field($model, 'dob')->widget(DatePicker::classname(), [
                'pluginOptions' => [
                    'format' => 'dd-M-yyyy',
                    'todayHighlight' => true
                ]
            ]) ?>
        </div>
        <div class="col col-md-6 col-lg-6 col-sm-12">
            <?= $form->field($model, 'role')->widget(Select2::classname(), [
                'data' => $role,
                'options' => ['placeholder' => 'Select role...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>
    </div>

    <div class="row" id="add_department">
        <div class="col col-md-6 col-lg-6 col-sm-12">
            <?= $form->field($model, 'departmentId')->widget(Select2::classname(), [
                'data' => $department,
                'options' => ['placeholder' => 'Select department ...'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ]) ?>
        </div>

    </div>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#user-role').on('change', function() {
                let role = $(this).val();
                if (role == 0 || role == 1) {
                    $('#add_department').hide();
                } else {
                    $('#add_department').show();
                }
            });
            $('#user-phone_number').on('keyup', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });
        });
    </script>
</div>