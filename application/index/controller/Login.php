<?php


namespace app\index\controller;


use app\index\model\UserModel;
use think\Controller;
use think\facade\Session;

class Login extends Controller
{

    /**
     * 登录检测
     */
    public function __construct()
    {
        parent::__construct();
        if (Session::has('name')) {
            $this->redirect('index/index/index');
        }
    }

    public function login() {
        $account = input('post.account');
        $password = input('post.password');
        $userModel = new UserModel();
        $resp = $userModel->checkLogin($account, $password);
        if ($resp['code'] == CODE_SUCCESS) {
            Session::set('name', $resp['data']['name']);
            Session::set('authority', $resp['data']['authority']==1?'管理员':'员工');
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function index() {
        return $this->fetch();
    }
}