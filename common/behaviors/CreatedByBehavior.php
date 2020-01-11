<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 10.01.2020
 * Time: 23:44
 */

namespace common\behaviors;

use Closure;
use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\web\User;

/**
 * Class CreatedByBehavior
 *
 * ```php
 * use common\behaviors\CreatedByBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         'CreatedByBehavior' => [
 *             'class' => CreatedByBehavior::class,
 *             'attribute' => 'created_by',
 *             'value' => function($event){},
 *         ],
 *     ];
 * }
 * ```
 *
 * @package common\behaviors
 */
class CreatedByBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $user = 'user';

    /**
     * @var string
     */
    public $attribute = 'created_by';

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                ActiveRecord::EVENT_BEFORE_INSERT => [$this->attribute],
            ];
        }
    }

    /**
     * @param Event $event
     *
     * @return int|mixed|string
     */
    protected function getValue($event)
    {
        /** @var User $user */
        $user = Instance::ensure($this->user, User::class);

        return $this->value instanceof Closure ? call_user_func($this->value, $event) : $user->getId();
    }
}
