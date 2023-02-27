<?php

namespace backend\models;

use common\models\Department as ModelsDepartment;
use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property User[] $users
 */
class Department extends ModelsDepartment
{
    
}
