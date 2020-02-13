<?php
// $md = ['product' => "cup", "qty" => 3];
// var_dump($md);

if(file_exists(dirname(__FILE__)."/vendor/autoload.php")){
	require_once dirname(__FILE__)."/vendor/autoload.php";
}
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

require_once __DIR__ . '/vendor/phpoffice/phpspreadsheet/src/Bootstrap.php';
//require __DIR__ . '/vendor/phpoffice/phpspreadsheet/samples/Header.php';
$helper = new Sample();

$inputFileType = 'Xlsx';
$inputFileName = __DIR__ . '/sampleData/SalesReport1.xlsx';

$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory with a defined reader type of ' . $inputFileType);
$reader = IOFactory::createReader($inputFileType);
$helper->log('Turning Formatting off for Load');
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($inputFileName);

$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
var_dump($sheetData);

$db =  new mysqli("localhost", "root", "", "test");
if ($db->connect_errno) {
    die("Database connection failed" . $db->connect_error);
}
for ($i=2; $i < count($sheetData); $i++) { 
    //$values = implode(",", $sheetData[$row]); 
    print_r($sheetData[$i]);
    //$values = substr(implode(" ,", $sheetData[$i]) , 0, -1);
    $res = $db->query("INSERT INTO sales_report()
                    VALUES(NULL,'{$sheetData[$i]['A']}', '{$sheetData[$i]['B']}','{$sheetData[$i]['C']}','{$sheetData[$i]['D']}','{$sheetData[$i]['E']}','{$sheetData[$i]['F']}' )");

}
