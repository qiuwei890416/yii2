<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $this->params['set']['web_title']; ?></title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
    <?php echo $this->render('@app/views/layouts/style.php');?>
    <?php echo $this->render('@app/views/layouts/script.php');?>
<!--    --><?//=Html::cssFile('@web/assets/f3dbbe20/css/bootstrap.css')?>
    <style >
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


    <div id="xh_container">
        <div id="xh_content">

        <div class="path">
            <a href='#'>主页</a> >
            <?php foreach ($this->params['weizhi'] as $key=>$val){ ?>
            <a href="<?= Url::to(['site/artlist','cateid' => $val['id']]) ?>"><?= $val['cate_name']; ?></a> >
            <?php } ?>
        </div>
            <div class="clear"></div>
            <div class="xh_area_h_3" style="margin-top: 40px;">
                <?php foreach ($list as $key=>$val){ ?>
                <div class="xh_post_h_3 ofh">
                    <div class="xh">
                        <a target="_blank" href="<?= Url::to(['site/article','id' => $val['id']]) ?>" title="<?= $val['art_title'] ?>">

                            <img src="<?php echo constant('YII_URL'); ?><?= $val['art_thumb']; ?>" onerror="imgerrorfun()" alt="<?= $val['art_title'] ?>" height="240" width="400">

                        </a>
                    </div>
                    <div class="r ofh">
                        <h2 class="xh_post_h_3_title ofh" style="height:60px;">
                            <a target="_blank" href="<?= Url::to(['site/article','id' => $val['id']]) ?>" title="<?= $val['art_title'] ?>"><?= $val['art_title'] ?></a>
                        </h2>
                        <span class="time"> <?=  date('Y-m-s',$val['art_time']);?></span>
                        <div class="xh_post_h_3_entry ofh" style="color:#555;height:80px; overflow:hidden;">

                        </div>
                        <div class="b">
                            <a href="<?= Url::to(['site/article','id' => $val['id']]) ?>" class="xh_readmore" rel="nofollow">read more</a> <span title="<?= $val['art_love'] ?>人赞" class="xh_love"><span class="textcontainer"><span><?= $val['art_love'] ?></span></span> </span> <span title="88人浏览" class="xh_views"><?= $val['art_view'] ?></span>
                        </div>
                    </div>
                </div>
               <?php } ?>
                        
                    
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
            </div>
        </div>
        <div id="xh_sidebar">        
<!-- 右侧 -->

         <div class="widget">

<div style="background: url('/images/hots_bg.png') no-repeat scroll 0 0 transparent;width:250px;height:52px;margin-bottom:15px;">
</div>
<ul id="ulHot">

    <?php foreach ($hotlist as $key=>$val){ ?>
    <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
        <div style="float:left;width:85px;height:55px; overflow:hidden;">
            <a href="<?= Url::to(['site/article','id' => $val['id']]) ?>" target="_blank">
                <img src="<?php echo constant('YII_URL'); ?><?= $val['art_thumb']; ?>" onerror="imgerrorfun()" width="83" title="<?= $val['art_title'] ?>" />
            </a>
        </div>
        <div style="float:right;width:145px;height:52px; overflow:hidden;"><a href="<?= Url::to(['site/article','id' => $val['id']]) ?>" target="_blank" title="<?= $val['art_title'] ?>"><?= $val['art_title'] ?></a></div>
    </li>
    <?php } ?>
</ul>
                </div>
            
            <div class="widget portrait">
    <div>
        <div class="textwidget">
            <a href="/tougao.html"><img src="/images/tg.jpg" alt="鎶曠ǹ"></a><br><br>
<script type="text/javascript">BAIDU_CLB_fillSlot("870073");</script>
<script type="text/javascript">BAIDU_CLB_fillSlot("870080");</script>
<script type="text/javascript">BAIDU_CLB_fillSlot("870081");</script>
        </div>
    </div>
</div>

        </div>
        <div class="clear">
        </div>
    </div>
    <div class="boxBor"></div>

    <div class="boxBor" onclick="IBoxBor()" style="cursor:pointer;"></div>
    <script type="text/javascript">
        $(function () {
            var imgHoverSetTimeOut = null;
            $('.xh_265x265 img').hover(function () {
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

    </div>

 <?php echo $this->render('@app/views/layouts/footer.php');?>
<div style="display: none;" id="scroll">
</div>


</body>
</html>
