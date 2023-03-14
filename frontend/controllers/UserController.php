<?php

namespace frontend\controllers;

use common\models\constant\IdeaTypeConstant;
use common\models\constant\StatusConstant;
use frontend\models\Idea;
use frontend\models\User;
use frontend\models\UserSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAuthor($id)
    {
        $model = $this->findModel($id);
        $ideas = Idea::find()->where(['=', 'userId', $id])->andWhere(['=', 'status', StatusConstant::ACTIVE])->andWhere(['=', 'post_type', IdeaTypeConstant::PUBLIC])->andWhere(['parentId' => NULL])->all();
        return $this->render('view', [
            'model' => $model,
            'ideas' => $ideas
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
