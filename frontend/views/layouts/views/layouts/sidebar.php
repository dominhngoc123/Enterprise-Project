<?php

use common\models\constant\StatusConstant;
use frontend\models\Category;
use frontend\models\Idea;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Url;

?>

<div class="widget">
      <h5 class="widget-title"><span>Search</span></h5>
      <form action="/logbook-hugo/search" class="widget-search">
         <input id="search-query" name="s" type="search" placeholder="Type &amp; Hit Enter...">
         <button type="submit"><i class="ti-search"></i>
         </button>
      </form>
   </div>
   <!-- categories -->
   <div class="widget">
      <h5 class="widget-title"><span>Categories</span></h5>
      <ul class="list-unstyled widget-list">
      <?php $categories = Category::find()->where(['=', 'status', StatusConstant::ACTIVE])->all(); ?>
      <?php if ($categories): ?>
         <?php foreach ($categories as $category): ?>
            <li><a href="#!" class="d-flex"><?= $category->name ?>
               <small class="ml-auto">(1)</small></a>
            </li>
         <?php endforeach; ?>
      <?php else: ?>
         <li><a href="" class="d-flex" style="pointer-events: none !important;">No category found</a></li>
      <?php endif; ?>
      </ul>
   </div>
   <!-- tags -->
   <!-- <div class="widget">
      <h5 class="widget-title"><span>Tags</span></h5>
      <ul class="list-inline widget-list-inline">
         <li class="list-inline-item"><a href="#!">Booth</a>
         </li>
         <li class="list-inline-item"><a href="#!">City</a>
         </li>
         <li class="list-inline-item"><a href="#!">Image</a>
         </li>
         <li class="list-inline-item"><a href="#!">New</a>
         </li>
         <li class="list-inline-item"><a href="#!">Photo</a>
         </li>
         <li class="list-inline-item"><a href="#!">Seasone</a>
         </li>
         <li class="list-inline-item"><a href="#!">Video</a>
         </li>
      </ul>
   </div> -->
   <!-- latest post -->
   <div class="widget">
      <?php $lastest_ideas = Idea::find()->where(['=', 'status', StatusConstant::ACTIVE])->orderBy(['created_at' => SORT_DESC])->limit(5)->all(); ?>
      <h5 class="widget-title"><span>Latest Ideas</span></h5>
      <?php if ($lastest_ideas): ?>
         <?php foreach ($lastest_ideas as $lastest_idea): ?>
            <ul class="list-unstyled widget-list">
               <li class="media widget-post align-items-center">
                  <a href="<?= Url::to(['idea/view', 'id' => $lastest_idea->id]); ?>">
                     <img loading="lazy" class="mr-3" src="../images/post/post-6.jpg">
                  </a>
                  <div class="media-body">
                     <h5 class="h6 mb-0"><a href="<?= Url::to(['idea/view', 'id' => $lastest_idea->id]); ?>"><?= $lastest_idea->title; ?></a></h5>
                     <small>
                        <?php
                           $time = strtotime('10/16/2003');
                           $date = date('Y-m-d',$time);
                           echo "$date";
                        ?>
                     </small>
                  </div>
               </li>
            </ul>
         <?php endforeach; ?>
      <?php else: ?>
         <ul class="list-unstyled widget-list">
         <li class="media widget-post align-items-center">
            <a href="post-elements.html">
               <img loading="lazy" class="mr-3" src="images/post/post-6.jpg">
            </a>
            <div class="media-body">
               <h5 class="h6 mb-0"><a style="pointer-events: none !important;">No lastest idea found</a></h5>
            </div>
         </li>
      </ul>
      <?php endif; ?>
   </div>
