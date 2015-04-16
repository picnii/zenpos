<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BillPending;
use app\models\Bill;

/**
 * BranchSearch represents the model behind the search form about `app\models\Branch`.
 */
class BillPendingSearch extends BillPending
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'branch_id', 'amount'], 'integer'],
            [['branch_id', 'amount', 'bill_id'], 'safe'],
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
        $query = BillPending::find();
        $query->joinWith('bill');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'branch_id' => $this->branch_id,
            'bill_id' => $this->bill_id,
            'amount' => $this->amount,
            'update_time' => $this->update_time,
        ]);


        return $dataProvider;
    }
}
