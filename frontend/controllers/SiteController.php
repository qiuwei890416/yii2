<?php
namespace frontend\controllers;
use common\models\Article;
use Yii;
use yii\data\Pagination;

class SiteController extends CommonController{


    public function actionIndex(){


        return $this->renderPartial('index');
    }
    public function actionImglist(){
        $article=new Article;
        $list=$article->allarticles(Yii::$app->request->get('cateid'));


        return $this->renderPartial('imglist',['list'=>$list['list'],'pages'=>$list['pages']]);

    }
    public function actionArtlist(){
        $article=new Article;
        $list=$article->allarticles(Yii::$app->request->get('cateid'));
        $hotlist=$article->hotarticles(Yii::$app->request->get('cateid'));


        return $this->renderPartial('artlist',['list'=>$list['list'],'pages'=>$list['pages'],'hotlist'=>$hotlist]);

    }
    public function actionArticle(){
        $id=Yii::$app->request->get('id');
        $data=Article::find()->where(['id'=>$id])->one();
        $shu=$data->art_view+1;
        Article::updateAll(['art_view'=>$shu],['id'=>$id]);

        $article=new Article;
        $hotlist=$article->hotarticles($data['cate_id']);
        return $this->renderPartial('article',['data'=>$data,'hotlist'=>$hotlist]);

    }
    public function actionSousuo(){
        $article=new Article;
        $list=$article->sousuoarticle(Yii::$app->request->get('art_title'));
        $hotlist=$article->hotarticle();
        return $this->renderPartial('sousuo',['list'=>$list['list'],'pages'=>$list['pages'],'hotlist'=>$hotlist]);

    }
}
