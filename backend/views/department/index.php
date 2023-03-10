<?php

use backend\models\Department;
use common\models\constant\StatusConstant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\DepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Departments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Department'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'name',
            'description',
            'status',
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
                'urlCreator' => function ($action, Department $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
