<?php

namespace app\index\model;

use think\exception\DbException;
use think\Model;

class CategoryModel extends Model
{
    protected $table = 'category';

    /**
     * @usage 添加分类
     * @param string name
     * @return array
     */
    public function addCategory($name) {
        try {
            $where = ['name' => $name];
            $result = $this->where($where)->find();
            if ($result) {
                return ['code' => CODE_ERROR, 'msg' => '分类已存在', 'data' => $result];
            } else {
                $this->insertGetId($where);
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除分类
     * @param string name
     * @return array
     */
    public function deleteCategory($name) {
        try {
            $where = ['name' => $name];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '分类不存在', 'data' => $result];
            } else {
                $this->where($where)->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取所有分类
     * @param array
     * @param array
     * @param array
     * @return array
     */
    public function getAllCategory() {
        try {
            $result = $this->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 模糊查询
     * @param string name
     * @return array
     */
    public function searchCategory($name) {
        try {
            $result = $this->where('name', 'like', '%'.$name.'%')->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}