<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<?php echo $this->render('@app/views/layouts/style.php');?>
<?php echo $this->render('@app/views/layouts/script.php');?>
<script language="javascript" type="text/javascript">
<!--

function postBadGood(ftype,fid)
{
    var taget_obj = document.getElementById(ftype+fid);
    var saveid = GetCookie('badgoodid');
    if(saveid != null)
    {
        var saveids = saveid.split(',');
        var hasid = false;
        saveid = '';
        j = 1;
        for(i=saveids.length-1;i>=0;i--)
        {
            if(saveids[i]==fid && hasid) continue;
            else {
                if(saveids[i]==fid && !hasid) hasid = true;
                saveid += (saveid=='' ? saveids[i] : ','+saveids[i]);
                j++;
                if(j==10 && hasid) break;
                if(j==9 && !hasid) break;
            }
        }
        if(hasid) { alert('您刚才已表决过了喔！'); return false;}
        else saveid += ','+fid;
        SetCookie('badgoodid',saveid,1);
    }
    else
    {
        SetCookie('badgoodid',fid,1);
    }
    myajax = new DedeAjax(taget_obj,false,false,'','','');
    myajax.SendGet2("/plus/feedback.php?aid="+fid+"&action="+ftype+"&fid="+fid);
}
function postDigg(ftype,aid)
{
    var taget_obj = document.getElementById('newdigg');
    var saveid = GetCookie('diggid');
    if(saveid != null)
    {
        var saveids = saveid.split(',');
        var hasid = false;
        saveid = '';
        j = 1;
        for(i=saveids.length-1;i>=0;i--)
        {
            if(saveids[i]==aid && hasid) continue;
            else {
                if(saveids[i]==aid && !hasid) hasid = true;
                saveid += (saveid=='' ? saveids[i] : ','+saveids[i]);
                j++;
                if(j==20 && hasid) break;
                if(j==19 && !hasid) break;
            }
        }
        if(hasid) { alert("您已经顶过该帖，请不要重复顶帖 ！"); return; }
        else saveid += ','+aid;
        SetCookie('diggid',saveid,1);
    }
    else
    {
        SetCookie('diggid',aid,1);
    }
    myajax = new DedeAjax(taget_obj,false,false,'','','');
    var url = "/plus/digg_ajax.php?action="+ftype+"&id="+aid;
    myajax.SendGet2(url);
}
function getDigg(aid)
{
    var taget_obj = document.getElementById('newdigg');
    myajax = new DedeAjax(taget_obj,false,false,'','','');
    myajax.SendGet2("/plus/digg_ajax.php?id="+aid);
    DedeXHTTP = null;
}
-->
</script>
<script type="text/javascript">

function ILike(th, v) {
    if (v) {
        $(th).addClass("single_views_over");
    }
    else {
        $(th).removeClass("single_views_over");
    }
}

</script>
 
</head>
<body class="single2">
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
       function imgerrorfun(){
           var img=event.srcElement;
           img.src="/images/345.jpg";
           img.onerror=null;
       }
   </script>
<script type="text/javascript">
    function showMask() {
        $("#mask").css("height", $(document).height());
        $("#mask").css("width", $(document).width());
        $("#mask").show();
    }  
</script>
<div id="mask" class="mask" onclick="CloseMask()"></div>
   <?php echo $this->render('@app/views/layouts/header.php');?>


   </div>
    <div id="wrapper">

    <div id="wrapper">
        <div id="container">
            <div id="content">
                <div class="post" id="post-19563" style="border-right: solid 1px #000000; min-height: 1700px;
                    margin-top: 10px;">
                    <div class="path">
                        <a href='#'>主页</a> >
                        <?php foreach ($this->params['weizhi'] as $key=>$val){ ?>
                            <a href="<?= Url::to(['site/artlist','cateid' => $val['id']]) ?>"><?= $val['cate_name']; ?></a> >
                        <?php } ?>
                    </div>
                    <div class="single_entry single2_entry">
                        <div class="entry fewcomment">
                            <div class="title_container">
                                <h2 class="title single_title">
                                    <span><?= $data['art_title']  ?></span><span class="title_date"></span></h2>
                                <p class="single_info">时间：<?= date('Y-m-s H:i:s',$data['art_time'])  ?>&nbsp;&nbsp;&nbsp;编辑：<?= $data['art_editor']  ?></p>
                            </div>
                            <div class="div-content">
                                <p><?= $data['art_content']  ?></p>

                                <p class="pagepage"></p>
                                
                                <center id="pagenav">
                                    </center>
                                <div id="BottomNavOver" style="height: 80px;">
                                    <div style="float: left; font-size: 12px;">
                                        
                                    </div>
                                    <div style="float: right; padding-right: 20px; width: 120px;" class="div">
                                        <table cellpadding="0" cellspacing="0" border="0" style="background-color: transparent;
                                            border: 0px solid #EEEEEE; border-collapse: collapse; margin: 5px 0 10px;">
                                            <tr>
                                                <td style="border-width: 0px; padding: 0px; padding-right: 4px;">

                                                </td>
                                                <td style="border-width: 0px; padding: 0px;">
                                                    <!-- JiaThis Button BEGIN -->
                                                    <div class="jiathis_style">
                                                        <a class="jiathis_button_qzone"></a><a class="jiathis_button_tqq"></a><a class="jiathis_button_renren">
                                                        </a><a class="jiathis_button_kaixin001"></a><a href="http://www.jiathis.com/share"
                                                            class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                                                    </div>
                                                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1365565447348652"
                                                        charset="utf-8"></script>
                                                    <!-- JiaThis Button END -->
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style="float: right; width: 60px; font-size: 12px;">
                                        分享至：</div>
                                    <div style="clear: both;">
                                    </div>
                                </div>
                            </div>
                            <div class="clear">
                            </div>
                            <div id="ctl00_ctl00_ContentPlaceHolder1_contentPlace_divRead">
                                <div style="text-align: left; width: 100%; border-bottom: solid 1px #e0e0e0; padding-bottom: 4px;
                                    color: Black; vertical-align: middle; font-weight: bold;">
                                    &nbsp;&nbsp;猜您喜欢的文章
                                </div>
                                <ul class="read" style="list-style-type: none; margin-top: 10px; width: 780px;">
