<?php

namespace backend\widgets\assets;

use yii\web\AssetBundle;

/**
 * Class AppleGenerateAsset
 *
 * @package backend\widgets\assets
 */
class AppleGenerateAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/widgets/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'apple-generate.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}