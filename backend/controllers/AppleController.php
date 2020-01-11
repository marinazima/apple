<?php
namespace backend\controllers;

use common\models\Apple;
use common\models\search\AppleSearch;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Apple controller
 */
class AppleController extends Controller
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
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Apple model.
     * If creation is successful, the browser will be redirected to the 'view' page.
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
}
