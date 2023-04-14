<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign".
 *
 * @property int $id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $closure_date
 * @property int $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Idea[] $ideas
 */
class Campaign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'campaign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['start_date', 'end_date', 'closure_date', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['start_date', 'end_date', 'closure_date', 'name'], 'required'],
            ['end_date','validateDates'],
            ['closure_date', 'validateClosureDate'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Campaign name'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function validateDates(){
        if(strtotime($this->end_date) <= strtotime($this->start_date)){
            $this->addError('start_date','Please give correct Start and End dates');
            $this->addError('end_date','Please give correct Start and End dates');
        }
        else
        {
            $now = date('Y-m-d h:i:s');
            if (strtotime($this->end_date) < strtotime($now))
            {
                $this->addError('end_date','End date must greater than current date');
            }
            if (strtotime($this->start_date) < strtotime($now))
            {
                $this->addError('start_date','Start date must greater than current date');
            }
        }
    }

    public function validateClosureDate() {
        if(strtotime($this->end_date) <= strtotime($this->closure_date) || strtotime($this->start_date) >= strtotime($this->closure_date)){
            $this->addError('closure_date','Please give correct closure dates (Must be between start and end date)');
        }
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
     * Gets query for [[Ideas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdeas()
    {
        return $this->hasMany(Idea::class, ['campaignId' => 'id']);
    }
}
