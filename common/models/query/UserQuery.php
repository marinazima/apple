<?php

namespace common\models\query;
use common\models\User;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return UserQuery
     */
    public function active(): UserQuery
    {
        return $this->andWhere([User::tableName() . '.[[status]]' => User::STATUS_ACTIVE]);
    }
}
