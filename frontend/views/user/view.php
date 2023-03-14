<?php

use frontend\models\Category;
use frontend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\User $model */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<section class="section-sm border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="title-bordered mb-5 d-flex align-items-center">
                    <h1 class="h4"><?= $model->full_name ?></h1>
                    <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
                        <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-lg-12 mb-5 mb-lg-12">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="Avatar" class="img-fluid my-5" style="width: 100px;" />
                                <h5>Marie Horwitz</h5>
                                <p>Web Designer</p>
                                <i class="far fa-edit mb-5"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Name</h6>
                                            <p class="text-muted"><?= Yii::$app->user->identity->full_name ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?= Yii::$app->user->identity->email ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Birthday</h6>
                                            <p class="text-muted"><?= Yii::$app->user->identity->dob ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Department</h6>
                                            <p class="text-muted"><?= Yii::$app->user->identity->getDepartment()->one()->name; ?></p>
                                        </div>
                                    </div>
                                    <h6>Address</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-12 mb-6">
                                            <span class="text-muted"><?= Yii::$app->user->identity->address  ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title text-center">
                    <h2 class="mb-5">Posted by this author</h2>
                </div>
            </div>
            <?php if ($ideas) : ?>
                <?php foreach ($ideas as $idea) : ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <article class="mb-5">
                            <h3 class="h5"><a class="post-title" href="<?= Url::toRoute(['view', 'id' => $idea->id]) ?>"><?= $idea->title ?></a></h3>
                            <ul class="list-inline post-meta mb-2">
                                <li class="list-inline-item"><i class="ti-user mr-2"></i>
                                    <a href="<?= Url::to(['user/author', 'id' => $idea->userId]) ?>">
                                        <?= User::find()->where(['=', 'id', $idea->userId])->one()->full_name; ?>
                                    </a>
                                </li>
                                <li class="list-inline-item">Posted at:
                                    <?php
                                    date_default_timezone_set('UTC');
                                    $posted_at = strtotime($idea->created_at);

                                    $date = date('Y-m-d', $posted_at);
                                    $time = date('h:i', $posted_at);
                                    echo "$date $time";
                                    ?>
                                </li>
                                <li class="list-inline-item">Category : <a href="<?= Url::to(['idea/get-ideas-by-category', 'categoryId' => $idea->categoryId]); ?>" class="ml-1"><?= Category::find()->where(['=', 'id', $idea->categoryId])->one()->name; ?></a>
                                </li>
                            </ul>
                            <div class="snip_text mb-10"><?= htmlspecialchars_decode(stripslashes($idea->content)); ?></div>
                            <a href="<?= Url::toRoute(['idea/view', 'id' => $idea->id]) ?>" class="btn btn-outline-primary">Continue Reading</a>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
            <?php endif; ?>
        </div>
    </div>
</section>