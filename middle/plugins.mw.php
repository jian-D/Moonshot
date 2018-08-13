<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/8/4
 * Time: 上午1:35
 */
if(!defined('NG_ME')) die();

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;



//视图中间件
$container['plugin_view'] = function ($container) {
    $view = new \Slim\Views\Twig('../plugins', [
        //'cache' => 'data/cache/template'
    ]);
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new \libs\asyncme\NgTwigExtension($container->get('router'), $basePath));

    return $view;
};