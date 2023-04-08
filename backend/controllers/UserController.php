<?php

namespace backend\controllers;

use backend\models\Department;
use backend\models\User;
use backend\models\UserSearch;
use common\models\constant\StatusConstant;
use common\models\constant\UserRolesConstant;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
                            'matchCallback' => function ($rule, $action) {
                                return User::isUserAdmin(Yii::$app->user->identity->username);
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $role = array(UserRolesConstant::ADMIN => 'Admin' , UserRolesConstant::QA_COORDINATOR => 'QA Coordinator', UserRolesConstant::QA_MANAGER =>'QA Manager', UserRolesConstant::STAFF => 'Staff');
        $department = Department::find()->where(['status' => StatusConstant::ACTIVE])->all();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->role == UserRolesConstant::ADMIN || $model->role == UserRolesConstant::QA_MANAGER)
                {
                    $model->departmentId = null;
                }
                if ($model->save())
                {
                    Yii::$app->session->setFlash('success', 'Successfully create user');
                    return $this->redirect(['view', 'id' => $model->id]);    
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Some errors occur when create new user');
                }                         
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'role' => $role,
            'model' => $model,
            'department' => ArrayHelper::map($department, 'id', 'name'),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $department = Department::find()->where(['status' => StatusConstant::ACTIVE])->all();
        $model = $this->findModel($id);
        $role = array(UserRolesConstant::ADMIN => 'Admin' , UserRolesConstant::QA_COORDINATOR => 'QA Coordinator', UserRolesConstant::QA_MANAGER =>'QA Manager', UserRolesConstant::STAFF => 'Staff');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Successfully update user');
            return $this->redirect(['view', 'id' => $model->id]);           
        }

        return $this->render('update', [
            'role' => $role,
            'model' => $model,
            'department' => ArrayHelper::map($department, 'id', 'name'),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->id != $id)
        {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Successfully delete user');
        }
        else
        {
            Yii::$app->session->setFlash('warning', 'Cannot delete yourself');
        }
        return $this->redirect(['index']);
    }

    public function actionUpdateStatus($id)
    {
        if (Yii::$app->user->identity->id != $id)
        {
            $model = $this->findModel($id);
            if ($model)
            {
                if ($model->status == StatusConstant::ACTIVE)
                {
                    $model->status = StatusConstant::INACTIVE;
                    if ($model->save())
                    {
                        Yii::$app->session->setFlash('success', 'Successfully deactive user');
                    }
                    else
                    {
                        Yii::$app->session->setFlash('error', 'Cannot deactive user');
                    }
                }
                else
                {
                    $model->status = StatusConstant::ACTIVE;
                    if ($model->save())
                    {
                        Yii::$app->session->setFlash('success', 'Successfully dective user success');
                    }
                    else
                    {
                        Yii::$app->session->setFlash('error', 'Cannot deactive user');
                    }
                }
            }
        }
        else
        {
            Yii::$app->session->setFlash('warning', 'Cannot deactive yourself');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
