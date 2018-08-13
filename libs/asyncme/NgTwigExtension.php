<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/27
 * Time: 上午1:48
 */

namespace libs\asyncme;

use \Twig_Extension;

class NgTwigExtension extends Twig_Extension
{

    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    private $router;

    /**
     * @var \Slim\Http\Uri
     */
    private $uri;



    public function __construct($router, $uri)
    {
        $this->router = $router;
        $this->uri = $uri;
    }

    public function getName()
    {
        return 'AsyncMe';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('path_for', array($this, 'pathFor')),
            new \Twig_SimpleFunction('base_url', array($this, 'baseUrl')),
            new \Twig_SimpleFunction('async_me', array($this, 'asyncMe')),
            new \Twig_SimpleFunction('URL', array($this, 'parse_url')),
        ];
    }

    public function pathFor($name, $data = [], $queryParams = [], $appName = 'default')
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    public function baseUrl()
    {
        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }

    //简写pathfor
    public function parse_url($name,$url,$queryParams)
    {

        $app_route = $this->router->getNamedRoute('sys');
        $url_lists = explode('/',$url);
        $data = $app_route->getArguments();
        $index = 0;
        foreach($data as $key=>$val) {
            $data[$key] = $url_lists[$index++];
        }
        return $this->router->pathFor($name, $data, $queryParams);
    }

    public function asyncMe($who)
    {
        return $this->getName().' '.$who;
    }
}