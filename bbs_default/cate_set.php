<?
include "../_header.php";

	$popup_chk=1;

	$board_id = $_REQUEST['board_id'];

	$query = "select * from board_cate where board_id= '".$board_id."' order by state, cate_name";
	$result = $db->query($query);

	foreach($result->results as $v){

		$data[]=$v;
	}
	
	
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && eregi(getenv("HTTP_HOST"),getenv("HTTP_REFERER") ) ){

		if($_POST['mode']=='ins'){

			foreach($_POST['cate'] as $k => $v){

				$qry = "update board_cate set
				cate_name = '".$v."'
				where sn='".$k."'
				and board_id = '".$board_id."'
				";
				
				$db->query($qry);
			}

			foreach($_POST['add_cate'] as $k => $v){

				$chk_qry = "select count(1) cnt from board_cate
				where board_id = '".$board_id."'
				and cate_name = '".$v."'
				";

				$res = $db->query($chk_qry);
				$chk_cnt=$res->results['0']['cnt'];

				if($v && $chk_cnt==0){

					$qry = "insert into board_cate set
					board_id = '".$board_id."'
					,cate_name = '".$v."'
					";
					//tydebug($qry);
					$db->query($qry);
				}
			}

		}else if($_POST['mode']=='del'){

			$qry = "update board_cate set
				state  = 'delete'
				where sn='".$_POST['sn']."'
				";
				//tydebug($qry);
				$db->query($qry);
		}

		echo "<script>document.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
		die;
	}

$tpl->assign(array('loop'=>$data));
$tpl->print_('tpl');
?>
