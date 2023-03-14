<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class CampaignFixture extends ActiveFixture
{
    public $modelClass = '\common\models\Campaign';
    public $dataFile = '@tests/fixtures/data/campaign.php';
}