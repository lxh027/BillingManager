<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

define("CODE_SUCCESS", 0);
define("CODE_ERROR", 1);

function apiReturn($status, $message, $data=[], $httpCode=200)
{
    return json([
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
    ], $httpCode);
}

function aoDataFormat($aoData, $column)
{
    $aoData = json_decode($aoData, false);
    $data['offset'] = 0;
    $data['limit'] = 10;
    $data['where'] = [];
    foreach ($aoData as $key => $val) {
        if ($key === 'iDisplayStart') {
            $data['offset'] = $val;
        }
        if ($key === 'iDisplayLength'){
            $data['limit']= $val;
        }
        if ($key === 'sSearch' && $val !== '') {
            $data['where'][$column] = ['like', '%' . $val . '%'];
        }
    }
    return $data;
}

function datatable_response($code, $where, $data, $model)
{
    $response = array(
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => ''
    );
    if($code === CODE_SUCCESS){
        $count = $model->where($where)->count();
        $response['recordsTotal'] = $count;
        $response['recordsFiltered'] = $count;
        $response['data'] = $data;
    }
    return json_encode($response);
}