<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 18:52
 */
use common\models\Apple;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model Apple*/
?>

<div class="js-item-inner">
    <?= $model->getColorPreview() ?>
        <span class="js-status">
            <b><?= $model->getStatusAsString() ?></b>
        </span>
    <?php if($model->down_at): ?>
        <span class="js-down-date">
            Дата падения:<?= \Yii::$app->formatter->asDatetime($model->down_at) ?>
        </span>
    <?php endif; ?>
    <?php if($model->eaten > 0): ?>
        <span class="js-balance">
            Остаток: <?= $model->getBalance() ?>%
        </span>
    <?php endif; ?>

    <div class="pull-right">
        <?php if($model->canDown()): ?>
            <button title="Упасть"
                    class="js-down"
            >
                <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
            </button>
        <?php endif; ?>

        <?php if($model->canEat()): ?>
            <button title="Съесть"
                    class="js-eat"
                    data-balance="<?= $model->getBalance() ?>"
            >
                <span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span>
            </button>
        <?php endif; ?>
    </div>
</div>


