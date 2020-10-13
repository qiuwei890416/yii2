<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>童老师ThinkPHP5交流群：484519446</title>
<meta name="description" content="童老师ThinkPHP5交流群：484519446" />
<meta name="keywords" content="童老师ThinkPHP5交流群：484519446" />

    <?php echo $this->render('@app/views/layouts/style.php');?>
    <?php echo $this->render('@app/views/layouts/script.php');?>



</head>
<body id="list_style_2" class="list_style_2">
   <script>
 function subForm()
 {
     if($('#go').val()!=''){
         formsearch.submit();
     }
 //form1为form的id
 }
 </script>
<script type="text/javascript">
    function showMask() {
        $("#mask").css("height", $(document).height());
        $("#mask").css("width", $(document).width());
        $("#mask").show();
    }  
</script>
   <script type="text/javascript">
       function imgerrorfun(){
           var img=event.srcElement;
           img.src="/images/345.jpg";
           img.onerror=null;
       }
   </script>
<div id="mask" class="mask" onclick="CloseMask()"></div>
   <?php echo $this->render('@app/views/layouts/header.php');?>

</div>
    <div id="wrapper">
    <style type="text/css">
        body
        {
            background-image: none;
            background-color: #dedede;
            color: #999999;
            font-family: "Microsoft Yahei" , "Helvetica Neue" ,Arial,Helvetica,sans-serif;
            font-size: 12px;
            height: 100%;
            text-align: left;
            width: 100%;
        }
        #xh_container
        {
            min-height: 1000px;
            background-color: #dedede;
            margin-top: 36px;
            width: 1098px;
        }
        #wrapper
        {
            background-color: #dedede;
        }
        #l-nav
        {
            background-image: url('/blog4./style/simg/look-bike-nav-bg.png');
            width: 188px;
            height: 360px;
            float: left;
        }
        #l-nav a
        {
            font-size: 14px;
            color: #000000;
        }
        #l-nav a:hover
        {
            font-size: 14px;
            color: #999999;
        }
        #l-nav div
        {
            padding-left: 20px;
        }
        #l-nav .l-nav-word
        {
            height: 40px;
            line-height: 40px;
        }
        #l-focus
        {
            float: right;
        }
        img
        {
            vertical-align: middle;
        }
        
        div
        {
            color: #666666;
        }
        #menu-item-196 a.a,#menu-item-198 a.a,#menu-item-197 a.a{color: #00BBEE;}
        #menu-item-198{ background-image:url('./images/up-arrow.png'); background-position: center bottom; background-repeat:no-repeat;} 
        .boxBor{
    position:absolute;left:0;top:0;display:none;z-index:9999; background-color:#ffffff;opacity: 0.3;filter:alpha(opacity=30)
}
        .pagination > li > a, .pagination > li > span {
            margin: 0 6px 0 0;
            padding-bottom: 3px;
            padding-top: 3px;
            text-decoration: none;
            color: #333333;
            font-family: "Microsoft Yahei" , "Helvetica Neue" ,Arial,Helvetica,sans-serif;
            font-size: 12px;
            border: 1px solid #CCCCCC;
            background-color:transparent;
        }
        .pagination > li > a:hover{
            background: black;
            color: white;
        }
        .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
            background: none repeat scroll 0 0 #333333;
            color: #FFFFFF;
            border-color: black;
        }
        .pagination > .disabled > span, .pagination > .disabled > span:hover, .pagination > .disabled > span:focus, .pagination > .disabled > a, .pagination > .disabled > a:hover, .pagination > .disabled > a:focus {
            color: #777777;
            cursor: not-allowed;
            border: 1px solid #CCCCCC;
            background-color:transparent;
        }
    </style>
    <div id="xh_container">

        
<div class="xh_265x265x00">
    <?php foreach ($list as $key=>$val){ ?>
        <div style="float: left; width: 343px; height: 293px; background-color: #ffffff;border: solid 1px #ccc; margin-left: 15px;margin-top: 15px;">
                <div style="background-color: #cccccc; width: 313px; height: 188px; margin-top: 16px;
                    margin-left: 14px;">
                    <a target="_blank" href="<?= Url::to(['site/article','id' => $val['id']]) ?>"><img src="<?php echo constant('YII_URL'); ?><?= $val['art_thumb']; ?>" onerror="imgerrorfun()"  alt="<?= $val['art_title']; ?>" height="188" width="313"></a>
                </div>
                <div style="margin-left: 14px; line-height: 25px; margin-top: 10px;">
                    <div style="font-size: 12px;color:#cccccc;"><?= date('Y年m月s日',$val['art_time']);?></div>
                    <div style="font-size: 14px;height:45px;">
                       <a target="_blank" href="<?= Url::to(['site/article','id' => $val['id']]) ?>"><?= $val['art_title'] ?></a></div>
                    
                </div>
            </div>
    <?php }?>
    <div style="clear: both;">
    </div>
                <div id="pagination">
                    <div class="wp-pagenavi">
                        <?= LinkPager::widget([
                            'pagination' => $pages,
                            'nextPageLabel' => '下一页',
                            'prevPageLabel' => '上一页',
//                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '尾页',
//                            'options'=>[
//                                    'class'=>''
//                            ]
                        ]); ?>
                    </div>
                </div>
<!--    <div id="pagination">-->
<!--        <div class="wp-pagenavi">-->
<!--            <span class="current">1</span>-->
<!--            <a class="page larger" href='list_2.html'>2</a>-->
<!--            <a class="page larger" href='list_3.html'>3</a>-->
<!--            <a class="page larger" href='list_2.html'>下一页</a>-->
<!--            <a class="page larger" href='list_3.html'>末页</a>-->
<!--            <span class="pages">共 3 页，36条</span>-->
<!--        </div>-->
<!--    </div>-->
</div>

        


    </div>
    <script type="text/javascript">
        $("#menu-item-198").find("a").addClass("a");
        $(".i-prev").hover(function () { $(this).addClass("i-prev-o"); }, function () { $(this).removeClass("i-prev-o"); });
        $(".i-next").hover(function () { $(this).addClass("i-next-o"); }, function () { $(this).removeClass("i-next-o"); });
        $(".more0").hover(function () { $(this).attr("src", "./style/simg/more-o.png"); }, function () { $(this).attr("src", "./style/simg/more.png"); });
    </script>
    <div class="boxBor"></div>
    
    <input type="hidden" id="hdBoxbor" />
    <div class="boxBor" onclick="IBoxBor()" style="cursor:pointer;"></div>


    </div>
<script type="text/javascript">
        $(function () {
            var imgHoverSetTimeOut = null;
            $('.xh_265x265x00 img').hover(function () {
                var oPosition = $(this).offset();
                var oThis = $(this);
                $(".boxBor").css({
                    left: oPosition.left,
                    top: oPosition.top,
                    width: oThis.width(),
                    height: oThis.height()
                });
                $(".boxBor").show();
                var urlText = $(this).parent().attr("href");
                $("#hdBoxbor").val(urlText);
            }, function () {
                imgHoverSetTimeOut = setTimeout(function () { $(".boxBor").hide(); }, 500);
            });
            $(".boxBor").hover(
                function () {
                    clearTimeout(imgHoverSetTimeOut);
                }
                , function () {
                    $(".boxBor").hide();
                }
            );
        });
        function IBoxBor() {
            window.open($("#hdBoxbor").val());
        }
        function goanewurl() {
            window.open($("#hdUrlFocus").val());
        }
</script>

   <?php echo $this->render('@app/views/layouts/footer.php');?>
<div style="display: none;" id="scroll">
</div>


</body>
</html>
