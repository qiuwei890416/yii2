<?php
namespace backend\models;
use yii\db\ActiveRecord;


class Authrule extends ActiveRecord{


    public static function tableName()
    {
        return '{{%auth_item}}';
    }
    public function getFz(){

        return $this->hasOne('backend\models\Fz', ['id'=>'fz_id'])->asArray();
    }


}
