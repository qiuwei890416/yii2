<?php
namespace backend\controllers;
use yii\captcha\Captcha;
use yii\web\Controller;
use Yii;
use backend\models\Login;
class LoginController extends Controller
{
    public $enableCsrfValidation = false;
    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => null,
                //背景颜色
                'backColor' =>  0x189F92,
                //最大显示个数
                'maxLength' => 4,
                //最少显示个数
                'minLength' => 4,
                //间距
                'padding' => 5,
                //高度
                'height' => 50,
                //宽度
                'width' => 150,
                //字体颜色
                'foreColor' => 0xffffff,
                //设置字符偏移量
                'offset' => 25,
            ],
        ];
    }

    public function actionLogin()
    {

        $model=new Login();
        if(Yii::$app->request->isPost){
            $model->load( Yii::$app->request->post());
            if($model->yanzheng()){
                return $this->redirect(['site/index']);
            }
        }
        return $this->renderPartial('login',['model'=>$model]);
    }


}
