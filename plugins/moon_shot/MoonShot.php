<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/8/4
 * Time: 上午1:29
 */

namespace plugins\moon_shot;

use libs\asyncme\Plugins as Plugins;
use libs\asyncme\RequestHelper as RequestHelper;
use libs\asyncme\ResponeHelper as ResponeHelper;
use \Slim\Http\UploadedFile;

class MoonShot extends Plugins
{
    public function IndexAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = [
            'author'=>'Async Me',
            'date'=>'2018-07-10',
            'email'=> 'asyncme2018@aol.com',
        ];

        return new ResponeHelper($status,$mess,$data,'template','index',__CLASS__);
    }
}