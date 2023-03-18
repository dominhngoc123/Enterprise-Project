<?php

use common\models\constant\IdeaTypeConstant;
use common\models\constant\ReactionTypeConstant;
use common\models\constant\StatusConstant;
use frontend\models\Campaign;
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
<style>
    a {
  border: 0 !important; 
}
/* Add this attribute to the element that needs a tooltip */
[data-tooltip] {
  position: relative;
  z-index: 2;
  cursor: pointer;
}

/* Hide the tooltip content by default */
[data-tooltip]:before,
[data-tooltip]:after {
  visibility: hidden;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=0);
  opacity: 0;
  pointer-events: none;
}

/* Position tooltip above the element */
[data-tooltip]:before {
  position: absolute;
  bottom: 150%;
  left: 50%;
  margin-bottom: 5px;
  margin-left: -80px;
  padding: 7px;
  width: 220px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  background-color: #000;
  background-color: hsla(0, 0%, 20%, 0.9);
  color: #fff;
  content: attr(data-tooltip);
  text-align: center;
  font-size: 14px;
  line-height: 1.2;
}

/* Triangle hack to make tooltip look like a speech bubble */
[data-tooltip]:after {
  position: absolute;
  bottom: 150%;
  left: 50%;
  margin-left: -5px;
  width: 0;
  border-top: 5px solid #000;
  border-top: 5px solid hsla(0, 0%, 20%, 0.9);
  border-right: 5px solid transparent;
  border-left: 5px solid transparent;
  content: " ";
  font-size: 0;
  line-height: 0;
}

/* Show tooltip content on hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
  filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=100);
  opacity: 1;
}

.disabled {
    cursor: pointer !important;
    pointer-events: auto !important;
}
</style>
<?php Pjax::begin(['enablePushState' => false]) ?>
<div class="idea-view">
    <section class="section post-content">
        <?php
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = new DateTime();
        $campaign = Campaign::find()->where(['=', 'id', $model->campaignId])->andWhere(['=', 'status', StatusConstant::ACTIVE])->one();
        if (Yii::$app->user->identity->id == $model->userId && strtotime($campaign->start_date) <= strtotime($now->format('d-m-Y')) && strtotime($campaign->closure_date) >= strtotime($now->format('d-m-Y'))):
        ?>
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
                        <li class="list-inline-item"><i class="ti-user mr-2"></i>
                            <?php if ($model->post_type == IdeaTypeConstant::PUBLIC) : ?>
                                <a href="<?= Url::to(['user/author', 'id' => $model->userId]) ?>"><?= User::find()->where(['=', 'id', $model->userId])->one()->full_name; ?></a>
                            <?php else : ?>
                                <span>Anonymous</span>
                            <?php endif; ?>
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
                        <?php if ($reaction && $reaction->status == ReactionTypeConstant::LIKE): ?>
                            <span <?php if ($upvote_data != "") { echo "data-tooltip=$upvote_data"; }?> class="btn text-green" style="border: 0 !important;">
                            <i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;<span id="like_count"><?= $model->upvote_count ?></span>
                            </span>
                        <?php else: ?>
                            <a <?php if ($upvote_data != "") { echo "data-tooltip=$upvote_data"; }?> href="<?= Url::to(['reaction/react-idea', 'ideaId' => $model->id, 'reactionType' => ReactionTypeConstant::LIKE]); ?>" class="btn text-green" id="like_btn"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;<span id="like_count"><?= $model->upvote_count ?></span></a>
                        <?php endif; ?>
                        
                        <?php if ($reaction && $reaction->status == ReactionTypeConstant::UNLIKE): ?>
                            <span <?php if ($downvote_data != "") { echo "data-tooltip=$downvote_data"; }?> class="btn text-red" style="border: 0 !important;">
                            <i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;<span id="dislike_count"><?= $model->downvote_count ?></span>
                            </span>
                        <?php else: ?>
                            <a <?php if ($downvote_data != "") { echo "data-tooltip=$downvote_data"; }?> href="<?= Url::to(['reaction/react-idea', 'ideaId' => $model->id, 'reactionType' => ReactionTypeConstant::UNLIKE]); ?>" class="btn text-red" id="unlike_btn"><i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;<span id="dislike_count"><?= $model->downvote_count ?></span></a>
                    </div>
                        <?php endif; ?>
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
                    <?php
                    if (strtotime($campaign->end_date) >= strtotime($now->format('d-m-Y'))) : ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'create-comment-form',
                        'action' => Url::to(['idea/comment', 'ideaId' => $model->id])
                    ]); ?>
                        <div class="post-comment">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="profile-photo-sm">
                            <?= $form->field($new_comment, 'content', [
                                'options' => ['class' => 'w-100']
                            ])->textInput(['class' => 'form-control', 'placeholder' => 'Post a comment'])->label(false) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                </div>
            </article>
        </div>
    </section>
</div>

<?php Pjax::end() ?>