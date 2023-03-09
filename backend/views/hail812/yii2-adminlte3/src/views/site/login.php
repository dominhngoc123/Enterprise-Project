<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Admin sign in');
?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="../images/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 contents justify-content-center card">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3 class="text-center">Admin sign in</h3>
                        </div>
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <div class="form-group first">
                            <?= $form->field($model, 'username', [
                                'options' => ['class' => 'form-control round-10'],
                                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                                'wrapperOptions' => ['class' => 'input-group mb-3 mt-3']
                            ])->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

                        </div>
                        <div class="form-group last mb-4">
                            <?= $form->field($model, 'password', [
                                'options' => ['class' => 'form-control'],
                                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                                'wrapperOptions' => ['class' => 'input-group mb-3 mt-3']
                            ])->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

                        </div>

                        <div class="d-flex mb-1 align-items-center mb-4">
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => '<div class="icheck-primary">{input}&nbsp;{label}</div>',
                                'uncheck' => null
                            ]) ?>
                        </div>

                        <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block w-100']) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>