<?php

namespace backend\controllers;

use backend\models\Hashtag;
use backend\models\HashtagSearch;
use common\models\constant\StatusConstant;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HashtagController implements the CRUD actions for Hashtag model.
 */
class HashtagController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
}
