<?php

class CANCEL{

	function __construct(){
		global $cfg, $db, $pg, $cfg_retrun_type, $cfg_retrun_type_sub, $cfg_send_type;

		$this->cfg = $cfg;
		$this->cfg_retrun_type = $cfg_retrun_type;
		$this->cfg_retrun_type_sub = $cfg_retrun_type_sub;
		$this->cfg_send_type = $cfg_send_type;
		$this->cfg_ing_type = $cfg_ing_type;
        $this->db = $db;
		$this->pg = new page();
        $this->fornum='1';


    }

    function selectClaim($where=array(), $order_by='ci.reg_date desc',$bad_info=0, $page_num='9999999'){
        /*
        if(count($where)){
            $add_where=" and ".implode(" and ",$where);
        }
*/
		if($bad_info){
			$add_qry=",cb.no cb_seq";
			$add_join=" left join cs_bad cb on cd.no=cb.cs_detail_no ";
		}

		$field="ci.return_type,ci.return_type_sub,ci.return_invoice, ci.return_delivery_code, ci.receipt, ci.account_code, ci.account_number,ci.goods_bad_memo
        , cd.*
        , ol.courier_code, ol.invoice, ol.order_num, ol.goodsnm, ol.order_num, ol.mall_no, ol.mall_name, ol.step, ol.step2, ol.step2, ol.deli_codeno, ol.order_cost, ol.buyer, ol.receiver, ol.mobile, ol.upload_form_type
        , g.img_name
        , b.brand_img_folder
        , exg.exchange_brand_img_folder, if(exg.exchange_goodsnm,exg.exchange_goodsnm,cd.exchange_goods_nm) as exchange_goodsnm, exg.exchange_img_name
        , m.id, m.name
		, ol2.no as ex_no, ol2.ordno as ex_ordno, ol2.invoice as ex_invoice, ol2.courier_code as ex_courier_code, ol2.deli_codeno as ex_deli_codeno
        ".$add_qry;
		$db_table="cs_info ci
        left join cs_detail cd on (ci.no=cd.cs_info_no)
        left join order_list ol on (cd.order_list_no=ol.no)
        left join goods g on (cd.goods_no=g.no) 
        left join brand b on (g.brandno = b.no)	
        left join member m on (ci.admin_no=m.no)
        left join (
            select  g.no, g.img_name as exchange_img_name, b.brand_img_folder as exchange_brand_img_folder, g.goodsnm as exchange_goodsnm from goods g 
            left join brand b on (g.brandno = b.no)
            ) exg on (cd.exchange_goods_no=exg.no)
		left join order_list ol2 on (ol2.csno=cd.no)
		".$add_join;
		$this->pg=new page($_GET[page],$page_num);
		$this->pg->field = $field;
		$this->pg->setQuery($db_table,$where,$order_by);
		$this->pg->exec();
        $qry=$this->pg->query;
        // tydebug1($qry);
        $res = $this->db->query($qry);        

        $bf_ordno='';
        $color_key=0;
        foreach($res->results as $v){

			if($v['csno']){
				//$rqry="select * from order_list ol where ol.";
            }
            
            if($v['ex_deli_codeno']>0){
                $cqry="select * from codedata c where c.no='".$v['ex_deli_codeno']."'";
                $cres = $this->db->query($cqry);
                $v['ex_delinm']=$cres->results[0]['cd'];
                
			}

	    $v['mall_name']=chk_mallnm($v['mall_name']);

            if($bf_ordno!=$v['order_no']){
                $bf_ordno=$v['order_no'];
                $color_key++;
            }
            $v['line_color']="table_tr".$color_key%2;
            
            $v['return_type_nm']=$this->cfg_retrun_type[$v['return_type']];
            if($v['return_type_sub'])$v['return_type_nm'].="(".$this->cfg_retrun_type_sub[$v['return_type']][$v['return_type_sub']].")";
            $v['send_type_nm']=$this->cfg_send_type[$v['send_type']];

            $v['img_url']=img_url($this->cfg['img_600_logo'],$v['brand_img_folder'],$v['img_name'],$v['goodsnm']);
            $v['exchange_img_url']=img_url($this->cfg['img_600_logo'],$v['exchange_brand_img_folder'],$v['exchange_img_name'],$v['exchange_goodsnm']);
            
            if($v['bundle']>0)$v['bundle_color']="red";
            if($v['upload_form_type']=='?????????')$v['mall_name']=$v['upload_form_type'].' '.$v['mall_name'];
            if(isset($v['ing_type'])) $v['ing_type']=$this->cfg_ing_type[$v['ing_type']];
            $loop[]=$v;
        }


        return $loop;
    }

