<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'CSP',
    // preloading 'log' component
    'preload' => array('log'),
    'aliases' => array(
        'xupload' => 'ext.xupload'
    ),
    // autoloading model and component classes
    'import' => array(
        'application.extensions.EAjaxUpload.*',
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'ext.easyimage.EasyImage',
    ),
    'modules' => array(
// uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1', '*'),
        ),
        'user' => array(
# encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => true,
            # allow access for non-activated users
            'loginNotActiv' => true,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => true,
            # automatically login from registration
            'autoLogin' => true,
            # registration path
            'registrationUrl' => array('/user/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            'loginUrl' => array('/user/login'),
            # page after login
            'returnUrl' => array('/user/profile'),
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
            'profileUrl' => array('/user/profile'),
        ),
        'wdcalendar' => array(
//'admin' => 'install',
            'embed' => true,
            'wd_options' => array(
                'view' => 'week',
                'readonly' => 'JS:false' // execute JS
            )
        ),
    ),
    // application components
    'components' => array(
        'clientScript' => array(
// disable default yii scripts
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false
            )),
        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'settings' => array(
            'class' => 'CmsSettings',
            'cacheComponentId' => 'cache',
            'cacheId' => 'global_website_settings',
            'cacheTime' => 84000,
            'tableName' => 'settings',
            'dbComponentId' => 'db',
            'createTable' => true,
            'dbEngine' => 'InnoDB',
        ),
        'urlManager' => array(
            'showScriptName' => false,
            'rules' => array(),
        ),
        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
        //'driver' => 'GD',
//'quality' => 100,
//'cachePath' => '/assets/easyimage/',
//'cacheTime' => 2592000,
//'retinaSupport' => false,
        ),
// uncomment the following to enable URLs in path-format
        /*
          'urlManager'=>array(
          'urlFormat'=>'path',
          'rules'=>array(
          '<controller:\w+>/<id:\d+>'=>'<controller>/view',
          '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
          '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
          ),
          ),
         */
        /*
          'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ),
         */
// uncomment the following to use a MySQL database
        'user' => array(
// 'class' => 'WebUser',
// 'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=olap2222',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
// using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => 'webmaster@example.com',
        'access' => 'true',
        'masterBranchCode' => '2'
    ),
);
