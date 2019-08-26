<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/footable.standalone.css',
        // 'css/jquery.jexcel.css',
        'css/jquery.jcalendar.css',
        'calendar/pg-calendar-master/dist/css/pignose.calendar.min.css',
        'calendar/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css',
        'css/tablecellsselection.css',
        'css/site.css',
    ];
    public $js = [
        'calendar/pg-calendar-master/dist/js/pignose.calendar.full.min.js',
        // 'calendar/bootstrap-datetimepicker-0.0.11/js/bootstrap-datetimepicker.min.js',
        // 'js/jquery.jexcel.js',
        // 'js/jquery.jcalendar.js',
        'js/footable.js',
        // 'js/tablecellsselection.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $publishOptions = [
      'forceCopy'=>true,
    ];
}
