<?php
namespace app\index\controller;


use think\facade\Session;

class Index extends Base
{

    public function logout() {
        Session::delete("name");
        Session::delete("authority");
        $this->redirect('index/login/index');
    }

    public function index()
    {
        return  $this->fetch();
    }

}
