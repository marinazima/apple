<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 0:17
 */

use backend\components\grid\DatePickerColumn;
use backend\widgets\AppleGenerateWidget;
use common\models\Apple;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Apples');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= AppleGenerateWidget::widget() ?>
        </p>
    </div>

    <div class="card-content">
        <?=
        GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => [
                        'class' => 'grid-action-col'
                    ],
                ],
                'id',
                [
                    'attribute'=>'color',
                    'value' => function(Apple $model){
                        return $model->color ? ($model->getColorPreview() . $model->color) : null;
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute'=>'status',
                    'filter' => Apple::getStatusList(),
                    'value' => function(Apple $model){
                        return $model->getStatus();
                    },
                ],
                [
                    'attribute' => 'created_by',
                    'filter' => User::asDropDown(),
                    'value' => function (Apple $model) {
                        return ArrayHelper::getValue($model->createdByRelation, 'username');
                    }
                ],
                [
                    'class' => DatePickerColumn::class,
                    'attribute' => 'created_at',
                ],
                [
                    'class' => DatePickerColumn::class,
                    'attribute' => 'down_at',
                ],
//                [
//                    'class' => DatePickerColumn::class,
//                    'attribute' => 'updated_at',
//                ],
            ],
        ]);
        ?>

    </div>
</div>

