<?
#xls_file/order_test_excel.xlsx

include "../_header.php";

require_once "../Classes/PHPExcel.php";
$objPHPExcel = new PHPExcel();

$filename = '../xls_file/1_1.xls'; // 엑셀 파일의 경로와 파일명
//$filename = '../xls_file/order_test_excel.xlsx'; // 엑셀 파일의 경로와 파일명

//파일로그 시작
$logFilename = dirname(__FILE__)."/../logs/debug".date("ymd")."_order_excel_add.txt";
$fileHandler = fopen($logFilename , "a");
// PHPExcel은 메모리를 사용하므로 메모리 최대치를 늘려준다.

// 이부분은 엑셀파일이 클때는 적절히 더욱 늘려줘야 제대로 읽어올수 있다.
ini_set('memory_limit', '2048M');

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

        // 날짜 형태의 셀을 읽을때는 toFormattedString를 사용한다.
        $b = PHPExcel_Style_NumberFormat::toFormattedString($b, 'YYYY-MM-DD');

        // echo $a . " / " . $b. " / " . $c . " / " . $d . " / " . $e . " / " . $f . " / " . $g . " <br>\n";

        $b  = addslashes($b);
        $c  = addslashes($c);
        $d  = addslashes($d);
        $e  = addslashes($e);
        $f  = addslashes($f);
        $g  = addslashes($g);
        
        $order_qry="select count(no) as order_cnt from order_list where ordno='".$f."' and goodsnm='".$n."' and invoice='".$h."'";
        $order_res=$db->query($order_qry);
        $order_count=$order_res->results[0]['order_cnt'];
        if(!$order_count){
            //몰번호 구하기.
            $mall_sql="select no, mall_name from mall_list where mall_name='".$g."' limit 1";
            $mall_res=$db->query($mall_sql);
            $mall_no=$mall_res->results[0]['no'];
            $mall_name=$mall_res->results[0]['mall_name'];
            $error="";
            if(!$mall_no) $error[]=$excelRow." / mall_no 없음";

            //상품번호 구하기.
            $goods_sql="select no, goodsnm from goods where goodsnm='".$n."' limit 1";
            $goods_res=$db->query($goods_sql);
            $goods_no=$goods_res->results[0]['no'];
            $goods_name=$goods_res->results[0]['goodsnm'];
            if(!$goods_no) $error[]=$excelRow." / goods_no 없음";
            //order_cost 구하기
            $GOODS=NEW goods();
            $order_cost= $GOODS->calc_stock($goods_no,$q);
            
            $query = "insert into order_list set
            ordno='".$f."'
            ,ori_ordno='".$f."'
            ,bundle='0' 
            ,mall_name='".$g."'
            ,mall_no='".$mall_no."'
            ,ord_date='".$c."'
            ,reg_date='".$b."'
            ,mod_date=''
            ,step='5'
            ,step2='0'
            ,mall_goodsnm='".$o."'
            ,goodsnm='".$n."'
            ,ori_goodsnm='".$n."'
            ,goodsno='".$goods_no."'
            ,order_num='".$q."'
            ,return_num='0'
            ,exchange_num='0'
            ,order_price='".str_replace(",","",$r)."'
            ,settle_price='".str_replace(",","",$r)."'
            ,order_cost='".$order_cost."'
            ,deli_price='0'
            ,deli_codeno='1' 
            ,buyer='".$t."'
            ,receiver='".$t."'
            ,buyer_mobile='".$v."'
            ,mobile='".$u."'
            ,zipcode='".$w."'
            ,address='".$x."'
            ,commission='0'
            ,order_memo='".$ab."'
            ,courier_code='CJGLS'
            ,invoice='".$h."'
            ,return_courier_code=''
            ,return_invoice=''
            ,memo=''
            ,copy_seq='0'
            ,upload_form_type='사방넷'
            ,reorder_yn='n'
            ";
            if(!$db->query($query))$error[]=$excelRow." / insert 오류";
            
            if($error){
                @fwrite ($fileHandler, "==================START ".$excelRow." : (".$f.")==================");
                @fwrite ($fileHandler, "\r\n");
                @fwrite ($fileHandler, print_r($error,true) );
                @fwrite ($fileHandler, "==================END ".$excelRow." : (".$f.")==================");
                @fwrite ($fileHandler, "\r\n");
                tydebug($error);
            }
        }
    }
    @fclose ($fileHandler);
   //echo $maxRow-1 . " Data inserting finished !";

} catch (exception $e) {
    echo '엑셀파일을 읽는도중 오류가 발생하였습니다.!';
}

?>