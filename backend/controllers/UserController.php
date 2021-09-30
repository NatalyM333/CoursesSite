<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\UserForm;
use common\models\User;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

//use backend\models\CategorySearch;
//use yii\web\NotFoundHttpException;


/**
 * CategoryController implements the CRUD actions for Category model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
   
    public function actionIndex()
    {
       
        // var_dump($role);
        // echo('br');
        // $auth = Yii::$app->getAuthManager();
        // $role = $auth->getRole('admin');
        // $auth->assign($role,2);
       // die();
       $dataProvider = new ActiveDataProvider([
        'query' => user::find(),
    ]);

    return $this->render('index',[
        'dataProvider' => $dataProvider
    ]);

    }
    public function actionView($id){
        $role = Yii::$app->AuthManager->Roles;
        $role_array = [];

        foreach ($role as $key => $value) {
            $role_array[$key] = $key;
        }
        $user1 = User::find()->asArray()->all();
        // $this->render('index',[
        //     'user'=>$user,
        //     'role_array'=>$role_array,
        // ]
        // );
        ////
        $model = new UserForm;
        $user = User::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()))
        {
         return  $this->redirect(['user/index']);
        }

        $model->username = $user->username;
        $model->email = $user->email;
      
        return $this->render('view', [
            'model' => $model,
            'user_id'=> $user->id,
            'user'=>$user1,
            'role_array'=>$role_array,
        ]);

    }
    public function actionDelete($id){
        $model = new UserForm;
        $user = User::findOne(['id' => $id]);
        if($user -> delete())
            {
             Yii::$app->session->setFlash('success', ' видалено з БД ');
            }
            else{
                Yii::$app->session->setFlash('error', 'Помилка НЕ видалено з БД ');
            }
           
        return  $this->redirect(['user/index']);
    }
    public function actionChangeRole(){
        if($_POST['id'] != '' && $_POST['role'] != '')
        {
            $auth = Yii::$app->AuthManager;
            //$role_old = array_keys(Yii::$app->getAuthManager->getRolesByUser($_POST['id']))[0];
            //$role_old = $auth->getRole($role_old);
            Yii::$app->AuthManager->revokeAll($_POST['id']);
            $role_new = $auth->getRole($_POST['role']);
            $auth->assign($role_new,$_POST['id']);
            return true;

        }
        return false;
    }

   
}
