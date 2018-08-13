<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/29
 * Time: 下午5:48
 */

namespace plugins\verification_code;

use libs\asyncme\Plugins as Plugins;
use libs\asyncme\RequestHelper as RequestHelper;
use libs\asyncme\ResponeHelper as ResponeHelper;

use Gregwar\Captcha\CaptchaBuilder;

class VerificationCode extends Plugins
{
    public function genAction(RequestHelper $req,array $preData)
    {
        $cwidth = $req->query_datas['w'];
        $cwidth = $cwidth ? $cwidth : '';
        $cheight = $req->query_datas['h'];
        $cheight = $cheight ? $cheight : '';
        $builder = new CaptchaBuilder;
        $builder->build($cwidth,$cheight);

        $status = true;
        $mess = '成功';
        $data = $builder;
        $type = 'captcha';

        $auth_name = $req->query_datas['auth'] ? $req->query_datas['auth'] : 'vcode';
        $auth_name = $req->company_id."_".$auth_name;

        $this->service->getSession()->set($auth_name,$builder->getPhrase());

        return new ResponeHelper($status,$mess,$data,$type);
    }
}