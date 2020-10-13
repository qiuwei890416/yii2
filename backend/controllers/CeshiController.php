<?php
namespace backend\controllers;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use common\models\Article;
use backend\controllers\CommonController;
use yii\imagine\Image;
use Yii;

class CeshiController extends CommonController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
    //图片上传
    public function actionUpload()
    {
        return $this->render('index');
    }
    //处理数组
    public function actionHelp()
    {
        //以数组内某个字段值为下标
//        $data=array(
//            array('id'=>1, 'name'=>'aaaa1', 'val'=>'aaaaa111'),
//            array('id'=>2, 'name'=>'aaaa2', 'val'=>'aaaaa222'),
//            array('id'=>3, 'name'=>'aaaa3', 'val'=>'aaaaa111'),
//        );
//        $newdata=ArrayHelper::index($data,'name');
//        $newdata=ArrayHelper::index($data,function ($element){
//                return $element['name'].'haha';
//        });//自定义数组下标

//        $newdata=ArrayHelper::getColumn($data,'name'); //获取数组内指定字段的值
//        $newdata=ArrayHelper::getColumn($data,function ($element){
//                return $element['name'].'haha';
//        });//修改指定字段的所有值

//        $newdata=ArrayHelper::map($data,'name','val');//转换成指定键值对的数组
//        $newdata=ArrayHelper::map($data,'name','val','val');//转换成以某个字段分组的

        //判断数组中指定键值是否存在
//        $data=array(
//            'name'=>'sdss',
//            'nUm'=>22,
//        );
//       var_dump(ArrayHelper::keyExists('num',$data));//识别大小写
//        var_dump(ArrayHelper::keyExists('num',$data,false));//不识别大小写
        //把数组以指定字段排序
//        $data=array(
//            array('id'=>1, 'name'=>'aaaa1', 'val'=>['aa'=>1]),
//            array('id'=>2, 'name'=>'aaaa2', 'val'=>['aa'=>3]),
//            array('id'=>3, 'name'=>'aaaa3', 'val'=>['aa'=>2]),
//        );
         //ArrayHelper::multisort($data,'id',SORT_DESC);//倒序
//        ArrayHelper::multisort($data,['val','aa'],SORT_DESC);
//        var_dump($data);

    }
    //图片操作
    public function actionImage(){
        $imgpath='@backend/web/uploads/wh860.jpg'; //原始图片路径

        //裁剪图片
       // $croppath=Yii::getAlias('@backend/web/uploads/canjian.jpg');//裁剪后图片存放路径及图片名
        //Image::crop($imgpath,200,200)->save($croppath,['quality'=>100]);
        //缩略图
       // $suocaipath=Yii::getAlias('@backend/web/uploads/canjiansuo.jpg');//裁剪缩略图存放路径及图片名
      //  Image::thumbnail($imgpath,100,100)->save($suocaipath,['quality'=>100]);//裁剪模式
        //$suopath=Yii::getAlias('@backend/web/uploads/suo.jpg');//缩略图存放路径及图片名
        //Image::thumbnail($imgpath,100,100,\Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)->save($suopath,['quality'=>100]);//填充模式
            //水印
       // $sypath='@backend/web/uploads/timg.png';//水印路径
        //$shuiyinpath=Yii::getAlias('@backend/web/uploads/shuiyin.jpg');
        //Image::watermark($imgpath,$sypath,[100,100])->save($shuiyinpath,['quality'=>100]);
        // 打文字
       // $font="@yii/captcha/SpicyRice.ttf"; //字体
       // $zipath=Yii::getAlias('@backend/web/uploads/zi.jpg');
       // Image::text($imgpath,'dddffssff',$font,[200,200],['size'=>36,'color'=>'fff','angle'=>30])->save($zipath,['quality'=>100]);
            //加边框
//        $bianpath=Yii::getAlias('@backend/web/uploads/bian.jpg');
//        Image::frame($imgpath,10,'f60',10)->save($bianpath,['quality'=>100]);
    }
    //增删改查
    public function actionZsg(){


        //查询指定条件的所有数据
//        $list=Article::findAll(['art_status'=>1]);
//        var_dump($list);
        //查询指定条件的一条数据
//        $data=Article::findOne(['art_status'=>1]);

        //find()链接查询,单条用one(),多条all().
//        $data=Article::find()->where(['art_status'=>1])->one();
//        $list=Article::find()
////            ->where('art_status=:art_status',[':art_status'=>1])   //防注入
////            ->orderBy('art_time desc') //排序
////            ->offset(2)  //从第几条开始
////            ->limit(3)   // 取几条
////            ->asArray()  //转数组
////            ->all();    //查询全部

        //修改数据
//        $data=Article::findOne(['id'=>15]);
//        $data->art_title='测试文章一';
//        $data->save(false); //false 不走验证

//        Article::updateAll(['art_title'=>'文章一'],['id'=>15]);

        //添加数据
//        $data= new Article;
//        $data->art_title='测试';
//        $data->art_tag='测试';
//        $data->art_description='测试';
//        $data->art_content='测试';
//        $data->art_time=time();
//        $data->art_editor='测试';
//        $data->cate_id=11;
//        $data->art_status=2;
//        $data->save(false);

        //删除数据
//        Article::findOne(64)->delete();
//        Article::deleteAll(['id'=>1]);

//----------------------------------------------------------------------------------------------
        //Query()查询
//        $db=(new \yii\db\Query());
//        $data=$db
//            ->from('qw_article')            //表全名
//            ->select('id,art_title')      //查询的字段
//            ->where('art_status=:art_status',[':art_status'=>1])
//            ->one();                                //查询一条
//        $list=$db
//            ->from('qw_article')            //表全名
//            ->select('id,art_title')      //查询的字段
//            ->where('art_status=:art_status',[':art_status'=>1])
//            ->all();                                //查询全部







//        echo "<pre/>";
//        var_dump($list);

    }
    //RBAC操作
    public function actionRbac(){
        $auth=\Yii::$app->authManager;
       // auth_item表增删改查
        //添加
//        $perm=$auth->createPermission('updata');
//        $perm->description='updata';
//        $auth->add($perm);
//
        //查看一条
        //  $oneperm=$auth->getPermission('demorbac');

        //查看全部
        //   $onepermall=$auth->getPermissions();

        //修改
//        $pre='demorbac';
//        $oneperm=$auth->getPermission($pre);
//        $oneperm->description='dddd';
//        $auth->update($pre,$oneperm);

        //删除
//        $oneperm=$auth->getPermission('demorbac');
//        $auth->remove($oneperm);
//        $auth->removeAllPermissions();

        // rule表增删改查
        //添加
//        $rule=$auth->createRole('juese');
//        $rule->description='juese';
//        $auth->add($rule);
//
        //查看一条
//          $onerule=$auth->getRole('rule');

        //查看全部
//           $oneruleall=$auth->getRoles();

        //修改
//        $pre='rule';
//        $onerule=$auth->getRole($pre);
//        $onerule->description='ddddfg';
//        $auth->update($pre,$onerule);

        //删除
//        $onerule=$auth->getRole('rule');
//        $auth->remove($onerule);
//        $auth->removeAllRoles();


        //把权限节点添加到角色
//        $onerule=$auth->getRole('rule');
//
//        $oneperm=$auth->getPermission('updata');
//        $auth->addChild($onerule,$oneperm);

        //读取角色下的所有节点
//        $rulename='rule';
//        $list=$auth->getPermissionsByRole($rulename);
        //判断角色内是否存在某个节点；
//        $onerule=$auth->getRole('rule');
//        $oneperm=$auth->getPermission('add');
//        $data=$auth->hasChild($onerule,$oneperm);
        //删除角色下的指定节点
//        $onerule=$auth->getRole('rule');
//        $oneperm=$auth->getPermission('updata');
//        $auth->removeChild($onerule,$oneperm);
        //删除角色下的所有节点
//        $onerule=$auth->getRole('rule');
//        $auth->removeChildren($onerule);

        //用户绑定角色
//        $onerule=$auth->getRole('rule');
//        $tworule=$auth->getRole('juese');
//        $auth->assign($onerule,2);
//        $auth->assign($tworule,2);
        //删除用户绑定角色
//        $onerule=$auth->getRole('rule');
//        $auth->revoke($onerule,2);
        //删除该用户绑定的所有角色
//        $auth->revokeAll(2);
        //获取用户下的所有权限
//        $list=$auth->getPermissionsByUser(2);
        //检查某个用户ID下是否有某个权限
//        $data=$auth->checkAccess(2,'add');
        //实例化权限规则
//        $tesrule= new \backend\rbac\Testrule();
        //添加权限规则
//        $auth->add($tesrule);
//把自定义权限规则插入
//        $onerule=$auth->getRule('testrule');
//        $pre='updata';
//       $oneperm=$auth->getPermission($pre);
//        $oneperm->ruleName='testrule';
//       $auth->update($pre,$oneperm);

        //验证新增权限
//        $findarticle=['article'=>['user_id'=>2]];
//        $data=$auth->checkAccess(2,'updata',$findarticle);
//        var_dump($data);
//        $onerule=$auth->getRule('testrule');
//        $auth->remove($onerule);

//            echo '<pre/>';
//    var_dump();
    }

}
