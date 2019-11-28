<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * ajax请求成功返回
     *
     * @param array $data
     * @return array
     */
    public function ajaxSucc($data = [], $code = 0, $msg = '')
    {
        return [
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
        ];
    }

    /**
     * ajax请求失败返回
     *
     * @param $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    public function ajaxError($code, $msg = '', $data = [])
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }
}
