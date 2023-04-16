<?php

namespace common\models;

use common\models\constant\StatusConstant;
use common\models\constant\UserRolesConstant;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

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
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Department $department
 * @property Idea[] $ideas
 * @property Reaction[] $reactions
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['departmentId', 'status', 'role'], 'integer'],
            [['username', 'full_name', 'email'], 'string', 'max' => 50],
            [['phone_number'], 'string', 'max' => 10],
            [['password', 'avatar', 'address', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'string', 'max' => 255],
            [['dob'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['departmentId'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['departmentId' => 'id']],
            [['status'], 'default', 'value' => StatusConstant::ACTIVE],
            [['status'], 'in', 'range' => [StatusConstant::ACTIVE, StatusConstant::INACTIVE]],
            [['role'], 'default', 'value' => UserRolesConstant::STAFF],
            [['role'], 'in', 'range' => [UserRolesConstant::ADMIN, UserRolesConstant::QA_COORDINATOR, UserRolesConstant::QA_MANAGER, UserRolesConstant::STAFF]],
        ];
    }

    public function beforeSave($insert)
    {

        if ($this->isNewRecord) {
            $this->auth_key = \Yii::$app->security->generateRandomString();
            $this->created_at = new \yii\db\Expression('NOW()');
            $this->created_by = Yii::$app->user->identity->username;
            $this->status = 1;
        } else {
            $this->updated_at = new \yii\db\Expression('NOW()');
            $this->updated_by = Yii::$app->user->identity->username;
        }
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'dob' => Yii::t('app', 'Date of birth'),
            'phone_number' => Yii::t('app', 'Phone number'),
            'avatar' => Yii::t('app', 'Avatar'),
            'address' => Yii::t('app', 'Address'),
            'departmentId' => Yii::t('app', 'Department'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'User role'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'departmentId']);
    }

    /**
     * Gets query for [[Ideas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdeas()
    {
        return $this->hasMany(Idea::class, ['userId' => 'id']);
    }

    /**
     * Gets query for [[Reactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReactions()
    {
        return $this->hasMany(Reaction::class, ['userId' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => StatusConstant::ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => StatusConstant::ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function isUserAdmin($username)
    {
        if (static::findOne(['username' => $username, 'role' => UserRolesConstant::ADMIN, 'status' => StatusConstant::ACTIVE])) {
            return true;
        } else {
            return false;
        }
    }

    public static function isUserManager($username)
    {
        if (static::findOne(['username' => $username, 'role' => UserRolesConstant::QA_MANAGER, 'status' => StatusConstant::ACTIVE])) {
            return true;
        } else {
            return false;
        }
    }

    public static function isUserCoordinator($username)
    {
        if (static::findOne(['username' => $username, 'role' => UserRolesConstant::QA_COORDINATOR, 'status' => StatusConstant::ACTIVE])) {
            return true;
        } else {
            return false;
        }
    }

    public static function isUserStaff($username)
    {
        if (static::findOne(['username' => $username, 'role' => UserRolesConstant::STAFF, 'status' => StatusConstant::ACTIVE])) {
            return true;
        } else {
            return false;
        }
    }
}
