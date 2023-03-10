<?php

use backend\models\Idea;
use backend\models\User;
use common\models\constant\StatusConstant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\IdeaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Ideas');
$this->params['breadcrumbs'][] = $this->title;
?>
</style>
<div class="idea-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Idea'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-download"></i> Download attachments', ['idea/download-zip'], ['class' => 'btn btn-success', 'title' => 'Download attachments']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => 'yii\bootstrap5\LinkPager'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title:ntext',
            // [
            //     'attribute' => 'content',
            //     'headerOptions' => ['style' => 'width:40%'],
            //     'value' => function($model) {
            //         return Html::encode(strip_tags($model->content));
            //     }
            // ],
            // 'parentId',
            [
                'attribute' => 'userId',
                'label' => 'Author',
                'headerOptions' => ['style' => 'width:20%'],
                'value' => function($model) {
                    return User::find()->where(['=', 'id', $model->userId])->one()->full_name;
                }
            ],
            //'attachmentId',
            //'categoryId',
            //'campaignId',
            //'upvote_count',
            //'downvote_count',
            //'post_type',
            [
                'attribute' => 'status',
                'headerOptions' => ['style' => 'width:10%'],
                'label' => 'Status',
                'value' => function($model) {
                    return $model->status == StatusConstant::ACTIVE ? 'Active' : 'Inactive';
                }
            ],
            'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'class' => ActionColumn::className(),
                'template'=>'{view} {update} {update-status} {delete}',
                'buttons'=>[
                    'update-status' => function ($url, $model) {     
                        if ($model->status == StatusConstant::ACTIVE)
                        {
                            return Html::a('<span class="fa fa-toggle-off"></span>', $url, [

                                'title' => Yii::t('yii', 'Deactive'),
                            ]);  
                        }
                        else
                        {
                            return Html::a('<span class="fa fa-toggle-on"></span>', $url, [

                                'title' => Yii::t('yii', 'Active'),
                            ]);  
                        }                        
                      }
                  ],
                'headerOptions' => ['style' => 'width:10%'],
                'urlCreator' => function ($action, Idea $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
