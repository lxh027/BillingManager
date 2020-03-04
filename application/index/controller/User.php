<?php

namespace app\index\controller;

use app\index\model\UserModel;

class User extends Base
{

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