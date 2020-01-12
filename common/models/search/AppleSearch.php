<?php

namespace common\models\search;

use common\models\Apple;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * AppleSearch represents the model behind the search form about `common\models\search`.
 */
class AppleSearch extends Apple
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by'], 'integer'],
            [['created_at', 'down_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = Apple::find()
            ->joinWith(['createdByRelation']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            Apple::tableName() . '.[[id]]' => $this->id,
            Apple::tableName() . '.[[status]]' => $this->status,
            Apple::tableName() . '.[[created_by]]' => $this->created_by,
        ]);

        $query
            ->andFilterWhere(['like', new Expression('FROM_UNIXTIME(' . Apple::tableName() . '.[[created_at]])'), $this->created_at])
            ->andFilterWhere(['like', new Expression('FROM_UNIXTIME(' . Apple::tableName() . '.[[down_at]])'), $this->down_at]);

        return $dataProvider;
    }
}
