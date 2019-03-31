<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post()){
            $tag=Yii::$app->request->post('tag');
            $lat=Yii::$app->request->post('lat');
            $long=Yii::$app->request->post('long');

            $token ='62c4b68a62c4b68a62c4b68a3362adc2ec662c462c4b68a3e529c11e89c8ab69a99babe';
            $url='https://api.vk.com/method/photos.search?q='.$tag.'&sort=0&count=5&long='.$long.'&lat='.$lat.'&start_time=&end_time=&offset=0&radius=7000&v=5.92&access_token='.$token;

            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // отправляем запрос
            $response = curl_exec($ch);
            // закрываем соединение
            curl_close($ch);
            $array=json_decode($response);
            
            $i=0;
            $images=array();
            foreach ($array->response->items as $key => $item) {
                foreach ($item->sizes as $key2 => $size) {
                    if ($size->type=='x'){
                        $url=$size->url;
                    }
                }
                $lat1=$item->lat;
                $long1=$item->long;
                $images[$i]=array('url'=>$url,'lat'=>$lat1,'long'=>$long1);
                $i++;
            }
            
            $json_images=json_encode($images);
        }

        return $this->render('index',[
            'images'=>$images,
            'json_images'=>$json_images,
            'lat'=>$lat,
            'long'=>$long,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
