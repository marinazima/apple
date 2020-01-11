<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class AppleTreeAsset
 *
 * @package backend\assets
 */
class AppleTreeAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/assets/dist';

    /**
     * @var array
     */
    public $js = [
        'apple-tree.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}