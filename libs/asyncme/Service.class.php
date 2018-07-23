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

    private $db = null;

    private $cache = null;

    public function __construct($bussine_id,$service_id)
    {
        $this->service_id = $service_id;
        $this->bussine_id = $bussine_id;
    }

    //设在db对象
    public function setDb($db_obj)
    {
        $this->db = $db_obj;
    }
    //获得db
    public function getDb()
    {
        return $this->db;
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


}