	function pg_return(){
		return $this->pg;
	}

    //send_type ????????????
    function stepChange($no, $code){
        if($code=='4' || $code=='21'){
            $set=",end_reg_date=now()";
        }else if($code=='3'){
            $set=",in_reg_date=now()";
        }

        $qry="update cs_detail set send_type=:send_type ".$set." where no=:no";

        $param[":send_type"]=$code;
        $param[":no"]=$no;

        $this->stepChangeLog($no, $code);

        if(!$this->db->query($qry,$param)){            
            throw new Exception('?????????????????? ???????????????.(CLAIM)', 1);
        }
    }
    //???????????? ????????? ?????? ?????? ??????
    function stockChange($no, $loc_f, $oi_type){
        $where[]="cd.no='".$no."'";
        $data=$this->selectClaim($where);

		#????????????????????? ???????????? ??????????????????
		if($data[0]['deli_codeno']=="outside"){
			$this->outside_ins($data[0]["no"], $data[0]['order_list_no'], $data[0]['goodsnm'], $data[0]['exchange_goods_num'], $oi_type);
		}else{
			//??????????????????
			$psd_stock=goods_psd_stock($data[0]["goods_no"]);
			//????????? ?????????????????? ????????????
			if($psd_stock<=0){
				goods_soldout_log("3",$data[0]["goods_no"],$data[0]["exchange_goods_num"]);
			}
	        $okd=stock_io($oi_type,$data[0]["goods_no"],$data[0]["goodsnm"],$data[0]["exchange_goods_num"],$data[0]["no"],$_SERVER['REQUEST_URI'],$loc_f);

			guadmin_stock_ctl($data[0]["goods_no"],$data[0]["exchange_goods_num"],$loc_f,'in',$data[0]["order_list_no"],'??????/????????????');
		}
    }

	function outside_ins($csDetailno, $orderListno, $goodsnm, $returnNum, $oi_type){

		$iqry="insert into outside_return_log set
		order_list_no='".$orderListno."'
		,cs_detail_no='".$csDetailno."'
		,goodsnm='".$goodsnm."'
		,goods_num='".$returnNum."'
		,type='".$oi_type."'
		,reg_date=now();
		";
		$this->db->query($iqry);
	}

    //?????????
    function exchangeSend($no, $scode='cs_exchange'){

        //cs?????? ????????????????????? ??????????????? ????????? ????????????
        $cqry="select cd.no as cno, cd.exchange_stock_yn, sil.* from cs_detail cd 
        join stock_io_log sil on (cd.no=sil.reference_no)
        where cd.no='".$no."' and sil.io_type='cs_hold' and sil.loc_f='".$this->cfg['hold_loc']."' order by cd.no desc limit 1";

        $cres=$this->db->query($cqry);
        $cdata=$cres->results[0];

        if($cdata['no']){
            $this->orderIns($no, $scode, $cdata['loc_f']);
            stock_io($scode,$cdata["goodsno"],$cdata["goodsnm"],-$cdata["cnt"],$cdata["reference_no"],$_SERVER['REQUEST_URI'],$cdata['loc_f'],'0',$cdata['exchange_stock_yn']);
        }else{
            throw new Exception('?????????????????? ???????????????.(STOCK)', 1);
        }

    }

	//?????????
    function exchangeStockOut($no, $scode='cs_exchange', $place_code){

	    //cs?????? ????????????????????? ??????????????? ????????? ????????????
        $cqry="select cd.* from cs_detail cd 
        where cd.no='".$no."' order by cd.no desc limit 1";

        $cres=$this->db->query($cqry);
        $cdata=$cres->results[0];

        if(($cdata['no'] && $cdata["exchange_goods_no"] && $cdata["exchange_goods_nm"] && $cdata["exchange_goods_num"]) || $place_code=='not_stock' || $place_code=='outside'){
            
            if($place_code=='not_stock'){
                $this->orderIns($no, $scode, $place_code);
            }else if($place_code=='outside'){
                $this->orderIns($no, $scode, $place_code);
            }else{
                $this->orderIns($no, $scode, $place_code);

				stock_io($scode,$cdata["exchange_goods_no"],$cdata["exchange_goods_nm"],-$cdata["exchange_goods_num"],$no,$_SERVER['REQUEST_URI'],$place_code,'0',$cdata['exchange_stock_yn']);
				
				//???????????? ????????????
				guadmin_stock_ctl2($cdata["exchange_goods_no"],$cdata["exchange_goods_num"],$place_code,'out',$cdata["order_list_no"],'????????????',$cdata['diff_price']);
            }
        }else{
            throw new Exception('?????????????????? ???????????????.(STOCK)', 1);
        }
    }

