<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/28
 * Time: 上午1:20
 */

namespace admin;

use libs\asyncme\Plugins as Plugins;
use libs\asyncme\RequestHelper as RequestHelper;
use libs\asyncme\ResponeHelper as ResponeHelper;
use \Slim\Http\UploadedFile;

class PermissionBase extends AdminBase
{
    public $sessions;

    public function auth()
    {
        $req = $this->service->getRequestHelper();
        $bid = $req->company_id;

        $path = [
            'mark' => 'sys',
            'bid'  => $bid,
            'pl_name'=>'admin',
        ];
        $query = [
            'mod'=>'pub',
            'act'=>'login'
        ];

        $url = urlGen($req,$path,$query);
        $time = 0;
        $mess = '';

        $session = $this->service->getSession();

        $sessions['admin_uid'] = $session->get('admin_uid');
        $sessions['admin_user'] = $session->get('admin_user');
        $sessions['admin_name'] = $session->get('admin_name');
        $sessions['admin_avatar'] = $session->get('admin_avatar');
        $sessions['admin_login_time'] = $session->get('admin_login_time');

        $this->sessions = $sessions;

        $status = $session->get('admin_user') ? true : false;
        return [
            'status'=>$status,
            'mess'=>$mess,
            'url'=>$url,
            'time'=>$time,
        ];

    }
}