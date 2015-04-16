<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sales;

/**
 * SalesSearch represents the model behind the search form about `app\models\Sales`.
 */
class SalesSearch extends Sales
{
    public $brand_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id','brand_id'], 'integer'],
            [['create_time', 'log'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Sales::find()->joinWith('branch');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                // Set the default sort by name ASC and created_at DESC.
                'defaultOrder' => [
                    'create_time' => SORT_ASC
                ]
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'branch_id' => $this->branch_id,
            'amount' => $this->amount,
            
            'brand_id' => $this->brand_id,
        ]);
        //'create_time' => $this->create_time,
        $query->andFilterWhere(['like', 'log', $this->log]);
        $query->andFilterWhere(['like', 'sales.create_time', $this->create_time]);

        return $dataProvider;
    }
}
