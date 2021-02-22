<?php
namespace app\index\model;

use think\Exception;
use think\exception\DbException;
use think\Model;

class BillItemModel extends Model
{
    protected $table = "bill_item";
    public function addItem($data) {
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

    public function getItems($where = []) {
        try {
            if ($where == []) $result = $this->select();
            else $result = $this->where($where)->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function updateItem($id, $data)
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
}