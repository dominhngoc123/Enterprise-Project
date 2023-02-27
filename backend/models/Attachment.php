<?php

namespace backend\models;

use common\models\Attachment as ModelsAttachment;
use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $id
 * @property string $url
 * @property int $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Idea[] $ideas
 */
class Attachment extends ModelsAttachment
{
    
}
