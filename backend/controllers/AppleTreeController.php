<?php
namespace backend\controllers;

use backend\interfaces\AppleServiceInterface;
use common\models\Apple;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * AppleTree controller
 */
class AppleTreeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @var AppleServiceInterface
     */
    protected $appleService;

    /**
     * AppleTreeController constructor.
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
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex() {
        $query = Apple::find()
            ->active()
            ->orderByCreatedAt();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Generates Apple models.
     * @return mixed
     */
    public function actionCreate(int $count = 5) {
        $errors = [];

        foreach (range(1, $count) as $iteration) {
            $model = new Apple();
            if(!$model->save()) {
                $errors[] = $model->getErrorSummary(true);
            }
        }

        if(!empty($errors)) {
            $errorsAsString = implode('<br>', implode(', ', $errors));
            \Yii::$app->getSession()->addFlash('error', 'Ошибки валидации. <br>' . $errorsAsString);
        }

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionDown(int $id)
    {
        if (!Yii::$app->request->isAjax) {
            return '';
        }

        $model = $this->findModel($id);
        if($model) {
            $dto = $this->appleService->down($model);
            if($dto->isSuccess()) {
                $inner = $this->renderAjax('_list-inner', ['model' => $model]);
                return $this->asJson([
                    'success' => true,
                    'inner' => $inner,
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'message' => $dto->getMessage(),
                ]);
            }
        }

        return $this->asJson([
            'success' => false,
            'message' => 'Яблоко украли',
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionCanEat(int $id)
    {
        if (!Yii::$app->request->isAjax) {
            return '';
        }

        $model = $this->findModel($id);
        if($model) {
            if($model->canEat()) {
                return $this->asJson([
                    'success' => true,
                ]);
            } else {
                //check if eatten and clear (set status eatten) if yes
                $dto = $this->appleService->clear($model);
                $eaten = $dto->isSuccess();

                if(!$eaten) {
                    //check if rotten and set status rotten if yes
                    $this->appleService->rot($model);
                    $inner = $this->renderAjax('_list-inner', ['model' => $model]);
                }

                return $this->asJson([
                    'success' => false,
                    'inner' => $inner ?? null,
                    'message' => 'Яблоко нельзя съесть(' . $model->getStatusAsString() . ')'
                ]);
            }
        }

        return $this->asJson([
            'success' => false,
            'message' => 'Яблоко украли',
        ]);
    }

    public function actionEat(int $id, int $pie)
    {
        if (!Yii::$app->request->isAjax) {
            return '';
        }

        $model = $this->findModel($id);
        if($model) {
            $dto = $this->appleService->eat($model, $pie);
            if($dto->isSuccess()) {
                if(!$model->checkEaten()) {
                    $inner = $this->renderAjax('_list-inner', ['model' => $model]);
                }
                return $this->asJson([
                    'success' => true,
                    'inner' => $inner ?? null,
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'message' => $dto->getMessage(),
                ]);
            }
        }

        return $this->asJson([
            'success' => false,
            'message' => 'Яблоко украли',
        ]);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * @param integer $id
     * @return Apple the loaded model
     */
    protected function findModel($id) {
        $model = Apple::findOne(['id' => $id]);

        return $model;
    }
}
