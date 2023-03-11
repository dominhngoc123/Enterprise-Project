<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Navbar -->
<header class="sticky-top bg-white border-bottom border-default">
   <div class="container">

      <nav class="navbar navbar-expand-lg navbar-white">
         <a class="navbar-brand" href="/">
            <img class="img-fluid" width="150px" src="../images/logo.png" alt="LogBook">
         </a>
         <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
            <i class="ti-menu"></i>
         </button>

         <div class="collapse navbar-collapse text-center" id="navigation">
            <ul class="navbar-nav ml-auto">
               <li class="nav-item">
                  <a class="nav-link" href="/">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Contact</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                     Account</i>
                  </a>
                  <div class="dropdown-menu">
                     <a class="dropdown-item" href="#" class="d-block" data-toggle="modal" data-target="#profile-modal">Profile</a>
                     <a class="dropdown-item" href="<?= Url::to(['idea/get-ideas-by-author', 'authorId' => Yii::$app->user->identity->id]); ?>" class="d-block">Posted ideas</a>
                     <a class="dropdown-item" href="index-full-right.html">View data</a>
                     <?= Html::a('Logout', ['/site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?>
                  </div>
               </li>
            </ul>

            <!-- search -->
            <div class="search px-4">
               <button id="searchOpen" class="search-btn"><i class="ti-search"></i></button>
               <div class="search-wrapper">
                  <form action="<?= Url::to(['idea/search']) ?>" method="GET" class="h-100">
                     <input class="search-box pl-4" id="search-query" name="inputSearch" type="search" placeholder="Type &amp; Hit Enter...">
                  </form>
                  <button id="searchClose" class="search-close"><i class="ti-close text-dark"></i></button>
               </div>
            </div>

         </div>
      </nav>
   </div>
</header>
<!-- /.navbar -->