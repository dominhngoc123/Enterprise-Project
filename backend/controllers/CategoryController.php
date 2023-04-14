<?php

namespace backend\controllers;

use backend\models\Category;
use backend\models\CategorySearch;
use backend\models\Idea;
use backend\models\User;
use common\models\constant\StatusConstant;
use common\models\constant\UserRolesConstant;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                                return User::isUserManager(Yii::$app->user->identity->username);
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Successfully create category');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Successfully update category');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $post = Idea::find()->where(['=', 'categoryId', $id])->one();
        if (!$post)
        {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Delete category success');
            return $this->redirect(['index']);
        }
        else
        {
            Yii::$app->session->setFlash('error', 'Cannot delete category due to existing idea(s)');
            return $this->redirect(['index']);
        }
    }

    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);
        if ($model)
        {
            if ($model->status == StatusConstant::ACTIVE)
            {
                $model->status = StatusConstant::INACTIVE;
                if ($model->save())
                {
                    Yii::$app->session->setFlash('success', 'Successfully deactive category');
                }
                else 
                {
                    Yii::$app->session->setFlash('error', 'Cannot deactive category');
                }
            }
            else
            {
                $model->status = StatusConstant::ACTIVE;
                if ($model->save())
                {
                    Yii::$app->session->setFlash('success', 'Successfully active category');
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Cannot active category');
                }
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
