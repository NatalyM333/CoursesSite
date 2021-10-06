<?php
namespace backend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LiftForm;
use common\models\Type;
use common\models\Producer;
use common\models\Lift;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class LiftController extends Controller
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
        $lifts = Lift::find()->all();
        $types = [];
        $producers = [];

        foreach($lifts as $lift){
             $types[$lift->type_id] = Type::find()->where(['id' => $lift->type_id])->one();
        }
        foreach($lifts as $lift){
            $producers[$lift->producer_id] = Producer::find()->where(['id' => $lift->producer_id])->one();
       }

        return $this->render('index',[
            'lifts' => $lifts,
            'types' => $types,
            'producers' => $producers
        ]);
    }

    public function actionCreate()
    {
        $model = new LiftForm;
        if($model->load(Yii::$app->request->post()))
        {
            $model->imageFile = UploadedFile::getInstances($model,'imageFile');
           if($imagePath=$model->upload())
           {
            $lift = new Lift;
            $lift->description = $model->description;
            $lift->type_id = $model->type_id ;
            $lift->producer_id = $model->producer_id ;
            $lift->url_image = json_encode($imagePath);
            if($lift->save())
            {
            // Yii::$app->session->setFlash('success', 'Товар збережено в БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
               }
           }
         return  $this->redirect(['lift/index']);
          
        }
        $types = Type::find()->all();
        foreach ($types as $type) {
            $type_array[$type->id] = $type->name;
        }
        $providers = Producer::find()->all();
        foreach ($providers as $provider) {
            $provider_array[$provider->id] = $provider->name;
        }

        return $this->render('create', [
            'model' => $model,
            'types' => $type_array,
            'producers' => $provider_array,
            'initialPreview' => [],
            'initialConfig' => [],
            'lift_id'=> '',
        ]);
    }
    public function actionUpdate($id){
        $model = new LiftForm;
        $lift = Lift::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()))
        {
            $model->imageFile = UploadedFile::getInstances($model,'imageFile');
            $imagePath=$model->upload();
           if($imagePath !== false)
           {
            $lift->description = $model->description;
            $lift->type_id = $model->type_id ;
            $lift->producer_id = $model->producer_id ;
            if($imagePath)
            {
                $image = json_decode($lift->url_image,true);
                $imagePath = array_merge($image, $imagePath);
                $lift->url_image = json_encode($imagePath);
            }
            
            if($lift->save())
            {
             //Yii::$app->session->setFlash('success', 'Товар збережено в БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
               }
           }
         return  $this->redirect(['lift/index']);
          
        }

        $model->description = $lift->description;
        $model->type_id = $lift->type_id;
        $model->producer_id = $lift->producer_id;
        $providers = Producer::find()->all();
        foreach ($providers as $provider) {
            $provider_array[$provider->id] = $provider->name;
        }
        $types = Type::find()->all();
        foreach ($types as $type) {
            $type_array[$type->id] = $type->name;
        }
        $images= json_decode($lift->url_image,true);
        $initialPreview = [];
        $initialConfig = [];
        foreach ($images as $image) {
            $initialPreview[]='../../' . $image;
          
            $initialConfig []=[
                'key' => $image,
            ];
        }

        return $this->render('create', [
            'model' => $model,
            'producers' => $provider_array,
            'types' => $type_array,
            'initialPreview' => $initialPreview,
            'lift_id'=> $lift->id,
            'initialConfig' =>  $initialConfig,
        ]);

    }

    public function actionDelete($id){
        $model = new LiftForm;
        $lift = Lift::findOne(['id' => $id]);
        $images = json_decode($lift->url_image,true);
        $result = [];
        foreach ($images as $value) {  
               unlink($value);
        }
      
        if($lift -> delete())
            {
             //Yii::$app->session->setFlash('success', 'Товар видалено з БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ видалено з БД ');
            }
           
        return  $this->redirect(['lift/index']);
    }
    public function actionFileDeleteLift($id){
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(isset($_POST['key'])){
            $image = $_POST['key'];
           
            unlink($_POST['key']);
            $lift = Lift::findOne(['id' => $id]);
            $images = json_decode($lift->url_image,true);
            $result = [];
            foreach ($images as $value) {
                if($image != $value){
                    $result[] = $value;
                }
            }
            $lift->url_image = json_encode($result);
            $lift->save();
        }
        return true;
    }
    public function actionView($id){
        $model = new LiftForm;
        $lift = Lift::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()))
        {
            $model->imageFile = UploadedFile::getInstances($model,'imageFile');
            $imagePath=$model->upload();
           if($imagePath !== false)
           {    
            $lift->description = $model->description;
            $lift->type_id = $model->type_id ;
            $lift->producer_id = $model->producer_id ;
            if($imagePath)
            {
                $image = json_decode($lift->url_image,true);
                $imagePath = array_merge($image, $imagePath);
                $lift->url_image = json_encode($imagePath);

            }
            $lift->url_image = json_encode($imagePath);
            
           }
         return  $this->redirect(['lift/index']);
          
        }

        $model->description = $lift->description;
        $model->type_id = $lift->type_id;
        $model->producer_id = $lift->producer_id;
        $producer = Producer::find()->where(['id' => $lift->producer_id])->one();
        $type = Type::find()->where(['id' => $lift->type_id])->one();
       
        $images= json_decode($lift->url_image,true);
        $initialPreview = [];
        $initialConfig = [];
        foreach ($images as $image) {
            $initialPreview[]='../../' . $image;
          
            $initialConfig []=[
                'key' => $image,
            ];
        }

        return $this->render('view', [
            'model' => $model,
            'type' => $type->name,
            'producer' => $producer->name,
            'initialPreview' => $initialPreview,
            'lift_id'=> $lift->id,
            'initialConfig' =>  $initialConfig,
        ]);

    }
}