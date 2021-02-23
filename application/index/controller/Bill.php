<?php

namespace app\index\controller;


use app\index\model\BillItemModel;
use app\index\model\BillModel;
use PHPExcel_Writer_HTML;
use think\Loader;
use PHPExcel;
use think\db\Where;
use think\Exception;

class Bill extends Base
{

    /*
     * 更新订单
     */
    public function updateBill()
    {
        $billModel = new BillModel();
        $billItemModel = new BillItemModel();
        $id = input('post.id');
        $req = input('post.data');
        /*$data['amount'] = round($data['amount'], 2);
        $data['favour'] = round($data['favour'], 2);
        $data['price'] = round($data['price'], 2);
        $data['pay'] = round($data['pay'], 2);*/
        $data = [
            "sno"       => $req["sno"],
            "bill_type" => $req["bill_type"],
            "amount"    => round($req["amount"], 2),
            "pay"       => round($req["pay"], 2),
            "favour"    => round($req["favour"], 2),
            "settlement"=> $req["settlement"],
            "customer"  => $req["customer"],
            "contact"   => $req["contact"],
            "number"    => $req["number"],
            "address"   => $req["address"],
            "deliver_type" => $req["deliver_type"],
            "clerk"     => $req["clerk"],
            "designer"  => $req["designer"],
            "tracker"   => $req["tracker"],
            "source"    => $req["source"],
            "writer"    => $req["writer"],
            "comment"  => $req["comment"],
            "book_date" => date("Y-m-d H:i:s")
        ];
        if ($req["deliver_date"] != "") {
            $data["deliver_date"] = $req["deliver_date"];
        }
        $resp = $billModel->updateBill($id, $data);
        if (isset($req["items"])) {
            foreach ($req["items"] as $item) {
                $data = [
                    "product"   => $item["product"],
                    "width"     => $item["width"],
                    "height"    => $item["height"],
                    "length_unit" => $item["length_unit"],
                    "price_unit"    => $item["price_unit"],
                    "price"     => round($item["price"], 2),
                    "remark"    => $item["remark"],
                    "amount"    => round($item["amount"], 2),
                    "product_num"   => $item["product_num"],
                ];
                $resp = $billItemModel->updateItem($item["id"], $data);
                if ($resp["code"] != CODE_SUCCESS) {
                    return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
                }
            }
        }

        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 收款
     */
    public function receiveMoney()
    {
        $billModel = new BillModel();
        $id = input("post.id");
        $money = input("post.pay");
        $resp = $billModel->receiveMoney($id, $money);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 收款状态
     */
    public function moneyStatus()
    {
        $billModel = new BillModel();
        $id = input("get.id");
        $resp = $billModel->getSpecificBill(['id' => $id]);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 送货
     */
    public function deliverProduct()
    {
        $billModel = new BillModel();
        $id = input("get.id");
        $resp = $billModel->deliverProduct($id);
        $this->redirect('index/bill/index');
    }

    /*
     * 获取特定订单
     */
    public function getSpecificBill()
    {
        $billModel = new BillModel();
        $billItemModel = new BillItemModel();
        $id = input('get.id');
        $where = ['id' => $id];
        $data = $billModel->getSpecificBill($where)["data"];
        $where = ['bill' => $id];
        $resp = $billItemModel->getItems($where);
        $data["items"] = $resp["data"];
        return apiReturn($resp['code'], $resp['msg'], $data, 200);
    }

    public function searchBill()
    {
        $billModel = new BillModel();
        $req = input('post.');
        $where = [
            ['customer', 'like', '%'.$req['customer'].'%'],
            ['clerk', 'like', '%'.$req['clerk'].'%'],
            ['designer', 'like', '%'.$req['designer'].'%'],
            ['tracker', 'like', '%'.$req['tracker'].'%'],
            ['book_date', 'between time', [strtotime($req['book_date_begin']), strtotime($req['book_date_end'])]],
            ['deliver_date', 'between time', [strtotime($req['deliver_date_begin']), strtotime($req['deliver_date_end'])]]
        ];
        $resp = $billModel->getBill($where);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /*
     * 获取所有订单
     */
    public function getAllBill()
    {
        $billModel = new BillModel();
        $resp = $billModel->getBill();
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    /**
     * @return \think\response\Json
     */
    public function deleteBill()
    {
        $billModel = new BillModel();
        $id = input('get.id');
        $where = ['id' => $id];
        $resp = $billModel->deleteBill($where);
        $this->redirect("index/bill/index");
    }

    /*
     * 添加订单
     */
    public function addBill()
    {
        $billModel = new BillModel();
        $billItemModel = new BillItemModel();
        $req = input('post.');
        /*$req['amount'] = round($req['amount'], 2);
        $req['favour'] = round($req['favour'], 2);
        $req['price'] = round($req['price'], 2);
        $req['pay'] = round($req['pay'], 2);*/
        $data = [
            "sno"       => $req["sno"],
            "bill_type" => $req["bill_type"],
            "amount"    => round($req["amount"], 2),
            "pay"       => round($req["pay"], 2),
            "favour"    => round($req["favour"], 2),
            "settlement"=> $req["settlement"],
            "customer"  => $req["customer"],
            "contact"   => $req["contact"],
            "number"    => $req["number"],
            "address"   => $req["address"],
            "deliver_type" => $req["deliver_type"],
            "clerk"     => $req["clerk"],
            "designer"  => $req["designer"],
            "tracker"   => $req["tracker"],
            "source"    => $req["source"],
            "writer"    => $req["writer"],
            "comment"  => $req["comment"],
            "book_date" => date("Y-m-d H:i:s")
        ];
        if ($req["deliver_date"] != "") {
            $data["deliver_date"] = $req["deliver_date"];
        }
        $resp = $billModel->addBill($data);
        $bill_id = $resp["data"];
        if (isset($req["items"])) {
            foreach ($req["items"] as $item) {
                $data = [
                    "product"   => $item["product"],
                    "width"     => $item["width"],
                    "height"    => $item["height"],
                    "length_unit" => $item["length_unit"],
                    "price_unit"    => $item["price_unit"],
                    "price"     => round($item["price"], 2),
                    "remark"    => $item["remark"],
                    "amount"    => round($req["amount"], 2),
                    "product_num"   => $item["product_num"],
                    "bill"      => $bill_id,
                ];
                $res = $billItemModel->addItem($data);
                if ($res["code"] != CODE_SUCCESS) {
                    return apiReturn($res['code'], $res['msg'], $res['data'], 200);
                }
            }
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
        //return $req;
    }

    public function getSno() {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8).'-';
        $uuid .= substr($chars, 8, 4).'-';
        $uuid .= substr($chars, 12, 4).'-';
        $uuid .= substr($chars, 16, 4).'-';
        $uuid .= substr($chars, 20, 12);
        return apiReturn(CODE_SUCCESS, 'ok', $uuid, 200);
    }

    public function printBill() {
        try {
            $phpExcel = new \PHPExcel();
            $excelModel = \PHPExcel_IOFactory::load('./static/print.xlsx');
            $sheet = $excelModel->getActiveSheet();

            $billModel = new BillModel();
            $billItemModel = new BillItemModel();
            $id = input('get.id');
            $type = input('get.type');
            $where = ['id' => $id];
            $data = $billModel->getSpecificBill($where)["data"];
            $where = ['bill' => $id];
            $items = $billItemModel->getItems($where)["data"];

            $bill_type = ["正常", "返工", "小样"];
            $deliver_type = ["送货", "自提"];
            //dump($data);
            $sheet->getCell("B3")->setValue($data["sno"]);
            $sheet->getCell("H3")->setValue($bill_type[$data["bill_type"]]);
            $sheet->getCell("B4")->setValue($data["customer"]);
            $sheet->getCell("B5")->setValue($data["contact"]);
            $sheet->getCell("B6")->setValue($data["number"]);
            $sheet->getCell("B7")->setValue($data["address"]);
            $sheet->getCell("B8")->setValue($deliver_type[$data["deliver_type"]]);

            $sheet->getCell("B13")->setValue($data["comment"]);
            $sheet->getCell("B16")->setValue($data["clerk"]);
            $sheet->getCell("B17")->setValue($data["designer"]);
            $sheet->getCell("B18")->setValue($data["tracker"]);
            $sheet->getCell("B19")->setValue($data["source"]);
            $sheet->getCell("B20")->setValue($data["writer"]);

            $sheet->getCell("F14")->setValue($data["settlement"]);
            $sheet->getCell("H14")->setValue($data["amount"]);
            $sheet->getCell("F15")->setValue($data["pay"]);
            $sheet->getCell("H15")->setValue($data["favour"]);
            $sheet->getCell("F16")->setValue($data["deliver_date"]);
            $sheet->getCell("F17")->setValue($data["book_date"]);

            $price_unit = ["成品", "面积", "长边", "宽", "高", "周长"];
            $length_unit = [1 => "mm", 10 => "cm", 100 => "m"];
            $i = count($items);
            foreach ($items as $item) {
                $sheet->insertNewRowBefore(11);
                $sheet->getCell("A11")->setValue($i);
                $sheet->getCell("B11")->setValue($item["product"]);
                $sheet->getCell("C11")->setValue($item["remark"]);
                $sheet->getCell("D11")->setValue($price_unit[$item["price_unit"]]);
                $sheet->getCell("E11")->setValue($item["width"]."x".$item["height"]."(".$length_unit[$item["length_unit"]].")");
                $sheet->getCell("F11")->setValue($item["product_num"]);
                $sheet->getCell("G11")->setValue($item["price"]);
                $sheet->getCell("H11")->setValue($item["amount"]);
                $i--;
            }

            if ($type == 0) {
                $filename = $data["customer"]."-".$data["book_date"];
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = \PHPExcel_IOFactory::createWriter($excelModel, 'Excel2007');
                $writer->save('php://output');
            } else {
                $objWriteHTML = new PHPExcel_Writer_HTML($excelModel); //输出网页格式的对象
                $objWriteHTML->save('php://output');
            }

        } catch (\PHPExcel_Exception $e) {
            return apiReturn(CODE_ERROR, $e->getMessage(), 0, 200);
        }
    }

    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function receive()
    {
        return $this->fetch();
    }

    public function check()
    {
        return $this->fetch();
    }

    public function edit()
    {
        return $this->fetch();
    }
}