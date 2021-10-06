<?php
namespace backend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\ProducerForm;

use backend\models\Producer;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class ProducerController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index', 'create', 'update', 'delete'],
                'only' => [],
                'rules' => [
                    [
                        'allow' => true,
                        // 'actions' => ['index', 'create', 'update', 'delete'],
                        'roles' => ['admin','owner','manager'],
                    ]
                ],
            ],
        ];
    }
    public function actionIndex()
    {
       // $producer = Producer::find()->all();
       

        return $this->render('index',[
            'producers' =>Producer::find()->asArray()->all()
        ]);
    }

    public function actionCreate()
    {
        $model = new ProducerForm;
        if($model->load(Yii::$app->request->post()))
        {
            $producer = new Producer;
            $producer->name = $model->name;
            $producer->description = $model->description;
            if($producer->save())
            {
           //  Yii::$app->session->setFlash('success', 'Виробника збережено в БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
            }  
         return  $this->redirect(['producer/index']);
          
        }
        return $this->render('create', [
            'model' => $model,
           
            'initialPreview' => [],
            'initialConfig' => [],
            'producer_id'=> '',
        ]);
    }
    public function actionUpdate($id){
        $model = new ProducerForm;
        $producer = Producer::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()))
        {
            $producer->name = $model->name;
            $producer->description = $model->description;
          
            if($producer->save())
            {
             //Yii::$app->session->setFlash('success', 'Товар збережено в БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
               }
           
         return  $this->redirect(['producer/index']);
          
        }

        $model->name = $producer->name;
        $model->description = $producer->description;

        $initialPreview = [];
        $initialConfig = [];
      
        return $this->render('create', [
            'model' => $model,
            'initialPreview' => $initialPreview,
            'producer_id'=> $producer->id,
            'initialConfig' =>  $initialConfig,
        ]);

    }

    public function actionDelete($id){
        $model = new ProducerForm;
        $producer = Producer::findOne(['id' => $id]);
        if($producer -> delete())
            {
             //Yii::$app->session->setFlash('success', 'Виробника видалено з БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ видалено з БД ');
            }
           
        return  $this->redirect(['producer/index']);
    }
   
    public function actionView($id){
        $model = new ProducerForm;
        $producer = Producer::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()))
        {           
            $producer->name = $model->name;
            $producer->description = $model->description ;
     
         return  $this->redirect(['producer/index']);
        }

        $model->name = $producer->name;
        $model->description = $producer->description; 
      
        $initialPreview = [];
        $initialConfig = [];
   
        return $this->render('view', [
            'model' => $model,
            'initialPreview' => $initialPreview,
            'producer_id'=> $producer->id,
            'initialConfig' =>  $initialConfig,
        ]);

    }
}