<?php

use backend\models\Idea;
use common\helpers\ChartDataHelper;
use common\models\constant\StatusConstant;
use dosamigos\chartjs\ChartJs;

$this->title = 'Admin';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <h5>Number of ideas per department</h5>
    <div class="row">
        <?php if ($departmentData) : ?>
            <?php foreach ($departmentData as $data) : ?>
                <div class="col-md-4 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => $data->name,
                        'number' => ChartDataHelper::getNumberOfIdeasPerDeparment($data),
                        'icon' => 'far fa-comment',
                    ]) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <h5>Number of ideas per campaign</h5>
    <div class="row">
        <?php if ($campaignData) : ?>
            <?php foreach ($campaignData as $data) : ?>
                <div class="col-md-4 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => $data->name,
                        'number' => ChartDataHelper::getNumberOfIdeasPerCampaign($data),
                        'icon' => 'far fa-comment',
                    ]) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col col-lg-12 col-md-12 col-sm-12 mr-10">
            <?php $current_year = date('Y'); ?>
            <label>Number of ideas per month in <?= $current_year ?></label>
            <?= ChartJs::widget([
                'type' => 'bar',
                'options' => [
                    'height' => 400,
                    'width' => 1200
                ],
                'data' => [
                    'labels' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    'datasets' => [
                        [
                            'label' => "Number of idea per month ($current_year)",
                            'backgroundColor' => "rgba(255,99,132,0.2)",
                            'borderColor' => "rgba(255,99,132,1)",
                            'pointBackgroundColor' => "rgba(255,99,132,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(255,99,132,1)",
                            'data' => ChartDataHelper::getNumberOfIdeasPerMonth()
                        ]
                    ],
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-12 col-md-12 col-sm-12 ml-10">
            <label>Number of reactions per month in <?= $current_year ?></label>
            <?= ChartJs::widget([
                'type' => 'line',
                'options' => [
                    'height' => 400,
                    'width' => 1200
                ],
                'data' => [
                    'labels' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    'datasets' => [
                        [
                            'label' => "Like count",
                            'backgroundColor' => "rgba(179,181,198,0.2)",
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => ChartDataHelper::getNumberOfLikePerMonth()
                        ],
                        [
                            'label' => "Unlike count",
                            'backgroundColor' => "rgba(255,99,132,0.2)",
                            'borderColor' => "rgba(255,99,132,1)",
                            'pointBackgroundColor' => "rgba(255,99,132,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(255,99,132,1)",
                            'data' => ChartDataHelper::getNumberOfUnLikePerMonth()
                        ]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-6">
        <label>Number of contributors per department</label>
            <?php
            echo ChartJs::widget([
                'type' => 'pie',
                'id' => 'structurePie',
                'options' => [
                    'height' => 400,
                    'width' => 400,
                ],
                'data' => [
                    'radius' =>  "100%",
                    'labels' => ChartDataHelper::getDepartmentLabels(), // Your labels
                    'datasets' => [
                        [
                            'data' => ChartDataHelper::getContributerInDepartment(), // Your dataset
                            'label' => '',
                            'backgroundColor' => [
                                '#ADC3FF',
                                '#FF9A9A',
                                'rgba(190, 124, 145, 0.8)'
                            ],
                            'borderColor' =>  [
                                '#fff',
                                '#fff',
                                '#fff'
                            ],
                            'borderWidth' => 1,
                            'hoverBorderColor' => ["#999", "#999", "#999"],
                        ]
                    ]
                ],
                'clientOptions' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                        'onClick' => null,
                        'labels' => [
                            'fontSize' => 14,
                            'fontColor' => "#425062",
                        ]
                    ],
                    'tooltips' => [
                        'enabled' => true,
                        'intersect' => true
                    ],
                    'hover' => [
                        'mode' => true
                    ],
                    'maintainAspectRatio' => true,

                ],
                'plugins' =>
                new \yii\web\JsExpression('
                        [{
                            afterDatasetsDraw: function(chart, easing) {
                                var ctx = chart.ctx;
                                chart.data.datasets.forEach(function (dataset, i) {
                                    var meta = chart.getDatasetMeta(i);
                                    console.log(meta.hidden);
                                    if (!meta.hidden) {
                                        meta.data.forEach(function(element, index) {
                                            // Draw the text in black, with the specified font
                                            ctx.fillStyle = \'rgb(0, 0, 0)\';
                
                                            var fontSize = 16;
                                            var fontStyle = \'normal\';
                                            var fontFamily = \'Helvetica\';
                                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
                
                                            // Just naively convert to string for now
                                            var dataString = dataset.data[index].toString();
                
                                            // Make sure alignment settings are correct
                                            ctx.textAlign = \'center\';
                                            ctx.textBaseline = \'middle\';
                
                                            var padding = 5;
                                            var position = element.tooltipPosition();
                                            ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                                        });
                                    }
                                });
                            }
                        }]')
            ]);
            ?>
        </div>
    </div>
</div>