<?php

namespace backend\models;

use common\models\Reaction as ModelsReaction;
use Yii;

/**
 * This is the model class for table "reaction".
 *
 * @property int $id
 * @property int|null $userId
 * @property int|null $ideaId
 * @property int $status
 * @property string|null $created_at
 *
 * @property Idea $idea
 * @property User $user
 */
class Reaction extends ModelsReaction
{
    
}
