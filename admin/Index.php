<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/24
 * Time: 下午7:09
 */

namespace admin;

use admin\model;
use libs\asyncme\RequestHelper;

class Index extends PermissionBase
{
    public function infoAction(RequestHelper $req,array $preData)
    {
        $plugin_req = $req;
        $plugin_req->request_plugin = 'moon_shot';
        $plugin_req->action = 'index';

        $plugin_reponse = ng_plugins($plugin_req,$this->service);
        return $plugin_reponse;
    }

    public function tAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = [
            'test'=>'hello admin!',
            'req'=>$req,
        ];

        return $this->render($status,$mess,$data);
    }

    public function indexAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';

        $nav_data = $this->nav_default($req,$preData);


        //ng_func_privilege_check($req->company_id,$this->sessions['admin_uid'],'index');

        $data = [
            'title'=>'hello admin!',
            'content'=>'',
        ];
        $data = array_merge($nav_data,$data);

        return $this->render($status,$mess,$data,'template','Index/index');
    }


    public function codeAction(RequestHelper $req,array $preData)
    {
        $plugin_req = $req;
        $plugin_req->request_plugin = 'verification_code';
        $plugin_req->action = 'gen';

        $plugin_reponse = ng_plugins($plugin_req,$this->service);
        return $plugin_reponse;
    }

    public function urlAction(RequestHelper $req,array $preData)
    {


        $path = [
            'mark' => 'plugin',
            'bid'  => $req->company_id,
            'pl_name'=>'verification_code',
        ];
        $query = [
            'act'=>'gen'
        ];
        $url = urlGen($req,$path,$query,true);

        $status = true;
        $mess = '成功';
        $data = [
            'url' => $url,
        ];
        return $this->render($status,$mess,$data);
    }
}