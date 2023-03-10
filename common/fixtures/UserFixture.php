<?php

namespace common\fixtures;;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'common\models\User';
    public $dataFile = '@tests/fixtures/data/user.php';
}