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
use \Slim\Http\UploadedFile;
use libs\exceptions\InvaildException;

use libs\asyncme\RequestHelper;
use libs\asyncme\Service;
use libs\asyncme\ResponeHelper;

$app->any('/plugin/{bid:[\w]+}/{pl_name:[\w]+}', function (Request $request, Response $response, array $args) {

    $asyRequest = new RequestHelper($request);


    $plugin_name = strtolower($asyRequest->request_plugin);
    $plugin_name_lists = explode("_",$plugin_name);
    $plugin_class_data = [];
    foreach ($plugin_name_lists as $plugin_name_item) {
        $plugin_class_data[] = ucfirst($plugin_name_item);
    }
    $plugin_class = implode('',$plugin_class_data);

    $response_output = 'json';
    $response_data = '';
    try {

        if (!file_exists(NG_ROOT.'/plugins/'.$plugin_name.'/'.$plugin_class.'.php')) {
            throw new InvaildException($plugin_class.' not invaild');
        }

        $pl_service = new Service($asyRequest->company_id,$asyRequest->service_id,$asyRequest);
        $pl_service->setSession($this->session);
        $pl_service->setCache($this->filecache);
        $pl_service->setRedis($this->redis);
        $pl_service->setDb($this->db);



        $pl_class = 'plugins\\'.$plugin_name.'\\'.$plugin_class;

        $pl = new $pl_class(NG_ROOT.'/plugins/'.$plugin_name.'/');
        $pl->setService($pl_service);
        $pl_respone = $pl->run($asyRequest);
        if ($pl_respone) {
            $response_output = $pl_respone->getType();
            $response_data = $pl_respone->getData();
            $response_template = $pl_respone->getTemplate();
            $json_data = $asyRequest->build_json_data($pl_respone->getStatus(),$pl_respone->getMessage(),$pl_respone->getData());
        } else {
            $json_data = $asyRequest->build_json_data(false,'nothing');
        }


    } catch (InvaildException $e){
        $json_data = $asyRequest->build_json_data(false,$e->getMessage());
    }

    switch ($response_output) {
        case 'json' :
            return $response->withJson($json_data);
        case 'html' :
            return $response->getBody()->write($response_data);
        case 'redirect' :
            return $response->withRedirect($response_data,301);
        case 'captcha' :
            return $response->withHeader('Content-Type','image/jpeg')->write($response_data->output());
        case 'template' :
            return $this->admin_view->render($response,$response_template,$response_data);
        default :
            return $response->withJson($json_data);
    }


});