<li style="margin-left: -10px; margin-right: 16px; margin-top: 20px; height: 180px;"> <a href="/life/379.html" target="_blank"><img src="/images/342.jpg" style="width: 250px; height: 150px; margin-bottom: 0px;" />
<span style="margin: 0px; padding: 0px; margin-top: -5px;">众里寻她千百度，蓦然回首，那景却在，延京深</span></a></li>
<li style="margin-left: -10px; margin-right: 16px; margin-top: 20px; height: 180px;"> <a href="/life/377.html" target="_blank"><img src="/images/336.jpg" style="width: 250px; height: 150px; margin-bottom: 0px;" />
<span style="margin: 0px; padding: 0px; margin-top: -5px;">周末4+2出行 到北京怀柔喇叭沟门赏红叶</span></a></li>
<li style="margin-left: -10px; margin-right: 16px; margin-top: 20px; height: 180px;"> <a href="/life/363.html" target="_blank"><img src="/images/323.jpg" style="width: 250px; height: 150px; margin-bottom: 0px;" />
<span style="margin: 0px; padding: 0px; margin-top: -5px;">周末随拍：北京单车生活</span></a></li>
             
                                </ul>
                            </div>
                            <div class="clear">
                            </div>
                            <div class="comments_wrap" style="margin-top: 35px;">
                                <a name="comment"></a>
          <!-- Duoshuo Comment BEGIN -->
          <div class="ds-thread" data-thread-key="" 
    data-title="" data-author-key="" data-url=""></div>
          <script type="text/javascript">
    var duoshuoQuery = {short_name:"dede58"};
    (function() {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';ds.async = true;
        ds.src = 'http://static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0] 
        || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
    </script> 
          <!-- Duoshuo Comment END --> 
                            </div>
                            <div class="clear">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sidebar">
                <div class="widget single" style="margin-bottom: 0px; margin-left: 0px; margin-top: 40px;
                    padding-bottom: 0px;" id="newdigg">
                    <div class="single_views" onmouseout="ILike(this,false)" onmouseover="ILike(this,true)">
                        <span class="textcontainer"><span class="votecount26536">0</span></span> <span class="bartext voteid26536"><a href="#"
                                id="aZanImg" onclick="javascript:postDigg('good',382)"></a></span><span class="text" id="spanZan">赞</span>
                        <span class="text love">人</span>
                    </div>


                </div>
  <script language="javascript" type="text/javascript">getDigg(382);</script>
<!-- 右侧 -->

         <div class="widget">

<div style="background: url('/images/hots_bg.png') no-repeat scroll 0 0 transparent;width:250px;height:52px;margin-bottom:15px;">
</div>
<ul id="ulHot">
    <?php foreach ($hotlist as $key=>$val){ ?>

        <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
        <div style="float:left;width:85px;height:55px; overflow:hidden;"><a href="<?= Url::to(['site/article','id' => $val['id']]) ?>" target="_blank"><img src="<?php echo constant('YII_URL'); ?><?= $val['art_thumb']; ?>" onerror="imgerrorfun()" width="83" title="<?= $val['art_title'] ?>" /></a></div>
        <div style="float:right;width:145px;height:52px; overflow:hidden;"><a href="<?= Url::to(['site/article','id' => $val['id']]) ?>" target="_blank" title="<?= $val['art_title'] ?>"><?= $val['art_title'] ?></a></div>
        </li>
    <?php } ?>
</ul>
                </div>
            
            <div class="widget portrait">
    <div>
        <div class="textwidget">
            <a href="/tougao.html"><img src="/images/tg.jpg"  alt="鎶曠ǹ"></a><br><br>
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
    </div>



    </div>


   <?php echo $this->render('@app/views/layouts/footer.php');?>
<div style="display: none;" id="scroll">
</div>


 
</body>
</html>
