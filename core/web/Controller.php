<?php

namespace app\core\web;

/**
 * Default controller for the `wechat` module
 */
class Controller extends \yii\web\Controller
{
	public function json($data = null, $info = '', $success = true) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return [
			'status' => $success,
			'info' => $info,
			'data' => $data,
		];
	}
}
