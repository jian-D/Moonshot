<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/10
 * Time: 上午1:19
 */
if(!defined('NG_ME')) die();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response, array $args) {
    //$this->logger->info("Slim-Skeleton '/' index");
    $tag = $request->getQueryParam('tag');
    $tag = $tag ? $tag : 0;
    $json_data = ['status'=>true,'data'=>'welcome','desc'=>'welcome to crv','tag'=>$tag];
    return $response->withJson($json_data);
});

$app->get('/error', function (Request $request, Response $response, array $args) {
    //$this->logger->info("Slim-Skeleton '/' index");
    $tag = $request->getQueryParam('tag');
    $tag = $tag ? $tag : 0;
    $json_data = ['status'=>false,'data'=>'error','desc'=>'error happen','tag'=>$tag];
    return $response->withJson($json_data);
});