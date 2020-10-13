<?php
namespace common\models;
use yii\db\ActiveRecord;


class Config extends ActiveRecord{


    public static function tableName()
    {
        return '{{%config}}';
    }



}
