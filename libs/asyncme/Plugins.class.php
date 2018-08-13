<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/10
 * Time: 上午2:31
 */

namespace libs\asyncme;

/**
 * Class Plugins
 * @package libs\asyncme
 * 插件的基类，虚类
 */
abstract class Plugins
{
    //组件的根地址
    public $plugin_root;

    //个性化的需求参数
    public $custom;

    //运行的参数数组，内部传递
    public $args;

    //服务对象
    public $service;

    //模版对象
    public $view;

    //插件的命名空间
    public $namespace;

    //管理对象
    private $admin;


    //构造函数
    public function __construct($root,$custom='',$admin=null)
    {
        $this->plugin_root = $root;
        $this->custom = $custom;
        $this->args = [];
        $this->admin = $admin;

        $this->callInit(0);
    }

    private function callInit($lelve)
    {
        if(method_exists($this,'initialize')) {
            $this->initialize($lelve);
        }
    }

    //设置服务对象
    public function setService($service)
    {
        $this->service = $service;
        $this->callInit(1);
    }

    //设置模版对象
    public function setView($view)
    {
        $this->view = $view;
        $this->callInit(2);
    }

    //命名空间+表名+大Bid
    public function tableName($table)
    {
        $tableName = '';
        if($this->namespace) {
            $tableName = $this->namespace.'_'.$table;
        }
        if($this->service) {
            $tableName = $this->service->getBussineTableName($tableName);
        }
        return $tableName;
    }


    /**
     * @param requestHelper
     * @param $beforeData
     * @return responeHelper
     */
    function real_run($asyRequest,$beforeData)
    {
        $func = $asyRequest->action;
        $func = $func.'Action';
        if (method_exists($this,$func)) {
            $data = $this->$func($asyRequest,$beforeData);
        }
        return $data;
    }


    //运行主入口
    function run($asyRequest)
    {
        $beforeData = [];
        if(method_exists($this,'before')) {
            $beforeData = $this->before($asyRequest);
        }

        $data = $this->real_run($asyRequest,$beforeData);
        if (method_exists($this,'after')) {
            $data = $this->after($asyRequest,$data);
        }

        return $data;
    }

    //安装的虚函数
    public function install()
    {
        if($this->admin->vaild) {
            //检查是不是管理员
            if($this->service) {

            }
        }

    }
    //卸载
    public function uninstall()
    {
        if($this->admin->vaild) {
            //检查是不是管理员
            if($this->service) {

            }
        }
    }
    //更新
    public function upgrade()
    {
        if($this->admin->vaild) {
            //检查是不是管理员
            if($this->service) {

            }
        }
    }
    //备份
    public function backup()
    {
        if($this->admin->vaild) {
            //检查是不是管理员
            if($this->service) {

            }
        }
    }
}