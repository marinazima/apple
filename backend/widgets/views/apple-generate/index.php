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
/** @var $maxCount int */
/** @var $enableManual int */

AppleGenerateAsset::register($this);

?>

<?=
    Html::button(Yii::t('app', 'Generate apples'), [
        'class' => 'btn btn-success js-generate',
        'data-max' => $maxCount,
        'data-enable-manual' => $enableManual,
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
                <?= Html::beginForm(['create'], 'GET', [
                    'id' => 'gen-form',
                ]) ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= Html::textInput('count', null, [
                                'type' => 'number',
                                'min' => 1,
                                'max' => $maxCount,
                                'class' => 'form-control js-count',

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
