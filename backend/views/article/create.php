<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?=Html::jsFile('@web/up/js/vendor/jquery.ui.widget.js')?>
<?=Html::jsFile('@web/up/js/jquery.iframe-transport.js')?>
<?=Html::jsFile('@web/up/js/jquery.fileupload.js')?>
<!--        <script src="./up/js/vendor/jquery.ui.widget.js"></script>-->
<!--        <script src="./up/js/jquery.iframe-transport.js"></script>-->
<!--        <script src="./up/js/jquery.fileupload.js"></script>-->
        <script>
            $(document).ready(function() {
                $('#fileupload').fileupload({
                    url: "<?= Url::to(['article/ajax_uploads']) ?>",
                    dataType: 'json',
                    done: function (e, data) {
                        console.log(data);
                        if(data.result.code==1){
                            $('#thumb_display').append('<span style="margin:5px;float: left;"><img src="<?php echo \Yii::$app->request->hostInfo.'/'; ?>'+data.result.thumb+'" height="60" width="60"><input type="hidden" name="thumball[]" value="'+data.result.thumb+'" ><br><input class="del_thumb layui-btn" style="width: 100%" type="button" value="删除" > </span>');
                        }else{
                            layer.alert(data.result.msg, {
                                    icon: 5
                                },
                                function(index) {
                                    layer.close(index);
                                });

                            // alert(data.result.msg);
                        }

                    }
                });

                $('#thumb_display').on('click','.del_thumb',function(){
                    var del_thumb = $(this).siblings('input').val();
                    $(this).parent('span').remove();

                    $('#del_thumb').append('<input type="hidden" name="del_thumb[]" value="'+del_thumb+'">');
                })
            });
        </script>

    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" id="art_form" enctype="multipart/form-data">
                    <div class="layui-form-item">
                        <label class="layui-form-label">文章分类</label>
                        <div class="layui-input-inline">
                            <select name="cate_id" lay-verify="required">
                                <?php foreach($list as $key=>$val){ ?>
                                <option value="<?= $val['id']; ?>"><?= str_repeat('|----',$val['level']); ?><?= $val['cate_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>文章标题</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="art_title" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>文章作者</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="art_editor" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="art_tag" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">文章描述</label>
                        <div class="layui-input-block">
                            <textarea style="width: 90%;" name="art_description" placeholder="请输入内容" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text" id="tuxian" style="display: none;">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <img id="imgshow" src="" alt="" style="width: 90px;"/>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">缩略图</label>
                        <div class="layui-input-block layui-upload">
                            <button type="button" class="layui-btn" id="test1">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                            <input type="file" name="Article[thumb]" id="filed" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text zhanshi">
                        <label class="layui-form-label">多图上传</label>
                        <div class="layui-input-block layui-upload zst">
                            <button type="button" onclick="fileupload.click()" class="layui-btn xz">
                                <i class="layui-icon">&#xe67c;</i>多图上传
                            </button>
                            <div id="thumb_display" >
                            </div>
                            <div style="clear:both;"></div>
                            <input type="file" name="Article[thumbduo]" id="fileupload" multiple="multiple"  style="visibility:hidden; "  >
                            <div id="del_thumb"></div>
                        </div>
                    </div>

                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken();?>">


                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">文章内容</label>
                        <div class="layui-input-block">
                            <!-- 加载编辑器的容器 -->
                            <textarea id="content" style="width: 95%;height: 400px;" name="art_content" placeholder="请输入内容"></textarea>
                            <!-- 配置文件 -->
                            <?=Html::jsFile('@web/ueditor/ueditor.config.js')?>
<!--                            <script type="text/javascript" src="./ueditor/ueditor.config.js "></script>-->
                            <!-- 编辑器源码文件 -->
                            <?=Html::jsFile('@web/ueditor/ueditor.all.js')?>
                            <?=Html::jsFile('@web/ueditor/lang/zh-cn/zh-cn.js')?>
<!--                            <script type="text/javascript" src="./ueditor/ueditor.all.js"></script>-->
<!--                            <script type="text/javascript" src="./ueditor/lang/zh-cn/zh-cn.js"></script>-->
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('content',{
                                    allowDivTransToP: false
                                });

                            </script>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否推荐</label>
                        <div class="layui-input-inline">
                            <input type="radio" name="art_status" value="1" title="是">
                            <input type="radio" name="art_status" value="2" title="否" checked>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
                </form>
            </div>
        </div>
        <script>


            layui.use(['form', 'layer','jquery','upload'],
            function() {

                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;
                var upload=layui.upload;
                $('#test1').on("click", function() {
                    $('#filed').trigger('click');
                    $('#filed').change(function(){
                        //获取input file的files文件数组;
                        //$('#filed')获取的是jQuery对象，.get(0)转为原生对象;
                        //这边默认只能选一个，但是存放形式仍然是数组，所以取第一个元素使用[0];
                        var file = $('#filed').get(0).files[0];
                        //创建用来读取此文件的对象
                        var reader = new FileReader();
                        //使用该对象读取file文件
                        reader.readAsDataURL(file);
                        //读取文件成功后执行的方法函数
                        reader.onload=function(e){
                            //读取成功后返回的一个参数e，整个的一个进度事件
                            console.log(e);
                            //选择所要显示图片的img，要赋值给img的src就是e中target下result里面
                            //的base64编码格式的地址
                            $('#imgshow').get(0).src = e.target.result;
                            $('#tuxian').attr('style','display: block;')
                            // $('#old').attr('style','display:none');
                        }
                    });
                });
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
                form.on('submit(add)',
                function(data) {
                    console.log(data);
                    //发异步，把数据提交给php
                    var obj=this;
                    var formData=new FormData($('#art_form')[0]);
                    $.ajax({
                        url: "<?= Url::to(['article/store']) ?>",
                        type: 'POST',
                        cache: false,
                        data: formData,
                        dataType : 'json',
                        processData: false,    //不需要对数据做任何预处理
                        contentType: false,    //不设置数据格式
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
                                $(obj).off('change');
                            }else{
                                layer.alert(data.message, {
                                        icon: 5
                                    },
                                    function(index) {
                                        layer.close(index);
                                    });
                            }
                        },
                        error:function(XMLHttpRequest,textStatus,errorThrown){
                            var number=XMLHttpRequest.status;
                            var info="错误号"+number+"文件上传失败!";
                            alert(info);
                        },
                        async:true

                    });
                    // $.ajax({
                    //     url:"{:url('Article/store')}",
                    //     type:'post',
                    //     timeout:"3000",
                    //     dataType : 'json',
                    //     cache:"false",
                    //     data:data.field,
                    //     success:function(data){
                    //         console.log(data);
                    //         if(data.status==0){
                    //             layer.alert(data.message, {
                    //                     icon: 6
                    //                 },
                    //                 function() {
                    //                     //关闭当前frame
                    //                     xadmin.close();
                    //
                    //                     // 可以对父窗口进行刷新
                    //                     xadmin.father_reload();
                    //                 });
                    //         }else{
                    //             layer.alert(data.message, {
                    //                     icon: 5
                    //                 },
                    //                 function(index) {
                    //                     layer.close(index);
                    //
                    //
                    //                 });
                    //         }
                    //
                    //
                    //
                    //     },
                    //     error:function(err){
                    //         console.log(err);
                    //     }
                    // });

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

