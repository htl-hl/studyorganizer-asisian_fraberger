<?php

namespace app\controllers;

use app\models\Homework;
use app\models\HomeworkSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HomeworkController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete', 'done'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'done' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new HomeworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->with('subject')
            ->orderBy([
                'H_is_done' => SORT_ASC,
                'H_due_date' => SORT_ASC,
            ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($H_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($H_ID),
        ]);
    }

    public function actionCreate()
    {
        $model = new Homework();

        if ($model->load(Yii::$app->request->post())) {
            $model->H_U_ID = (int) Yii::$app->user->id;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Homework created successfully.');

                return $this->redirect(['view', 'H_ID' => $model->H_ID]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($H_ID)
    {
        $model = $this->findModel($H_ID);

        if (!$model->isEditable()) {
            Yii::$app->session->setFlash('error', 'Completed homework can no longer be changed.');

            return $this->redirect(['view', 'H_ID' => $model->H_ID]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->H_U_ID = (int) Yii::$app->user->id;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Homework updated successfully.');

                return $this->redirect(['view', 'H_ID' => $model->H_ID]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($H_ID)
    {
        $model = $this->findModel($H_ID);

        if (!$model->isEditable()) {
            Yii::$app->session->setFlash('error', 'Completed homework can no longer be changed.');

            return $this->redirect(['view', 'H_ID' => $model->H_ID]);
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Homework deleted successfully.');

        return $this->redirect(['index']);
    }

    public function actionDone($H_ID)
    {
        $model = $this->findModel($H_ID);

        if ($model->isDone()) {
            Yii::$app->session->setFlash('info', 'This homework is already marked as done.');

            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        }

        $model->H_is_done = 1;

        if ($model->save(false, ['H_is_done'])) {
            Yii::$app->session->setFlash('success', 'Homework marked as done.');
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    protected function findModel($H_ID)
    {
        if (($model = Homework::findOne([
            'H_ID' => $H_ID,
            'H_U_ID' => Yii::$app->user->id,
        ])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Homework nicht gefunden.');
    }
}
