<?php

namespace backend\models;

use common\models\Campaign as ModelsCampaign;
use Yii;

/**
 * This is the model class for table "academic".
 *
 * @property int $id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Idea[] $ideas
 */

class Campaign extends ModelsCampaign
{
    
}
