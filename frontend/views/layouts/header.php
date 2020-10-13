<?php
use yii\helpers\Url;
?>
<div id="header_wrap">
    <div id="header">
        <div style="float: left; width: 310px;">
            <h1>
                <a href="/" title="宽屏大气文章类--41天鹰模板">宽屏大气文章类--41天鹰模板</a>
                <div class="" id="logo-sub-class">
                </div>
            </h1>
        </div>
        <div id="navi">
            <ul id="jsddm">
                <li><a class="navi_home" href="/home">首页</a></li>
                <?php foreach ($this->params['daohang'] as $key=>$val){?>
                <?php if(count($val['arr'])!=0){ ?>
                <li>
                    <?php if($val['cate_type']==1){ ?>
                    <a href="<?= Url::to(['site/artlist','cateid' => $val['id']]) ?>"><?= $val['cate_title']; ?></a>
                    <?php }else if($val['cate_type']==2){ ?>
                    <a href="<?= Url::to(['site/danye','cateid' => $val['id']]) ?>"><?= $val['cate_title']; ?></a>
                    <?php }else { ?>
                    <a href="<?= Url::to(['site/imglist','cateid' => $val['id']]) ?>"><?= $val['cate_title']; ?></a>
                    <?php }?>
                    <ul>
                        <?php foreach ($val['arr'] as $k=>$v){ ?>
                        <li>
                            <?php if($val['cate_type']==1){ ?>
                            <a href="<?= Url::to(['site/artlist','cateid' => $v['id']]) ?>"><?= $v['cate_title']; ?></a>
                            <?php }else if($val['cate_type']==2){ ?>
                            <a href="<?= Url::to(['site/danye','cateid' => $v['id']]) ?>"><?= $v['cate_title']; ?></a>
                            <?php }else { ?>
                            <a href="<?= Url::to(['site/imglist','cateid' => $v['id']]) ?>"><?= $v['cate_title']; ?></a>
                            <?php }?>
                        </li>
                        <?php }?>
                    </ul>
                </li>
                <?php }else { ?>
                <li>
                    <?php if($val['cate_type']==1){ ?>
                    <a href="<?= Url::to(['site/artlist','cateid' => $val['id']]) ?>"><?= $val['cate_title']; ?></a>
                    <?php }else if($val['cate_type']==2){ ?>
                    <a href="<?= Url::to(['site/danye','cateid' => $val['id']]) ?>"><?= $val['cate_title']; ?></a>
                    <?php }else { ?>
                    <a href="<?= Url::to(['site/imglist','cateid' => $val['id']]) ?>"><?= $val['cate_title']; ?></a>
                    <?php }?>
                </li>
                <?php }?>
                <?php }?>
            </ul>
            <div style="clear: both;"></div>
        </div>
        <div style="float: right; width: 209px;">
            <div class="widget" style="height: 30px; padding-top: 20px;">
                <div style="float: left;">
                    <form  name="formsearch" action="<?= Url::to(['site/sousuo']) ?>">
                        <input type="hidden"  value="0" />
                        <input type="text" name="art_title" style="background-color: #000000;padding-left: 10px; font-size: 12px;font-family: 'Microsoft Yahei'; color: #999999;height: 29px; width: 160px; border: solid 1px #666666; line-height: 28px;" id="go" value="<?= Yii::$app->request->get('art_title'); ?>" />
                    </form>
                </div>
                <div style="float: left;">
                    <img src="/images/search-new.png" id="imgSearch" style="cursor: pointer; margin: 0px;
                        padding: 0px;"  onclick="subForm()"  />
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</div>