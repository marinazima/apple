<?php

/**
 * Created by PhpStorm.
 * User: zima
 * Date: 10.01.2020
 * Time: 23:48
 */

namespace backend\behaviors;

use Closure;
use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\web\User;

/**
 * Class ColorBehavior
 *
 * ```php
 * use backend\behaviors\ColorBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         'ColorBehavior' => [
 *             'class' => ColorBehavior::class,
 *             'attribute' => 'color',
 *             'value' => function($event){},
 *         ],
 *     ];
 * }
 * ```
 *
 * @package backend\behaviors
 */
class ColorBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $attribute = 'color';

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
        return $this->value instanceof Closure ? call_user_func($this->value, $event) : $this->generateColor();
    }

    /**
     * @return string
     */
    protected function generateColor(): string
    {
        $hex = dechex(rand(0x000000, 0xFFFFFF));
        return '#' . $hex;
    }
}