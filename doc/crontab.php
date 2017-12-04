#lion sys crontab

*/1 * * * * /alidata/server/php/bin/php /data/htdocs/lion/yii msg/send
30 23 * * * /alidata/server/php/bin/php /data/htdocs/lion/yii canteen/account
01 23 * * * /alidata/server/php/bin/php /data/htdocs/lion/yii canteen/out
