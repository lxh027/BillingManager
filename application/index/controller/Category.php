<?php

namespace app\index\controller;



use app\index\model\CategoryModel;
use app\index\model\ProductModel;

class Category extends Base
{

    /*
     * 获取所有分类
     */
    public function getAllCategory() {
        $categoryModel = new CategoryModel();
        $resp = $categoryModel->getAllCategory();
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 通过分类获取项目
     */
    public function getProductByCategory() {
        $productModel = new ProductModel();
        $category = input('get.category');
        $resp = $productModel->getProductByCategory($category);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 添加分类
     */
    public function addCategory() {
        $categoryModel = new CategoryModel();
        $category = input('post.category');
        $resp = $categoryModel->addCategory($category);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 添加项目
     */
    public function addProduct() {
        $productModel = new ProductModel();
        $category = input('post.category');
        $product = input('post.product');
        $resp = $productModel->addProduct($product, $category);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 删除项目
     */
    public function deleteProductByID() {
        $productModel = new ProductModel();
        $id = input('get.id');
        $resp = $productModel->deleteProductByID($id);
        $this->redirect('index/category/index');
    }

    /*
     * 删除分类
     */
    public function deleteCategory() {
        $categoryModel = new CategoryModel();
        $name = input('post.name');
        $resp = $categoryModel->deleteCategory($name);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function add()
    {
        return $this->fetch();
    }
    public function index()
    {
        return $this->fetch();
    }
}