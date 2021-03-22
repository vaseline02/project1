<?
include "../_header.php";

$page_title='상품 상세정보관리';

$returnUrl=$_REQUEST['returnUrl']?$_REQUEST['returnUrl']:$_SERVER['REQUEST_URI'];

$catelist=get_cate_info();

$category_1=$_REQUEST['category_1']?$_REQUEST['category_1']:"000";
$category_2=$_REQUEST['category_2']?$_REQUEST['category_2']:"000";
$category_3=$_REQUEST['category_3']?$_REQUEST['category_3']:"000";
$category_4=$_REQUEST['category_4']?$_REQUEST['category_4']:"000";
$selected['category_1'][$_POST['category_1']]="selected";
$selected['category_2'][$_POST['category_2']]="selected";
$selected['category_3'][$_POST['category_3']]="selected";
$selected['category_4'][$_POST['category_4']]="selected";


$s_cate=$category_1.$category_2.$category_3.$category_4;
//if($s_cate!='000000000000')$add_where[]="gl.category='".$s_cate."'";


if($_FILES){
	$excel_data=excel_read('unlink','7');

	//데이터 검증
	if(count($excel_data)>0){
        foreach($excel_data as $k=>$v){
			
			if($k!='7')if(!$v['0'])$err_msg[]=$k."번열 상품고유코드가 존재하지않습니다.";            
            
		}

		if (sizeof($err_msg) > 0) {
			tydebug($err_msg);
		}else{

			/*상세정보필터*/
			$spec_filter=spec_filter();
			
			try{
				
                $db->beginTransaction();
				foreach($excel_data as $k=>$v){

					if($k=='7'){
						
						for($i=0;$i<100;$i++){
							if($v[$i]!=''){
								$excel_colnm[$i]=$v[$i];
							}
						}
					}else{

						$param="";

						unset($qr);
						foreach($excel_colnm as $eck=>$ecv){

							$qr[]=$ecv."=:".$ecv;
							$param[":".$ecv]=$v[$eck];
						}

						$qr=implode(",",$qr);

						foreach($spec_filter as $sfk=>$sfv){

							if($param[":".$sfk]){
								
								$tmp_exp=explode("|",$param[":".$sfk]);

								foreach($tmp_exp as $tev){
									if(!in_array($tev,$sfv)){

										$msg[]=$k."열 ".$sfk." ".$tev." 정보없음.";
							
										continue 3;
									}
								}
							}
						}

						$qry="select * from goods_info where goodsno='".$v[0]."'";
						$res=$db->query($qry);
						$ginfo_data=$res->results;
						if($ginfo_data){
							if(in_array('consumer_price',$excel_colnm) && ($ginfo_data[0]['consumer_price']!=$param[":consumer_price"])){
								$lqry="insert into goods_info_log set
								goods_no='".$v[0]."'
								,colum_name='consumer_price'
								,b_data='".$ginfo_data[0]['consumer_price']."'
								,a_data='".$param[":consumer_price"]."'
								,admin_no='".$_SESSION["sess"]["m_no"]."'
								,admin_name='".$_SESSION["sess"]["name"]."'
								,reg_date=now()
								";
								$db->query($lqry);
							}
				
							$uqry="update goods_info set 
							".$qr."
							where goodsno=:goodsno
							";
							$param[":goodsno"]=$v[0];
							$db->query($uqry, $param);
				
						}else{
							
							$iqry="insert into goods_info set 
							goodsno=:goodsno
							,".$qr."
							";
							$param[":goodsno"]=$v[0];
					   
							$db->query($iqry, $param);
						}

                    }
				}


				//$db->rollBack();
                $db->commit();
                if($msg){
					tydebug($msg);
					//echo "<button type='button' onclick='history.go(-1)'>확인완료</button>";
				}else{
					msg('처리되었습니다.',$returnUrl);
				}
			}
			catch( Exception $e ){
				tydebug('err');
				$db->rollBack();
				tydebug($e->getMessage().":".$e->getFile());	
			}
		
        }        
    }
}

$s_res=get_search_where();
if($s_res['where']){
	
	foreach($s_res['where'] as $v){
		$add_where[]=$v;
	}
}



if(count($add_where)>1){
    $add_where_imp=" and ".implode(" and ",$add_where);
}

