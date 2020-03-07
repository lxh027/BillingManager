<?php

namespace app\index\controller;

use think\App;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    /**
     * 登录检测
     */
    public function __construct()
    {
        parent::__construct();
        if (!Session::has('name')) {
            $this->redirect('index/login/index');
            //Session::set('name', '123');
            //Session::set('authority', '管理员');
        }
        $this->assign('name', session('name'));
        $this->assign('authority', session('authority'));
    }
}