<?php 
return [  
   'class' => 'yii\swiftmailer\Mailer',  
    'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
    'htmlLayout' => '@app/core/views/mail/layout.php',
    'viewPath' => '@app/core/views/mail', 
    'transport' => [  
       'class' => 'Swift_SmtpTransport',  
       'host' => 'smtp.163.com',  //每种邮箱的host配置不一样
       'username' => 'cboy868@163.com',  
       'password' => '77d^5l6',
       'port' => '25',  
       'encryption' => 'tls', 
    ],   
    'messageConfig'=>[  
       'charset'=>'UTF-8',  
       'from'=>['cboy868@163.com'=>'公司名']  
    ],  
];