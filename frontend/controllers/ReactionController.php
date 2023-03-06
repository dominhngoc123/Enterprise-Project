<?php

namespace frontend\controllers;

use common\models\constant\ReactionTypeConstant;
use frontend\models\Idea;
use frontend\models\Reaction;
use frontend\models\ReactionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReactionController implements the CRUD actions for Reaction model.
 */
class ReactionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }
    
    public function actionReactIdea(int $ideaId, int $reactionType)
    {
        
        //Check if reaction available
        $reaction = Reaction::find()->where(['=', 'userId', Yii::$app->user->identity->id])->andWhere(['=', 'ideaId', $ideaId])->one();
        if ($reaction)
        {
            
            //Check if reaction type is different from stored data
            if ($reaction->status != $reactionType)
            {
                $reaction->status = $reactionType;
                $reaction->save();
                $this->updateIdeaReactionCount($ideaId, $reactionType);
            }
        }
        else
        {
            $reaction = new Reaction();
            $reaction->ideaId = $ideaId;
            $reaction->status = $reactionType;
            $reaction->save();
            $this->updateIdeaReactionCount($ideaId, $reactionType);
        }
        return $this->render('../idea/view', [
            'model' => Idea::findOne($ideaId),
            'reaction' => $reaction
        ]);
    }

    private function updateIdeaReactionCount($ideaId, $reactionType)
    {
        $idea = Idea::find()->where(['=', 'id', $ideaId])->one();
        if ($reactionType == ReactionTypeConstant::LIKE)
        {
            $idea->upvote_count++;
            $idea->downvote_count == 0 ? 0 : $idea->downvote_count--;
        }
        else
        {
            $idea->downvote_count++;
            $idea->upvote_count == 0 ? 0 : $idea->upvote_count--;
        }
        $idea->save();
    }
}
