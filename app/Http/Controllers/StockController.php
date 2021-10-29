<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use PHPExcel; 
use PHPExcel_IOFactory;
use PHPExcel_Cell;


class StockController extends Controller
{
    public function getDashboard(){
        // $dataExport = $this->exportData();
        // $results = [];
        // $resultsGroup = [];
        // $count = 0;
        // foreach ($dataExport as $key => $value) {
        //     if(empty($value[0]) || empty($value[1]) || empty($value[2])){
        //         continue;
        //     }
        //     if($value[0] == 'Mã CP'){
        //         continue;
        //     }
        //     if($value[11] > 0){
        //         $count += $value[11];
        //         $resultsGroup[$value[2]][] = $value;
        //         $results[] = $value;
        //         $count += floatval($value[11]);
        //     }
        // }
        // var_dump($count);die;
        return view('dashboard');
    }
     public function exportData($file = null){
        if(!$file){
            $file = '../storage/files/test.xlsx';
        }

        $objFile = PHPExcel_IOFactory::identify($file);
        $objData = PHPExcel_IOFactory::createReader($objFile);

        //Chỉ đọc dữ liệu
        $objData->setReadDataOnly(true);

        // Load dữ liệu sang dạng đối tượng
        $objPHPExcel = $objData->load($file);

        //Lấy ra số trang sử dụng phương thức getSheetCount();
        // Lấy Ra tên trang sử dụng getSheetNames();

        //Chọn trang cần truy xuất
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

        //Lấy ra số dòng cuối cùng
        $Totalrow = $sheet->getHighestRow();
        //Lấy ra tên cột cuối cùng
        $LastColumn = $sheet->getHighestColumn();

        //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
        $TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

        //Tạo mảng chứa dữ liệu
        $data = [];

        //Tiến hành lặp qua từng ô dữ liệu
        for ($i = 1; $i <= $Totalrow; $i++) {
            for ($j = 0; $j < $TotalCol; $j++) {
                $data[$i - 1][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
            }
        }
        return $data;


    }
    
}
