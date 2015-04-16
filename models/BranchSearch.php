<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Branch;

/**
 * BranchSearch represents the model behind the search form about `app\models\Branch`.
 */
class BranchSearch extends Branch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'branch_type_id', 'address_id'], 'integer'],
            [['name', 'create_time', 'update_time'], 'safe'],
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
        $query = Branch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'branch_type_id' => $this->branch_type_id,
            'address_id' => $this->address_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
