<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\User $model */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'full_name',
            'email:email',
            'dob',
            'address',
            'departmentId',
            'status',
            [
                'label' => 'Created at',
                'value' => function ($model)
                {
                    return date("d/m/Y H:i:s", $model->created_at);
                }
            ],
            'created_by',
            [
                'label' => 'Updated at',
                'value' => function ($model)
                {
                    if ($model->updated_at)
                    {
                        return date("d/m/Y H:i:s", $model->updated_at);
                    }
                    return "(not set)";
                }
            ],
            'updated_by',
        ],
    ]) ?>

</div>
