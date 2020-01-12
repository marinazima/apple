<?php

namespace console\controllers;

use backend\interfaces\AppleServiceInterface;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Created by PhpStorm.
 * User: zima
 * Date: 12.01.2020
 * Time: 22:48
 */

/**
 * sets statuses if apple state is ready for it
 * run in console
 *
 * php yii apple-status/rotten
 * statuses:
 * rotten
 */
class AppleStatusController extends Controller
{
    /**
     * @var AppleServiceInterface
     */
    protected $appleService;

    /**
     * AppleStatusController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param AppleServiceInterface $appleService
     * @param array $config
     */
    public function __construct(string $id, \yii\base\Module $module, AppleServiceInterface $appleService, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->appleService = $appleService;
    }

    /**
     * @return int
     */
    public function actionRotten(): int
    {
        $this->log('Start check rotten...');

        $rotten = $this->appleService->massRot();

        $this->log('Finished. Rotten: ' . $rotten);
        $this->log('====================');

        return ExitCode::OK;
    }

    /**
     * @param string $message
     * @return void
     */
    public function log($message): void
    {
        fwrite(STDOUT, $message . PHP_EOL);
    }
}