<?php
namespace backend\controllers;
use Yii;
use common\models\Config;
class ConfigController extends CommonController{

    public function actionIndex()
    {

        $list=Config::find()->asArray()->all();

        foreach($list as $key=>$val){

            switch ($val['fiele_type']){

                case 'input';
                    $list[$key]['conf_contents']=' <input type="text" value="'.$val['conf_content'].'" name="conf_content[]" class="layui-input">';
                    break;
                case 'textarea';
                    $list[$key]['conf_contents']='<textarea name="conf_content[]"  class="layui-textarea">'.$val['conf_content'].'</textarea>';
                    break;
                case 'radio';
                    $str='';
                    $all=explode(',',$val['fiele_value']);

                    foreach($all as $k=>$v){
                        if($val['conf_content']==$v){
                            $str.='<input type="radio" name="conf_content[]" checked value="'.$v.'" title="'.$v.'">';
                        }else{
                            $str.='<input type="radio" name="conf_content[]" value="'.$v.'" title="'.$v.'">';

                        }

                    }

                    $list[$key]['conf_contents']=$str;

                    break;

                case 'select';
                    $str='';
                    $all=explode(',',$val['fiele_value']);
                    $str='<select name="conf_content[]" lay-verify="required">';
                    foreach($all as $k=>$v){
                        if($val['conf_content']==$v){
                            $str.='<option selected value="'.$v.'">'.$v.'</option>';
                        }else{
                            $str.='<option value="'.$v.'">'.$v.'</option>';

                        }

                    }
                    $str.= '</select>';
                    $list[$key]['conf_contents']=$str;

                    break;
            }

        }

        return $this->renderPartial('index',['list' => $list]);
    }


    public function actionCreate()
    {
        return $this->renderPartial('create');
    }

    public function actionStore()
    {
        $conf_title = Yii::$app->request->post('conf_title');
        $conf_name = Yii::$app->request->post('conf_name');
        $conf_content = Yii::$app->request->post('conf_content');
        $fiele_type = Yii::$app->request->post('fiele_type');
        $fiele_value = Yii::$app->request->post('fiele_value');
        if($fiele_value!=''){
            $fiele_value=str_replace('，',',', $fiele_value);
        }
        $data= new Config;
        $data->conf_title=$conf_title;
        $data->conf_name=$conf_name;
        $data->conf_content=$conf_content;
        $data->fiele_value=$fiele_value;
        $data->fiele_type=$fiele_type;
        $res=$data->save(false);

        if($res){

            $data=array(
                'status'=>0,
                'message'=>'添加成功'
            );
        }else{
            $data=array(
                'status'=>1,
                'message'=>'添加失败'
            );
        }
        return \yii\helpers\Json::encode($data);
    }

    public function show($id)
    {
        //
    }


    public function actionEdit($id)
    {
        $data=Config::find()->where(['id'=>$id])->asArray()->one();

        return $this->renderPartial('edit',['data'=>$data]);
    }


    public function actionUpdate(){

        $conf_title = Yii::$app->request->post('conf_title');
        $conf_name = Yii::$app->request->post('conf_name');
        $conf_content = Yii::$app->request->post('conf_content');
        $fiele_value = Yii::$app->request->post('fiele_value');
        $id = Yii::$app->request->post('id');

        if($fiele_value!=''){
            $fiele_value=str_replace('，',',', $fiele_value);
        }
        $res = Config::updateAll([
            'conf_title' => $conf_title,
            'conf_name' => $conf_name,
            'conf_content' => $conf_content,
            'fiele_value' => $fiele_value,
        ], ['id' => $id]);
       if($res){

            $data=array(
                'status'=>0,
                'message'=>'修改成功'
            );
        }else{
            $data=array(
                'status'=>1,
                'message'=>'修改失败或没有修改'
            );
        }
        return \yii\helpers\Json::encode($data);
    }


    public function actionDestroy()
    {
        $id=Yii::$app->request->post('id');
        $res=Config::findOne($id)->delete();

        if($res){
            $data=array(
                'status'=>0,
                'message'=>'删除成功'
            );
        }else{
            $data=array(
                'status'=>1,
                'message'=>'删除失败'
            );
        }

        return \yii\helpers\Json::encode($data);
    }
    //批量修改
    public function actionEditall()
    {

        //重新排序
        $i=0;
        $arr=array();
        foreach(Yii::$app->request->post('conf_content') as $key=>$val){
            $arr[$i]=$val;
            $i++;
        }

        foreach (Yii::$app->request->post('id') as $key=>$val){

            Config::updateAll(['conf_content'=>$arr[$key]],['id'=>$val]);
        }


        $this->redirect(['config/index']);

    }



}
