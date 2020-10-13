<?php
namespace backend\models;
use yii\db\ActiveRecord;


class Fz extends ActiveRecord{

    public static function tableName()
    {
        return '{{%fz}}';
    }
    public function getAuthrule(){
        return $this->hasMany('backend\models\Authrule', ['fz_id'=>'id'])->asArray();
    }


}
