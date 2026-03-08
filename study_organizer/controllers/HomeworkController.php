<?php

namespace app\controllers;

use Yii;
use app\models\Homework;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HomeworkController extends Controller
{
    // Alle Homeworks anzeigen
    public function actionIndex()
    {
        $homeworks = Homework::find()->all();

        return $this->render('index', [
            'homeworks' => $homeworks,
        ]);
    }

    // Einzelne Homework anzeigen
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // Neue Homework erstellen
    public function actionCreate()
    {
        $model = new Homework();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Homework bearbeiten
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Homework löschen
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // Model finden
    protected function findModel($id)
    {
        if (($model = Homework::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Homework nicht gefunden.');
    }
}