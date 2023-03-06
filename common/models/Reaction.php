<?php

namespace common\models;

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
class Reaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'ideaId', 'status'], 'integer'],
            [['created_at'], 'string', 'max' => 255],
            [['ideaId'], 'exist', 'skipOnError' => true, 'targetClass' => Idea::class, 'targetAttribute' => ['ideaId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'ideaId' => Yii::t('app', 'Idea ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
    
    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->userId = Yii::$app->user->identity->id;
        }
        $this->created_at = new \yii\db\Expression('NOW()');
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Idea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdea()
    {
        return $this->hasOne(Idea::class, ['id' => 'ideaId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }
}
