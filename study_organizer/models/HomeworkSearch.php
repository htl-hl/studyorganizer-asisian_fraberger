<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Homework;

/**
 * HomeworkSearch represents the model behind the search form of `app\models\Homework`.
 */
class HomeworkSearch extends Homework
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['H_ID', 'H_is_done', 'H_S_ID'], 'integer'],
            [['H_title', 'H_description', 'H_due_date'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Homework::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'H_ID' => $this->H_ID,
            'H_due_date' => $this->H_due_date,
            'H_is_done' => $this->H_is_done,
            'H_S_ID' => $this->H_S_ID,
        ]);

        $query->andFilterWhere(['like', 'H_title', $this->H_title])
            ->andFilterWhere(['like', 'H_description', $this->H_description]);

        return $dataProvider;
    }
}
