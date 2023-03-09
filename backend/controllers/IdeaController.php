<?php

namespace backend\controllers;

use common\helpers\DownloadHelper;
use backend\models\Campaign;
use backend\models\Attachment;
use backend\models\Category;
use backend\models\Idea;
use backend\models\IdeaSearch;
use backend\models\UploadForm;
use common\helpers\EmailHelper;
use Yii;
use yii\bootstrap5\Html as Bootstrap5Html;
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
        $searchModel = new IdeaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
                $model->save();
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
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $category = Category::find()->where(['status' => 1])->all();
        $campaign = Campaign::find()->where(['status' => 1])->all();

        return $this->render('create', [
            'all_files' => $all_files,
            'all_files_preview' => $all_files_preview,
            'files_type' => $files_type,
            'model' => $model,
            'category' => ArrayHelper::map($category, 'id', 'name'),
            'campaign' => ArrayHelper::map($campaign, 'id', 'name'),
            'ideaType' => ArrayHelper::map(IdeaController::ideaType, 'id', 'name')
        ]);
    }

    public function actionComment($ideaId)
    {
        $comment = new Idea();
        if ($this->request->isPost) {
            if ($comment->load($this->request->post())) {
                $comment->title = null;
                $comment->parentId = $ideaId;
                $comment->categoryId = null;
                $comment->campaignId = null;
                $comment->upvote_count = 0;
                $comment->downvote_count = 0;
                if ($comment->save()) {
                    Yii::$app->session->setFlash('success', 'Create new comment success');
                } else {
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
        $category = Category::find()->where(['status' => 1])->all();
        $campaign = Campaign::find()->where(['status' => 1])->all();

        return $this->render('update', [
            'all_files' => $all_files,
            'all_files_preview' => $all_files_preview,
            'files_type' => $files_type,
            'model' => $model,
            'category' => ArrayHelper::map($category, 'id', 'name'),
            'campaign' => ArrayHelper::map($campaign, 'id', 'name'),
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

    public function actionDownloadZip()
    {
        DownloadHelper::DownloadZipFiles();
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
