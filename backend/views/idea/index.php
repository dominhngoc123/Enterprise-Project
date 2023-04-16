<?php

use backend\models\Campaign;
use backend\models\Category;
use backend\models\Idea;
use backend\models\User;
use common\models\constant\IdeaTypeConstant;
use common\models\constant\StatusConstant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/** @var yii\web\View $this */
/** @var backend\models\IdeaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Ideas');
$this->params['breadcrumbs'][] = $this->title;
?>
</style>
<div class="idea-index">
    <?php
    $exportColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'title:ntext',
        [
            'attribute' => 'content',
            'headerOptions' => ['style' => 'width:40%'],
            'value' => function ($model) {
                return Html::encode(strip_tags($model->content));
            }
        ],
        [
            'attribute' => 'userId',
            'label' => 'Author',
            'headerOptions' => ['style' => 'width:20%'],
            'value' => function ($model) {
                $user = User::find()->where(['=', 'id', $model->userId])->one();
                return $user ? $user->full_name : NULL;
            }
        ],
        [
            'attribute' => 'categoryId',
            'label' => 'Category',
            'headerOptions' => ['style' => 'width:20%'],
            'value' => function ($model) {
                $category = Category::find()->where(['=', 'id', $model->categoryId])->one();
                return $category ? $category->name : NULL;
            }
        ],
        [
            'attribute' => 'campaignId',
            'label' => 'Campaign',
            'headerOptions' => ['style' => 'width:20%'],
            'value' => function ($model) {
                $campaign = Campaign::find()->where(['=', 'id', $model->campaignId])->one();
                return $campaign ? $campaign->name : NULL;
            }
        ],
        'upvote_count',
        'downvote_count',
        [
            'attribute' => 'post_type',
            'label' => 'Idea type',
            'headerOptions' => ['style' => 'width:20%'],
            'value' => function ($model) {
                if ($model->post_type == IdeaTypeConstant::ANONYMOUS) {
                    return 'Anonymous';
                }
                return 'Public';
            }
        ],
        [
            'attribute' => 'status',
            'headerOptions' => ['style' => 'width:10%'],
            'label' => 'Status',
            'value' => function ($model) {
                return $model->status == StatusConstant::ACTIVE ? 'Active' : 'Inactive';
            }
        ],
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    $columns = [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'title:ntext',
        [
            'attribute' => 'userId',
            'label' => 'Author',
            'headerOptions' => ['style' => 'width:20%'],
            'value' => function ($model) {
                return User::find()->where(['=', 'id', $model->userId])->one()->full_name;
            }
        ],
        [
            'attribute' => 'status',
            'headerOptions' => ['style' => 'width:10%'],
            'label' => 'Status',
            'value' => function ($model) {
                return $model->status == StatusConstant::ACTIVE ? 'Active' : 'Inactive';
            }
        ],
        'created_at',

        [
            'class' => ActionColumn::className(),
            'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
            'headerOptions' => ['style' => 'width:10%'],
            'urlCreator' => function ($action, Idea $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update-status}',
            'buttons' => [
                'update-status' => function ($url, $model) {
                    if ($model->status == StatusConstant::ACTIVE) {
                        return Html::a('<span class="fa fa-toggle-off"></span>', $url, [

                            'title' => Yii::t('yii', 'Deactive'),
                        ]);
                    } else {
                        return Html::a('<span class="fa fa-toggle-on"></span>', $url, [

                            'title' => Yii::t('yii', 'Active'),
                        ]);
                    }
                }
            ],
            'headerOptions' => ['style' => 'width:5%'],
            'urlCreator' => function ($action, Idea $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ];
    ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <?= Html::a(Yii::t('app', 'Create Idea'), ['create'], ['class' => 'btn btn-success']) ?> -->
    <?= Html::a('<i class="fa fa-download"></i> Download attachments', ['idea/download-zip'], ['class' => 'btn btn-success', 'title' => 'Download attachments']) ?>
    <?php

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $exportColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'clearBuffers' => true, //optional
        'exportContainer' => [
            'class' => 'btn-group mr-2'
        ],
        'exportConfig' => [
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_EXCEL => [
                'label' => Yii::t('app', 'Export Excel')
            ],
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_CSV   => [
                'label'           => Yii::t('app', 'Export CSV'),
            ],
            ExportMenu::FORMAT_EXCEL_X => [
                'label'           => Yii::t('app', 'Export Excel 2007+'),
            ],
        ],
        'dropdownOptions' => [
            'class' => 'btn',
        ],
        'columnSelectorMenuOptions' => [
            'style' => 'overflow-y: scroll, height: auto; 
                       max-height: 250px;  overflow-x: hidden; padding-left: 20px',
        ]
    ]); ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => 'yii\bootstrap5\LinkPager'
        ],
        'columns' => $columns,
    ]); ?>

    <?php Pjax::end(); ?>

</div>