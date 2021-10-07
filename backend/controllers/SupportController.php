<?php
namespace backend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\SupportForm;
use common\models\Support;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class SupportController extends Controller
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
                        'roles' => ['admin'],
                    ]
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index',[
            'support' =>  Support::find()->all(),
        ]);
    }

    public function actionCreate()
    {
        $model = new SupportForm;
        if($model->load(Yii::$app->request->post()))
        {
            $model->supportFile = UploadedFile::getInstances($model,'supportFile');
           if($supportPath=$model->upload())
           {
            $support = new Support;
            $support->description = $model->description;
            $support->name = $model->name;
            $support->url_file = json_encode($supportPath);
            if($support->save())
            {
            // Yii::$app->session->setFlash('success', 'Товар збережено в БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
               }
           }
         return  $this->redirect(['support/index']);
          
        }
       
        return $this->render('create', [
            'model' => $model,
            'initialPreview' => [],
            'initialConfig' => [],
            'support_id'=> '',
        ]);
    }
    public function actionUpdate($id){
        $model = new SupportForm;
        $support = Support::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()))
        {
            $model->supportFile = UploadedFile::getInstances($model,'supportFile');
            $supportPath=$model->upload();
           if($supportPath !== false)
           {
            $support->description = $model->description;
            $support->name = $model->name;
            if(count($supportPath)>0)
            {
                $support = json_decode($support->url_file,true);
                $supportPath = array_merge($support, $supportPath);
                $support->url_file = json_encode($supportPath);
            }
            
            if($support->save())
            {
             //Yii::$app->session->setFlash('success', 'Товар збережено в БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
               }
           }
         return  $this->redirect(['support/index']);
          
        }

        $model->description = $support->description;
        $model->name = $support->name;
        
        $files= json_decode($support->url_file,true);
        $initialPreview = [];
        $initialConfig = [];
        foreach ($files as $file) {
            $initialPreview[]='../../' . $file;
          
            $initialConfig []=[
                'key' => $file,
            ];
        }

        return $this->render('create', [
            'model' => $model,
            'initialPreview' => $initialPreview,
            'support_id'=> $support->id,
            'initialConfig' =>  $initialConfig,
        ]);

    }

    public function actionDelete($id){
        $model = new SupportForm;
        $support = Support::findOne(['id' => $id]);
        $supports = json_decode($support->url_file,true);
        $result = [];
        foreach ($supports as $value) {  
               unlink($value);
        }

        if($support -> delete())
            {
             //Yii::$app->session->setFlash('success', 'Товар видалено з БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ видалено з БД ');
            }
           
        return  $this->redirect(['support/index']);
    }
    public function actionFileDeleteSupport($id){
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(isset($_POST['key'])){
            $file = $_POST['key'];
           
            unlink($_POST['key']);
            $support = Support::findOne(['id' => $id]);
            $files = json_decode($support->url_file,true);
            $result = [];
            foreach ($files as $value) {
                if($file != $value){
                    $result[] = $value;
                }
            }
            $support->url_file = json_encode($result);
            $support->save();
        }
        return true;
    }
    public function actionView($id){
        $model = new SupportForm;
        $support = Support::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()))
        {
            $model->supportFile = UploadedFile::getInstances($model,'supportFile');
            $supportPath=$model->upload();
           if($supportPath !== false)
           {    
            $support->description = $model->description;
            $support->name = $model->name ;
            if($supportPath)
            {
                $support = json_decode($support->url_file,true);
                $supportPath = array_merge($support, $supportPath);
                $support->url_file = json_encode($supportPath);

            }
            $support->url_file = json_encode($supportPath);
            
           }
         return  $this->redirect(['support/index']);
          
        }

        $model->description = $support->description;
        $model->name = $support->name;
        $files= json_decode($support->url_file,true);
        $initialPreview = [];
        $initialConfig = [];
        foreach ($files as $file) {
            $initialPreview[]='' . $file;
          
            $initialConfig []=[
                'key' => $file,
            ];
        }

        return $this->render('view', [
            'model' => $model,
            'initialPreview' => $initialPreview,
            'support_id'=> $support->id,
            'initialConfig' =>  $initialConfig,
        ]);

    }
    public function actionFile($filename)
    {
        //return \Yii::$app->response->sendFile($filename); 
        return Yii::$app->response->sendFile($filename,'', ['inline'=>true]);
       
    }
}