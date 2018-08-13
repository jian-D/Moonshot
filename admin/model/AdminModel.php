<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/27
 * Time: 上午12:20
 */

namespace admin\model;


use libs\asyncme\Service;

class AdminModel
{
    public $service = null;

    public $db = null;

    public $cache = null;

    public $redis = null;

    public function __construct(Service $service)
    {
        $this->service = $service;
        $this->db = $service->getDb();
        $this->cache = $service->getCache();
        $this->redis = $service->getRedis();
    }

    /**
     * 获得配置
     * @param $name
     * @return array
     */
    public function getConfig($name)
    {
        $map = [
            'name'=> $name
        ];
        $res = $this->db->table('sys_config')->where($map)->first();
        if ($res && isset($res->config)) {
            $res = json_decode($res->config,true);

        }
        return $res;
    }

    /**
     * 添加系统日志
     * @param $bid
     * @param $loginfo
     * @param string $type
     */
    public function sysLog($bid,$loginfo,$type='sys')
    {
        if($bid && $loginfo) {
            $info = ng_mysql_json_safe_encode($loginfo);
            $map = [
                'company_id'=>$bid,
                'info'=>$info,
                'type'=>$type,
                'ctime'=>time()
            ];
            $this->db->table('sys_logs')->insertGetId($map);
        }
    }

    public function str()
    {
        echo __CLASS__;
    }

    /**
     * 获得表前缀
     * @return mixed
     */
    public function get_table_prefix()
    {
        return $this->db->getConnection()->getTablePrefix();
    }

}