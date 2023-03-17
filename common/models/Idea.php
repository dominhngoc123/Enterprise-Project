<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "idea".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property int|null $parentId
 * @property int|null $userId
 * @property int|null $categoryId
 * @property int|null $campaignId
 * @property int|null $departmentId
 * @property int|null $upvote_count
 * @property int|null $downvote_count
 * @property int|null $view_count
 * @property int|null $post_type
 * @property int $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Campaign $campaign
 * @property Campaign $department
 * @property Attachment[] $attachments
 * @property Category $category
 * @property Idea[] $ideas
 * @property Idea $parent
 * @property Reaction[] $reactions
 * @property User $user
 */
class Idea extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'idea';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'string'],
            [['parentId', 'userId', 'categoryId', 'campaignId', 'upvote_count', 'downvote_count', 'view_count', 'post_type', 'status'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'string', 'max' => 255],
            [['campaignId'], 'exist', 'skipOnError' => true, 'targetClass' => campaign::class, 'targetAttribute' => ['campaignId' => 'id']],
            [['parentId'], 'exist', 'skipOnError' => true, 'targetClass' => Idea::class, 'targetAttribute' => ['parentId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['departmentId'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['departmentId' => 'id']],
            [['file'], 'file', 'maxFiles' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'parentId' => Yii::t('app', 'Parent ID'),
            'userId' => Yii::t('app', 'User ID'),
            'categoryId' => Yii::t('app', 'Category ID'),
            'departmentId' => Yii::t('app', 'Department ID'),
            'campaignId' => Yii::t('app', 'Campaign ID'),
            'upvote_count' => Yii::t('app', 'Upvote Count'),
            'downvote_count' => Yii::t('app', 'Downvote Count'),
            'view_count' => Yii::t('app', 'View Count'),
            'post_type' => Yii::t('app', 'Post Type'),
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
            $this->userId = Yii::$app->user->identity->id;
            $this->status = 1;
        } else {
            $this->updated_at = new \yii\db\Expression('NOW()');
            $this->updated_by = Yii::$app->user->identity->username;
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[campaign]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::class, ['id' => 'campaignId']);
    }

    /**
     * Gets query for [[department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'departmentId']);
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::class, ['ideaId' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'categoryId']);
    }

    /**
     * Gets query for [[Ideas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdeas()
    {
        return $this->hasMany(Idea::class, ['parentId' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Idea::class, ['id' => 'parentId']);
    }

    /**
     * Gets query for [[Reactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReactions()
    {
        return $this->hasMany(Reaction::class, ['ideaId' => 'id']);
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
