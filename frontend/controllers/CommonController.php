<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Category;
use common\models\Article;
use yii\helpers\ArrayHelper;
class CommonController extends Controller{
    public $daohang;
    public $weizhi;
    public $set;
    //验证是否登录
    public function init(){
        parent::init();
        //设置
        $this->set= $this->actionSet();
        //输出到所有页面
        Yii::$app->view->params['set'] = $this->set;
        //导航
        $this->daohang= $this->actionDaohang();
        //输出到所有页面
        Yii::$app->view->params['daohang'] = $this->daohang;
        //位置
        if(Yii::$app->request->get('cateid')){
            $this->weizhi= $this->actionWeizhi(Yii::$app->request->get('cateid'));
        }
        if(Yii::$app->request->get('id')){
            $cateid=Article::find()->where(['id'=>Yii::$app->request->get('id')])->select('cate_id')->one();
            $this->weizhi=   $this->actionWeizhi($cateid);
        }
        Yii::$app->view->params['weizhi'] = $this->weizhi;

    }
    public function actionSet(){
        $db=(new \yii\db\Query());
        $list=$db->from('qw_config')            //表全名
            ->select('conf_name,conf_content')
            ->all();

        $newlist=ArrayHelper::map($list,'conf_name','conf_content');//转换成指定键值对的数组

        return $newlist;


    }
    public function actionWeizhi($id){
        $category=new Category;
        $weizhi=$category->shanglanmu($id);

        return $weizhi;

    }

    public function actionDaohang(){
        $list=Category::find()
            ->orderBy('cate_order asc') //排序
            ->asArray()  //转数组
            ->all();    //查询全部

        $arr=array();
        foreach($list as $key=>$val){
            if($val['cate_pid']==0){
                $arr[$key]=$val;
                $arr[$key]['arr']=array();
                foreach($list as $k=>$v){
                    if($val['id']==$v['cate_pid']){
                        $arr[$key]['arr'][]=$v;
                    }
                }
            }
        }
       return $arr;
    }

}
