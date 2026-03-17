<?php

namespace app\controllers;

use Yii;
use app\models\Subjects;
use app\models\Teachers;
use app\models\TeachersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeachersController implements the CRUD actions for Teachers model.
 */
class TeachersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => static function () {
                                return !Yii::$app->user->isGuest
                                    && Yii::$app->user->identity->isAdmin();
                            },
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Teachers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TeachersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->with('subjects')
            ->orderBy(['T_name' => SORT_ASC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Teachers model.
     * @param int $T_ID T ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($T_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($T_ID),
        ]);
    }

    /**
     * Creates a new Teachers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Teachers();
        $model->scenario = 'create';

        if ($model->load($this->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $subject = new Subjects([
                    'S_name' => $model->initialSubjectName,
                ]);

                if (!$model->save(false)) {
                    throw new \RuntimeException('Teacher could not be saved.');
                }

                $subject->S_T_ID = $model->T_ID;

                if (!$subject->save()) {
                    foreach ($subject->getFirstErrors() as $message) {
                        $model->addError('initialSubjectName', $message);
                    }

                    throw new \RuntimeException('Subject could not be saved.');
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Teacher created successfully with the first subject.');

                return $this->redirect(['view', 'T_ID' => $model->T_ID]);
            } catch (\Throwable $exception) {
                $transaction->rollBack();

                if (!$model->hasErrors('initialSubjectName')) {
                    $model->addError('initialSubjectName', 'The first subject could not be created.');
                }
            }
        }

        if ($this->request->isGet) {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Teachers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $T_ID T ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($T_ID)
    {
        $model = $this->findModel($T_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Teacher updated successfully.');

            return $this->redirect(['view', 'T_ID' => $model->T_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Teachers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $T_ID T ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($T_ID)
    {
        Yii::$app->session->setFlash('error', 'Teachers cannot be deleted. Set the teacher to inactive instead.');

        return $this->redirect(['view', 'T_ID' => $T_ID]);
    }

    /**
     * Finds the Teachers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $T_ID T ID
     * @return Teachers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($T_ID)
    {
        if (($model = Teachers::findOne(['T_ID' => $T_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
