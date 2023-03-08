<?php

namespace common\fixtures;;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'backend\models\User';
    public $dataFile = '@tests/fixtures/data/user.php';
}