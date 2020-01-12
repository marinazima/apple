<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 21:19
 */

namespace backend\services;

use backend\dto\AppleServiceDto;
use backend\interfaces\AppleServiceInterface;
use common\models\Apple;
use yii\db\Expression;
use yii\db\Query;

class AppleService implements AppleServiceInterface
{
    /**
     * @param Apple $model
     * @return AppleServiceDto
     */
    public function down(Apple $model): AppleServiceDto
    {
        if($model->canDown()) {
            $model->status = Apple::STATUS_DOWN;
            $model->down_at = time();
            $model->save(false);
            return new AppleServiceDto([
                'success' => true,
            ]);
        } else {
            $message = 'Яблоко не может упасть';
        }

        return new AppleServiceDto([
            'success' => false,
            'message' => ($message ?? null),
        ]);
    }

    /**
     * @param Apple $model
     * @return AppleServiceDto
     */
    public function rot(Apple $model): AppleServiceDto
    {
        if($model->canRot()) {
            if($model->checkRotten()) {
                $model->status = Apple::STATUS_ROTTEN;
                $model->save(false);
                return new AppleServiceDto([
                    'success' => true,
                ]);
            } else {
                $message = 'Яблоко еще не сгнило';
            }
        } else {
            $message = 'Яблоко не может сгнить';
        }

        return new AppleServiceDto([
            'success' => false,
            'message' => ($message ?? null),
        ]);
    }

    /**
     * @param Apple $model
     * @return AppleServiceDto
     */
    public function clear(Apple $model): AppleServiceDto
    {
        if($model->checkEaten()) {
            $model->status = Apple::STATUS_EATEN;
            $model->save(false);
            return new AppleServiceDto([
                'success' => true,
            ]);
        } else {
            $message = 'Яблоко не съедено целиком';
        }

        return new AppleServiceDto([
            'success' => false,
            'message' => ($message ?? null),
        ]);
    }

    /**
     * @param Apple $model
     * @return AppleServiceDto
     */
    public function eat(Apple $model, int $pie): AppleServiceDto
    {
        if($model->canEat()) {
            $eaten = $this->normalizeEaten(($model->eaten + $pie));
            $model->eaten = $eaten;
            if($eaten === 100) {
                $model->status = Apple::STATUS_EATEN;
            }
            $model->save(false);
            return new AppleServiceDto([
                'success' => true,
            ]);
        } else {
            $message = 'Яблоко нельзя съесть';
        }

        return new AppleServiceDto([
            'success' => false,
            'message' => ($message ?? null),
        ]);
    }

    /**
     * @return int
     */
    public function massRot(): int
    {
        $ids = Apple::find()
            ->select(['id'])
            ->status(Apple::STATUS_DOWN)
            ->andWhere(['>', new Expression('FLOOR((UNIX_TIMESTAMP() - down_at) / 3600)'), Apple::TIME_ROT])
            ->column();

        if(!empty($ids)) {
            Apple::updateAll([
                'status' => Apple::STATUS_ROTTEN
            ], [
                'id' => $ids
            ]);

            return count($ids);
        }

        return 0;
    }

    /**
     * @param int $eaten
     * @return int
     */
    private function normalizeEaten(int $eaten): int
    {
        return ($eaten < 0 ? 100 : $eaten);
    }
}