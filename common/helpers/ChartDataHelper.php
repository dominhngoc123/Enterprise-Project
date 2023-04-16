<?php

namespace common\helpers;

use backend\models\Department;
use backend\models\Idea;
use common\models\constant\StatusConstant;

class ChartDataHelper
{
    public static function getNumberOfIdeasPerDeparment($department)
    {
        return count($department->ideas);
    }
    public static function getNumberOfIdeasPerCampaign($campaign)
    {
        return count($campaign->ideas);
    }
    public static function getNumberOfIdeasPerMonth()
    {
        $data = Idea::find()->select(['COUNT(*) as number_of_idea, MONTH(created_at) as month'])
            ->where(['=', 'YEAR(created_at)', date("Y")])
            ->andWhere(['=', 'status', StatusConstant::ACTIVE])
            ->andWhere(['IS', 'parentId', NULL])
            ->groupBy(['MONTH(created_at)'])->asArray()->all();
        $chart_data = [];
        for ($i = 1; $i < 13; $i++) {
            $chart_data[] = 0;
        }
        for ($i = 0; $i < count($data); $i++) {
            $chart_data[$data[$i]['month'] - 1] = $data[$i]['number_of_idea'];
        }
        return $chart_data;
    }

    public static function getDepartmentLabels()
    {
        $label = [];
        $departments = Department::find()->where(['=', 'status', StatusConstant::ACTIVE])->all();
        foreach ($departments as $department) {
            $label[] = $department->name;
        }
        return $label;
    }

    public static function getContributorInDepartment() {
        $data = Idea::find()->select(['COUNT(DISTINCT idea.userId) as contributor, department.name'])
            ->innerJoin('user', 'idea.userId = user.id')
            ->innerJoin('department', 'user.departmentId = department.id')
            ->where(['=', 'idea.status', StatusConstant::ACTIVE])
            ->where(['=', 'user.status', StatusConstant::ACTIVE])
            ->where(['=', 'department.status', StatusConstant::ACTIVE])
            ->andWhere(['IS', 'idea.parentId', NULL])
            ->groupBy(['department.name'])->asArray()->all();
        $chart_data = [];
        for ($i = 0; $i < count($data); $i++) {
            $chart_data[$i] = $data[$i]['contributor'];
        }
        return $chart_data;
    }
    public static function getNumberOfLikePerMonth() {
        $data = Idea::find()->select(['SUM(upvote_count) as like_count, MONTH(created_at) as month'])
            ->where(['=', 'YEAR(created_at)', date("Y")])
            ->andWhere(['=', 'status', StatusConstant::ACTIVE])
            ->andWhere(['IS', 'parentId', NULL])
            ->groupBy(['MONTH(created_at)'])->asArray()->all();
        $chart_data = [];
        for ($i = 1; $i < 13; $i++) {
            $chart_data[] = 0;
        }
        for ($i = 0; $i < count($data); $i++) {
            $chart_data[$data[$i]['month'] - 1] = $data[$i]['like_count'];
        }
        return $chart_data;
    }
    public static function getNumberOfUnLikePerMonth() {
        $data = Idea::find()->select(['SUM(downvote_count) as dislike_count, MONTH(created_at) as month'])
            ->where(['=', 'YEAR(created_at)', date("Y")])
            ->andWhere(['=', 'status', StatusConstant::ACTIVE])
            ->andWhere(['IS', 'parentId', NULL])
            ->groupBy(['MONTH(created_at)'])->asArray()->all();
        $chart_data = [];
        for ($i = 1; $i < 13; $i++) {
            $chart_data[] = 0;
        }
        for ($i = 0; $i < count($data); $i++) {
            $chart_data[$data[$i]['month'] - 1] = $data[$i]['dislike_count'];
        }
        return $chart_data;
    }
}