    //?????? ????????? ??????
    function orderIns($no, $scode, $place_code=''){
        $oqry="select cd.*, ci.order_no, ci.ori_order_no, ci.receiver, ci.zipcode, ci.address, ci.mobile, ci.delivery_type, ci.delivery_price, ci.return_invoice,
        ol.mall_name, ol.mall_no as olmall_no, ol.order_price, ol.settle_price, ol.ori_ordno, ol.upload_form_type, if(g.goodsnm,g.goodsnm,cd.exchange_goods_nm)as goodsnm from cs_detail cd
        join cs_info ci on (cd.cs_info_no=ci.no)
        left join order_list ol on (cd.order_list_no=ol.no)
        left join goods g on(cd.exchange_goods_no=g.no)
        where cd.no='".$no."' limit 1";
        $ores=$this->db->query($oqry);
        $odata=$ores->results[0];
        if(!$odata['no']){
            throw new Exception('?????????????????? ???????????????.(ORDER)', 1);
        }

        $sqry="select no from order_list ol where csno='".$odata['no']."'";
        $sres=$this->db->query($sqry);
        $sdata=$sres->results[0];

        if($sdata['no']){
            throw new Exception('??????????????? ???????????? ????????????.(NEW_ORDER)', 1);
        }

        $GOODS=NEW goods();
        //??????????????? ????????????????????? ?????? ??????
        if($place_code!='outside' && $place_code!='not_stock') $order_cost= $GOODS->calc_stock($odata['exchange_goods_no'],$odata['exchange_goods_num']);
		else $order_cost="";
        
        $qr="
        csno=:csno
        ,ordno=:ordno
        ,ori_ordno=:ori_ordno
        ,mall_name=:mall_name
        ,mall_no=:mall_no
        ,bundle='0'
        ,step=:step
        ,step2='0'
        ,ord_date=now()
        ,reg_date=now()
        ,mall_goodsnm=:mall_goodsnm
        ,goodsnm=:goodsnm
        ,goodsno=:goodsno
        ,order_num=:order_num
        ,order_price=:order_price
        ,settle_price=:settle_price
        ,order_cost=:order_cost
        ,buyer=:buyer
        ,receiver=:receiver
        ,buyer_mobile=:buyer_mobile
        ,mobile=:mobile
        ,zipcode=:zipcode
        ,address=:address
        ,upload_form_type=:upload_form_type
        ,reorder_status=:reorder_status
        ,deli_codeno=:deli_codeno
        ";
/*
        if($odata["exchange_stock_yn"]=='n'){
            $param[":step"]='6';
        }else{
            $param[":step"]='4';
        }
  */      

        if($place_code=='not_stock'){
            $param[":step"]='55';
            $place_code="????????????";
        }else{
			if($scode=='cs_send'){
				$param[":step"]='70';
			}else{
				$param[":step"]='50';
			}
        }
            

        if($odata['ori_ordno']){
            $ordno=$odata['ori_ordno'];
        }else{
            $ordno=$odata['order_no'];
        }
        
        if($scode=='re_order'){
            $mall_goodsnm="???????????????";
            $qr.=",reorder_yn=:reorder_yn";
            $param[":reorder_yn"]='y';
        }else if($scode=='cs_send'){
			$ordno.='-'.date('Ymd');
            $mall_goodsnm="??????";
        }else{
            $ordno.='-'.date('Ymd');
            $mall_goodsnm="????????????";
        }
        
        $param[":csno"]=$odata['no'];
        $param[":ordno"]=$ordno; 
        $param[":ori_ordno"]=$odata['ori_ordno']; 
        $param[":mall_name"]=$odata['mall_name'];
        $param[":mall_no"]=$odata['olmall_no'];
        $param[":mall_goodsnm"]=$mall_goodsnm; 
        $param[":goodsnm"]=$odata['goodsnm'];
        $param[":goodsno"]=$odata['exchange_goods_no'];
        $param[":order_num"]=$odata['exchange_goods_num'];
        $param[":order_price"]=($odata['order_price']+$odata['diff_price']); 
        $param[":settle_price"]=($odata['settle_price']+$odata['diff_price']);
        $param[":order_cost"]=$order_cost;
        $param[":buyer"]=$odata['receiver'];
        $param[":receiver"]=$odata['receiver'];
        $param[":buyer_mobile"]=$odata['mobile']; 
        $param[":mobile"]=$odata['mobile'];      
        $param[":zipcode"]=$odata['zipcode'];      
        $param[":address"]=$odata['address'];      
        $param[":upload_form_type"]=$odata['upload_form_type'];      
		$param[":reorder_status"]='1';      
		$param[":deli_codeno"]=$place_code;      
        
        $qry="insert into order_list set 
        ".$qr."
        ";

        $this->fornum++;   

        if(!$this->db->query($qry,$param)){
            throw new Exception('?????????????????? ???????????????.(ORDER2)', 1);
        }
        
    }

