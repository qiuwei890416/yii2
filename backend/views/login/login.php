<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.2</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <?php echo $this->render('@app/views/layouts/style.php');?>
    <?php echo $this->render('@app/views/layouts/script.php');?>
</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">x-admin2.0-管理登录</div>
        <div id="darkbannerwrap"></div>
        
<!--        <form method="post" action="--><?//=   Url::to(['login/dologin']) ?><!--" class="layui-form" >-->
            <?= Html::beginForm( '','post',['class'=>'layui-form']) ?>
<!--            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >-->
            <?= Html::activeInput('text',$model,'username',['class'=>'layui-input','placeholder'=>'用户名']) ?>
            <?= Html::error($model,'username',['style'=>'color:red;']) ?>
            <hr class="hr15">
            <?= Html::activeInput('password',$model,'password',['class'=>'layui-input','placeholder'=>'密码']) ?>
            <?= Html::error($model,'password',['style'=>'color:red;']) ?>

            <hr class="hr15">
            <?= yii\captcha\Captcha::widget([
                'model'=>$model,
                'attribute'=> 'verify',
                'captchaAction'=> 'login/captcha',
                'template'=> '{input}{image}',
                'options'=>[
                    'class'=>'layui-input',
                    'style'=>'width: 150px;float: left;',
                    'placeholder'=>'验证码',
                ],
                'imageOptions'=>[
                    'id'=>'verifyImg',
                    'style'=>'margin-left: 20px;',
                    'alt'=>'点击更换验证码',
                    'onclick' => 'this.src=this.src+"&c="+Math.random();'
                ],
            ])

            ?>
        <?= Html::error($model,'verify',['style'=>'color:red;']) ?>
<!--            <input name="verify"  style="width: 150px;float: left" lay-verify="required" placeholder="验证码"  type="text" class="layui-input">-->
<!--            <img id="verifyImg" style="margin-left: 20px;" src="--><?php //echo Url::toRoute('login/captcha'); ?><!--">-->
            <input name="_csrf" type="hidden" value="<?php echo \Yii::$app->request->csrfToken; ?>">
            <hr class="hr15">
        <input type="checkbox" name="Login[rember]" value="1" title="保持登录状态" lay-skin="primary" >

            <hr class="hr15">

<!--            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">-->
        <?= Html::activeInput('submit',$model,'ti',['lay-submit','value'=>'登录','style'=>'width:100%;']) ?>

        <hr class="hr20" >
<!--        </form>-->
        <?= Html::endForm() ?>
    </div>

    <script>
        layui.use('form', function(){
            var form = layui.form;

            //监听提交
            form.on('submit(formDemo)', function(data){
                layer.msg(JSON.stringify(data.field));
                return false;
            });
        });
        $(function  () {
            //处理点击刷新验证码
            //$("#verifyImg").on("click", function () {
            //    $.get("<?//= Url::to(['login/captcha']) ?>//",{'refresh':'1'},function (data) {
            //        $("#verifyImg").attr("src", data.url);
            //    },'json');
            //
            //});

        })
    </script>
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
</body>
</html>