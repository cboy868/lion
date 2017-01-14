<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use app\core\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = '邮件发送成功';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="line bouncein" style="padding-top:100px;">
        <div class="xs6 xm4 xs3-move xm4-move">
            <div class="site-login">
                    <div class="text-center">
                    <h1>已发送修改密码连接至您的邮箱，请两天内前去修改</h1>

                    <p>
                        <a href="<?=Url::toRoute(['/'])?>">返回首页</a>
                    </p>
                    </div>


            </div>
        </div>
    </div>
</div>