    //??????????????? ?????? ???????????? 
    function cancelStock($no){
        if($no){
            
            if($file){
                $qry="select IFNULL(sum(cd.exchange_goods_num),'0') as cnt, cd.order_list_no from cs_info ci
                join cs_detail cd on(ci.no=cd.cs_info_no)
                where cd.order_list_no=(select order_list_no from cs_detail where no='".$no."' limit 1) 
                and cd.send_type='4'";

                $res=$this->db->query($qry);
                $data=$res->results[0];

                if($data['order_list_no']){
					//??????
					if($data['return_type']=='60'){
						$type="return_num";
					//??????
					}else if($data['return_type']=='70'){
						$type="exchange_num";
					}

                    $qry="update order_list set ".$type."='".$data['cnt']."' where no='".$data['order_list_no']."'";
                    $this->db->query($qry);
                }
            }
        }
    }

    function badIns($no, $oi_type='', $place_code='1'){
		$GOODS=NEW goods();

        $where[]="cd.no='".$no."'";
        $data=$this->selectClaim($where);

		//???????????????		
		$order_cost=$data[0]['order_cost'];

		for($i=0;$i<$data[0]['exchange_goods_num'];$i++){
			//order_list??? order_cost??????????????? ????????? ???????????????.
			if(strpos($order_cost,'^')===false){
				$order_cost=$this->bad_calc_stock($data[0]['goods_no'],'1');	
			}

			 $qry="insert into cs_bad set
			order_no=:order_no
			,order_list_no=:order_list_no
			,cs_detail_no=:cs_detail_no
			,goods_no=:goods_no
			,goodsnm=:goodsnm
			,quantity=:quantity
            ,reg_date=now()
            ,admin_no=:admin_no
			,step=:step
			,memo=:memo
			,mod_admin_no=:mod_admin_no
			,cost=:cost
			";
			$param[':order_no']=$data[0]['order_no'];
			$param[':order_list_no']=$data[0]['order_list_no'];
			$param[':cs_detail_no']=$data[0]['no'];
			$param[':goods_no']=$data[0]['goods_no'];
			$param[':goodsnm']=$data[0]['goodsnm'];
			//$param['quantity']=$data[0]['exchange_goods_num'];
			$param[':quantity']='1';
			$param[':admin_no']=$_SESSION['sess']['m_no'];
			$param[':memo']=$data[0]['goods_bad_memo'];
			$param[':step']='1';
			$param[':mod_admin_no']=$_SESSION['sess']['m_no'];
			$param[':cost']=$order_cost;
			

            $this->db->query($qry,$param);
            
            //??????????????? ????????? ??????????????? ??????
            stock_io('cs_return',$data[0]["goods_no"],$data[0]["goodsnm"],'1',$data[0]["no"],$_SERVER['REQUEST_URI'],$place_code);
            guadmin_stock_ctl($data[0]["goods_no"],'1',$place_code,'in',$data[0]["order_list_no"],'??????/????????????');
            stock_io('repairing',$data[0]["goods_no"],$data[0]["goodsnm"],'-1',$data[0]["no"],$_SERVER['REQUEST_URI'],$place_code);		
            guadmin_stock_ctl($data[0]["goods_no"],'1',$place_code,'out',$data[0]["order_list_no"],'????????????');
		}     
		
		

		if($data[0]['deli_codeno']=="outside"){
			$this->outside_ins($data[0]["no"], $data[0]['order_list_no'], $data[0]['goodsnm'], $data[0]['exchange_goods_num'], $oi_type);
		}

    }

