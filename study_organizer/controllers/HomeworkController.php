<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * HomeworkController implements the CRUD actions for Homework model.
 */
class HomeworkController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Homework models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \app\models\Homework::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Homework model.
     * @param int $H_ID H ID
     * @return string
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function actionView($H_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($H_ID),
        ]);
    }

    /**
     * Creates a new Homework model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \app\models\Homework();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Homework model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $H_ID H ID
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($H_ID)
    {
        $model = $this->findModel($H_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Homework model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $H_ID H ID
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($H_ID)
    {
        $this->findModel($H_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Homework model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $H_ID H ID
     * @return \app\models\Homework the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */

    public function actionDone($H_ID)
    {
        $model = $this->findModel($H_ID);

        $model->H_is_done = 1;
        $model->save(false);

        return $this->redirect(['site/index']);
    }

    protected function findModel($H_ID)
    {
        if (($model = \app\models\Homework::findOne(['H_ID' => $H_ID])) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
