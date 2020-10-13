<?php
namespace backend\rbac;
use  yii\rbac\Rule;
class Testrule extends Rule{
    public $name='testrule';
    //只能修改自己发布的文章
    public function execute($user_id, $item, $params){
       if(isset($params['article'])) {
            return   $params['article']['user_id']==$user_id?true:false;
       }

    }
}


?>

