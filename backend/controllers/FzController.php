<?php
namespace backend\controllers;
use Yii;
use backend\models\Fz;
use yii\data\Pagination;
//添加权限组控制器
class FzController extends CommonController
{
    public function actionIndex(){
        $fz=Fz::find();
        $title=Yii::$app->request->get('title');
        if($title!=''){
            $fz->andWhere(['like', 'title',$title]);
        }
        $pages = new Pagination(['totalCount' =>$fz->count(), 'pageSize' => Yii::$app->request->get('num')!=''?Yii::$app->request->get('num'):10]);    //实例化分页类,带上参数(总条数,每页显示条数)
        $list= $fz->offset($pages->offset)->limit($pages->limit)->all();
        return $this->renderPartial('index',['list' => $list,'pages' =>$pages,]);
    }
    public function actionCreate(){

        return $this->renderPartial('create');
    }
    public function actionStore(){
        $title=Yii::$app->request->post('title');
        if($title==''){
            $data=array(
                'status'=>2,
                'message'=>'分组标题不为空'
            );
            return \yii\helpers\Json::encode($data);
        }

        $result=Fz::findOne(['title'=>$title]);
        if($result){
            $data=array(
                'status'=>2,
                'message'=>'添加失败，分组标题已存在'
            );
            return \yii\helpers\Json::encode($data);
        }
        $fz= new Fz;
        $fz->title=$title;
        $res= $fz->save();

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
    public function actionEdit($id){
        $data=Fz::findOne(['id'=>$id]);
        return $this->renderPartial('edit',['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionUpdate()
    {
        $title=Yii::$app->request->post('title');
        $id=Yii::$app->request->post('id');
        $data=Fz::find()->where(['!=', 'id', $id])->andWhere(['title'=>$title])->one();
        if($data){
            $data=array(
                'status'=>2,
                'message'=>'修改失败，分组标题已存在'
            );
            return \yii\helpers\Json::encode($data);
        }

        $res= Fz::updateAll(['title'=>$title],['id'=>$id]);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionDestroy()
    {
        $id=Yii::$app->request->post('id');
        $res=Fz::findOne($id)->delete();

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
    public function actionDelall(){
        $ids=Yii::$app->request->post('ids');


        $res= Fz::deleteAll(['id'=>$ids]);

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
}
