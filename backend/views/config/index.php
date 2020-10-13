<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php
use yii\helpers\Url;
?>
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
                        <div class="layui-card-header">
                            <button style="height: 30px;line-height: 30px;padding: 0 10px;margin-top: 6px;" class="layui-btn" onclick="xadmin.open('添加配置','<?= Url::to(['config/create']) ?>',900,700)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <form class="layui-form" method="post" action="<?= Url::to(['config/editall']) ?>">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                      <th>ID</th>
                                      <th>标题</th>
                                      <th>名称</th>
                                      <th>内容</th>
                                      <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $key=>$val){ ?>
                                    <tr>
                                        <td><?= $val['id']; ?></td>
                                        <td><?= $val['conf_title']; ?></td>
                                        <td><?= $val['conf_name']; ?></td>
                                        <td>
                                            <input type="hidden" name="id[]" value="<?= $val['id']; ?>">
                                            <?= $val['conf_contents']; ?>
                                        </td>
                                        <td>
                                            <a title="编辑"  onclick="xadmin.open('编辑','<?= Url::to(['config/edit','id' => $val['id']]) ?>',900,700)" href="javascript:;">
                                                <i class="layui-icon">&#xe642;</i>
                                            </a>

                                            <a title="删除" onclick="member_del(this,<?= $val['id']; ?>)" href="javascript:;">
                                                <i class="layui-icon">&#xe640;</i>
                                            </a>

                                        </td>
                                    </tr>
                               <?php } ?>
                             <tr>
                                 <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                                 <td colspan="7">
                                     <button lay-submit="" class="layui-btn"><i class="layui-icon"></i>批量修改</button>

                                 </td>
                             </tr>

                                </tbody>

                            </table>
                            </form>
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

        $(document).ready(function() {

        });
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });


      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.post("<?= Url::to(['config/destroy']) ?>",{"id":id,'<?= Yii::$app->request->csrfParam; ?>':'<?= Yii::$app->request->getCsrfToken();?>'},function (data) {
                  if(data.status==0){
                      $(obj).parents("tr").remove();
                      layer.msg(data.message,{icon:6,time:1000});
                  }else{
                      layer.msg(data.message,{icon:5,time:3000});
                  }
              },'json')

          });
      }
    </script>
</html>