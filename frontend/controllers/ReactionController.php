<?php

namespace frontend\controllers;

use common\models\constant\ReactionTypeConstant;
use frontend\models\Idea;
use frontend\models\Reaction;
use frontend\models\ReactionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReactionController implements the CRUD actions for Reaction model.
 */
class ReactionController extends Controller
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
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }
    
    public function actionReactIdea($ideaId, $reactionType)
    {
        
    }
}
