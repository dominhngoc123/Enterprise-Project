<?php

use common\models\constant\UserRolesConstant;
use yii\helpers\Url;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::toRoute(['index']); ?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 1">
        <span class="brand-text font-weight-light">Administrator</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block" data-toggle="modal" data-target="#profile-modal"><?= Yii::$app->user->identity->full_name; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            if (Yii::$app->user->identity->role == UserRolesConstant::ADMIN)
            {
                $items = [
                    [
                        'label' => 'USERS',
                        'icon' => 'users',
                        // 'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Manage users', 'url' => ['user/index'], 'icon' => 'user'],
                        ]
                    ],
                    [
                        'label' => 'UNIVERSITY',
                        'icon' => 'university',
                        // 'iconStyle' => 'fa-solid',
                        // 'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Manage campaign', 'url' => ['campaign/index'], 'icon' => 'calendar'],
                            ['label' => 'Manage department', 'url' => ['department/index'], 'icon' => 'building'],
                        ]
                    ],
                ];
            }
            else if (Yii::$app->user->identity->role == UserRolesConstant::QA_MANAGER)
            {
                $items = [
                    [
                        'label' => 'USERS',
                        'icon' => 'users',
                        // 'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Manage users', 'url' => ['user/index'], 'icon' => 'user'],
                        ]
                    ],
                    [
                        'label' => 'CONTENT',
                        'icon' => 'tachometer-alt',
                        // 'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Manage category', 'url' => ['category/index'], 'icon' => 'bookmark', 'disabled' => true],
                            ['label' => 'Manage idea', 'url' => ['idea/index'], 'icon' => 'comment-alt', 'iconStyle' => 'fas'],
                        ]
                    ],
                ];
            }
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => $items
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>