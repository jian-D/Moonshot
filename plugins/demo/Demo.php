<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/15
 * Time: 上午1:31
 */

namespace plugins\demo;

use libs\asyncme\Plugins as Plugins;
use libs\asyncme\RequestHelper as RequestHelper;
use libs\asyncme\ResponeHelper as ResponeHelper;
use \Slim\Http\UploadedFile;


class Demo extends Plugins
{


    public function IndexAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = [
            'test'=>'what the hell',
            'req'=>$req,
        ];

        return new ResponeHelper($status,$mess,$data);
    }

    public function htmlAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = '<p><font style="color: red">123</font></p>';

        return new ResponeHelper($status,$mess,$data,'html');
    }

    public function redirectAction()
    {
        $status = true;
        $mess = '成功';
        $data = 'http://127.0.0.1/';
        return new ResponeHelper($status,$mess,$data,'redirect');
    }

    public function uploadAction(RequestHelper $req)
    {
        $asset_path = $this->service->getAssetPath();
        if(!is_dir($asset_path.'/')) {
            mkdir($asset_path.'/',0775,true);
        }
        $success_upload_data = [];

        foreach ( $req->upload_files as $file) {
            $oldname = $file->getClientFilename();
            $error = $file->getError();
            if ($error === UPLOAD_ERR_OK) {
                $extension = strtolower(pathinfo($oldname)['extension']);
                $uploadFileName = uniqid(date('Ymd').'-').".".$extension;
                $file->moveTo($asset_path."/".$uploadFileName);
                $filesize = $file->getSize();
                $filetype = $file->getClientMediaType();
                $success_upload_data[] = [
                    'name'=>$asset_path."/".$uploadFileName,
                    'size'=>$filesize,
                    'type'=>$filetype,
                ];
            } else {
                $success_upload_data = [];
                break;
            }
        }
        if (count($success_upload_data)) {
            $status = true;
            $mess = '成功';
            $data = $success_upload_data;
        } else {
            $status = false;
            $mess = '失败';
            $data = $error;
        }


        return new ResponeHelper($status,$mess,$data,'json');

    }

    public function findAction(RequestHelper $req)
    {

        $map = [];
        $data = $this->service->getDb()->table('plugins_rel')->where($map)->first();
        $data = (array)$data;
        $status = true;
        $mess = '成功';
        return new ResponeHelper($status,$mess,$data,'json');
    }

    public function cacheAction(RequestHelper $req)
    {
        $this->service->getRedis()->set('engine','moon_shot_'.time());

        $data = $this->service->getRedis()->get('engine');;
        $status = true;
        $mess = '成功';
        return new ResponeHelper($status,$mess,$data,'json');
    }
}