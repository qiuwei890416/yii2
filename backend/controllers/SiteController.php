<?php
namespace backend\controllers;
use Yii;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionWelcome()
    {
        return $this->renderPartial('welcome');
    }
    public function actionOutlogin(){
        //        删除session
        $session=Yii::$app->session;
        $session->removeAll();
        //            删除Cookies

        $cookie= Yii::$app->request->cookies;
        if($cookie->has('rember')){
            $ck=$cookie->get('rember');
            Yii::$app->response->getCookies()->remove($ck);
        }

        $this->redirect(['login/login']);
    }
    public function actionError(){

        return $this->renderPartial('error');
    }
}
