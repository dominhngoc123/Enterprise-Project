<?php

use frontend\models\Category;
use frontend\models\Idea;
use frontend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\IdeaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Ideas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="idea-index">
    <?php if (!Yii::$app->user->isGuest) : ?>
        <script>
            alert(<?= Yii::$app->user->identity->full_name ?>);
        </script>
    <?php endif; ?>

    <?php Pjax::begin(); ?>

    <?php if ($ideas) : ?>

        <?php foreach ($ideas as $idea) : ?>
            <article class="row mb-5">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="post-slider slider-sm">
                        <img loading="lazy" src="images/post/post-4.jpg" class="img-fluid" alt="post-thumb" style="height:200px; object-fit: cover;">
                        <img loading="lazy" src="images/post/post-1.jpg" class="img-fluid" alt="post-thumb" style="height:200px; object-fit: cover;">
                    </div>
                </div>
                <div class="col-md-8">
                    <h3 class="h5"><a class="post-title" href="<?= Url::toRoute(['view', 'id' => $idea->id]) ?>"><?= $idea->title ?></a></h3>
                    <ul class="list-inline post-meta mb-2">
                        <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.html"><?= User::find()->where(['=', 'id', $idea->userId])->one()->full_name; ?></a>
                        </li>
                        <li class="list-inline-item">
                            <?php
                                $time = strtotime('10/16/2003');
                                $date = date('Y-m-d',$time);
                                echo "$date";
                            ?>
                        </li>
                        <li class="list-inline-item">Category : <a href="#" class="ml-1"><?= Category::find()->where(['=', 'id', $idea->categoryId])->one()->name; ?></a>
                        </li>
                    </ul>
                    <div class="snip_text mb-10"><?= htmlspecialchars_decode(stripslashes($idea->content)); ?></div>
                    <a href="post-details-1.html" class="btn btn-outline-primary">Continue Reading</a>
                </div>
            </article>
        <?php endforeach; ?>

    <?php else : ?>
        <div style="text-align: center;">
            No idea found
        </div>
    <?php endif; ?>

    <?php Pjax::end(); ?>

</div>