<?
include "../_header.php";
ini_set('memory_limit', -1);
ini_set('max_execution_time',0);
exit;
$qry="select no,buyer,receiver,buyer_mobile,mobile,address,email from order_list where reg_date<='2021-01-15' and etc_chk='0' and no not in ('899071','974461') order by no asc
#and no in ('1013304','1013422','1013775','1009998','1009087','1009047','1006656')
";
$res=$db->query($qry);
$i1="0";
foreach($res->results as $v){
	$set="";
	if($v['buyer']!=''){
		$buyer=letterMasking('N',$v['buyer']);
		$set[]="buyer='".$buyer."'";
	}
	
	if($v['receiver']!=''){
		$receiver=letterMasking('N',$v['receiver']);
		$set[]="receiver='".$receiver."'";
	}
		
	if($v['buyer_mobile']!=''){
		$buyer_mobile=letterMasking('P',$v['buyer_mobile']);
		$set[]="buyer_mobile='".$buyer_mobile."'";
	}		
			
	if($v['mobile']!=''){
		$mobile=letterMasking('P',$v['mobile']);
		$set[]="mobile='".$mobile."'";
	}		
		
	if($v['address']!=''){
		$address=letterMasking('A',$v['address']);
		$set[]="address='".$address."'";
	}

	if($v['email']!=''){
		$email=letterMasking('E',$v['email']);
		$set[]="email='".$email."'";
	}

	if($set){
		$set[]="etc_chk='1'";
		$uqry="update order_list set ".implode(",",$set)." where no='".$v['no']."'";
		$db->query($uqry);
		$i1++;
		//tydebug($uqry);
	}

}

$qry="select no,receiver,address,mobile from  cs_info where reg_date <='2021-01-15 23:59:59' and etc_chk='0' and ((receiver!='0' and receiver!='') or address!='' or mobile!='') order by no asc";
$res=$db->query($qry);
$i2=0;
foreach($res->results as $v){
	$set="";
	
	if($v['receiver']!=''){
		$receiver=letterMasking('N',$v['receiver']);
		$set[]="receiver='".$receiver."'";
	}
		
	if($v['mobile']!=''){
		$mobile=letterMasking('P',$v['mobile']);
		$set[]="mobile='".$mobile."'";
	}		
		
	if($v['address']!=''){
		$address=letterMasking('A',$v['address']);
		$set[]="address='".$address."'";
	}

	if($set){
		$set[]="etc_chk='1'";
		$uqry="update cs_info set ".implode(",",$set)." where no='".$v['no']."'";
		$db->query($uqry);
		$i2++;
		//tydebug($uqry);
	}

}

$qry="select no, receipt_name, receiver, mobile, address from as_info where reg_date <='2021-01-15 23:59:59' and etc_chk='0' and no not in ('30650') and (receipt_name!='' or receiver!='' or address!='' or mobile!='') order by no asc";
$res=$db->query($qry);
$i3=0;
foreach($res->results as $v){
	$set="";
	if($v['receipt_name']!=''){
		$receipt_name=letterMasking('N',$v['receipt_name']);
		$set[]="receipt_name='".$receipt_name."'";
	}

	if($v['receiver']!=''){
		$receiver=letterMasking('N',$v['receiver']);
		$set[]="receiver='".$receiver."'";
	}
		
	if($v['mobile']!=''){
		$mobile=letterMasking('P',$v['mobile']);
		$set[]="mobile='".$mobile."'";
	}		
		
	if($v['address']!=''){
		$address=letterMasking('A',$v['address']);
		$set[]="address='".$address."'";
	}

	if($set){
		$set[]="etc_chk='1'";
		$uqry="update as_info set ".implode(",",$set)." where no='".$v['no']."'";
		$db->query($uqry);
		$i3++;
		//tydebug($uqry);
	}

}

echo "주문 : ".$i1.", CS : ".$i2." AS, : ".$i3;

