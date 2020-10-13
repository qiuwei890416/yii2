<?php
namespace backend\controllers;
use backend\models\Fz;
use Yii;
use yii\data\Pagination;
use backend\models\Authrule;
//角色控制器
class AuthgroupController extends CommonController
{
    public function actionIndex(){
        $authgroup=Authrule::find()->where(['type'=>1]);
        $name=Yii::$app->request->get('name');
        if($name!=''){
            $authgroup->andWhere(['like', 'name',$name]);
        }
        $pages = new Pagination(['totalCount' =>$authgroup->count(), 'pageSize' => Yii::$app->request->get('num')!=''?Yii::$app->request->get('num'):10]);    //实例化分页类,带上参数(总条数,每页显示条数)
        $list= $authgroup
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->renderPartial('index',['list' => $list,'pages' =>$pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actionCreate(){
        $authrule=Authrule::find()->where(['type'=>2])->orderBy('fz_id asc')->asArray()->all();
        $fz=Fz::find()->asArray()->all();
        $arr=array();
        foreach ($authrule as $key=>$val){
            $arr[$val['fz_id']][]=$val;
        }
        foreach ($fz as $key=>$val){
            $fz[$key]['qx']=$arr[$val['id']];
        }


        return $this->renderPartial('create',['fz' => $fz]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function actionStore(){
        $auth=\Yii::$app->authManager;
        $description=Yii::$app->request->post('description');
        $name=Yii::$app->request->post('name');
        $status=Yii::$app->request->post('status');
        $rules=Yii::$app->request->post('rules');
          if($status=='on'){
              $status=1;
          }else{
              $status=0;
          }
        if($name==''){
            $data=array(
                'status'=>2,
                'message'=>'录入内容不得为空'
            );
            return \yii\helpers\Json::encode($data);
        }

        $result= $onerule=$auth->getRole($name);

        if($result){
            $data=array(
                'status'=>2,
                'message'=>'添加失败，角色已存在'
            );
            return \yii\helpers\Json::encode($data);
        }

        $rule=$auth->createRole($name);
        $rule->description=$description;
        $res=$auth->add($rule);
        if($res){
            Authrule::updateAll(['status'=>$status],['name'=>$name]);
            if(isset($rules)){
                foreach ($rules as $key=>$val){
                    $onerule=$auth->getRole($name);
                    $oneperm=$auth->getPermission($val);
                    $auth->addChild($onerule,$oneperm);

                }
            }

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
        $auth=\Yii::$app->authManager;
        $authrule=Authrule::find()->where(['type'=>2])->orderBy('fz_id asc')->asArray()->all();
        $fz=Fz::find()->asArray()->all();
        $arr=array();
        foreach ($authrule as $key=>$val){
            $arr[$val['fz_id']][]=$val;
        }
        foreach ($fz as $key=>$val){
            $fz[$key]['qx']=$arr[$val['id']];
        }

        $data=Authrule::findOne(['name'=>$name]);

        $list_qx=$auth->getPermissionsByRole($name);
        $you=array();
        foreach ($list_qx as $key=>$val){
            $you[]=$key;
        }
        $list_fid=Authrule::find()->where(['name'=>$you])->select('fz_id')->asArray()->all();
        $fid=array();
        if(isset($list_fid)){
           foreach ($list_fid as $key=>$val){
               $fid[]=$val['fz_id'];
           }
            $fid=array_unique($fid);
        }


        return $this->renderPartial('edit',['data' => $data,'fz'=>$fz,'you'=>$you,'fid'=>$fid]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionUpdate(){
        $auth=\Yii::$app->authManager;
        $description=Yii::$app->request->post('description');
        $name=Yii::$app->request->post('name');
        $status=Yii::$app->request->post('status');
        $rules=Yii::$app->request->post('rules');
        $oldname=Yii::$app->request->post('oldname');

        if($status=='on'){
            $status=1;
        }else{
            $status=0;
        }
        if($name==''){
            $data=array(
                'status'=>2,
                'message'=>'录入内容不得为空'
            );
            return \yii\helpers\Json::encode($data);
        }
        $yan=Authrule::find()
            ->where(['name'=>$name,'type'=>1])
            ->andWhere(['!=', 'name', $oldname])
            ->asArray()  //转数组
            ->one();    //查询全部

        if($yan){
            $data=array(
                'status'=>2,
                'message'=>'修改失败，角色已存在'
            );
            return \yii\helpers\Json::encode($data);

        }

        $onerule=$auth->getRole($oldname);
        $onerule->description=$description;
        $onerule->name=$name;
        $res=$auth->update($oldname,$onerule);

        if($res){
            Authrule::updateAll(['status'=>$status,],['name'=>$name]);
            //删除角色下的所有权限
            $yan=$auth->getPermissionsByRole($name);
            if(count($yan)!=0){
                $oneru=$auth->getRole($name);
                $auth->removeChildren($oneru);
            }

            //给角色添加权限
            if(isset($rules)){
                foreach ($rules as $key=>$val){
                    $oner=$auth->getRole($name);
                    $onep=$auth->getPermission($val);
                    $auth->addChild($oner,$onep);
                }
            }

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
        $onerule=$auth->getRole($name);
        $res= $auth->remove($onerule);
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
                $onerule=$auth->getRole($val);
                $res= $auth->remove($onerule);
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
    public function actionStatus(){
        $name=Yii::$app->request->post('name');
        $status=Yii::$app->request->post('status');
        $db=(new \yii\db\Query());
        $map['item_name']=array('=',$name);
        $yan=$db
            ->from('qw_auth_assignment')            //表全名
            ->where($map)
            ->one();

        if($yan){
            $data=array(
                'status'=>5,
                'message'=>'有用户正在使用此角色，不可禁用!!'
            );
            return \yii\helpers\Json::encode($data);
        }
        $res= Authrule::updateAll(['status'=>$status,],['name'=>$name]);
        if($res){
            $data=array(
                'status'=>0,
                'message'=>'修改成功'
            );
        }else{
            $data=array(
                'status'=>1,
                'message'=>'修改失败'
            );
        }
        return \yii\helpers\Json::encode($data);
    }
}
