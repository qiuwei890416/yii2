<?php
namespace backend\controllers;
use Yii;
use common\models\User;
use yii\data\Pagination;
use backend\models\Authrule;
class UserController extends CommonController
{

    public function actionIndex(){

        $user=User::find();
        $username=Yii::$app->request->get('username');
        if($username!=''){
            $user->andWhere(['like', 'username',$username]);
        }
        $pages = new Pagination(['totalCount' =>$user->count(), 'pageSize' => Yii::$app->request->get('num')!=''?Yii::$app->request->get('num'):10]);    //实例化分页类,带上参数(总条数,每页显示条数)
        $list= $user->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        $auth=\Yii::$app->authManager;
        foreach ($list as $key=>$val){
            $you=$auth->getRolesByUser($val['id']);
            $list_y=array();
            if(count($you)!=0){
                foreach ($you as $k=>$v){
                    $list_y[]=$k;
                }
                $list[$key]['juese']=implode(',',$list_y);
            }else{
                $list[$key]['juese']='';
            }
        }

        return $this->renderPartial('index',['list' => $list,'pages' =>$pages,]);
    }
    public function actionCreate(){
        $list=Authrule::find()->where(['type'=>1])->asArray()->all();    //查询全部

        return $this->renderPartial('create',['list' => $list]);
    }
    public function actionStore(){
        $group=Yii::$app->request->post('group');
        $username=Yii::$app->request->post('username');
        if($username==''||Yii::$app->request->post('password')==''){
            $data=array(
                'status'=>2,
                'message'=>'用户名或密码不能为空'
            );
            return \yii\helpers\Json::encode($data);
        }

        $password=md5(Yii::$app->request->post('password'));

        $result=User::findOne(['username'=>$username]);
        if($result){
            $data=array(
                'status'=>2,
                'message'=>'添加失败，用户名已存在'
            );
            return \yii\helpers\Json::encode($data);
        }
        $user= new User;
        $user->username=$username;
        $user->password=$password;
        $res= $user->save();
        if($res){
            if(isset($group)){
                $auth=\Yii::$app->authManager;
                foreach($group as $key=>$val){
                    $rule=$auth->getRole($val);
                    $auth->assign($rule,$user->attributes['id']);
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
    public function actionEdit($id){
        $list=Authrule::find()->where(['type'=>1])->asArray()->all();    //查询全部
        $auth=\Yii::$app->authManager;
        $data=User::findOne(['id'=>$id]);
        $you=$auth->getRolesByUser($id);

        $list_y=array();
       if(count($you)!=0){
           foreach ($you as $key=>$val){
               $list_y[]=$key;
           }
       }

        return $this->renderPartial('edit',['data' => $data,'list'=>$list,'list_y'=>$list_y]);
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
        $auth=\Yii::$app->authManager;
        $group=Yii::$app->request->post('group');
        $username=Yii::$app->request->post('username');
        $id=Yii::$app->request->post('id');
        $data=User::find()->where(['!=', 'id', $id])->andWhere(['username'=>$username])->one();
        if($data){
            $data=array(
                'status'=>2,
                'message'=>'修改失败，用户名已存在'
            );
            return \yii\helpers\Json::encode($data);
        }

        $data_old=User::findOne(['id'=>$id]);
        Yii::$app->request->post('password')!=''?$password=md5( Yii::$app->request->post('password')):$password=$data_old->password;

        $res= User::updateAll(['username'=>$username,'password'=>$password],['id'=>$id]);


//        //删除当前用户的角色
        $res2=$auth->revokeAll($id);
        //给当前用户添加角色
        $res1=0;
        if(isset($group)){
            foreach($group as $key=>$val){
                $rule=$auth->getRole($val);
                $auth->assign($rule,$id);
                $res1=1;
            }
        }

        if($res||$res1==1||$res2){
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
        $auth=\Yii::$app->authManager;
        $id=Yii::$app->request->post('id');

        if($id!=1){
            $res=User::findOne($id)->delete();
        }else{
            $data=array(
                'status'=>1,
                'message'=>'删除失败,总管理禁止删除'
            );
            return \yii\helpers\Json::encode($data);
        }

        if($res){
            $auth->revokeAll($id);
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
        if (in_array("1", $ids)){
            $data=array(
                'status'=>2,
                'message'=>'删除失败,总管理不能删除'
            );
            return \yii\helpers\Json::encode($data);
        }

        $res= User::deleteAll(['id'=>$ids]);
        $auth=\Yii::$app->authManager;
        if($res){
            foreach ($ids as $key=>$val){
                $auth->revokeAll($val);
            }
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
