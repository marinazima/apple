<?php

namespace common\models\query;
use common\models\Apple;

/**
 * This is the ActiveQuery class for [[Apple]].
 *
 * @see Apple
 */
class AppleQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Apple[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Apple|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return AppleQuery
     */
    public function active(): AppleQuery
    {
        return $this->andWhere(['NOT', [Apple::tableName() . '.[[status]]' => Apple::STATUS_EATEN]]);
    }

    /**
     * @param int $status
     * @return AppleQuery
     */
    public function status(int $status): AppleQuery
    {
        return $this->andWhere([Apple::tableName() . '.[[status]]' => $status]);
    }

    /**
     * @param int $sort
     * @return AppleQuery
     */
    public function orderByCreatedAt(int $sort = SORT_DESC): AppleQuery
    {
        return $this->orderBy([Apple::tableName() . '.[[created_at]]' => $sort]);
    }
}
