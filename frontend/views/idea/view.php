<?php

use frontend\models\Category;
use frontend\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Idea $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ideas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="idea-view">
    <section class="section post-content">
        <div class="container post-container">
            <article class="row mb-4">
                <div class="col-lg-10 mx-auto mb-4">
                    <h1 class="h2 mb-3"><?= $model->title ?></h1>
                    <ul class="list-inline post-meta mb-3">
                        <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.html"><?= User::find()->where(['=', 'id', $model->userId])->one()->full_name; ?></a>
                        </li>
                        <li class="list-inline-item">Date :
                            <?php
                            $time = strtotime('10/16/2003');
                            $date = date('Y-m-d', $time);
                            echo "$date";
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
                        <a class="btn text-green" id="like_btn"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;<span id="like_count"><?= $model->downvote_count ?></span></a>
                        <a class="btn text-red" id="unlike_btn"><i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;<span id="dislike_count"><?= $model->downvote_count ?></span></a>
                    </div>
                    <div class="post-comment">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" class="profile-photo-sm">
                        <p><a href="timeline.html" class="profile-link">Diana </a><i class="em em-laughing"></i> Lorem ipsum dolor sit
                            amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad
                            minim veniam, quis nostrud </p>
                    </div>
                    <div class="post-comment">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="profile-photo-sm">
                        <p><a href="timeline.html" class="profile-link">John</a>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                            sed do eiusmod tempor incididunt ut labore et dolore
                            magna aliqua. Ut enim ad minim veniam, quis nostrud </p>
                    </div>
                    <div class="post-comment">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="profile-photo-sm">
                        <input type="text" class="form-control" placeholder="Post a comment">
                    </div>
                </div>
            </article>
        </div>
    </section>

</div>