<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 12.01.2020
 * Time: 1:10
 */
use yii\web\View;

/** @var $this View */
/** @var $stat array */

?>

<div class="stat">
    <div class="row">
        <div class="col-md-3">
            <p class="bg-primary"><b>Произведено яблок:</b> <?= $stat['total'] ?></p>
            <p class="bg-success"><b>Съедено:</b> <?= $stat['eaten'] ?></p>
            <p class="bg-info"><b>В обороте:</b> <?= $stat['active'] ?></p>
        </div>
        <div class="col-md-3">
            <p class="bg-success"><b>На дереве:</b> <?= $stat['new'] ?></p>
            <p class="bg-danger"><b>Упало:</b> <?= $stat['down'] ?></p>
            <p class="bg-warning"><b>Сгнило:</b> <?= $stat['rotten'] ?></p>
        </div>
    </div>
</div>