if($_REQUEST['mode']=='cate_ins'){
	
	
	if($_POST['category_1'] && $_POST['category_2']){

		$qry="select no,depth_1,depth_2,depth_3,depth_4 from category where 
		depth_1=:depth_1
		and depth_2=:depth_2
		and depth_3=:depth_3
		and depth_4=:depth_4
		";
		
		$param[':depth_1']=($_POST['category_1'])?$_POST['category_1']:"000";
		$param[':depth_2']=($_POST['category_2'])?$_POST['category_2']:"000";
		$param[':depth_3']=($_POST['category_3'])?$_POST['category_3']:"000";
		$param[':depth_4']=($_POST['category_4'])?$_POST['category_4']:"000";
		
		$ins_category=$param[':depth_1'].$param[':depth_2'].$param[':depth_3'].$param[':depth_4'];
		$res = $db->query($qry,$param);

		$data=$res->results['0'];

		$s_paste=paste_to_arr($_REQUEST['s_paste']);

		if($_REQUEST['s_brand'] && !$s_paste){
			$gnqry="select goodsnm from goods g join brand b on b.no=g.brandno where b.brandnm='".$_REQUEST['s_brand']."' ";	
			$gnres=$db->query($gnqry);

			foreach($gnres->results as $gnv){
				
				$s_paste[]=$gnv['goodsnm'];
			}
		}
	
		if($data['no'] && $s_paste){
			
			foreach($s_paste as $v){
				unset($param);
				$qry="insert into goods_link set
				goodsno=(select no from goods where goodsnm=:goodsnm)
				,cateno=:cateno
				,category=:category
				on duplicate key update category=:upcategory
				";
				
				$param[':goodsnm']=$v;
				$param[':cateno']=$data['no'];
				$param[':category']=$ins_category;
				$param[':upcategory']=$ins_category;
				
				if($res = $db->query($qry,$param)){
					
				}
			}

			msg('처리되었습니다.');
			
		}else{
			msg("카테고리를 설정해주세요.");
		}

	}else{
		msg("카테고리를 설정해주세요.");
	}
	
}

if($add_where_imp){
		
	/*스펙필터*/
	$qry="select no,goods_info from category where depth_1=:depth_1 and depth_2='000'";
	$res = $db->query($qry,array(":depth_1"=>$_POST['category_1']));
    
	foreach($res->results as $v){
		$sfilter=$v['goods_info'];
	}
	
	if($sfilter){
		$ex_sfilter=explode(":",$sfilter);
		
		$sfilter_data=explode("|",$ex_sfilter[0]);
		$sfilter_sort=explode("|",$ex_sfilter[1]);

		$orderby=" order by case";

		foreach($sfilter_data as $k=>$v){
			
			$orderby.=" when no='".$v."' then  ".$sfilter_sort[$k]." ";
		}
		$orderby.=" else 1000 end";
	}
		
	/*제품속성*/
	$qry="select * from category_goods_info where no in ('".str_replace("|","','",$ex_sfilter[0])."')
	".$orderby."
	";
	$res = $db->query($qry);

	foreach($res->results as $v){
//		$info_name=$cfg_goods_info[$_POST['category_1']][$v['colum_name']]?$cfg_goods_info[$_POST['category_1']][$v['colum_name']]:$v['info_name'];
		$gi[$v['colum_name']]=$cfg_goods_info[$_POST['category_1']][$v['colum_name']]?$cfg_goods_info[$_POST['category_1']][$v['colum_name']]:$v['info_name'];
		$use_filter[$v['colum_name']]=$v['use_filter'];
	}

	/*리스트*/
    $qry="select g.*, b.brand_img_folder, b.brandnm, (select count(no) from goods_barcode gb where gb.goodsno=g.no ) as barcodecnt, gi.* 
	,c.catenm
	from goods g 
	left join goods_link gl on gl.goodsno=g.no
    left join brand b on g.brandno = b.no	
    left join goods_info gi on g.no=gi.goodsno
	left join goods_cnt_loc gcl on g.no=gcl.goodsno
	left join category c on gl.cateno=c.no
    where 1=1 ".$add_where_imp;
   
    $res = $db->query($qry);
   
	foreach($res->results as $v){
		
		$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
		
        //$v['img_url']=img_url($cfg['img_600_logo'],$v['brand_img_folder'],$v['goodsnm']);

		foreach($gi as $key=>$val){
			$v['spec_data'][$key]=$v[$key];
		}

		$loop[$v['goodsnm']]=$v;
    }
    
    //붙여넣기가 있으면 붙여넣기 순서로 재정렬
    if($_REQUEST['s_paste']){
        
        $paste_arr = paste_to_arr($_REQUEST['s_paste']);
        foreach($paste_arr as $v){

            if($loop[$v]){
                $tmp_arr[]=$loop[$v];
                unset($loop[$v]);
            }
        }
        $loop=$tmp_arr;
    }

}


$tpl->assign(array(	
'loop' => $loop
,'catelist'=>$catelist
,'gi'=>$gi
));
$tpl->print_('tpl');
?>
