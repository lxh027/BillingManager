<?php

namespace app\index\model;

use think\exception\DbException;
use think\Model;

class UserModel extends Model
{
    protected $table = 'user';

    /**
     * @usage 获取所有在职员工
     * @param void
     * @return array
     */
    public function getAllEmployee() {
        try {
            $where = ['status' => 1];
            $result = $this->field(['id', 'name', 'authority'])->where($where)->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 判断登录
     * @param int account
     * @param string password
     * @return array ['code', 'msg', 'data']
     */
    public function checkLogin($account, $password) {
        try {
            $where = [
                'account'   => $account,
                'password'  => $password
            ];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '用户名或密码错误', 'data' => []];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '验证成功', 'data' => $result];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}