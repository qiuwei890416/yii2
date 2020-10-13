<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
    
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form"  id="art_form" enctype="multipart/form-data">

                    <div class="layui-form-item">
                        <label class="layui-form-label">权限分组</label>
                        <div class="layui-input-inline">
                            <select name="fz_id" lay-verify="required">
                                <?php foreach($list as $key=>$val){ ?>
                                    <option <?php if($data['fz_id']==$val['id']){?>selected <?php }?>value="<?= $val['id']; ?>"><?= $val['title']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">

                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>权限名称</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="description" value="<?= $data['description']; ?>" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>控/方</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="name"  value="<?= $data['name']; ?>" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <input type="hidden"  name="oldname" value="<?= $data['name']; ?>" required=""  autocomplete="off" class="layui-input">

                     <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button>
                    </div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer','upload'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                    layer = layui.layer;
                //自定义验证规则
                // form.verify({
                //     nikename: function(value) {
                //         if (value.length < 5) {
                //             return '昵称至少得5个字符啊';
                //         }
                //     },
                //     pass: [/(.+){6,12}$/, '密码必须6到12位'],
                //     repass: function(value) {
                //         if ($('#L_pass').val() != $('#L_repass').val()) {
                //             return '两次密码不一致';
                //         }
                //     }
                // });

                //监听提交
                form.on('submit(edit)',
                function(data) {
                    console.log(data);
                    //发异步，把数据提交给php

                    $.ajax({
                        url:"<?= Url::to(['authrule/update']) ?>",
                        type:'Post',
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

