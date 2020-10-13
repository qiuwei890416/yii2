<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" id="art_form" enctype="multipart/form-data">
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>角色名称</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="name" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>是否启用</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" name="status"  lay-text="开启|停用"  checked="checked" lay-skin="switch">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">说明</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="description" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            角色权限</label>
                        <div class="layui-input-inline" style="width: 80%">
                            <table class="layui-table" >
                                <?php foreach($fz as $key=>$val){ ?>
                                <thead>
                                    <tr style="background: #bbbbbb;">
                                        <th>
                                            <input class="father" type="checkbox"  title="<?= $val['title']; ?>" value="<?= $val['id']; ?>" lay-skin="primary" lay-filter="father">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php if(isset($val['qx'])){ foreach($val['qx'] as $k=>$v){ ?>

                                            <input class="child" name="rules[]"  title="<?= $v['description']; ?>" value="<?= $v['name']; ?>" lay-filter="child"  lay-skin="primary" type="checkbox">

                                            <?php }} ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">

                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
                </form>
            </div>
        </div>
        <script>
            layui.use(['form', 'layer','jquery',],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;
                form.on('checkbox(child)', function(data){
                    console.log(data);
                    if(data.elem.checked){
                        $(this).prop("checked", true);
                        $(this).parent().parent().parent().prev().find('.father').prop("checked", true);
                        form.render();
                    }else{
                        $(this).prop("checked", false);
                        var a=[];
                        var i=0;
                        $(data.elem).parent().find('input').each(function(){
                            if($(this).prop('checked')){
                                a[i]=1
                            }else{
                                a[i]=0
                            }
                            i++;
                        });
                        console.log(a);
                        var fan=0;
                        for(var i = 0;i<a.length;i++){
                            // if(a[0]==a[i]&&a[0]==0){
                            //     fan=1;
                            // }else{
                            //     fan=0;
                            // }
                            if(a[i]==1){
                                fan=0;
                                break;
                            }else{
                                fan=1;
                            }
                        }
                        if(fan==1){
                            $(this).parent().parent().parent().prev().find('.father').prop("checked", false);
                        }



                        form.render();
                    }
                });

                form.on('checkbox(father)', function(data){

                    if(data.elem.checked){
                        $(data.elem).parent().parent().parent().next().find('input').prop("checked", true);
                        form.render();
                    }else{
                        $(data.elem).parent().parent().parent().next().find('input').prop("checked", false);
                        form.render();
                    }
                });
                // //自定义验证规则
                // form.verify({
                //     nikename: function(value) {
                //         if (value.length < 5) {
                //             return '昵称至少得5个字符啊';
                //         }
                //     },
                //
                // });

                //监听提交
                form.on('submit(add)',
                function(data) {
                    console.log(data);
                    $.ajax({
                        url:"<?= Url::to(['authgroup/store']) ?>",
                        type:'post',
                        timeout:"3000",
                        dataType : 'json',
                        cache:"false",
                        data:data.field,
                        success:function(data){
                            console.log(data);
                            if(data.status==0){
                                layer.alert(data.message, {
                                        icon: 6
                                    },
                                    function() {
                                        //关闭当前frame
                                        xadmin.close();

                                        // 可以对父窗口进行刷新
                                        xadmin.father_reload();
                                    });
                            }else{
                                layer.alert(data.message, {
                                        icon: 5
                                    },
                                    function(index) {
                                        layer.close(index);


                                    });
                            }



                        },
                        error:function(err){
                            console.log(err);
                        }
                    });

                    return false;
                });

            });</script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

