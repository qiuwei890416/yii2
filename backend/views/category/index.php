<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php
use yii\helpers\Url;
?>
<style>
    input[readonly] {
        color: #939192;
        background: #f5f5f5 !important;
        cursor: default;
    }
</style>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a>
              <cite>导航元素</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <form  action="<?= Url::to(['category/import_excel_data']) ?>" enctype="multipart/form-data" method="post">
                            <input id="showPath" name="path" class="easyui-textbox" readonly="true" style="width:250px"/>
                            <a href="javascript:;" class="layui-btn" style="position:relative;">浏览...
                                <input class="btn btn-primary" type="file" name="UploadForm[file]" style="opacity:0; filter:alpha(opacity=0); position:absolute; top:2px; right:0px" id="exampleInputFile">
                            </a>
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                            <input type="submit"  class="layui-btn" value="导入Excel">
                        </form>
                        <hr>
                        <form  action="<?= Url::to(['category/piliang']) ?>" enctype="multipart/form-data" method="post">
                            <input id="showPath1" name="path" class="easyui-textbox" readonly="true" style="width:250px"/>
                            <a href="javascript:;" class="layui-btn" style="position:relative;">浏览...
                                <input class="btn btn-primary" type="file" name="file" style="opacity:0; filter:alpha(opacity=0); position:absolute; top:2px; right:0px" id="exampleInputFile1">
                            </a>
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                            <input type="submit"  class="layui-btn" value="导入CSV">
                        </form>
                        <hr>
                        <form  action="<?= Url::to(['category/expuser1']) ?>" method="post" style="width: 200px;float: left;margin-bottom: 10px;">
                            <button class="layui-btn" type="submit" ><i class="layui-icon"></i>大数据导出</button>
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                        </form>
                        <form  action="<?= Url::to(['category/expuser']) ?>"  style="width: 200px;float: left" method="post">
                            <button class="layui-btn" type="submit" ><i class="layui-icon"></i>正常导出</button>
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                        </form>
                        <hr>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加分类','<?= Url::to(['category/create']) ?>',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>
                                      <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                                    </th>
                                    <th>ID</th>
                                    <th>分类名</th>
                                      <th>分类别名</th>
                                      <th>排序</th>
                                      <th>类型</th>
                                    <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php foreach($list as $key=>$val){ ?>
                                    <tr>
                                        <td>
                                            <input  class="did" type="checkbox" value="<?= $val['id']; ?>" data-id="<?= $val['id']; ?>"  lay-skin="primary">
                                        </td>
                                        <td><?= $val['id']; ?></td>
                                        <td><?= str_repeat('|----',$val['level']); ?><?= $val['cate_name']; ?></td>
                                        <td><?= $val['cate_title']; ?></td>
                                        <td>
                                            <span style="float: left;margin-top: 5px;"><?= str_repeat('|----',$val['level']); ?></span><input onchange="paixu(this,<?= $val['id']; ?>)" type="text" style="width: 50px;" name="cate_order" value="<?= $val['cate_order']; ?>" data-id="<?= $val['id']; ?>" required  lay-verify="required" autocomplete="off" class="layui-input paixu">
                                        </td>
                                        <td>
                                            <?php
                                            if($val['cate_type']=='1'){
                                                echo '文章列表';
                                            }else if($val['cate_type']=='2'){
                                                echo '单页';
                                            }else if($val['cate_type']=='3'){
                                                echo '图片列表';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a title="编辑"  onclick="xadmin.open('编辑','<?= Url::to(['category/edit','id' => $val['id']]) ?>',600,400)" href="javascript:;">
                                                <i class="layui-icon">&#xe642;</i>
                                            </a>

                                            <a title="删除" onclick="member_del(this,<?= $val['id']; ?>)" href="javascript:;">
                                                <i class="layui-icon">&#xe640;</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
        function paixu(obj,id){
            var cate_order=$(obj).val();
            $.post('<?= Url::to(['category/paixu']) ?>',{'id':id,'cate_order':cate_order,'<?= Yii::$app->request->csrfParam; ?>':'<?= Yii::$app->request->getCsrfToken();?>'},function (data) {
                if(data.status==0){
                    // $(obj).parents("tr").remove();
                    layer.msg(data.message,{icon:6,time:1000},function () {
                        location.reload();//刷新页面
                    });
                }else{
                    layer.msg(data.message,{icon:5,time:3000});
                }
            },'json')
        }

      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;

          <?php if(Yii::$app->session->hasFlash('success')){ ?>
          layer.msg('<?= Yii::$app->session->getFlash('success') ?>',{icon: 1,time:3000});
          <?php }else if(Yii::$app->session->hasFlash('error')){ ?>
          layer.msg('<?= Yii::$app->session->getFlash('error') ?>',{icon: 2,time:3000});
          <?php }?>
          $(document).ready(function() {
              $("#exampleInputFile").change(function(){  // 当 id 为 file 的对象发生变化时
                  var fileSize = this.files[0].size;
                  console.log(fileSize);
                  var size = fileSize / 1024 / 1024;
                  if (size > 50) {
                      layer.msg('附件不能大于50M,请将文件压缩后重新上传！',{icon: 2,time:3000});
                      this.value="";
                      return false;
                  }else{
                      $("#showPath").val($("#exampleInputFile").val());  //将 #file 的值赋给 #file_name
                  }
              });
              $("#exampleInputFile1").change(function(){  // 当 id 为 file 的对象发生变化时
                  var fileSize = this.files[0].size;
                  console.log(fileSize);
                  var size = fileSize / 1024 / 1024;
                  if (size > 50) {
                      layer.msg('附件不能大于50M,请将文件压缩后重新上传！',{icon: 2,time:3000});
                      this.value="";
                      return false;
                  }else{
                      $("#showPath1").val($("#exampleInputFile1").val());  //将 #file 的值赋给 #file_name
                  }
              });

          });

        // 监听全选
        form.on('checkbox(checkall)', function(data){

          if(data.elem.checked){
            $('tbody input').prop('checked',true);
          }else{
            $('tbody input').prop('checked',false);
          }
          form.render('checkbox');
        }); 
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.post('<?= Url::to(['category/destroy']) ?>',{"id":id,'<?= Yii::$app->request->csrfParam; ?>':'<?= Yii::$app->request->getCsrfToken();?>'},function (data) {
                  if(data.status==0){
                      $(obj).parents("tr").remove();
                      layer.msg(data.message,{icon:6,time:1000});
                  }else{
                      layer.msg(data.message,{icon:5,time:3000});
                  }
              },'json')
          });
      }



      function delAll (argument) {
        var ids = [];

        // 获取选中的id 
        $('.did').each(function(index, el) {
            if($(this).prop('checked')){
               ids.push($(this).val())
            }
        });

        layer.confirm('确认要删除吗？'+ids.toString(),function(index){
            //捉到所有被选中的，发异步进行删除
            $.post('<?= Url::to(['category/delall']) ?>',{"ids":ids,'<?= Yii::$app->request->csrfParam; ?>':'<?= Yii::$app->request->getCsrfToken();?>'},function (data) {

                if(data.status==0){
                    layer.msg(data.message, {icon: 6});
                    $(".layui-form-checked").not('.header').parents('tr').remove();

                }else{
                    layer.msg(data.message, {icon: 5});
                }
            },'json')

        });
      }
    </script>
