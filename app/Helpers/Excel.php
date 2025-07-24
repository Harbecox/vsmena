<?php

namespace App\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Excel
{
    static function download(array $head, Builder $query,string $name)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $row = "A";
        $col = 1;
        foreach ($head as $key => $value){
            $activeWorksheet->setCellValue($row.$col, $value);
            $col++;
        }
        $row++;
        foreach ($query->get() as $item){
            $col = 1;
            foreach ($head as $key => $value){
                $activeWorksheet->setCellValue($row.$col, $item[$key]);
                $col++;
            }
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        if(!Str::endsWith($name, '.xlsx')){
            $name .= '.xlsx';
        }
        dd(1);
        $writer->save($name);
    }
}


/*
    "id" => 1679
    "positions_id" => 5
    "title" => "Future-proofed transitional moderator"
    "color" => "#d5b41f"
    "start_date" => "2025-07-21 11:00:00"
    "end_date" => "2025-07-21 15:00:00"
    "status" => 0
    "created_at" => "2025-07-19 00:25:13"
    "updated_at" => "2025-07-19 00:25:13"
    "posname" => "Meat Packer"
    "restname" => "Collier, Heller and Boehm"
    "price_hour" => "693.00"
 */