function letterMasking($_type, $_data, $_mode='admin_downmasking_id'){
    /* $_type 값 정의
     * N : 이름
     * P : 전화번호
     * B : 생일
     * A : 주소
     * I : 아이피
     * E : 메일
     * V : 계좌번호
     * S : 3글자뒤로 마스킹
     * 'Z' : 전체마스킹
     * */

    $strlen = mb_strlen($_data, 'utf-8');
    $maskingValue = "";
    $maskingCut="";
    $useHyphen = "-";

    if($_type == 'N'){ //이름
        switch($strlen){
            case 1:
                $maskingValue = mb_substr($_data, 0, 1, "UTF-8");
                break;
            case 2:
                $maskingValue = mb_substr($_data, 0, 1, "UTF-8").'*';
                break;
            default:
                for($i=0;$i<($strlen-2);$i++){
                    $maskingCut.="*";
                }
                $maskingValue = mb_substr($_data, 0, 1, "UTF-8").$maskingCut.mb_substr($_data, $strlen-1, 1, "UTF-8");
                break;
        }
    }else if($_type == 'P'){ //전화번호
        $explode_data=explode('-',$_data);
        if(count($explode_data)>'1'){
            $number_strlen = mb_strlen($explode_data[1], 'utf-8');
            for($i=0;$i<$number_strlen;$i++){
                $maskingCut.="*";
            }
            //$maskingValue = $explode_data[0]."{$useHyphen}{$maskingCut}{$useHyphen}*".mb_substr($explode_data[2], 1, 4, "UTF-8");
			$maskingValue = $explode_data[0]."{$useHyphen}{$maskingCut}{$useHyphen}".$explode_data[2];

        }else{
            switch($strlen){
                case 9:
                    //$maskingValue = mb_substr($_data, 0, 2, "UTF-8")."{$useHyphen}***{$useHyphen}*".mb_substr($_data, $strlen-3, 4, "UTF-8");
					$maskingValue = mb_substr($_data, 0, 2, "UTF-8")."{$useHyphen}***{$useHyphen}".mb_substr($_data, $strlen-4, 4, "UTF-8");
                    break;
                default:
                    //$maskingValue = mb_substr($_data, 0, 3, "UTF-8")."{$useHyphen}****{$useHyphen}*".mb_substr($_data, $strlen-3, 4, "UTF-8");
					$maskingValue = mb_substr($_data, 0, 3, "UTF-8")."{$useHyphen}****{$useHyphen}".mb_substr($_data, $strlen-4, 4, "UTF-8");
                    break;
            }
        }

    }else if($_type == 'B'){ //생일
        $maskingValue = mb_substr($_data, 0, 2, "UTF-8")."**{$useHyphen}**{$useHyphen}**";

    }else if($_type == 'A'){ //주소
        $explode_data=explode(' ',$_data);
        if(count($explode_data)>'1'){
            $number_strlen = mb_strlen($explode_data[3], 'utf-8');
            for($i=0;$i<$number_strlen;$i++){
                $maskingCut.="*";
            }
            $maskingValue = $explode_data[0]." ".$explode_data[1]." ".$explode_data[2]." ".$maskingCut;
        }else {
            for($i=0;$i<($strlen-10);$i++){
                $maskingCut.="*";
            }
            $maskingValue = mb_substr($_data, 0, 10, "UTF-8")." ".$maskingCut;
        }

    }else if($_type == 'I'){//아이피
        $explode_data=explode('.',$_data);
        if(count($explode_data)>'1'){
            $number_strlen = mb_strlen($explode_data[2], 'utf-8');
            for($i=0;$i<$number_strlen;$i++){
                $maskingCut.="*";
            }
            $maskingValue = $explode_data[0].".".$explode_data[1].".".$maskingCut.".".$explode_data[3];

        }else {
            for($i=0;$i<($strlen-6);$i++){
                $maskingCut.="*";
            }
            $maskingValue = mb_substr($_data, 0, 6, "UTF-8")." ".$maskingCut;
        }

    }else if($_type == 'E'){//E메일
        $explode_data=explode('@',$_data);
        if(count($explode_data)>'1'){
            $number_strlen = mb_strlen($explode_data[0], 'utf-8');
            for($i=0;$i<($number_strlen-2);$i++){
                $maskingCut.="*";
            }
            $maskingValue = mb_substr($_data, 0, 2, "UTF-8").$maskingCut."@".$explode_data[1];
        }else {
            for($i=0;$i<($strlen-2);$i++){
                $maskingCut.="*";
            }
            $maskingValue = mb_substr($_data, 0, 2, "UTF-8")." ".$maskingCut;
        }

    }else if($_type == 'V'){//계좌번호
        $explode_data=explode('-',$_data);

        if(count($explode_data)>'1'){
            $for_data=array();
            for($v=0;$v<=(count($explode_data)-1);$v++){
                if($v==(count($explode_data)-1)){
                    $number_strlen = mb_strlen($explode_data[$v], 'utf-8');
                    for($i=0;$i<($number_strlen);$i++){
                        $maskingCut.="*";
                    }
                    $for_data[]=$maskingCut;
                }else if($v==(count($explode_data)-2)){
                    $number_strlen = mb_strlen($explode_data[$v], 'utf-8');
                    $for_data[]=mb_substr($explode_data[$v], 0, $number_strlen-1, "UTF-8")."*";
                }else{
                    $for_data[]=$explode_data[$v];
                }
            }

            $maskingValue = implode($useHyphen,$for_data);
        }else {
            for ($i = 0; $i < ($strlen - 8); $i++) {
                $maskingCut .= "*";
            }
            $maskingValue = mb_substr($_data, 0, 8, "UTF-8").$maskingCut;
        }

    }else if($_type == 'S'){//3글자이상 마스킹
        for($i=0;$i<($strlen-3);$i++){
            $maskingCut.="*";
        }
        $maskingValue = mb_substr($_data, 0, 3, "UTF-8").$maskingCut;

    }else if($_type == 'Z'){//전체마스킹
        for($i=0;$i<($strlen);$i++){
            $maskingCut.="*";
        }
        $maskingValue = $maskingCut;
    }
    return $maskingValue;
}

?>