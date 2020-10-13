<?php
namespace backend\controllers;
use common\models\Article;
use common\models\Category;
use Yii;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\web\UploadedFile;

class ArticleController extends CommonController
{
    public function actionIndex(){
//        Yii::$app->cache->set('qqq', 'ffff');


        $article=Article::find();
        $art_title=Yii::$app->request->get('art_title');
        if($art_title!=''){
            $article->andWhere(['like', 'art_title',$art_title]);
        }
        $art_status=Yii::$app->request->get('art_status');
        if($art_status!=''){
            $article->andWhere(['like', 'art_status',$art_status]);
        }
        $start=Yii::$app->request->get('start');
        $end=Yii::$app->request->get('end');
        if($start!=''&&$end!=''){
            $start=strtotime($start);
            $end=strtotime($end);
            $article->andWhere(['between','art_time',$start, $end]);
        }else if($start!=''&&$end==''){
            $start=strtotime($start);
            $article->andWhere(['>=', 'art_time',$start]);
        }else if($start==''&&$end!=''){
            $end=strtotime($end);
            $article->andWhere(['<=', 'art_time',$end]);
        }

        $pages = new Pagination(['totalCount' =>$article->count(), 'pageSize' => Yii::$app->request->get('num')!=''?Yii::$app->request->get('num'):10]);    //实例化分页类,带上参数(总条数,每页显示条数)
        $list= $article->with('category')
            ->orderBy('art_time desc')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->renderPartial('index',['list' => $list,'pages' =>$pages,]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actionCreate()
    {
        $cate=Category::find()->orderBy('cate_order asc')->all();
        $list=Category::wuxianji($cate,$fid=0,$level=0);

        return $this->renderPartial('create',['list'=>$list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public  function mkMutiDir($dir){
        if(!is_dir($dir)){
            if(!self::mkMutiDir(dirname($dir))){
                return false;
            }
            if(!mkdir($dir,0777)){
                return false;
            }
        }
        return true;
    }
    public function actionStore( )
    {
        $art_title=Yii::$app->request->post('art_title');
        $art_tag=Yii::$app->request->post('art_tag');
        $art_description=Yii::$app->request->post('art_description');
        $art_content=Yii::$app->request->post('art_content');
        $art_editor=Yii::$app->request->post('art_editor');
        $cate_id=Yii::$app->request->post('cate_id');
        $art_status=Yii::$app->request->post('art_status');

        $result=Article::find()->where(['art_title'=>$art_title,'cate_id'=>$cate_id])->asArray()->one();

        if($result){
            $data=array(
                'status'=>2,
                'message'=>'添加失败，相同分类下文章名不能相同'
            );
            return \yii\helpers\Json::encode($data);

        }
        if($art_status==1){
            $res=Article::find()->where(['art_status'=>1,'cate_id'=>$cate_id])->asArray()->one();
            if($res){
                $data=array(
                    'status'=>3,
                    'message'=>'添加失败，相同分类下只能有一篇推荐文章'
                );
                return \yii\helpers\Json::encode($data);

            }
        }
        $article= new Article;
        $folder='/web/uploads/'.date('Y-m-d');
        $picurl='uploads/'.date('Y-m-d');
        $rootpath=\Yii::$app->getBasePath().$folder;

        $article->thumb=$image=UploadedFile::getInstance($article,'thumb');


        if(is_object($image)){
            if($article->validate()) {
                $ext=$image->getExtension();
                $randname=md5(time().rand(1000,9999)).'.'.$ext;
                $this->mkMutiDir($rootpath);
                $image->saveAs($rootpath.'/'.$randname);

                $article->art_thumb=$picurl.'/'.$randname;
            }else{
                $data=array(
                    'status'=>3,
                    'message'=>Html::error($article,'thumb'),
                );
                return \yii\helpers\Json::encode($data);
            }
        }

        $del_thumb=Yii::$app->request->post('del_thumb');
        if(isset($del_thumb)){
            foreach ($del_thumb as $key=>$val){
                if(file_exists(\Yii::$app->getBasePath().'/web/'.$val)){
                    unlink(\Yii::$app->getBasePath().'/web/'.$val);
                }
            }
        }
        $thumball=Yii::$app->request->post('thumball');

        if(isset($thumball)){
            $article->thumball=implode(',',Yii::$app->request->post('thumball'));
        }

        $article->art_title=$art_title;
        $article->art_time=time();
        $article->art_tag=$art_tag;
        $article->art_description=$art_description;
        $article->art_content=$art_content;
        $article->art_editor=$art_editor;
        $article->cate_id=$cate_id;
        $article->art_status=$art_status;
        $res= $article->save(false);



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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionShow($id)
    {
        //事务
        Db::startTrans(); //开启事务

        try {
            // 校验值...

            Db::commit();  ;//事务提交
            return redirect('Article');
        } catch (\Exception $e) {
            Db::rollback();//事务回滚
            echo $e->getMessage();
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionEdit($id)
    {
        $data=Article::find()->where(['id'=>$id])->asArray()->one();

        if($data['thumball']!=''){
            $data['thumball']=explode(',',$data['thumball']);
        }
        $cate=Category::find()->orderBy('cate_order asc')->all();
        $list=Category::wuxianji($cate,$fid=0,$level=0);

        return $this->renderPartial('edit',['list'=>$list,'data'=>$data]);



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionUpdate(){
        $art_title=Yii::$app->request->post('art_title');
        $art_tag=Yii::$app->request->post('art_tag');
        $art_description=Yii::$app->request->post('art_description');
        $art_content=Yii::$app->request->post('art_content');
        $art_editor=Yii::$app->request->post('art_editor');
        $cate_id=Yii::$app->request->post('cate_id');
        $art_status=Yii::$app->request->post('art_status');
        $id=Yii::$app->request->post('id');

        $result=Article::find()
            ->where(['art_title'=>$art_title,'cate_id'=>$cate_id])
            ->andWhere(['!=','id',$id])
            ->one();
        if($result){
            $data=array(
                'status'=>2,
                'message'=>'修改失败，相同分类下文章名不能相同'
            );
            return \yii\helpers\Json::encode($data);

        }
        if($art_status==1){
            $res=Article::find()
                ->where(['art_status'=>$art_status,'cate_id'=>$cate_id])
                ->andWhere(['!=','id',$id])
                ->one();
            if($res){
                $data=array(
                    'status'=>3,
                    'message'=>'修改失败，相同分类下只能有一篇推荐文章'
                );
                return \yii\helpers\Json::encode($data);
            }
        }

        $art_thumb=Yii::$app->request->post('art_thumb_old');

        $article= new Article;
        $folder='/web/uploads/'.date('Y-m-d');
        $picurl='uploads/'.date('Y-m-d');
        $rootpath=\Yii::$app->getBasePath().$folder;

        $article->thumb=$image=UploadedFile::getInstance($article,'thumb');

        if(is_object($image)){
            if($article->validate()) {
                $oldthumb=Yii::$app->request->post('art_thumb_old');
                if($oldthumb!=''){
                    if(file_exists(\Yii::$app->getBasePath().'/web/'.$oldthumb)){
                        unlink(\Yii::$app->getBasePath().'/web/'.$oldthumb);
                    }
                }
                $ext=$image->getExtension();
                $randname=md5(time().rand(1000,9999)).'.'.$ext;
                $this->mkMutiDir($rootpath);
                $image->saveAs($rootpath.'/'.$randname);

                $art_thumb=$picurl.'/'.$randname;
            }else{
                $data=array(
                    'status'=>3,
                    'message'=>Html::error($article,'thumb'),
                );
                return \yii\helpers\Json::encode($data);
            }
        }

        $del_thumb=Yii::$app->request->post('del_thumb');
        if(isset($del_thumb)){
            foreach ($del_thumb as $key=>$val){
                if(file_exists(\Yii::$app->getBasePath().'/web/'.$val)){
                    unlink(\Yii::$app->getBasePath().'/web/'.$val);
                }
            }
        }
        $thumball=Yii::$app->request->post('thumball');
        if(isset($thumball)){
            $thumball=implode(',',$thumball);
        }else{
            $thumball='';
        }

        $res=Article::updateAll([
            'art_title'=>$art_title,
            'art_tag'=>$art_tag,
            'art_description'=>$art_description,
            'art_thumb'=>$art_thumb,
            'art_content'=>$art_content,
            'art_editor'=>$art_editor,
            'cate_id'=>$cate_id,
            'art_status'=>$art_status,
            'thumball'=>$thumball,
        ],['id'=>$id]);

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

        $data=Article::find()->where(['id'=>$id])->asArray()->one();

        if($data['art_thumb']!=''){
            if(file_exists(\Yii::$app->getBasePath().'/web/'.$data['art_thumb'])){
                unlink(\Yii::$app->getBasePath().'/web/'.$data['art_thumb']);
            }
        }
        if($data['thumball']!=''){
            $arr=explode(',',$data['thumball']);
            foreach ($arr as $key=>$val){
                if(file_exists(\Yii::$app->getBasePath().'/web/'.$val)){
                    unlink(\Yii::$app->getBasePath().'/web/'.$val);
                }
            }

        }
        $res=Article::findOne($id)->delete();

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
        $list=Article::find()
            ->where(['id'=>$ids])
            ->select('art_thumb')
            ->asArray()  //转数组
            ->all();    //查询全部
        $listduo=Article::find()
            ->where(['id'=>$ids])
            ->select('thumball')
            ->asArray()  //转数组
            ->all();    //查询全部



        $res=Article::deleteAll(['id'=>$ids]);
        if($res){
            foreach($list as $key=>$val){
                if(isset($val['art_thumb'])){
                    if(file_exists(\Yii::$app->getBasePath().'/web/'.$val['art_thumb'])){
                        unlink(\Yii::$app->getBasePath().'/web/'.$val['art_thumb']);
                    }
                }
            }
            foreach($listduo as $key=>$val){
                if(isset($val['thumball'])){
                    $arr=explode(',',$val['thumball']);
                    foreach ($arr as $k=>$v){
                        if(file_exists(\Yii::$app->getBasePath().'/web/'.$v)){
                            unlink(\Yii::$app->getBasePath().'/web/'.$v);
                        }
                    }
                }
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


//多图片上传
    public function actionAjax_uploads(){
        $article= new Article;
        $folder='/web/uploads/'.date('Y-m-d');
        $picurl='uploads/'.date('Y-m-d');
        $rootpath=\Yii::$app->getBasePath().$folder;
        $article->thumbduo=$image=UploadedFile::getInstance($article,'thumbduo');
        if(is_object($image)){
            if($article->validate()) {
                $ext=$image->getExtension();
                $randname=md5(time().rand(1000,9999)).'.'.$ext;
                $this->mkMutiDir($rootpath);
                $info=$image->saveAs($rootpath.'/'.$randname);
                $code = 1;
                $thumb = $picurl.'/'.$randname;
                $msg='成功';
            }else{
                // 上传失败获取错误信息
                $code = 0;
                $msg = Html::error($article,'thumbduo');
                $thumb='';
            }


            $data = array(
                'code' => $code,
                'msg' => $msg,
                'thumb' =>$thumb
            );

        }else{
            $data = array(
                'code' => 0,
                'msg' => '没有文件',
                'thumb' => '',
            );
        }
        return \yii\helpers\Json::encode($data);


    }

}
