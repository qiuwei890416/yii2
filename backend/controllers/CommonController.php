<?php
namespace backend\controllers;
use yii\web\Controller;
use Yii;
use backend\models\Login;

class CommonController extends Controller
{
    //验证是否登录
    public function init()
    {
        parent::init();
        if(!Yii::$app->session->get('uid')&&!Login::yancookie()){

            Yii::$app->response->redirect( ['login/login']);

        }else{

            $uid=Yii::$app->session->get('uid');

            if($uid!=1){

                $ben= Yii::$app->requestedRoute ;
//        //获取个人权限路由
                $quan=Yii::$app->session->get('quan');
//        //不参加权限验证的路由
                $guo=array(
                    'site/index',
                    'site/welcome',
                    'site/outlogin',
                    'site/error'
                );


        //权限验证
                if(in_array($ben,$quan)==false&&in_array($ben,$guo)==false) {
            //判断是不是AJAX请求
                    if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
                        $data=array(
                            'status'=>3,
                            'message'=>'没有权限'
                        );
                        echo \yii\helpers\Json::encode($data);
                        exit(0);
                    }else{
                        Yii::$app->response->redirect(['site/error']);
                    }
                }
            }

        }




    }


}
