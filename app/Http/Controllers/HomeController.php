<?php

namespace App\Http\Controllers;

use App\Imports\SmsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    const STR_QUEUE_SYNC_SMS_LISTS = 'Queue:Sync:Sms:Lists'; //记录刷新文档映射
    const STR_SYMBOL_SPOT = '.'; //记录刷新文档映射
    const STR_CODE_MAPPING = [
        1 => 5276551628153579435,
        2 => 5276562898145752097,
    ];
    const DEFAULT_CALLBACK_ARRAY = [
        'custid' => '147',
        'mobile' => '13521262613',
        'stime' => '2019-11-14 14:38:36',
        'status' => 0,
        'errcode' => 'DELIVRD',
    ];

    // [750 => 1, 749 => 2]
    //
    public function welcome()
    {
        $filePath = public_path() . '/import/' . iconv('UTF-8', 'GBK', '7346-1') . '.xlsx';
        $smsImport = new SmsImport();
        $smsArray = Excel::toArray($smsImport, $filePath);
        $defaultArray = self::DEFAULT_CALLBACK_ARRAY;
        $mapping = self::STR_CODE_MAPPING;
        $smsArray = array_map(function ($items) use ($defaultArray, $mapping) {
            return array_map(function ($item) use ($defaultArray, $mapping) {
                $defaultArray['custid'] = $mapping[$item['code']];
                $defaultArray['mobile'] = $item['phone'];
                $defaultArray['stime'] = $item['stime'];
                $defaultArray['status'] = $defaultArray['errcode'] = $item['status'];
                Redis::rpush(self::STR_QUEUE_SYNC_SMS_LISTS, json_encode($defaultArray));
                return $defaultArray;
            }, $items);
        }, $smsArray);
//        dd(Redis::rpush(self::STR_QUEUE_SYNC_SMS_LISTS, json_encode($smsArray)));
        dd($smsArray);
    }
    public function home()
    {
        return 'home Blog';
    }
}
