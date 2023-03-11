<?php

namespace frontend\models;

use common\models\Idea as ModelsIdea;
use Yii;

/**
 * This is the model class for table "idea".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property int|null $parentId
 * @property int|null $userId
 * @property int|null $attachmentId
 * @property int|null $categoryId
 * @property int|null $campaignId
 * @property int|null $upvote_count
 * @property int|null $downvote_count
 * @property int|null $post_type
 * @property int $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property Campaign $campaign
 * @property Attachment $attachment
 * @property Category $category
 * @property Idea[] $ideas
 * @property Idea $parent
 * @property Reaction[] $reactions
 * @property User $user
 */
class Idea extends ModelsIdea
{
    public $allowTermsConditions;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'string'],
            [['allowTermsConditions', 'title', 'content'], 'required'],
            [['parentId', 'userId', 'categoryId', 'campaignId', 'upvote_count', 'downvote_count', 'post_type', 'status'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'string', 'max' => 255],
            [['campaignId'], 'exist', 'skipOnError' => true, 'targetClass' => campaign::class, 'targetAttribute' => ['campaignId' => 'id']],
            [['parentId'], 'exist', 'skipOnError' => true, 'targetClass' => Idea::class, 'targetAttribute' => ['parentId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['categoryId' => 'id']],
            [['departmentId'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['departmentId' => 'id']],
            [['file'], 'file', 'maxFiles' => 0]
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
            'post_type' => Yii::t('app', 'Post Type'),
            'status' => Yii::t('app', 'Status'),
            'allowTermsConditions' => Yii::t('app', 'I allow the'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
