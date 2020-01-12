<?php

namespace common\models;

use common\models\query\AppleQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use common\behaviors\TagDependencyBehavior;
use common\behaviors\CreatedByBehavior;
use backend\behaviors\ColorBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string|null $color
 * @property int|null $eaten
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $down_at
 * @property int $created_by
 *
 * @property User $createdByRelation
 */
class Apple extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_DOWN = 1;
    const STATUS_ROTTEN = 2;
    const STATUS_EATEN = 3;

    // in hours
    const TIME_ROT = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
            'CreatedByBehavior' => [
                'class' => CreatedByBehavior::class,
            ],
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'ColorBehavior' => [
                'class' => ColorBehavior::class,
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eaten', 'status', 'created_at', 'updated_at', 'down_at'], 'integer'],
            [['created_at', 'updated_at', 'color'], 'safe'],
            [['eaten'], 'default', 'value' => 0],
//            [
//                ['color'],
//                'match',
//                'pattern' => '/^#[0-9A-f]{6}$/i',
//                'message' => 'Цвет в формате HEX (#000fff)'
//            ],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'eaten' => 'Съедено (%)',
            'status' => 'Статус',

            'down_at' => 'Дата падения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',

            'created_by' => 'Пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedByRelation() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return AppleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_NEW => 'На дереве',
            self::STATUS_DOWN => 'Упало',
            self::STATUS_ROTTEN => 'Сгнило',
            self::STATUS_EATEN => 'Съедено',
        ];
    }

    /**
     * @return string|null
     */
    public function getStatusAsString(): ?string
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        $balance = 100 - $this->eaten;
        return $balance > 0 ? $balance : 0;
    }

    /**
     * @return null|string
     */
    public function getColorPreview(): ?string
    {
        if($this->color) {
            return Html::tag('div', '', [
                'class' => 'color-preview',
                'style' => 'background-color: ' . $this->color . ';',
            ]);
        }

        return null;
    }

    /**
     * @return bool
     */
    public function checkRotten(): bool
    {
        if(
            $this->status == self::STATUS_DOWN &&
            $this->down_at
        ){
            $timeRot = time() - (self::TIME_ROT * 60 * 60);
            // all apples down later than {{self::TIME_ROT}} hours ago - are rotten
            if($this->down_at <= $timeRot) {
                return true;
            }
        }

        return false;
    }

    public function checkEaten(): bool
    {
        return $this->getBalance() == 0;
    }

    /**
     * @return bool
     */
    public function canDown(): bool
    {
        return $this->status == self::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function canRot(): bool
    {
        return (
            $this->status == self::STATUS_DOWN && //down
            !$this->checkEaten() //not eaten
        );
    }

    /**
     * @return bool
     */
    public function canEat(): bool
    {
        return (
            $this->status == self::STATUS_DOWN && //down
            !$this->checkEaten() && //not eaten
            !$this->checkRotten() //not rotten
        );
    }
}
