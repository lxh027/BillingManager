<?php

namespace app\index\controller;


use app\index\model\CustomerModel;

class Customer extends Base
{

    /*
     * 更改客户
     */
    public function updateCustomer()
    {
        $customerModel = new CustomerModel();
        $id = input('post.id');
        $data = input('post.data');
        $resp = $customerModel->updateCustomer($id, $data);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 删除用户
     */
    public function deleteCustomer()
    {
        $customerModel = new CustomerModel();
        $name = input('get.name');
        $resp = $customerModel->deleteCustomer($name);
        $this->redirect('index/customer/index');
    }


    /*
     * 获取所有用户
     */
    public function getCustomer()
    {
        $customerModel = new CustomerModel();
        $resp = $customerModel->getAllCustomer();
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 获取用户
     */
    public function getCustomerByName()
    {
        $customerModel = new CustomerModel();
        $name = input('post.name');
        $resp = $customerModel->getCustomerByName($name);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 获取用户 ID
     */
    public function getSpecificCustomerByID()
    {
        $customerModel = new CustomerModel();
        $id = input('get.id');
        $resp = $customerModel->getCustomerByID($id);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 获取用户
     */
    public function getSpecificCustomer()
    {
        $customerModel = new CustomerModel();
        $name = input('get.name');
        $resp = $customerModel->getCustomer($name);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 添加客户
     */
    public function addCustomer()
    {
        $customerModel = new CustomerModel();
        $req = input("post.");
        $insertData = [
            'name'      => $req['name'],
            'contact'   => $req['contact'],
            'number'    => $req['number'],
            'address'   => $req['address'],
            'deliver'   => $req['deliver']
        ];
        $resp = $customerModel->addCustomer($insertData);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function edit()
    {
        return $this->fetch();
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