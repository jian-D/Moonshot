<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/10
 * Time: 上午11:37
 */

namespace libs\asyncme;


class Service
{
    //业务id
    public $service_id;
    //大B id
    public $bussine_id;
    //数据库对象
    private $db = null;
    //缓存对象
    private $cache = null;
    //日志对象
    private $logger = null;
    //redis对象
    private $session = null;
    //redis对象
    private $redis = null;
    //资源目录
    private $asset_path;
    //request对象
    private $request_helper = null;
    //实例对象
    private static $instance;

    //单例方法
    static public function getInstance($bussine_id,$service_id,$request_helper=null)
    {
        //以后扩展支持多个db的识别，现在不操作
        if (!self::$instance instanceof self) {
            self::$instance = new self($bussine_id,$service_id,$request_helper);
        }
        return self::$instance;
    }

    public function __construct($bussine_id,$service_id,$request_helper)
    {
        $this->service_id = $service_id;
        $this->bussine_id = $bussine_id;
        $this->asset_path = './data/'.$this->bussine_id;
        $this->request_helper = $request_helper;
    }
    //返回请求对象
    public function getRequestHelper()
    {
        return $this->request_helper;
    }

    //设置db对象
    public function setDb($db_obj)
    {
        $this->db = $db_obj;
    }
    //获得db
    public function getDb()
    {
        return $this->db;
    }
    //设置日志对象
    public function setLogger($log_obj)
    {
        $this->logger = $log_obj;
    }
    //获得日志对象
    public function getLogger()
    {
        return $this->logger;
    }
    //设置session对象
    public function setSession($session)
    {
        $this->session = $session;
    }
    //获得session
    public function getSession()
    {
        return $this->session;
    }
    //设置缓存对象
    public function setCache($cache_obj)
    {
        $this->cache = $cache_obj;
    }
    //获得cache
    public function getCache()
    {
        return $this->cache;
    }
    //设置redis对象
    public function setRedis($redis_obj)
    {
        $this->redis = $redis_obj;
    }
    //获得redis
    public function getRedis()
    {
        return $this->redis;
    }

    //返回带大B后缀的表名
    public function getBussineTableName($table)
    {
        $bussineTB = '';
        if($table && $this->bussine_id) {
            if(substr($table,0,-1)!='_') {
                $bussineTB = '_'.$this->bussine_id;
            }
        }

        return $bussineTB;
    }
    //返回资源地址
    public function getAssetPath($folder='default',$customPath='')
    {
        if($customPath) {
            return './data/'.$customPath.'/'.$folder;
        } else {
            return $this->asset_path.'/'.$folder;
        }
    }

}