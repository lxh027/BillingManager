<?php

namespace app\index\model;

use think\Exception;
use think\exception\DbException;
use think\Model;

class BillModel extends Model
{
    protected $table = 'bill';

    /**
     * @usage 更新订单
     * @param int id
     * @param array data
     * @return array
     */
    public function updateBill($id, $data)
    {
        try {
            $where = ['id' => $id];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '订单号不存在', 'data' => $result];
            } else {
                $this->where($where)->update($data);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 收款
     * @param int id
     * @param double money
     * @return array
     */
    public function receiveMoney($id, $money) {
        try {
            $where = ['id' => $id];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '订单号不存在', 'data' => $result];
            } else {
                if ($money<0 || $result['amount']-$result['pay']-$result['favour'] < $money) {
                    return ['code' => CODE_ERROR, 'msg' => '超出金额范围', 'data' => []];
                }
                $data = [
                    'pay' => $result['pay']+$money,
                ];
                $this->where($where)->update($data);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 送货
     * @param int id
     * @return array
     */
    public function deliverProduct($id) {
        try {
            $where = ['id' => $id];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '订单号不存在', 'data' => $result];
            } else {
                $data = ['deliver_status' => 1];
                $this->where($where)->update($data);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取特定订单
     * @param array $where
     * @return array
     */
    public function getSpecificBill($where) {
        try {
            $result = $this->where($where)->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取订单
     * @param array $where
     * @return array
     */
    public function getBill($where = []) {
        try {
            if ($where == []) $result = $this->order('id', 'desc')->select();
            else $result = $this->where($where)->order('id', 'desc')->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 添加订单
     * @param array data
     * @return array
     */
    public function addBill($data) {
        try {
            /*$where = ['sno' => $data['sno']];
            $result = $this->where($where)->find();
            if ($result) {
                return ['code' => CODE_ERROR, 'msg' => '订单号已存在', 'data' => $result];
            } else {
                $this->insertGetId($data);
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => []];
            }*/
            $id = $this->insertGetId($data);
            return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => $id];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
    /**
     * @usage 添加订单
     * @param array data
     * @return array
     */
    public function deleteBill($data) {
        try {
            $where = ['id' => $data['id']];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '订单号不存在', 'data' => $result];
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
}