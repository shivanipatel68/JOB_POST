<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;

/**
 * PostSearch represents the model behind the search form of `app\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'job_category_id', 'job_type_id', 'industry_type_id', 'short_desc', 'job_desc', 'start_date', 'pay_rate'], 'integer'],
            [['job_title'], 'safe'],
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
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
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
            'company_id' => $this->company_id,
            'job_category_id' => $this->job_category_id,
            'job_type_id' => $this->job_type_id,
            'industry_type_id' => $this->industry_type_id,
            'short_desc' => $this->short_desc,
            'job_desc' => $this->job_desc,
            'start_date' => $this->start_date,
            'pay_rate' => $this->pay_rate,
        ]);

        $query->andFilterWhere(['like', 'job_title', $this->job_title]);

        return $dataProvider;
    }
}
