<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 21:53
 */

namespace backend\interfaces;

use backend\dto\AppleServiceDto;
use common\models\Apple;

interface AppleServiceInterface
{
    /**
     * @param Apple $model
     * @return AppleServiceDto
     */
    public function down(Apple $model): AppleServiceDto;

    /**
     * @param Apple $model
     * @return AppleServiceDto
     */
    public function rot(Apple $model): AppleServiceDto;

    /**
     * @param Apple $model
     * @return AppleServiceDto
     */
    public function clear(Apple $model): AppleServiceDto;
}