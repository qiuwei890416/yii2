<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
    <body>
          <div class="layui-container">
           <div class="fly-panel"> 
            <div class="fly-none"> 
             <h2><i class="layui-icon layui-icon-404"></i></h2> 
             <p ><span style="color: red">没有权限</span></p>
            </div>
           </div>
          </div>
    <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
        </script>
    </body>
