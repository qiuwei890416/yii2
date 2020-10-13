<?php
use yii\widgets\Breadcrumbs;

?>

<?=
    Breadcrumbs::widget([
        'homeLink'=>['label' => '首页'], // 若设置false 则 可以隐藏Home按钮
        'links'   =>[
            ['label' => '用户信息', 'url' => ['dddd/index']
        ],
        '阿萨德'

        ],
    ]);

?>
