<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Idea;

/**
 * IdeaSearch represents the model behind the search form of `backend\models\Idea`.
 */
class IdeaSearch extends Idea
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parentId', 'campaignId', 'upvote_count', 'downvote_count', 'post_type'], 'integer'],
            [['title', 'content', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['userId', 'categoryId', 'status'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Idea::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 5 ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parentId' => $this->parentId,
            'userId' => $this->userId,
            'categoryId' => $this->categoryId,
            'campaignId' => $this->campaignId,
            'upvote_count' => $this->upvote_count,
            'downvote_count' => $this->downvote_count,
            'post_type' => $this->post_type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);
        $query->andWhere(['parentId' => null]);
        return $dataProvider;
    }
}
