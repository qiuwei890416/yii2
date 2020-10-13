<?php
namespace common\models;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use common\models\Category;
class Article extends ActiveRecord{
    public $thumb;
    public $thumbduo;

    public function rules(){
        return [
            [['thumb'], 'file', 'extensions' => 'jpg,png,gif,jpeg', 'mimeTypes' => 'image/jpeg, image/png,image/gif',],
            [['thumbduo'], 'file', 'extensions' => 'jpg,png,gif,jpeg','mimeTypes' => 'image/jpeg, image/png,image/gif',],
        ];
    }


    public static function tableName()
    {
        return '{{%Article}}';
    }
    public function getCategory(){

        return $this->hasOne('common\models\Category', ['id'=>'cate_id'])->asArray();
    }
//查询本栏目和子栏目的文章
    public function allarticles($cateid){
        $category=new Category;
        $cateids= $category->delzi($cateid);
        $articles=Article::find()->where(['cate_id'=>$cateids]);

        $pages = new Pagination(['totalCount' =>$articles->count(), 'pageSize' => 5]);
        $list=$articles->orderBy('art_time desc')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return ['list'=>$list,'pages'=>$pages];
    }
//查询本栏目和子栏目的热门文章
    public function hotarticles($cateid){
        $category=new Category;
        $cateids= $category->delzi($cateid);
        $list=Article::find()->where(['cate_id'=>$cateids])->orderBy('art_view desc')->limit(5)->asArray()->all();
        return $list;
    }
    //热点文章
    public function hotarticle(){
        $list=Article::find()->orderBy('art_view desc')->limit(5)->asArray()->all();
        return $list;
    }
    //搜索页
    public function sousuoarticle($art_title){
        $articles=Article::find()->where(['like', 'art_title',$art_title]);
        $pages = new Pagination(['totalCount' =>$articles->count(), 'pageSize' => 5]);
        $list=$articles->orderBy('art_time desc')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return ['list'=>$list,'pages'=>$pages];
    }
}