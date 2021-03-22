<?
include "../_header.php";member_chk();

$catelist=get_cate_info();

/*기존 카테고리 셀렉트박스*/
$category_1=$_REQUEST['category_1']?$_REQUEST['category_1']:"000";
$category_2=$_REQUEST['category_2']?$_REQUEST['category_2']:"000";

$selected['category_1'][$_POST['category_1']]="selected";
$selected['category_2'][$_POST['category_2']]="selected";


/*카테고리 셀렉트박스 동적 추가*/
$total_cnt = $_POST['total_cnt']? $_POST['total_cnt']:1;
$sel_cnt = $total_cnt+1; //다음 카테고리 번호 (+, - 할때)
echo "cnt =>>".$total_cnt."  /  ".$sel_cnt."<br>";
$idx = $_POST['idx_arr'];
// vscode
$category1_1=$_REQUEST['category1_1']?$_REQUEST['category1_1']:"000";
$category1_2=$_REQUEST['category1_2']?$_REQUEST['category1_2']:"000";

$idx_arr = explode(",", $idx);

if($total_cnt >1){
	$i = 2;
	foreach($idx_arr as $k => $v){

		${'category'.$i.'_1'} = $_POST['category'.$v.'_1'] ? $_POST['category'.$v.'_1'] : '000';
		${'category'.$i.'_2'} = $_POST['category'.$v.'_2'] ? $_POST['category'.$v.'_2'] : '000';

		$i++;
	}
}

if($total_cnt){
echo "post -> category <br>";
echo "category1 : ".$category1_1."  /  ".$category1_2."<br>";
echo "category2 : ".$category2_1."  /  ".$category2_2."<br>";
echo "category3 : ".$category3_1."  /  ".$category3_2."<br>";
echo "category4 : ".$category4_1."  /  ".$category4_2."<br>";
echo "category5 : ".$category5_1."  /  ".$category5_2."<br>";
print_r($select);
}



/* 카테고리 셀렉트 정보 저장*/



//db에서 가져온 예시 데이터라고 치자
/*
$c1_1 = '001'; $c1_2 = '001';
$c2_1 = '001'; $c2_2 = '002';
$c3_1 = '002'; $c3_2 = '002';
$c4_1 = '003'; $c4_2 = '003';
$c5_1 = '004'; $c5_2 = '004';
*/



$tpl->assign(array(	
	'catelist'=>$catelist
));


$tpl->print_('tpl');
?>