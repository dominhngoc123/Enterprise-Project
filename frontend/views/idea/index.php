<?php

use common\models\constant\IdeaTypeConstant;
use frontend\models\Category;
use frontend\models\Idea;
use frontend\models\User;
use yii\bootstrap4\LinkPager;
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

    <?php Pjax::begin(); ?>

    <?php if ($ideas) : ?>

        <?php foreach ($ideas as $idea) : ?>
            <article class="row mb-5">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div>
                        <img loading="lazy" src="../images/post/post-4.jpg" class="img-fluid" alt="post-thumb" style="height:200px; object-fit: cover;">
                        
                    </div>
                </div>
                <div class="col-md-8">
                    <h3 class="h5"><a class="post-title" href="<?= Url::toRoute(['view', 'id' => $idea->id]) ?>"><?= $idea->title ?></a></h3>
                    <ul class="list-inline post-meta mb-2">
                        <li class="list-inline-item"><i class="ti-user mr-2"></i>
                        <?php if ($idea->post_type == IdeaTypeConstant::PUBLIC): ?>
                            <a href="<?= Url::to(['user/author', 'id' => $idea->userId]) ?>"><?= User::find()->where(['=', 'id', $idea->userId])->one()->full_name; ?></a>
                        <?php else: ?>
                            <span>Anonymous</span>
                        <?php endif; ?>
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
                    <a href="<?= Url::toRoute(['view', 'id' => $idea->id]) ?>" class="btn btn-outline-primary">Continue Reading</a>
                </div>
            </article>
        <?php endforeach; ?>

    <?php else : ?>
        <div style="text-align: center;">
            No idea found
        </div>
    <?php endif; ?>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
    <script>
        $(document).on('ready pjax:success', function() {
            //your javascript here    
            $('.post-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                dots: false,
                arrows: true,
                prevArrow: '<button type=\'button\' class=\'prevArrow\'><i class=\'ti-angle-left\'></i></button>',
                nextArrow: '<button type=\'button\' class=\'nextArrow\'><i class=\'ti-angle-right\'></i></button>'
            });
        });
    </script>
    <?php Pjax::end(); ?>
    <script>
        $(document).ready(function() {
            //your javascript here    
            $('.post-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                dots: false,
                arrows: true,
                prevArrow: '<button type=\'button\' class=\'prevArrow\'><i class=\'ti-angle-left\'></i></button>',
                nextArrow: '<button type=\'button\' class=\'nextArrow\'><i class=\'ti-angle-right\'></i></button>'
            });
        });
    </script>
</div>