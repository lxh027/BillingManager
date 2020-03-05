<?php

namespace app\index\controller;


use app\index\model\BillModel;

class Bill extends Base
{

    /*
     * 添加订单
     */
    public function addBill()
    {
        $billModel = new BillModel();
        $req = input('post.');
        $req['book_date'] = date("Y-m-d H:i:s");
        $resp = $billModel->addBill($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
        //return $req;
    }

    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }
}