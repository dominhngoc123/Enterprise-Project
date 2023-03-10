<?php

namespace backend\models;

use common\models\User as ModelsUser;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $dob
 * @property string|null $avatar
 * @property string|null $address
 * @property int|null $departmentId
 * @property string $auth_key
 * @property int $status
 * @property int $role
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Department $department
 * @property Idea[] $ideas
 * @property Reaction[] $reactions
 */
class User extends ModelsUser
{
    
}
