<?php
namespace Libary;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

abstract class Excel{

    public static function load($file)
    {
        try
        {
            // type file
            $fileType = IOFactory::identify($file);
            //create file to read
            $reader = IOFactory::createReader($fileType);
            $reader->setReadDataOnly(true);
            //load file
            $spreadsheet = $reader->load($file);
        }
        catch(Exception $e)
        {
            return ['Error ao ler o arquivo "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage()];
        }
        //return sheet active
        return  $spreadsheet;
    }

    /*
     * TODO função para exportação de arquivo de acordo com a preferencia de cada pessoa
     */
    public static function export($file, $config = [])
    {
        try{
            //style default to title
            $styleTitleArray = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'font' => [
                    'bold' => true,
                    'size' => '14'
                ]
            ];
            //style default to columns
            $styleColorArray = [
                'fill' =>
                    [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color'    => ['rgb' => '6699cc'],
                    ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'font' => [
                    'color' => ['rgb' => 'ffffff'],
                    'size' => '11'
                ],
            ];

            //get merge columns title
            $qtdColumns = isset($config['merge']) > 0 ? $config['merge'] : 0;

            //load file to transform xlx
            $spreadsheet =  self::load($file);

            //required configs
            if(count($config) == 0)
            {
                return ["success" => false, "message" => "Configurações são nescessarias para poder gerar o arquivo"];
            }

            //required columns
            if(!isset($config["columns"]))
            {
                return ["success" => false, "message" => "Nescessário ao menos uma coluna."];
            }

            $keyExcel  = array_keys($config["columns"]);
            $columnEnd = end($keyExcel);
            //if title exist
            if(isset($config["title"])){

                $spreadsheet->getActiveSheet(0)->setCellValue("A1", $config["title"]);

                $endColumn = $columnEnd."1";
                if($qtdColumns != 0)
                {
                    $endColumn = $columnEnd.$qtdColumns;
                }

                $spreadsheet->getActiveSheet(0)->mergeCells("A1:".$endColumn);

                $style = isset($config['style']['titulo']) ? $config['style']['titulo'] : $styleTitleArray;

                $spreadsheet->getActiveSheet(0)->getStyle("A1:".$columnEnd.$qtdColumns)->applyFromArray($style);
            }
            
            //jump line
            $newQtdColumns = $qtdColumns + 1;
            
            if($qtdColumns == 0 && isset($config["title"]))
            {
                $newQtdColumns = $qtdColumns + 2;
            }
            
            //insert columns in sheet
            foreach ($config["columns"] as $key => $col)
            {
                $spreadsheet->getActiveSheet(0)->setCellValue($key.$newQtdColumns, $col);
            }
            
            //style for columns
            $styleColumns = isset($config['style']['colmuns']) ? $config['style']['colmuns'] : $styleColorArray;
            
            $spreadsheet->getActiveSheet(0)->getStyle("A".$newQtdColumns.":".$columnEnd.$newQtdColumns)->applyFromArray($styleColumns);
            
            //filter for columns
            if($config["filter"] == true){
                $spreadsheet->getActiveSheet(0)->setAutoFilter("A".$newQtdColumns.":".$columnEnd.$newQtdColumns);
            }

            if(isset($config["height"])){
                $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight($config["height"]);
            }

            if(isset($config["width"])){
                foreach ($keyExcel as $colu)
                {
                    $spreadsheet->getActiveSheet(0)->getColumnDimension($colu)->setWidth($config["width"]);
                }
            }

            return ["success" => true, "document" => $spreadsheet];
        }
        catch (\Exception $e)
        {
            return ["success" => true, "message" => "Erro ao gerar arquivo ".$e];
        }

    }

    public static function download($file, $name)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($file, 'Xls');
        $writer->save('php://output');
    }

    //função de exportar Protocolo EXCEL
    public static function exportProtocol($file, $config = [])
    {
        try{
            //style default to title
            $styleTitleArray = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_BOTTOM
                ],
                'font' => [
                    'bold' => true,
                    'size' => '20'
                ],
            ];

