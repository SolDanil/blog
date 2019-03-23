<?php
namespace app\controllers;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use app\models\Role;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
class AuthController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        $roles=ArrayHelper::map(Role::find()->where(['not', ['id' => 1]])->select('id,name')->asArray()->all(), 'id', 'name');

        $model = new SignupForm();
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->signup())
            {
                return $this->redirect(['auth/login']);
            }
        }
        return $this->render('signup', ['model'=>$model,'roles'=>$roles]);
    }
    public function actionLoginVk($uid, $first_name, $photo)
    {
        $user = new User();
        if($user->saveFromVk($uid, $first_name, $photo))
        {
            return $this->redirect(['site/index']);
        }
    }

    public function actionTest()
    {
        $user=User::findOne(Yii::$app->user->id);

        if(Yii::$app->user->isGuest)
        {
            echo 'Пользователь гость';
        }
        else
        {
            print_r('Пользователь '.$user->roles->name.' Авторизован:') ;
            echo '<pre>';
            print_r($user->roles->name);
            echo '</pre>';


        }
    }
}