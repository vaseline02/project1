<?//upload_form_type 선택 후 몰 상세정보 리턴
include "../_header.php";


	$qry="select no,mall_name from mall_list where upload_form_type='".$_POST['group_name']."'";
	$res=$db->query($qry);

	$html="";

	foreach($res->results as $v){
		$html.="<option value='".$v['no']."'>".$v['mall_name']."</option>";
	}

	echo $html;
?>