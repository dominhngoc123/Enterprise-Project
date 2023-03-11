<?php

namespace frontend\controllers;

use backend\helpers\DownloadHelper;
use common\helpers\EmailHelper;
use common\models\constant\ConfigParams;
use common\models\constant\StatusConstant;
use frontend\models\Campaign;
use frontend\models\Attachment;
use frontend\models\Category;
use frontend\models\Department;
use frontend\models\Idea;
use frontend\models\IdeaSearch;
use frontend\models\Reaction;
use frontend\models\UploadForm;
use frontend\models\User;
use Yii;
use yii\bootstrap5\Html as Bootstrap5Html;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * IdeaController implements the CRUD actions for Idea model.
 */
class IdeaController extends Controller
{

    const ideaType = [
        [
            "id" => 0,
            "name" => "Public"
        ],
        [
            "id" => 1,
            "name" => "Anonymous"
        ]
    ];
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
     * Lists all Idea models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Idea::find()->where(['=', 'status', 1])->andWhere(['parentId' => NULL]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $ideas = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'ideas' => $ideas,
            'pages' => $pages
        ]);
    }

    /**
     * Displays a single Idea model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $new_comment = new Idea();
        $reaction = Reaction::find()->where(['=', 'userId', Yii::$app->user->identity->id])->andWhere(['=', 'ideaId', $id])->one();
        $comments = Idea::find()->where(['=',  'parentId', $id])->andWhere(['=', 'status', StatusConstant::ACTIVE])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'reaction' => $reaction,
            'new_comment' => $new_comment,
            'comments' => $comments
        ]);
    }

    /**
     * Creates a new Idea model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $all_files = array();
        $all_files_preview = array();
        $files_type = array();
        $model = new Idea();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->parentId = null;
                $model->upvote_count = 0;
                $model->downvote_count = 0;
                $files = UploadedFile::getInstances($model, 'file');
                $assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Create new comment success');
                    EmailHelper::emailWhenSubmitIdea($model);
                    $folder_name = 'idea_' . time();
                    FileHelper::createDirectory(Url::to('@backend') . '/web/uploads/' . $folder_name, $mode = 0775, $recursive = true);
                    foreach ($files as $file) {
                        $url = Url::to('@backend') . '/web/uploads/' . $folder_name . '/' . Yii::$app->security->generateRandomString(12) . '.' . $file->extension;
                        $file->saveAs($url);
                        $attachment = new Attachment();
                        $attachment->url = $url;
                        $attachment->file_type = $this->getFileType($file->extension);
                        $attachment->original_name = $file->name;
                        $attachment->ideaId = $model->id;
                        $attachment->save();
                    }
                    Yii::$app->session->setFlash('success', 'Create new idea success');
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Cannot create new idea');
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $category = Category::find()->where(['status' => StatusConstant::ACTIVE])->all();
        $campaign = Campaign::find()->where(['status' => StatusConstant::ACTIVE])->all();
        $department = Department::find()->where(['status' => StatusConstant::ACTIVE])->all();

        return $this->render('create', [
            'all_files' => $all_files,
            'all_files_preview' => $all_files_preview,
            'files_type' => $files_type,
            'model' => $model,
            'category' => ArrayHelper::map($category, 'id', 'name'),
            'campaign' => ArrayHelper::map($campaign, 'id', 'name'),
            'department' => ArrayHelper::map($department, 'id', 'name'),
            'ideaType' => ArrayHelper::map(IdeaController::ideaType, 'id', 'name')
        ]);
    }

    public function actionComment($ideaId)
    {
        $comment = new Idea();
        if ($this->request->isPost) {
            if ($comment->load($this->request->post())) {
                $comment->title = "";
                $comment->parentId = $ideaId;
                $comment->categoryId = null;
                $comment->campaignId = null;
                $comment->upvote_count = 0;
                $comment->downvote_count = 0;
                if ($comment->save()) {
                    Yii::$app->session->setFlash('success', 'Create new comment success');
                    $idea = Idea::find()->where(['id' => $ideaId])->andWhere(['status' => StatusConstant::ACTIVE])->one();
                    if ($idea && Yii::$app->user->identity->id != $idea->userId) {
                        EmailHelper::emailWhenCreateComment($idea, $comment);
                    }
                } else {
                    var_dump($comment->getErrors());
                    die();
                    Yii::$app->session->setFlash('error', 'Cannot create new comment');
                }
            }
        }
        return $this->redirect(['view', 'id' => $ideaId]);
    }

    /**
     * Updates an existing Idea model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $all_files = array();
        $all_files_preview = array();
        $files_type = array();
        $model = $this->findModel($id);
        $uploaded_file = Attachment::find()->where(['=', 'ideaId', $model->id])->all();
        $folder_url = "";
        if ($uploaded_file) {
            $folder_url = substr(end($uploaded_file)->url, 0, strripos(end($uploaded_file)->url, '/'));
            foreach ($uploaded_file as $file) {
                $all_files[] = Url::base(TRUE) . "/" . $file->url;
                $obj = (object) array('caption' => $file->original_name, 'url' => "/index.php?r=idea%2Fdelete-file&id=$file->id", 'key' => $file->id, 'type' => $file->file_type);
                $files_type[] = $file->file_type;
                $all_files_preview[] = $obj;
            }
        }
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->parentId = null;
            $model->upvote_count = 0;
            $model->downvote_count = 0;
            $removed_id = array();
            foreach ($uploaded_file as $file) {
                $removed_id[] = $file->id;
            }
            $this->deleteFiles($removed_id);
            $files = UploadedFile::getInstances($model, 'file');
            $assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
            $model->save();
            foreach ($files as $file) {
                if ($folder_url != '' && file_exists($folder_url)) {
                    $url = $folder_url . '/' . Yii::$app->security->generateRandomString(12) . '.' . $file->extension;
                } else {
                    $folder_name = 'idea_' . time();
                    FileHelper::createDirectory(Url::to('@backend') . '/web/uploads/' . $folder_name, $mode = 0775, $recursive = true);
                    $url = Url::to('@backend') . '/web/uploads/' . $folder_name . '/' . Yii::$app->security->generateRandomString(12) . '.' . $file->extension;
                }
                $file->saveAs($url);
                $attachment = new Attachment();
                $attachment->url = $url;
                $attachment->file_type = $this->getFileType($file->extension);
                $attachment->original_name = $file->name;
                $attachment->ideaId = $model->id;
                $attachment->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $category = Category::find()->where(['status' => StatusConstant::ACTIVE])->all();
        $campaign = Campaign::find()->where(['status' => StatusConstant::ACTIVE])->all();
        $department = Department::find()->where(['status' => StatusConstant::ACTIVE])->all();

        return $this->render('update', [
            'all_files' => $all_files,
            'all_files_preview' => $all_files_preview,
            'files_type' => $files_type,
            'model' => $model,
            'category' => ArrayHelper::map($category, 'id', 'name'),
            'campaign' => ArrayHelper::map($campaign, 'id', 'name'),
            'department' => ArrayHelper::map($department, 'id', 'name'),
            'ideaType' => ArrayHelper::map(IdeaController::ideaType, 'id', 'name')
        ]);
    }

    public function actionDeleteFile($id)
    {
        $file = Attachment::findOne($id);
        $check = $file->delete();
        if ($check) {
            unlink($file->url);
        }
    }

    public function deleteFiles($id)
    {
        $url = Attachment::find()->select(['url'])->where(['IN', 'id', $id])->one();
        if ($url) {
            $folder_url = substr($url->url, 0, strripos($url->url, '/'));
            $check = Attachment::deleteAll(['ideaId' => $id]);
            if ($check && is_dir($folder_url)) {
                $this->rmdir_recursive($folder_url);
            }
        }
    }

    public function deleteFilesOfIdea($id)
    {
        $url = Attachment::find()->select(['url'])->where(['=', 'ideaId', $id])->one();
        if ($url) {
            $folder_url = substr($url->url, 0, strripos($url->url, '/'));
            $check = Attachment::deleteAll(['ideaId' => $id]);
            if ($check && is_dir($folder_url)) {
                $this->rmdir_recursive($folder_url);
            }
        }
    }

    function rmdir_recursive($dir)
    {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) $this->rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    /**
     * Deletes an existing Idea model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->deleteFilesOfIdea($id);
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('idea', ['parentId' => $id])
            ->execute();
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('reaction', ['ideaId' => $id])
            ->execute();
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Idea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Idea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Idea::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    private function sendEmailToCoordinator($idea)
    {
        $send_from = ConfigParams::SMTP_EMAIL;
    }

    public function actionGetIdeasByCategory($categoryId)
    {
        $query = Idea::find()->where(['=', 'categoryId', $categoryId])->andWhere(['=', 'status', StatusConstant::ACTIVE]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $ideas = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'ideas' => $ideas,
            'pages' => $pages
        ]);
    }

    public function actionGetIdeasByDepartment($departmentId)
    {
        $query = Idea::find()->where(['=', 'departmentId', $departmentId])->andWhere(['=', 'status', StatusConstant::ACTIVE]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $ideas = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'ideas' => $ideas,
            'pages' => $pages
        ]);
    }

    public function actionGetIdeasByAuthor($authorId)
    {
        $query = Idea::find()->where(['=', 'userId', $authorId])->andWhere(['=', 'status', StatusConstant::ACTIVE])->andWhere(['parentId' => NULL]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $ideas = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'ideas' => $ideas,
            'pages' => $pages
        ]);
    }

    public function actionSearch($inputSearch)
    {
        $query = Idea::find();
        $query->andFilterWhere(['like', 'title', $inputSearch])
            ->orFilterWhere(['like', 'content', $inputSearch]);
        $query->andwhere(['=', 'status', StatusConstant::ACTIVE])->andWhere(['parentId' => NULL]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $ideas = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'ideas' => $ideas,
            'pages' => $pages
        ]);
    }

    private function getFileType($extension)
    {
        $extension = "." . $extension;
        switch ($extension) {
            case  '.txt':
                return 'text';

            case '.doc':
            case '.docx':
            case '.ppt':
            case '.pptx':
            case '.xls':
            case '.xlsx':
                return 'office';

            case '.pdf':
                return 'pdf';

            case '.jpg':
            case '.jpeg':
            case '.png':
            case '.gif':
            case '.tif':
            case '.tiff':
                return 'image';

            case '.wav':
            case '.mp3':
            case '.m4a':
            case '.ogg':
            case '.flac':
            case '.wma':
            case '.aac':
            case '.gsm':
            case '.dct':
            case '.aiff':
            case '.au':
                return 'audio';

            default:
                return 'other';
        }
    }
}
