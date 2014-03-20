<?php
return array(
	'language' => 'ru',
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Shortener!',
	'preload' => array(
		'bootstrap'
	),
	'import' => array(
		'application.models.*',
	),
	'defaultController' => 'site/index',
	'components' => array(
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'add' => '/site/add',
				'<link:\w+>' => '/site/redirect',
			),
		),

		'db' => array(
			'enableProfiling' => false,
			'enableParamLogging' => false,
			'connectionString' => 'mysql:host=localhost;dbname=shortener',
			'username' => 'root',
			'password' => 'asdasd',
			'charset' => 'utf8',
		),

		'cache'=>array(
			'class'=>'system.caching.CMemCache',
			//'useMemcached'=>true,
			'servers'=>array(
				array('host'=>'localhost', 'port'=>11211, 'weight'=>100),
			),
		),

		// Включаем Yii Booster
		'bootstrap' => array(
			'class' => 'ext.bootstrap.components.Bootstrap',
			'responsiveCss' => true,
		)
	)
);