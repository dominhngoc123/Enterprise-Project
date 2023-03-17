<?php

use yii\helpers\Url;
?>
<div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-user"></i> User profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col col-lg-12 mb-12 mb-lg-12">
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
                                                <p class="text-muted"><?php 
                                                    if (Yii::$app->user->identity->departmentId)
                                                    {
                                                        echo Yii::$app->user->identity->getDepartment()->one()->name;
                                                    }
                                                    else
                                                    {
                                                        echo "";
                                                    }
                                                ?></p>
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
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="<?= Url::to(['user/update', 'id' => Yii::$app->user->identity->id]) ?>" class="btn btn-primary">Update</a>
                </div>
            </div>
        </div>
    </div>