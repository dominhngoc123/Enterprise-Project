<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $id
 * @property int $ideaId
 * @property string $url
 * @property string|null $file_type
 * @property string|null $original_name
 * @property int $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Idea $idea
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ideaId', 'url'], 'required'],
            [['ideaId', 'status'], 'integer'],
            [['url', 'original_name', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'string', 'max' => 255],
            [['file_type'], 'string', 'max' => 10],
            [['ideaId'], 'exist', 'skipOnError' => true, 'targetClass' => Idea::class, 'targetAttribute' => ['ideaId' => 'id']],
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
            'url' => Yii::t('app', 'Url'),
            'file_type' => Yii::t('app', 'File Type'),
            'original_name' => Yii::t('app', 'Original Name'),
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
}
