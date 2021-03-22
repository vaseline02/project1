<?
#xls_file/order_test_excel.xlsx

include "../_header.php";

require_once "../Classes/PHPExcel.php";
$objPHPExcel = new PHPExcel();
$year="2020";
$filename = '../xls_file/company_order/202008.xls'; // 엑셀 파일의 경로와 파일명
//$filename = '../xls_file/order_test_excel.xlsx'; // 엑셀 파일의 경로와 파일명

//파일로그 시작
// PHPExcel은 메모리를 사용하므로 메모리 최대치를 늘려준다.

// 이부분은 엑셀파일이 클때는 적절히 더욱 늘려줘야 제대로 읽어올수 있다.
ini_set('memory_limit', '2048M');
exit;
try {
    // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
    $objReader = PHPExcel_IOFactory::createReaderForFile($filename);

    // 읽기전용으로 설정
    $objReader->setReadDataOnly(true);

    // 엑셀파일을 읽는다
    $objExcel = $objReader->load($filename);

    // 첫번째 시트를 선택
    $objExcel->setActiveSheetIndex(0);

    $objWorksheet = $objExcel->getActiveSheet();

    $rowIterator = $objWorksheet->getRowIterator();

    foreach ($rowIterator as $row) {
               $cellIterator = $row->getCellIterator();
               $cellIterator->setIterateOnlyExistingCells(false);
    }

    $maxRow = $objWorksheet->getHighestRow();

    // echo $maxRow . "<br>";

    for ($excelRow = 2 ; $excelRow <= $maxRow ; $excelRow++) {

        $a = $objWorksheet->getCell('A' . $excelRow)->getValue(); // A열
        $b = $objWorksheet->getCell('B' . $excelRow)->getValue(); // B열 
        $c = $objWorksheet->getCell('C' . $excelRow)->getValue(); // C열 
        $d = $objWorksheet->getCell('D' . $excelRow)->getValue(); // D열
        $e = $objWorksheet->getCell('E' . $excelRow)->getValue(); // E열 
        $f = $objWorksheet->getCell('F' . $excelRow)->getValue(); // F열
        $g = $objWorksheet->getCell('G' . $excelRow)->getValue(); // G열 
        $h = $objWorksheet->getCell('H' . $excelRow)->getValue(); // H열 
        $i = $objWorksheet->getCell('I' . $excelRow)->getValue(); // I열 
        $j = $objWorksheet->getCell('J' . $excelRow)->getValue(); // J열 
        $k = $objWorksheet->getCell('K' . $excelRow)->getValue(); // K열 
        $l = $objWorksheet->getCell('L' . $excelRow)->getValue(); // L열 
        $m = $objWorksheet->getCell('M' . $excelRow)->getValue(); // M열 
        $n = $objWorksheet->getCell('N' . $excelRow)->getValue(); // N열 
        $o = $objWorksheet->getCell('O' . $excelRow)->getValue(); // O열 
        $p = $objWorksheet->getCell('P' . $excelRow)->getValue(); // P열 
        $q = $objWorksheet->getCell('Q' . $excelRow)->getValue(); // Q열 
        $r = $objWorksheet->getCell('R' . $excelRow)->getValue(); // R열 
        $s = $objWorksheet->getCell('S' . $excelRow)->getValue(); // S열 
        $t = $objWorksheet->getCell('T' . $excelRow)->getValue(); // T열 
        $u = $objWorksheet->getCell('U' . $excelRow)->getValue(); // U열 
        $v = $objWorksheet->getCell('V' . $excelRow)->getValue(); // V열 
        $w = $objWorksheet->getCell('W' . $excelRow)->getValue(); // W열 
        $x = $objWorksheet->getCell('X' . $excelRow)->getValue(); // X열 
        $y = $objWorksheet->getCell('Y' . $excelRow)->getValue(); // Y열 
        $z = $objWorksheet->getCell('Z' . $excelRow)->getValue(); // Z열 
        $aa = $objWorksheet->getCell('AA' . $excelRow)->getValue(); // AA열 
        $ab = $objWorksheet->getCell('AB' . $excelRow)->getValue(); // AB열 
        $ac = $objWorksheet->getCell('AC' . $excelRow)->getValue(); // AC열 
        $ad = $objWorksheet->getCell('AD' . $excelRow)->getValue(); // AD열 
        $ae = $objWorksheet->getCell('AE' . $excelRow)->getValue(); // AE열 
        $af = $objWorksheet->getCell('AF' . $excelRow)->getValue(); // AE열 
        $ag = $objWorksheet->getCell('AG' . $excelRow)->getValue(); // AG열 
        $ah = $objWorksheet->getCell('AH' . $excelRow)->getValue(); // AH열 
        $ai = $objWorksheet->getCell('AI' . $excelRow)->getValue(); // AI열 
        $aj = $objWorksheet->getCell('AJ' . $excelRow)->getValue(); // AJ열 

        $qry="insert into t_order_list_excel_b set
        a='".$a."'
        ,b='".$b."'
        ,c='".$c."'
        ,d='".$d."'
        ,e='".$e."'
        ,f='".$f."'
        ,g='".$g."'
        ,h='".$h."'
        ,i='".$i."'
        ,j='".$j."'
        ,k='".$k."'
        ,l='".$l."'
        ,m='".$m."'
        ,n='".$n."'
        ,o='".$o."'
        ,p='".$p."'
        ,q='".$q."'
        ,r='".$r."'
        ,s='".$s."'
        ,t='".$t."'
        ,u='".$u."'
        ,v='".$v."'
        ,w='".$w."'
        ,x='".$x."'
        ,y='".$y."'
        ,z='".$z."'
        ,aa='".$aa."'
        ,ab='".$ab."'
        ";
        $db->query($qry);
    }
   echo $maxRow-1 . " Data inserting finished !";

} catch (exception $e) {
    echo '엑셀파일을 읽는도중 오류가 발생하였습니다.!';
}

?>