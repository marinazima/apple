<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 18:52
 */
use common\models\Apple;

/** @var $this yii\web\View */
/** @var $model Apple*/
?>

<div id="item-<?= $model->id ?>"
    class="list-item js-item"
    data-id="<?= $model->id ?>"
>
    <?= $this->render('_list-inner', [
        'model' => $model,
    ]) ?>
</div>
