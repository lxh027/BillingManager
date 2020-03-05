<?php

namespace app\index\model;

use think\Exception;
use think\exception\DbException;
use think\Model;

class BillModel extends Model
{
    protected $table = 'bill';

    /**
     * @usage 添加订单
     * @param array data
     * @return array
     */
    public function addBill($data) {
        try {
            $where = ['sno' => $data['sno']];
            $result = $this->where($where)->find();
            if ($result) {
                return ['code' => CODE_ERROR, 'msg' => '订单号已存在', 'data' => $result];
            } else {
                $this->insertGetId($data);
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}