	function badMod($no,$column,$data,$place_code='1'){

		if(!$no) throw new Exception('?????????????????? ???????????????.(no)', 1);
		if($column=="admin_memo"){
			$data="concat(ifnull(".$column.",''),'".$data." / ')";
		}else if(!is_numeric($data)){
			$data="'".$data."'";			
		}

		foreach($no as $v){

			$sqry="select * from cs_bad where no='".$v."'";
			$sres=$this->db->query($sqry);
			$badData=$sres->results[0];
			$b_step=$badData['step'];

			$uqry="update cs_bad set 
			".$column."=".$data."
			,mod_admin_no='".$_SESSION['sess']['m_no']."'
			,mod_date=now()
			where no='".$v."'";			
			$this->db->query($uqry);

			if($column=="step"){
				//??????????????? ???????????? ????????? ???????????????.
				if($data=="60" || $data=="62"){
					$gqry="select * from goods where goodsnm='".$badData["goodsnm"]."'";
					$gres=$this->db->query($gqry);
					$goodsData=$gres->results[0];

					if(!$goodsData) throw new Exception($badData["goodsnm"].' ????????? ????????????????????????.\n???????????? ??????????????????.', 1);

					if($badData["goods_no"] && $data=="60"){
						//??????????????????
						$psd_stock=goods_psd_stock($badData["goods_no"]);
						//????????? ?????????????????? ????????????
						if($psd_stock<=0){
							goods_soldout_log("3",$badData["goods_no"],$badData["quantity"]);
						}
					}

                    $submess="";
                    if($data=="62") $submess="-refurb  ????????????";
					$this->bad_calc_stock_order($v);
					$okd=stock_io('repaired',$badData["goods_no"],$badData["goodsnm"],$badData["quantity"],$badData["no"],$_SERVER['REQUEST_URI'].$submess,$place_code);
				}

				//???????????? ??????
				$iqry="insert into cs_bad_log set
				bad_no='".$v."'
				,b_step='".$b_step."'
				,a_step=".$data."
				,admin_no='".$_SESSION['sess']['m_no']."'
				,reg_date=now()
				";
				$this->db->query($iqry);
			}

		}
	}


	function order_stock_list($no){
		$sqry="select ol.no as orderNo, ol.order_cost, ol.step, ol.deli_codeno, ol.order_cost, cd.exchange_goods_num from cs_detail cd 
		left join order_list ol on (cd.order_list_no=ol.no)
		where cd.no='".$no."'";

		$sres=$this->db->query($sqry);
		$orderData=$sres->results[0];

		#?????????????????? ?????????????????? order_cost ????????? ??????.
		if($orderData['deli_codeno']!='outside'){
            $ORDER=new order();		

            $ex_cost=explode("|",$orderData['order_cost']);

            $ordcost_array="";
            $return_num=$orderData['exchange_goods_num'];
            foreach($ex_cost as $v){
                $ex_data=explode("^",$v);
                
                if($ex_data[2]>=$return_num){
                    $ordcost_array[]=$ex_data[0]."^".$ex_data[1]."^".$return_num;
                    break;		
                }else{
                    $ordcost_array[]=$ex_data[0]."^".$ex_data[1]."^".$ex_data[2];
                    $return_num-=$ex_data[2];
                }
            }
            $order_cost=implode("|",$ordcost_array);
            
			$ORDER->calc_stock_order_send($order_cost,$orderData['orderNo']);
		}

	}

    // function stockChange($no, $code){

    //     if(!$no && !$code){
    //         throw new Exception('????????? ???????????????.', 1);
    //     }
    //     $qry="select cc.*, ol.deli_codeno from cs_claim cc 
    //     left join order_list ol on (cc.order_list_no=ol.no)
    //     where cc.no='".$no."' ";
    //     $res=$this->db->query($qry);
    //     $data=$res->results[0];


