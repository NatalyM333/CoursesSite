<?php 
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\filters\AccessControl;

    use common\models\Type;
    use common\models\Product;
    use backend\models\TypeForm;
   
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
                $type = new Type;
                $type->name = $model->name;
                $type->description = $model->description;
                
                if($type->save())
                {
                    Yii::$app->session->setFlash('success', 'Type saved into DB');
                }
                else { 
                    Yii::$app->session->setFlash('error', 'Error! Type NOT saved into DB ');
                }
                
                return  $this->redirect(['type/index']);
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
                $type->name = $model->name;
                $type->description = $model->description;

                if($type->save())
                {
                    Yii::$app->session->setFlash('success', 'Товар збережено в БД ');
                }
                else{
                    Yii::$app->session->setFlash('error', 'Помилка НЕ збережено в БД ');
                }
            
                return  $this->redirect(['type/index']);
            
            }

            $model->name = $type->name;
            $model->description = $type->description;  
            $initialPreview = [];
            $initialConfig = [];
        
            return $this->render('create', [
                'model' => $model,        
                'initialPreview' => $initialPreview,
                'type_id'=> $type->id,
                'initialConfig' =>  $initialConfig,
            ]);
        }

        public function actionDelete(){
            
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;// формат відповіді
            
            if($_POST) {
                $model = new TypeForm; 
                $id = $_POST['id'];
                $type = Type::findOne(['id' => $id]);
                $products = Product::find()->where(['type_id' => $id])->all();
            
                if($type->delete()){

                    foreach($products as $product) {
                        $images = json_decode($product->url_image, true);
                        foreach($images as $image){
                            unlink($image);
                        }
                    }
                    return  false;
                }
                else{
                    Yii::$app->session->setFlash('error', 'Error! Type NOT deleted from DB');
                    return $this->redirect('index');
                }
            }
        }
    }