<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.20
 * Time: 01:41
 */

namespace backend\components\grid;

use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\jui\DatePicker;

/**
 * Class DatePickerColumn
 *
 * @package app\core\grid
 */
class DatePickerColumn extends DataColumn
{
    /**
     * @var string
     */
    public $dateFormat = 'php:Y-m-d';

    /**
     * @var string
     */
    public $format = 'datetime';

    /**
     * @var null
     */
    public $attributeFilter = null;

    /**
     * @var array
     */
    public $datePickerOptions = [
        'class' => 'form-control',
    ];

    public function init()
    {
        parent::init();

        if (empty($this->attribute)) {
            throw new InvalidConfigException('The "attribute" property must be set.');
        }

        if ($this->attributeFilter === null) {
            $this->attributeFilter = $this->attribute;
        }
    }

    /**
     * @return string
     */
    protected function renderFilterCellContent()
    {
        return DatePicker::widget([
            'model' => $this->grid->filterModel,
            'attribute' => $this->attributeFilter,
            'dateFormat' => $this->dateFormat,
            'options' => $this->datePickerOptions,
        ]);
    }
}