    //     if($data['send_type'] < $code){
    //         for($i=($data['send_type']+1);$i<=$code;$i++){
    //             //????????????(????????? ????????? ????????? ???????????????.)
    //             if($i=='2'){
    //                 //$okd=stock_io('cs_return',$data["goods_no"],$data["mall_goodsnm"],$data["exchange_goods_num"],$data["no"],$_SERVER['REQUEST_URI'],$data["deli_codeno"]);
    //                 //$okd=stock_io('cs_hold',$_POST["exchange_goods_no"][$v],$_POST["exchange_goods_nm"][$v],-$_POST["exchange_goods_num"][$v],$lastNo,$_SERVER['REQUEST_URI'],$deli_codeno,'116');
    //             //????????????(???????????????????????? ???????????? ????????? ???????????????.(??????????????????))
    //             }else if($i=='3'){
    //                 if($data['return_type']>='40' && $data['return_type']<'50'){

    //                 }else{

    //                 }
    //             }
    //         }
    //     }else if($data['send_type'] > $code){
    //         for($i=($data['send_type']-1);$i>=$code;$i--){
    //             //??????(??????????????? ????????? ??????????????? ?????? ????????? ??????.)
    //             if($i=='1'){
                
    //             //????????????(?????????????????? ????????? ??????????????? ??????????????? ????????? ??????????????? ???????????????.(??????????????????))
    //             }else if($i=='2'){
    //                 if($data['return_type']>='40' && $data['return_type']<'50'){

    //                 }else{
                        
    //                 }
    //             }
    //         }
    //     }
    // }

    function stepChangeLog($no,$code){
        $qry="select * from cs_detail where no='".$no."'";
        $res=$this->db->query($qry);
        $data=$res->results[0];

        $param=array(
            ":cs_no"=>$no
            ,":b_code"=>$data['send_type']
            ,":a_code"=>$code
            ,":admin_no"=>$_SESSION['sess']['m_no']            
        );	

        $qry="insert into cs_log set
        cs_no=:cs_no
        ,b_code=:b_code
        ,a_code=:a_code
        ,admin_no=:admin_no
        ,reg_date=now()
        ";
        $this->db->query($qry,$param);
    }

	/*order_cost ???????????? 1.????????????, 2.????????????????????? ??????????????? ????????????*/
	function bad_calc_stock($goodsno,$num){
        $GOODS=NEW goods();
        
        $gqry="select * from goods g where no='".$goodsno."'";
        $gres=$this->db->query($gqry);
        $goods_data=$gres->results[0];

		$cost=$GOODS->avg_price($goodsno);

		$qry="insert into stock_list set
		brandno=:brandno
		,goodsno=:goodsno
		,goodsnm=:goodsnm
		,stock_num=:stock_num
		,now_cnt=:now_cnt
		,cost=:cost
		,state=1
		,memo='???????????????????????? ??????'
		,return_order=1
		,reg_date=now()
		,admin_no=:admin_no
		,admin_name=:admin_name
		";
		
		$param[":brandno"]=$goods_data['brandno'];
		$param[":goodsno"]=$goods_data['no'];
		$param[":goodsnm"]=$goods_data['goodsnm'];
		$param[":stock_num"]=$num;
		$param[":now_cnt"]=0;
		$param[":cost"]=$cost;
		$param[":admin_no"]=$_SESSION['sess']['m_no'];
		$param[":admin_name"]=$_SESSION['sess']['name'];

		$res=$this->db->query($qry,$param);

        $lastStockNo=$res->lastId;		
        
        $order_cost=$lastStockNo."^".$cost."^".$num;

		return $order_cost;
	}	

