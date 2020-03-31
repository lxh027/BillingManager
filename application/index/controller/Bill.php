<?php

namespace app\index\controller;


use app\index\model\BillModel;
use think\db\Where;

class Bill extends Base
{

    /*
     * 更新订单
     */
    public function updateBill()
    {
        $billModel = new BillModel();
        $id = input('post.id');
        $data = input('post.data');
        $data['amount'] = round($data['amount'], 2);
        $data['favour'] = round($data['favour'], 2);
        $data['price'] = round($data['price'], 2);
        $data['pay'] = round($data['pay'], 2);
        $resp = $billModel->updateBill($id, $data);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

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
     * 获取特定订单
     */
    public function getSpecificBill()
    {
        $billModel = new BillModel();
        $id = input('get.id');
        $where = ['id' => $id];
        $resp = $billModel->getSpecificBill($where);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function searchBill()
    {
        $billModel = new BillModel();
        $req = input('post.');
        $where = [
            ['customer', 'like', '%'.$req['customer'].'%'],
            ['clerk', 'like', '%'.$req['clerk'].'%'],
            ['designer', 'like', '%'.$req['designer'].'%'],
            ['tracker', 'like', '%'.$req['tracker'].'%'],
            ['book_date', 'between time', [strtotime($req['book_date_begin']), strtotime($req['book_date_end'])]],
            ['deliver_date', 'between time', [strtotime($req['deliver_date_begin']), strtotime($req['deliver_date_end'])]]
        ];
        $resp = $billModel->getBill($where);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
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

    /**
     * @return \think\response\Json
     */
    public function deleteBill()
    {
        $billModel = new BillModel();
        $id = input('get.id');
        $where = ['id' => $id];
        $resp = $billModel->deleteBill($where);
        $this->redirect("index/bill/index");
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