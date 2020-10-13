<?php
namespace backend\controllers;
use Yii;
use backend\models\Authrule;
use yii\data\Pagination;
use backend\models\Fz;
//权限控制器
class AuthruleController extends CommonController
{

    public function actionIndex(){
        $authrule=Authrule::find()->where(['type'=>2]);
        $description=Yii::$app->request->get('description');
        if($description!=''){
            $authrule->andWhere(['like', 'description',$description]);
        }
        $name=Yii::$app->request->get('name');
        if($name!=''){
            $authrule->andWhere(['like', 'name',$name]);
        }
        $fz_id=Yii::$app->request->get('fz_id');
        if($fz_id!=''){
            $authrule->andWhere(['=', 'fz_id',$fz_id]);
        }
        $pages = new Pagination(['totalCount' =>$authrule->count(), 'pageSize' => Yii::$app->request->get('num')!=''?Yii::$app->request->get('num'):10]);    //实例化分页类,带上参数(总条数,每页显示条数)
        $list= $authrule->with('fz')
           ->orderBy('fz_id asc')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $list_fz=Fz::find()->asArray()->all();
        return $this->renderPartial('index',['list' => $list,'pages' =>$pages,'list_fz'=>$list_fz]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actionCreate(){
        $list=Fz::find()->asArray()->all();
        return $this->renderPartial('create',['list' => $list]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function actionStore(){
        $description=Yii::$app->request->post('description');
        $name=Yii::$app->request->post('name');
        $fz_id=Yii::$app->request->post('fz_id');
        if($name==''||$description==''){
            $data=array(
                'status'=>2,
                'message'=>'录入内容不得为空'
            );
            return \yii\helpers\Json::encode($data);
        }
        $auth=\Yii::$app->authManager;
        $result=$auth->getPermission($name);
        if($result){
            $data=array(
                'status'=>2,
                'message'=>'添加失败，权限已存在'
            );
            return \yii\helpers\Json::encode($data);
        }

        $auth=\Yii::$app->authManager;
        $perm=$auth->createPermission($name);
        $perm->description=$description;
        $res=$auth->add($perm);
        if($res){
            Authrule::updateAll(['fz_id'=>$fz_id],['name'=>$name]);
            $onerule=$auth->getRole('超级管理员');
            $oneperm=$auth->getPermission($name);
            $auth->addChild($onerule,$oneperm);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionShow($id)
    {
        //事务
        DB::beginTransaction(); //开启事务

        try {
            // 校验值...

            DB::commit();//事务提交
            return redirect('admin/Article');
        } catch (\Exception $e) {
            DB::rollBack();//事务回滚
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionEdit($name){
        $list=Fz::find()->asArray()->all();
        $data=Authrule::findOne(['name'=>$name]);

        return $this->renderPartial('edit',['data' => $data,'list'=>$list]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionUpdate(){
        $description=Yii::$app->request->post('description');
        $name=Yii::$app->request->post('name');
        $fz_id=Yii::$app->request->post('fz_id');
        $oldname=Yii::$app->request->post('oldname');
        if($name==''||$description==''){
            $data=array(
                'status'=>2,
                'message'=>'录入内容不得为空'
            );
            return \yii\helpers\Json::encode($data);
        }
        $yan=Authrule::find()
            ->where(['name'=>$name,'type'=>2])
            ->andWhere(['!=', 'name', $oldname])
            ->asArray()  //转数组
            ->one();    //查询全部

        if($yan){
            $data=array(
                'status'=>2,
                'message'=>'修改失败，权限已存在'
            );
            return \yii\helpers\Json::encode($data);

        }

        $auth=\Yii::$app->authManager;
        $oneperm=$auth->getPermission($oldname);
        $oneperm->description=$description;
        $oneperm->name=$name;
        $res=$auth->update($oldname,$oneperm);

        if($res){
            Authrule::updateAll(['fz_id'=>$fz_id,],['name'=>$name]);
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
        $name=Yii::$app->request->post('name');
        $auth=\Yii::$app->authManager;
        $oneperm=$auth->getPermission($name);
        $res=$auth->remove($oneperm);


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
        $auth=\Yii::$app->authManager;
        if(isset($ids)){
            foreach ($ids as $key=>$val){
                $oneperm=$auth->getPermission($val);
                $res=$auth->remove($oneperm);
                if(!$res){
                    $data=array(
                        'status'=>1,
                        'message'=>'删除失败'
                    );
                    return \yii\helpers\Json::encode($data);
                }
            }
            $data=array(
                'status'=>0,
                'message'=>'删除成功'
            );
            return \yii\helpers\Json::encode($data);
        }else{
            $data=array(
                'status'=>2,
                'message'=>'请选择'
            );
            return \yii\helpers\Json::encode($data);
        }

    }

}