	function bad_calc_stock_order($bad_seq=0){ //????????? ?????? ?????? ????????? ???????????? ??????(???????????? ????????? ?????????)
		$GOODS=NEW goods();

		if(!$bad_seq) throw new Exception('????????????????????? ????????????????????????.(??????????????????)', 1);

		$sqry="select cb.*,g.brandno from cs_bad cb
		left join goods g on (cb.goods_no=g.no)
		where cb.no='".$bad_seq."'";
		$sres=$this->db->query($sqry);
		$sdata=$sres->results[0];

		if(!$sdata['goods_no']) throw new Exception('????????????????????? ????????????????????????.(????????????)', 1);

		if(strpos($sdata['cost'],'^')===false) throw new Exception('????????????????????? ????????????????????????.(COST)', 1);

		$ex_cost=explode("^",$sdata['cost']);		
		
		if( !$ex_cost[0] ) {
			if(!$ex_cost['1']) throw new Exception('??????????????? ????????????????????????.('.$sdata['goodsnm'].')', 1);

			$qry="insert into stock_list set
			brandno=:brandno
			,goodsno=:goodsno
			,goodsnm=:goodsnm
			,stock_num=:stock_num
			,now_cnt=:now_cnt
			,cost=:cost
			,state=1
			,memo='?????????????????? ????????????'
			,return_order=1
			,reg_date=now()
			,admin_no=:admin_no
			,admin_name=:admin_name
			";
			
			$param[":brandno"]=$sdata['brandno'];
			$param[":goodsno"]=$sdata['goods_no'];
			$param[":goodsnm"]=$sdata['goodsnm'];
			$param[":stock_num"]=$sdata['quantity'];
			$param[":now_cnt"]=$sdata['quantity'];
			$param[":cost"]=$ex_cost[1];
			$param[":admin_no"]=$_SESSION['sess']['m_no'];
			$param[":admin_name"]=$_SESSION['sess']['name'];
			
			$res=$this->db->query($qry,$param);

			$lastBedNo=$res->lastId;
			
			$ucost=$lastBedNo.'^'.$ex_cost[1].'^'.$sdata['quantity'];
			$uqry="update cs_bad 	
			set cost='".$ucost."'
			where no='".$bad_seq."'";
			$this->db->query($uqry);


		}else{
			$ex_cost=explode("|",$sdata['cost']);

			foreach($ex_cost as $v){
				$data=explode("^",$v);

                //$cost_cnt=$data['2']?$data['2']:"1";
                				
				$qry="update stock_list set 
				now_cnt=now_cnt+'".$sdata['quantity']."'
				where no = '".$data['0']."'
				";
			
				$this->db->query($qry);
			}
		}
	}

	function cs_cancel($csno,$sendcode='91'){
		global $db;

		//cs??????
		$qry="select * from 
		cs_info ci 
		join cs_detail cd on(ci.no=cd.cs_info_no)
		where cd.no='".$csno."'";
		$res=$db->query($qry);
		$csData=$res->results[0];

		//tydebug($csData);

		//tydebug($sendcode);

		//???????????? ???????????? ????????????????????? ??????????????? ???????????? ????????????
		if($csData['return_type']=="70" && $csData['send_type']=="2"){
			//?????? ????????? ??????????????? ??????
			$qry="select * from order_list where csno='".$csno."'";
			$res=$db->query($qry);
			$newOrderData=$res->results[0];

			//tydebug($newOrderData);

			if(!$newOrderData['no']){
				throw new Exception("?????????????????? ???????????? ????????????.",'0'); 
			}
			
			//??????????????? ????????????????????? ?????? ??????????????????.
			if($newOrderData['invoice']){
				throw new Exception("??????????????? ??????????????? ????????? ???????????? ????????????????????????.",'1'); 
			}

			if(!$newOrderData['order_cost'] && ($newOrderData['deli_codeno']!='outside' && $newOrderData['deli_codeno']!='????????????')){
				throw new Exception("????????? ??????????????????. ???????????? ??????????????????.",'2'); 
			}

			//?????? ????????????
			if($newOrderData['order_cost']){
				$exCost=explode("^",$newOrderData['order_cost']);
				
				//stock_list??? ????????? ??????
				$qry="select * from stock_list sl where no='".$exCost[0]."'";
				$res=$db->query($qry);
				$stockData=$res->results[0];		
				
				if(!$stockData) {
					throw new Exception("????????? ????????????????????????. ???????????? ??????????????????.",'3'); 
				}

				//???????????? ?????? (??????????????? ???????????? ??????)
				$qry="select * from stock_io_log sil where io_type='cs_exchange' and reference_no='".$csno."' order by no desc";
				$res=$db->query($qry);
				$stockIoData=$res->results[0];
				
				if(!$stockIoData) {
					throw new Exception("??????????????? ????????????????????????. ???????????? ??????????????????.",'4'); 
				}

				$cnt=$stockIoData['cnt']*-1;//????????????

				//?????? ????????????
				$qry="update stock_list set now_cnt=(now_cnt+".$cnt.") where no='".$exCost[0]."'";
				$db->query($qry);
				stock_io('cs_cancel',$newOrderData['goodsno'],$newOrderData['goodsnm'],$cnt,$csno,$_SERVER['REQUEST_URI'],$stockIoData['loc_f']);

				//tydebug($qry);
			}
			//???????????? ??????????????????
			$qry="update order_list set step2='45' where no='".$newOrderData['no']."'";
			$db->query($qry);

			//tydebug($qry);
		}

		$this->stepChange($csno,$sendcode);
	}
}
