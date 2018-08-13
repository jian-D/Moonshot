<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/10
 * Time: 上午12:56
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use libs\exceptions\InvaildException;


define("APPLICATION_ENV","debug");

define('NG_ME',"9527");

defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?
    getenv('APPLICATION_ENV') :
    'debug'));

if (APPLICATION_ENV === 'debug') {
    error_reporting(E_ERROR | E_WARNING);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ERROR);
}
define('NG_ROOT',dirname(dirname(__FILE__)));


$config = include NG_ROOT.'/config/config.debug.inc.php';

require NG_ROOT.'/vendor/autoload.php';


$settings = ['settings'=>$config];

$c = new \Slim\Container($settings);

$app = new \Slim\App($c);

$container = $app->getContainer();
//版本处理
$request = $container->get('request');
$response = $container->get('response');
$version = $request->getQueryParam('v');
if(!$version) {
    define("APP_VERSION",'v1');
    define("APP_VERSION_PATH",'');
} else {
    $version = strtolower($version);

    if (in_array($version,$config['versions'])) {
        define("APP_VERSION",'v'.$version);
        define("APP_VERSION_PATH",APP_VERSION);
    } else {
        $json_data = ['status'=>false,'data'=>'error','desc'=>'version {'.$version.'} not vaild'];
        $app->respond($response->withJson($json_data)->withHeader('Content-type', 'application/json'));
        die();
    }
}

//载入通用的函数
$functions = glob(NG_ROOT.'/utils/*.inc.php');
if ( $functions ) {
    foreach ( $functions as $func) {
        require $func;
    }
}
//载入通用的类库
$libs = glob(NG_ROOT.'/libs/*/*.class.php');
if ( $libs ) {
    foreach ( $libs as $lib) {
        require $lib;
    }
}
//载入中间件
$middle_wares = glob(NG_ROOT.'/middle/*.mw.php');
if ( $middle_wares ) {
    foreach ( $middle_wares as $middle_ware) {
        require $middle_ware;
    }
}



$routers = glob(NG_ROOT.'/routers/*.router.php');
if ( $routers ) {
    foreach ( $routers as $router) {
        require $router;
    }
}

$app->add(new \Slim\Middleware\Session([
    'name' => 'dummy_session',
    'autorefresh' => true,
    'lifetime' => '1 hour'
]));
$app->run();