            $styleDate = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    'vertical' => Alignment::VERTICAL_BOTTOM
                ],
                'font' => [
                    'bold' => true,
                    'size' => '20'
                ],
            ];

            $styleBorders =    [
                'borderStyle' => Border::BORDER_THIN,
                'allBorders' => [
                        'color' => [
                            'rgb'  => '808080',
                        ],
                ],
            ];
    
            //style default to columns
            $styleColorArray = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText'     => TRUE
                ],
                'font' => [
                    'color' => ['rgb' => '000000'],
                    'size' => '11',
                    'bold' => true,
                ],
                'borderStyle' => Border::BORDER_THIN,
                'allBorders' => [
                    'color' => [
                        'rgb'  => '808080',
                    ],
                ],
            ];

            //get merge columns title
            $qtdColumns = isset($config['merge']) > 0 ? $config['merge'] : 0;

            //load file to transform xlx
            $spreadsheet =  self::load($file);

            //required configs
            if(count($config) == 0)
            {
                return ["success" => false, "message" => "Configurações são nescessarias para poder gerar o arquivo"];
            }

            //required columns
            if(!isset($config["columns"]))
            {
                return ["success" => false, "message" => "Nescessário ao menos uma coluna."];
            }

            $keyExcel  = array_keys($config["columns"]);
            $columnEnd = end($keyExcel);
            $columnPrev = prev($keyExcel);
            $columnPrev2 = prev($keyExcel);

            //if title exist
            if(isset($config["title"])){

                $spreadsheet->getActiveSheet(0)->setCellValue("B2", $config["title"]);
                $spreadsheet->getActiveSheet(0)->setCellValue("Q2", $config["dateP"]);
                $spreadsheet->getActiveSheet(0)->getStyle("Q".$qtdColumns)->applyFromArray($styleDate);

                $endColumn = $columnPrev2."2";
                if($qtdColumns != 0)
                {
                    $endColumn = $columnPrev2.$qtdColumns;
                }

                $spreadsheet->getActiveSheet(0)->getStyle("Q" . $qtdColumns)->applyFromArray($styleDate);
                $spreadsheet->getActiveSheet(0)->mergeCells("B2:".$endColumn);

                $style = isset($config['style']['titulo']) ? $config['style']['titulo'] : $styleTitleArray;
                
                $spreadsheet->getActiveSheet(0)->getStyle("B2:".$columnPrev2.$qtdColumns)->applyFromArray($style);
            }
            //Border bottom title
            $spreadsheet->getActiveSheet(0)->getStyle("B2:".$columnEnd.$qtdColumns)->getBorders()->applyFromArray([
                'bottom' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => [
                        'rgb' => '808080'
                   ]
                ],
            ]);
            
            //jump line
            $newQtdColumns = $qtdColumns + 2;
            if($qtdColumns == 0 && isset($config["title"]))
            {
                $newQtdColumns = $qtdColumns + 2;
            }

            //insert columns in sheet
            foreach ($config["columns"] as $key => $col)
            {
                $spreadsheet->getActiveSheet(0)->setCellValue($key.$newQtdColumns, $col);
            }

            //style for columns
            $styleColumns = isset($config['style']['columns']) ? $config['style']['columns'] : $styleColorArray;

            $spreadsheet->getActiveSheet(0)->getStyle("B".$newQtdColumns.":".$columnEnd.$newQtdColumns)->applyFromArray($styleColumns);
            $spreadsheet->getActiveSheet(0)->getStyle("B".$newQtdColumns.":".$columnEnd.$newQtdColumns)->getBorders()->getAllBorders()->applyFromArray(
                    [
                        'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => '808080'
                            ],
                    ]
            );
            
            //filter for columns
            if($config["filter"] == true){
                $spreadsheet->getActiveSheet(0)->setAutoFilter("B".$newQtdColumns.":".$columnEnd.$newQtdColumns);
            }

            // if(isset($config["height"])){
            //     $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight($config["height"]);
            // }

            if(isset($config["width"])){
                foreach ($keyExcel as $colu)
                {
                    $spreadsheet->getActiveSheet(0)->getColumnDimension($colu)->setWidth($config["width"]);
                }
            }
            //Iniciar com zoom 75
            $spreadsheet->getActiveSheet(0)->getSheetView()->setZoomScale(75);

            return ["success" => true, "document" => $spreadsheet];
        }
        catch (\Exception $e)
        {
            return ["success" => true, "message" => "Erro ao gerar arquivo ".$e];
        }

    }

}
