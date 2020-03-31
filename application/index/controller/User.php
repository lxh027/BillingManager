<?php

namespace app\index\controller;

use app\index\model\UserModel;

class User extends Base
{

    public function getAuthority()
    {
        return apiReturn(0, 'ok', session("authority"), 200);
    }

    public function getAllUser()
    {
        $userModel = new UserModel();
        $resp = $userModel->getEmployee();
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function fireEmployee()
    {
        $userModel = new UserModel();
        $id = input('get.id');
        $resp = $userModel->fireEmployee($id);
        $this->redirect('index/user/index');
    }

    public function addEmployee()
    {
        $userModel = new UserModel();
        $req = input('post.');
        $resp = $userModel->addEmployee($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function getAllEmployee()
    {
        $userModel = new UserModel();
        $resp = $userModel->getAllEmployee();
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
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