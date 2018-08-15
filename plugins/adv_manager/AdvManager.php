<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/8/6
 * Time: 下午6:57
 */

namespace plugins\adv_manager;

use libs\asyncme\Plugins as Plugins;
use libs\asyncme\RequestHelper as RequestHelper;
use libs\asyncme\ResponeHelper as ResponeHelper;
use \Slim\Http\UploadedFile;

class AdvManager extends Plugins
{
    public function positionAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = '<p><font style="color: red">position</font></p>';

        return new ResponeHelper($status,$mess,$data,'html');
    }

    public function advAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = '<p><font style="color: red">adv</font></p>';

        return new ResponeHelper($status,$mess,$data,'html');
    }

    public function logAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = '<p><font style="color: red">log</font></p>';

        return new ResponeHelper($status,$mess,$data,'html');
    }
}