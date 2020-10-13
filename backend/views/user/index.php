<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php

use yii\helpers\Url;

use yii\widgets\LinkPager;

?>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
              <a><cite>用户列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">

                            <form class="layui-form layui-col-space5" action="<?= Url::to(['user/index']) ?>" method="get">
                                <div class="layui-input-inline">
                                    <select name="num" lay-verify="">
                                        <option value="3" <?php if(Yii::$app->request->get('num')==3){ ?> selected <?php } ?>>3</option>
                                        <option value="10" <?php if(Yii::$app->request->get('num')==10||Yii::$app->request->get('num')==''){ ?> selected <?php } ?>>10</option>
                                        <option value="50"<?php if(Yii::$app->request->get('num')==50){ ?> selected <?php } ?>>50</option>
                                    </select>
                                </div>
                                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                                <input type="hidden" name="r" value="user/index">
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="username" value="<?= Yii::$app->request->get('username') ?>"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','<?= Url::to(['user/create']) ?>',900,700)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>
                                      <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                                    </th>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>角色</th>
                                    <th>操作</th></tr>
                                </thead>
                                <tbody>
                               <?php foreach($list as $key=>$val){ ?>
                                <tr>
                                        <td>
                                            <input type="checkbox" value="<?= $val['id']; ?>" data-id="<?= $val['id']; ?>"  lay-skin="primary">
                                        </td>
                                        <td><?= $val['id']; ?></td>
                                        <td><?= $val['username']; ?></td>
                                        <td class="td-status">
                                            <?= $val['juese']; ?>
                                        </td>
                                        <td class="td-manage">

                                            <a title="编辑"  onclick="xadmin.open('编辑','<?= Url::to(['user/edit','id' => $val['id']]) ?>',900,700)" href="javascript:;">
                                                <i class="layui-icon">&#xe642;</i>
                                            </a>

                                            <?php if($val['id']!=1){ ?>
                                            <a title="删除" onclick="member_del(this, <?= $val['id']; ?>)" href="javascript:;">
                                                <i class="layui-icon">&#xe640;</i>
                                            </a>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                            <?= LinkPager::widget([
                                    'pagination' => $pages,
                            ]); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


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
              $.post('<?= Url::to(['user/destroy']) ?>',{"id":id,'<?= Yii::$app->request->csrfParam; ?>':'<?= Yii::$app->request->getCsrfToken();?>'},function (data) {

                  if(data.status==0){
                      $(obj).parents("tr").remove();
                      layer.msg(data.message,{icon:6,time:1000});
                  }else{
                      layer.msg(data.message,{icon:5,time:1000});
                  }
              },'json')
          });
      }



      function delAll (argument) {
        var ids = [];

        // 获取选中的id 
        $('tbody input').each(function(index, el) {
            if($(this).prop('checked')){
               ids.push($(this).val())
            }
        });
        layer.confirm('确认要删除吗？'+ids.toString(),function(index){
            //捉到所有被选中的，发异步进行删除
            $.post('<?= Url::to(['user/delall']) ?>',{"ids":ids,'<?= Yii::$app->request->csrfParam; ?>':'<?= Yii::$app->request->getCsrfToken();?>'},function (data) {
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
