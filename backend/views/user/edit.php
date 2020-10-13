<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<style>
    .layui-form-checkbox span{
        height:3%;
    }
</style>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>用户名</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="username" value="<?= $data['username']; ?>" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">
                            <span class="x-red">*</span>密码</label>
                        <div class="layui-input-inline">
                            <input type="password" id="L_pass" name="password" required="" lay-verify="pass" autocomplete="off" class="layui-input"></div>
                        <div class="layui-form-mid layui-word-aux">6到16个字符</div></div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            <span class="x-red">*</span>确认密码</label>
                        <div class="layui-input-inline">
                            <input type="password" id="L_repass" name="repass" required="" lay-verify="repass" autocomplete="off" class="layui-input"></div>
                    </div>
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">
                    <input type="hidden"  name="id" value="<?= $data['id']; ?>" required=""  autocomplete="off" class="layui-input">
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">用户角色</label>
                        <div class="layui-input-block">
                            <?php foreach ($list as $key=>$val){?>
                                <?php if($data['id'] == 1){ ?>
                                    <span style="pointer-events:none;"><input class="danxuan" type="checkbox" checked name="group[]" title="<?= $val['name']; ?>" value="<?= $val['name']; ?>" lay-skin="primary"></span>
                                <?php }else{ ?>
                                    <?php if(in_array($val['name'],$list_y) == true){ ?>
                                        <input type="checkbox" class="danxuan" checked name="group[]" title="<?= $val['name']; ?>" value="<?= $val['name']; ?>" lay-skin="primary">
                                    <?php }else{ ?>
                                        <input type="checkbox" class="danxuan" name="group[]" title="<?= $val['name']; ?>" value="<?= $val['name']; ?>" lay-skin="primary">
                                    <?php }; ?>
                                <?php }; ?>

                            <?php }; ?>
                        </div>
                    </div>
                     <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button>
                    </div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //自定义验证规则
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    },

                    pass:function(value) {
                        if($('#L_pass').val()!=''){
                            [/(.+){6,12}$/, '密码必须6到12位'];
                        }


                    },
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()&&$('#L_pass').val() !='') {
                            return '两次密码不一致';
                        }
                    }
                });

                //监听提交
                form.on('submit(edit)',
                function(data) {
                    console.log(data);
                    //发异步，把数据提交给php
                    $.ajax({
                        url:'<?= Url::to(['user/update']) ?>',
                        type:'POST',
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
                            }else {
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

