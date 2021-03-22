<?
//상품명 유효성 확인
include "../_header.php";

	$GOODS=new goods();
	$chk_goods=$GOODS->get_goodsno($_POST['goodsnm']);

	if($chk_goods){
		echo "1";
	}else{
		echo "0";
	}

?>