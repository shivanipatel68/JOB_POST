<?php

namespace app\controllers;

use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\db\Expression;

use yii;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();

       // VarDumper::dump($model ,  $dept = 10,  $highlight = true);
       
        if ($this->request->isPost) {
            
            if ($model->load($this->request->post())) {
                $model->save();
                $postid = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));

                $model->descFile = UploadedFile::getInstance($model, 'descFile');
                $path = $postid . $model->descFile->getBaseName() . '.' . $model->descFile->getExtension();
                $model->descFile->saveAs('uploads/' . $path);
                $model->job_desc = ('uploads/') . $path;
            
                $model->save();
               
                
                // echo '<pre>';
                // print_r($path);
                // print_r($model->descFile);
                // exit;
                // echo '</pre>';
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionDeleteall(){
        
        if (Yii::$app->request->isPost) {
            $selection = Yii::$app->request->post('selection');
            $response['success'] = false;

            //$transaction = Yii::$app->db->beginTransaction();

            try {
                Post::deleteAll(['id' => $selection]);
                $response['success'] = true;
               // $transaction->commit();
            } catch (\Exception $ex) {
               // $transaction->rollBack();
                $response['msg'] = $ex->getMessage();
            }

            echo \yii\helpers\Json::encode($response);

        }
    }

    public function actionDelete($id)
    {

        $data = $this->findModel($id);
                
        unlink(Yii::$app->basePath . '/web/' . $data->job_desc);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}