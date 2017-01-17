<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\core\widgets;


use app\core\helpers\Url;

/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class ActiveForm extends \yii\widgets\ActiveForm
{

    public $fieldClass = 'app\core\widgets\ActiveField';

	public $fieldConfig = [
            'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>',
            'labelOptions' => [
                'class' => 'control-label col-sm-2'
            ],
            'inputOptions' =>['class'=>'form-control']
        ];

    public $options = ['class' => 'form-horizontal'];



    /**
     * 搜索处用的form 开始
     */
    public static function searchBegin($config = null)
    {
    	if(is_null($config)) {
    		$config = [
    			'fieldConfig'=>[
		            'template' => '{label}{input}',
		            'labelOptions' => [
		                'class' => 'control-label'
		            ],
		            'inputOptions' =>['class'=>'form-control input-sm']
		        ],
		        // 'action' => Url::current(),
		        'method' => 'get',
		        'options'=> [
		            'class'=>'form-inline'
		        ]
    		];
    	}
    	return parent::begin($config);
    }


    // public static function remoteBegin($config=null)
    // {
    //     if(is_null($config)) {
    //         $config = [
    //             'fieldConfig'=>[
    //                 'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>',
    //                 'labelOptions' => [
    //                     'class' => 'control-label col-sm-2'
    //                 ],
    //                 'inputOptions' =>['class'=>'form-control'],
    //                 'hintOptions' =>['class'=>'input-note']
    //             ],
    //             // 'action' => ['index'],
    //             'options'=> [
    //                 'class' => 'form-horizontal rform', 'id'=>'rform'
    //             ]
    //         ];
    //     }
    //     return parent::begin($config);
    // }

    public static function memberBegin($config=null)
    {
        if(is_null($config)) {
            $config = [
                'fieldConfig'=>[
                    'template' => '{label}<div class="field">{input}{hint}{error}</div>',
                    'labelOptions' => [
                        'class' => 'label'
                    ],
                    'inputOptions' =>['class'=>'input', 'size'=>30],
                    'hintOptions' =>['class'=>'input-note']
                ],
                // 'action' => ['index'],
                'options'=> [
                    'class' => 'form-x'
                ]
            ];
        }
        return parent::begin($config);
    }







}
