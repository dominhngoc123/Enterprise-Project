<?php

namespace backend\controllers;

use backend\models\Campaign;
use backend\models\Department;
use backend\models\Idea;
use backend\models\User;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (User::isUserAdmin(Yii::$app->user->identity->username) || User::isUserManager(Yii::$app->user->identity->username)) {
            $departmentData = Department::find()->all();
            $campaignData = Campaign::find()->all();
            $ideaData = Idea::find()->select(['count(*) as idea_count, MONTH(created_at), YEAR(created_at)'])->groupBy(['MONTH(created_at), YEAR(created_at)'])->all();

            return $this->render('index', [
                'departmentData' => $departmentData,
                'campaignData' => $campaignData,
                'ideaData' => $ideaData
            ]);
        } else {
            Yii::$app->session->setFlash('warning', 'You do not have permission to access this page');
        }
        return $this->goBack();
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goHome();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
