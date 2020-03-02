<?php

namespace app\index\model;


use think\exception\DbException;
use think\Model;

class ProductModel extends Model
{
    protected $table = 'product';

    /**
     * @usage 添加项目
     * @param string product
     * @param string category
     * @return array
     */
    public function addProduct($product, $category) {
        try {
            $where = [
                'product'   => $product,
                'category'  => $category
            ];
            $result = $this->where($where)->find();
            if ($result) {
                return ['code' => CODE_ERROR, 'msg' => '项目已存在', 'data' => $result];
            } else {
                $this->insertGetId($where);
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => []];
            }
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除项目
     * @param string product
     * @param string category
     * @return array
     */
    public function deleteProduct($product, $category) {
        try {
            $where = [
                'product'   => $product,
                'category'  => $category
            ];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '项目不存在', 'data' => $result];
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
     * @usage 删除项目
     * @param string id
     * @return array
     */
    public function deleteProductByID($id) {
        try {
            $where = [
                'id'   => $id,
            ];
            $result = $this->where($where)->find();
            if (!$result) {
                return ['code' => CODE_ERROR, 'msg' => '项目不存在', 'data' => $result];
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
     * @usage 获取所有项目
     * @param void
     * @return array
     */
    public function getAllProduct() {
        try {
            $resp = $this->select();
            //$resp = $this->process($result);
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $resp];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取分类所有项目
     * @param string category
     * @return array
     */
    public function getProductByCategory($category) {
        try {
            $where = ['category' => $category];
            $resp = $this->where($where)->select();
            //$resp = $this->process($result);
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $resp];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }


    /**
     * @usage 模糊获取所有项目
     * @param string name
     * @return array
     */
    public function searchProduct($name) {
        try {
            $sql = "select * from product where product like \"%".$name."%\" OR category like \"%".$name."%\"";
            $resp = $this->query($sql);
            //$resp = $this->process($result);
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $resp];
        } catch(DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    private function process($result) {
        $data = [];
        foreach ($result as $product) {
            if (!isset($data[$product['category']])) {
                $temp = array();
                $data[$product['category']] = $temp;
            }
            array_push($data[$product['category']], $product['product']);
        }
        return $data;
    }
}