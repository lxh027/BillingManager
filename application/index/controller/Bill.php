<?php

namespace app\index\controller;


use app\index\model\BillModel;

class Bill extends Base
{

    /*
     * 收款
     */
    public function receiveMoney()
    {
        $billModel = new BillModel();
        $id = input("post.id");
        $money = input("post.pay");
        $resp = $billModel->receiveMoney($id, $money);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 收款状态
     */
    public function moneyStatus()
    {
        $billModel = new BillModel();
        $id = input("get.id");
        $resp = $billModel->getSpecificBill(['id' => $id]);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 送货
     */
    public function deliverProduct()
    {
        $billModel = new BillModel();
        $id = input("get.id");
        $resp = $billModel->deliverProduct($id);
        $this->redirect('index/bill/index');
    }

    /*
     * 获取所有订单
     */
    public function getAllBill()
    {
        $billModel = new BillModel();
        $resp = $billModel->getBill();
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 添加订单
     */
    public function addBill()
    {
        $billModel = new BillModel();
        $req = input('post.');
        $req['book_date'] = date("Y-m-d H:i:s");
        $req['amount'] = round($req['amount'], 2);
        $req['favour'] = round($req['favour'], 2);
        $req['price'] = round($req['price'], 2);
        $req['pay'] = round($req['pay'], 2);
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

    public function receive()
    {
        return $this->fetch();
    }

    public function check()
    {
        return $this->fetch();
    }

    public function edit()
    {
        return $this->fetch();
    }
}