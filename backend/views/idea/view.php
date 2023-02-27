<?php

use backend\models\Academic;
use backend\models\Category;
use backend\models\User;
use common\models\constant\IdeaTypeConstant;
use common\models\constant\StatusConstant;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Idea $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ideas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="idea-view">

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
            'title:ntext',
            [
                'label' => Yii::t('app', 'Content'),
                'value' => Html::encode(strip_tags($model->content))
            ],
            // 'parentId',
            [
                'label' => Yii::t('app', 'Author'),
                'value' => User::find()->where(['=', 'id', $model->userId])->one()->full_name
            ],
            [
                'label' => Yii::t('app', 'Category'),
                'value' => Category::find()->where(['=', 'id', $model->categoryId])->one()->name
            ],
            [
                'label' => Yii::t('app', 'Academic'),
                'value' => Academic::find()->where(['=', 'id', $model->academicId])->one()->name
            ],
            // 'upvote_count',
            // 'downvote_count',
            [
                'label' => Yii::t('app', 'Idea type'),
                'value' => $model->post_type == IdeaTypeConstant::ANONYMOUS ? 'Anonymous' : 'Public'
            ],
            [
                'label' => Yii::t('app', 'Status type'),
                'value' => $model->status == StatusConstant::ACTIVE ? 'Active' : 'Inactive'
            ],
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
