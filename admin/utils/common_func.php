<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/8/2
 * Time: 下午11:41
 */
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
/**
 * 检查是否具备功能权限
 * @param $bid
 * @param $admin_uid
 * @param $op
 * @return bool
 */
function ng_func_privilege_check($bid,$admin_uid,$op)
{
    $ingore_admin_uid = 1;
    if ($admin_uid==$ingore_admin_uid){
        return true;
    }
    $map = [
        'company_id'=>$bid,
        'admin_uid'=>$admin_uid,
    ];

    $cachePath = NG_ROOT."/public/data/cache/privs";
    if(!is_dir($cachePath.'/')) {
        mkdir($cachePath.'/',0755,true);
    }
    $privs_data = [];
    $cache_file = 'priv_'.md5($bid.$admin_uid).".cache.php";
    if (file_exists($cachePath.'/'.$cache_file) && time()-filemtime($cachePath.'/'.$cache_file) < 5*60) {
        $privs_data = include $cachePath.'/'.$cache_file;

    } else {
        $has = Capsule::schema()->hasTable('sys_privilege_lists');
        if ($has) {
            $res = Capsule::table('sys_privilege_lists')->select('priv_path','priv_custom_data')->where($map)->get();
            if ($res) {
                $res = reset($res);

                foreach ($res as $key=>$val) {
                    $val = (array)$val;
                    if($val['priv_custom_data']){
                        $val['priv_custom_data'] = json_decode($val['priv_custom_data'],true);
                    }
                    if(!empty($val)) {
                        $privs_data[]=$val;
                    }

                }

                if(!empty($privs_data)) {
                    ob_start();
                    var_export($privs_data);
                    $cache_str = "<?php\n if(!defined('NG_ME')) die();\nreturn ".ob_get_contents().";\n";
                    ob_end_clean();
                    @file_put_contents($cachePath.'/'.$cache_file,$cache_str);
                }
            }
        }
    }

    $flag = false;
    if(!empty($privs_data)) {
        foreach ($privs_data as $priv) {
            if($priv['priv_path']==$op) {
                $flag = true;
                break;
            }
        }
    }

    return $flag;

}