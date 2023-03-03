<?php

namespace backend\models;

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
    
}
