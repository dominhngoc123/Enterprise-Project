<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "idea_tag".
 *
 * @property int $id
 * @property int|null $ideaId
 * @property int|null $hashTagId
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 * 
 * @property Idea $idea
 * @property Hashtag $hashtag
 * 
 */
class IdeaTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'idea_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ideaId', 'hashtagId', 'status'], 'integer'],
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
            'ideaId' => Yii::t('app', 'Idea ID'),
            'hashtagId' => Yii::t('app', 'Hash Tag ID'),
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
     * Gets query for [[Idea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdea()
    {
        return $this->hasOne(Idea::class, ['id' => 'ideaId']);
    }

    /**
     * Gets query for [[Idea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHashtag()
    {
        return $this->hasOne(Hashtag::class, ['id' => 'hashtagId']);
    }
}
