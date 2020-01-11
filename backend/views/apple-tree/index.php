<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 0:17
 */

use backend\assets\AppleTreeAsset;
use backend\components\grid\DatePickerColumn;
use backend\widgets\AppleGenerateWidget;
use common\models\Apple;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Apple tree');
$this->params['breadcrumbs'][] = $this->title;

AppleTreeAsset::register($this);

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
        ListView::widget([
            'id' => 'apple-tree',
            'dataProvider' => $dataProvider,
            'itemView' => '_list',
            'summary' => false,
            'options' => [
                'data-url-down' => Url::to(['down']),
                'data-url-can-eat' => Url::to(['can-eat']),
                'data-url-eat' => Url::to(['eat']),
            ],
        ]);
        ?>

        <?= $this->render('_modals') ?>
    </div>
</div>

