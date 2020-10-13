<?php
namespace common\models;
use yii\db\ActiveRecord;


class Category extends ActiveRecord{
    public $level;
    public $fid;

    public static function tableName()
    {
        return '{{%category}}';
    }

    //无限极分类
    public static function wuxianji($data,$fid,$level){
        static $array = array();
        foreach ($data as $k => $v) {
            if($fid == $v->cate_pid){
                $v->level = $level;
                $array[] = $v;
                self::wuxianji($data,$v->id,$level+1);
            }
        }

        return $array;

    }
    public function getArticle(){
        return $this->hasMany('common\models\Article', ['cate_id'=>'id'])->asArray();
    }
    //获取该栏目下的子栏目和该栏目的ID
    public function delzi($id){
        $cates=Category::find() ->asArray()->all();
        $arr= $this->delzido($cates,$id);
        $arr[]=$id;
        $cateids=implode(',',$arr);
        return $cateids;
    }
    //获取栏目下的子栏目ID
    public function delzido($cates,$id){
        static $arr=array();
        foreach ($cates as $key=>$val ){
            if($val['cate_pid']==$id){
                $arr[]=$val['id'];
                $this->delzido($cates,$val['id']);
            }
        }
        return $arr;
    }
    //获取该栏目的上级栏目和本栏目
    public function shanglanmu($id){
        $cates=Category::find()->select('id,cate_pid,cate_name')->asArray()->all();
        //Query()查询
        $db=(new \yii\db\Query());
        $data=$db
            ->from('qw_category')
            ->select('id,cate_pid,cate_name')
            ->where(['id'=>$id])
            ->one();

        if($data['cate_pid']!=0){
            $arr= $this->shanglanmus($cates,$data['cate_pid']);
        }

        $arr[]=$data;
        return $arr;
    }
    //获取栏目的上级栏目
    public function shanglanmus($cates,$pid){
        static $arr=array();
        foreach ($cates as $key=>$val ){
            if($val['id']==$pid){
                $arr[]=$val;
                $this->shanglanmus($cates,$val['cate_pid']);
            }
        }
        return $arr;
    }
}
