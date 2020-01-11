<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 1:15
 */

use backend\widgets\assets\AppleGenerateAsset;
use yii\base\View;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this View */
/** @var $defaultCount int */

AppleGenerateAsset::register($this);

?>

<?=
    Html::button(Yii::t('app', 'Generate apples'), [
        'class' => 'btn btn-success js-generate',
        'data-toggle' => 'modal',
        'data-target' => '#modalGenerate',
    ]);
?>

<!-- modals -->
<?php $this->beginBlock('modalMessage'); ?>
    <div id="modalGenerate"
         role="dialog"
         aria-hidden="true"
         class="modal fade"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Добавить яблоки</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= Html::beginForm(['create'], 'POST', [
                    'id' => 'gen-form',
                ]) ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= Html::textInput('count', $defaultCount, [
                                'type' => 'number',
                                'min' => 1,
                                'class' => 'form-control js-count',
                                'data-default' => $defaultCount,
                            ]) ?>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?= Html::button('Добавить', [
                            'class' =>  "btn btn-primary js-submit",
                        ]) ?>
                    </div>
                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>
<?php $this->endBlock() ?>
