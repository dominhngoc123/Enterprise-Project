<?php

use common\models\constant\ReactionTypeConstant;
use common\models\constant\StatusConstant;
use frontend\models\Category;
use frontend\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\Idea $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ideas'), 'url' => ['../idea/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php Pjax::begin(['enablePushState' => false]) ?>
<div class="idea-view">
    <section class="section post-content">
        <?php if (Yii::$app->user->identity->id == $model->userId): ?>
        <div id="menu-wrap">
            <input type="checkbox" class="toggler" />
            <div class="dots">
                <div></div>
            </div>
            <div class="menu">
                <div>
                    <ul>
                        <li><a href="<?= Url::to(['idea/update', 'id' => $model->id]); ?>" class="link"><i class="fas fa-edit"></i> Update</a></li>
                        <li><?= Html::a('<i class="fas fa-trash"></i> Delete', ['idea/delete', 'id' => $model->id], ['data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],]) ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="container post-container">
            <article class="row mb-4">
                <div class="col-lg-10 mx-auto mb-4">
                    <h1 class="h2 mb-3"><?= $model->title ?></h1>
                    <ul class="list-inline post-meta mb-3">
                        <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.html"><?= User::find()->where(['=', 'id', $model->userId])->one()->full_name; ?></a>
                        </li>
                        <li class="list-inline-item">Date :
                            <?php
                            $posted_at = strtotime($model->created_at);
                            $date = date('Y-m-d', $posted_at);
                            $time = date('H:m', $posted_at);
                            echo "$date $time";
                            ?></li>
                        <li class="list-inline-item">Categories : <a href="#!" class="ml-1"><?= Category::find()->where(['=', 'id', $model->categoryId])->one()->name; ?></a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-10 mx-auto post-detail">
                    <div class="content">
                        <?= htmlspecialchars_decode(stripslashes($model->content)); ?>
                    </div>
                    <div class="line-divider"></div>
                    <div class="reaction">
                        <a href="<?= Url::to(['reaction/react-idea', 'ideaId' => $model->id, 'reactionType' => ReactionTypeConstant::LIKE]); ?>" class="btn text-green <?php if ($reaction && $reaction->status == ReactionTypeConstant::LIKE) {
                                                                                                                                                                            echo 'disabled';
                                                                                                                                                                        } ?>" id="like_btn"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;<span id="like_count"><?= $model->upvote_count ?></span></a>
                        <a href="<?= Url::to(['reaction/react-idea', 'ideaId' => $model->id, 'reactionType' => ReactionTypeConstant::UNLIKE]); ?>" class="btn text-red <?php if ($reaction && $reaction->status == ReactionTypeConstant::UNLIKE) {
                                                                                                                                                                            echo 'disabled';
                                                                                                                                                                        } ?>" id="unlike_btn"><i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;<span id="dislike_count"><?= $model->downvote_count ?></span></a>
                    </div>
                    <?php if ($comments) : ?>
                        <?php foreach ($comments as $comment) : ?>
                            <?php
                            $user = User::find()->where(['=', 'id', $comment->userId])->one();
                            ?>
                            <div class="post-comment">
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="<?= $user->full_name ?>" class="profile-photo-sm">
                                <p><?= $comment->content; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'create-comment-form',
                        'action' => URL::to(['idea/comment', 'ideaId' => $model->id])
                    ]); ?>
                    <div class="post-comment">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="profile-photo-sm">
                        <?= $form->field($new_comment, 'content', [
                            'options' => ['class' => 'w-100']
                        ])->textInput(['class' => 'form-control', 'placeholder' => 'Post a comment'])->label(false) ?>
                    </div>
                    <?php $form = ActiveForm::end(); ?>
                </div>
            </article>
        </div>
    </section>
</div>

<?php Pjax::end() ?>