<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 21:07
 */
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */

?>

<!-- modals -->
<?php $this->beginBlock('modalEat'); ?>
<div id="modalEat"
     role="dialog"
     aria-hidden="true"
     class="modal fade"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Съесть яблоко</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= Html::beginForm(['create'], 'GET', [
                'id' => 'form-eat',
            ]) ?>
            <?= Html::hiddenInput('id') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Откусить (%)</label>
                    <?= Html::textInput('pie', 1, [
                        'type' => 'number',
                        'min' => 1,
                        'max' => 100,
                        'class' => 'form-control js-pie',

                    ]) ?>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::button('Съесть', [
                    'class' =>  "btn btn-primary js-submit",
                ]) ?>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('modalError'); ?>
<div id="modalError"
     role="dialog"
     aria-hidden="true"
     class="modal fade"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Ошибка!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="js-message"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

