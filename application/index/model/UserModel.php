<?php

namespace app\index\model;

use think\exception\DbException;
use think\Model;

class UserModel extends Model
{
    protected $table = 'user';

    /**
     * @usage 添加员工
     * @param $data
     * @return array
     */
    public function addEmployee($data)
    {
        try {
            $where = [
                'account' => $data['account']
            ];
            $result = $this->where($where)->find();
            if ($result) {
                return ['code' => CODE_ERROR, 'msg' => '账户已存在', 'data' => $result];
            } else {
                $this->insert($data);
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 开除员工
     * @param int id
     * @return array
     */
    public function fireEmployee($id) {
        try {
            $where = [
                'id' => $id
            ];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '账户不存在', 'data' => $result];
            } else {
                $this->where($where)->update(['status' => 0]);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

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
     * @usage 获取所有员工
     * @param void
     * @return array
     */
    public function getEmployee() {
        try {
            $result = $this->field(['account', 'status', 'id', 'name', 'authority'])->select();
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
                'password'  => $password,
                'status'    => 1
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