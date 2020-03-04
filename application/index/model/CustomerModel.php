<?php

namespace app\index\model;

use think\exception\DbException;
use think\Model;

class CustomerModel extends Model
{
    protected $table = 'customer';

    /**
     * @usage 添加客户
     * @param array data
     * @return array
     */
    public function addCustomer($data) {
        try {
            $where = [
                'name' => $data['name']
            ];
            $result = $this->where($where)->find();
            if ($result) {
                return ['code' => CODE_ERROR, 'msg' => '客户已存在', 'data' => $result];
            } else {
                $this->insert($data);
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除客户
     * @param string name
     * @return array
     */
    public function deleteCustomer($name) {
        try {
            $where = [
                'name' => $name
            ];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '客户不存在', 'data' => $result];
            } else {
                $this->where($where)->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获得所有客户
     * @param void
     * @return array
     */
    public function getAllCustomer() {
        try {
            $result = $this->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获得用户
     * @param string name
     * @return array
     */
    public function getCustomerByName($name) {
        try {
            $result = $this->where('name', 'like', '%'.$name.'%')->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获得用户
     * @param string name
     * @return array
     */
    public function getCustomer($name) {
        try {
            $where = [
                'name' => $name,
            ];
            $result = $this->where($where)->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}