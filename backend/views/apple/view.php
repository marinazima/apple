<?php

use common\models\Apple;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model Apple */

$this->title = Yii::t('app', 'Apple') . '#' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apple stat'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
        </p>
    </div>

    <div class="card-content">

        <?= DetailView::widget([
        'options' => ['class' => 'table'],
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'color',
                'value' => $model->getColorPreview(),
                'format' => 'raw',
            ],             
            [
                'attribute' => 'status',
                'value' => $model->getStatusAsString(),
            ],
            [
                'attribute' => 'eaten',
                'value' => $model->eaten . '%',
            ],
            [
                'attribute' => 'balance',
                'value' => $model->getBalance() . '%',
                'label' => 'Остаток',
            ],
            [
                'attribute' => 'created_by',
                'value' => ArrayHelper::getValue($model, ['createdByRelation', 'username']),
            ],
            'created_at:datetime',
            'down_at:datetime',
            'updated_at:datetime',
        ],
        ]) ?>

    </div>
</div>
