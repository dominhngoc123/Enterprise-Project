<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hashtag".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 * 
 * @property IdeaTag[] $ideatags
 * 
 */
class Hashtag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hashtag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->created_at = new \yii\db\Expression('NOW()');
            $this->created_by = Yii::$app->user->identity->username;
            $this->status = 1;
        } else {
            $this->updated_at = new \yii\db\Expression('NOW()');
            $this->updated_by = Yii::$app->user->identity->username;
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[IdeaTag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdeatags()
    {
        return $this->hasMany(IdeaTag::class, ['hashtagId' => 'id']);
    }
}
