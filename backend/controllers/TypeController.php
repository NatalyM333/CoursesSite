<?php 
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\filters\AccessControl;
    use common\models\Type;
    use backend\models\TypeForm;
    use common\models\Lift;
   
    class TypeController extends Controller
    {
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => [],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin','owner','manager'],
                        ]
                    ],
                ],
            ];
        }
        
        public function actionIndex()
        {
            return $this->render('index',[
                'types' =>Type::find()->asArray()->all()
            ]);
        }

        public function actionCreate()
        {
            $model = new TypeForm;
           
            if($model->load(Yii::$app->request->post()))
            {
                $model->imageFile = UploadedFile::getInstances($model,'imageFile');
                if($imagePath=$model->upload())
                {
                    $type = new Type;
                    $type->name = $model->name;
                    $type->description = $model->description;
                    $type->url_image = json_encode($imagePath);
                    if($type->save())
                    {
                    // Yii::$app->session->setFlash('success', 'Type saved into DB');
                    }
                    else { 
                        Yii::$app->session->setFlash('error', 'Error! Type NOT saved into DB ');
                    }
                }
                else return  $this->redirect(['user/index']);
                return  $this->redirect(['index']);
            
            }
        
            return $this->render('create', [
                'model' => $model,    
                'initialPreview' => [],
                'initialConfig' => [],
                'type_id'=> '',
            ]);
        }

        public function actionUpdate($id){
            $model = new TypeForm;

            $type = Type::findOne(['id' => $id]);

            if($model->load(Yii::$app->request->post()))
            {
                $model->imageFile = UploadedFile::getInstances($model,'imageFile');
                $imagePath=$model->upload();
                if($imagePath !== false)
                {
                        $type->name = $model->name;
                        $type->description = $model->description;
                        if($imagePath)
                        {
                            $image = json_decode($type->url_image,true);
                            $imagePath = array_merge($image, $imagePath);
                            $type->url_image = json_encode($imagePath);
                        }
                       
                        if($type->save())
                        {
                            //Yii::$app->session->setFlash('success', 'Товар збережено в БД ');
                        }
                        else{
                            Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
                        }
                }
                return  $this->redirect(['index']);
            
            }

            $model->name = $type->name;
            $model->description = $type->description;  
            $initialPreview = [];
            $initialConfig = [];
            $images= json_decode($type->url_image,true);
            foreach ($images as $image) {
                $initialPreview[]='../../' . $image;
              
                $initialConfig []=[
                    'key' => $image,
                ];
            }
            return $this->render('create', [
                'model' => $model,        
                'initialPreview' => $initialPreview,
                'type_id'=> $type->id,
                'initialConfig' =>  $initialConfig,
            ]);
        }

        public function actionDelete($id)
        {
            $model = new Type;
            $type = Type::findOne(['id' => $id]);
            $lifts = Lift::find()->where(['type_id' => $id])->all();
            foreach ($lifts as $lift) {  
                $images = json_decode($lift->url_image,true);
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
            }
            $images = json_decode($type->url_image,true);
       
            foreach ($images as $value) {  
                unlink($value);
            }
      
            if($type -> delete())
            {
            // Yii::$app->session->setFlash('success', ' видалено з БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ видалено з БД ');
            }
           
            return $this->redirect(['type/index']);
        }
        public function actionFileDeleteType($id){
        
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(isset($_POST['key'])){
                $image = $_POST['key'];
               
                unlink($_POST['key']);
                $type = Type::findOne(['id' => $id]);
                $images = json_decode($type->url_image,true);
                $result = [];
                foreach ($images as $value) {
                    if($image != $value){
                        $result[] = $value;
                    }
                }
                $type->url_image = json_encode($result);
                $type->save();
            }
            return true;
        }
    }