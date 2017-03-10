<?php

namespace app\modules\test\controllers\home;

use app\core\helpers\Html;
class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
    	// p($this->view->theme);die;
        return $this->render('index');
    }

    public function actionTest()
    {
    	$a = <<<ABC
<p style="border: 0px; margin-top: 0px; margin-bottom: 0px; padding: 26px 0px 0px; font-size: 14px; font-family: 宋体, simsun, sans-serif, Arial; line-height: 26px; white-space: normal; background-color: rgb(255, 255, 255);">
    　　#央视快讯#【下台！宪法法院通过对朴槿惠的弹劾案】今天上午，韩国宪法法院通过了对总统朴槿惠的弹劾案。朴槿惠将立即被免去总统职务，成为韩国历史上首位被弹劾下台的总统。接下来按计划，韩国将在60天内举行下届大选。
</p>
<p style="border: 0px; margin-top: 0px; margin-bottom: 0px; padding: 26px 0px 0px; font-size: 14px; font-family: 宋体, simsun, sans-serif, Arial; line-height: 26px; white-space: normal; background-color: rgb(255, 255, 255);">
    　　另据澎湃：在面向韩国全国的电视直播中，宪法法院代理院长李贞美宣读判决书。李贞美表示，针对朴槿惠的弹劾案分&quot;违反宪法规定&quot;和&quot;违反法律规定&quot;两部分提出了弹劾理由。在违反宪法规定方面，包括朴槿惠使崔顺实等亲信们介入政策、逼迫企业捐款，&quot;世越号事故&quot;发生后应对不力等违反宪法的相关规定。
</p>
<p style="border: 0px; margin-top: 0px; margin-bottom: 0px; padding: 26px 0px 0px; font-size: 14px; font-family: 宋体, simsun, sans-serif, Arial; line-height: 26px; white-space: normal; background-color: rgb(255, 255, 255);">
    　　在违反法律规定方面，弹劾案将三星、乐天、SK等企业集团为两大涉腐基金会捐款视为贿赂行为，认定朴槿惠有受贿之嫌。
</p>
<p style="border: 0px; margin-top: 0px; margin-bottom: 0px; padding: 26px 0px 0px; font-size: 14px; font-family: 宋体, simsun, sans-serif, Arial; line-height: 26px; white-space: normal; background-color: rgb(255, 255, 255);">
    　　弹劾通过后，朴槿惠将即刻被免去总统职务，成为韩国历史上首位被弹劾的总统。下届总统选举将在60天内（5月9日之前）举行。
</p>
<p>
    <br/>
</p>
ABC;

	$a = Html::cutstr_html($a, 10);

		p($a);
    }
}
