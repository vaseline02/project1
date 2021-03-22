<?
$glb_root_cron="/www/html/ukk_test";
require_once($glb_root_cron."/lib/db.class.php");
require_once($glb_root_cron."/lib/lib.func.php");

$db =  new DB($glb_root_cron."/conf/db.conf.php");



die;
/*브랜드 연동*/

try{
	
	$db->beginTransaction();
	/*
	$qry="truncate table new_erp.brand";
	$db->query($qry,array(),'cron');

	$qry="insert into new_erp.brand (no,brandnm,brand_img_folder,memo,save_time)
	select no,name,brand_img_folder,memo,save_time from timemecca1.brand 
	";
	*/


	$qry="insert into new_erp.brand (no,brandnm,brand_img_folder,memo,save_time)
	select no
	,@sel_name:=name
	,@sel_brand_img_folder:=brand_img_folder
	,@sel_memo:=memo
	,@sel_save_time:=save_time 
	from timemecca1.brand
	ON DUPLICATE KEY update 
	brandnm=@sel_name
	,memo=@sel_memo
	,save_time=@sel_save_time
	";

	$db->query($qry,array(),'cron');

	//$db->rollBack();
	$db->commit();
	tydebug('브랜드ok.');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}



//캘린더
try{
	
	$db->beginTransaction();

	$qry="delete from new_erp.calendar";
	$db->query($qry,array(),'cron');

	$qry="ALTER TABLE new_erp.calendar AUTO_INCREMENT=1";
	$db->query($qry,array(),'cron');


	$qry="insert into new_erp.calendar (no,u_id,date_from,date_to,type,title,save_time)
	select no,u_id,date_from,date_to,type,title,save_time from timemecca1.calendar 
	";
	$db->query($qry,array(),'cron');

	//$db->rollBack();
	$db->commit();
	tydebug('달력ok.');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}



//상품  . 입고횟수를 stock_list 데이터 이전후 쿼리로 등록필요.
try{
	
	$db->beginTransaction();
	/*
	$qry="delete from new_erp.goods";
	$db->query($qry,array(),'cron');

	$qry="insert into new_erp.goods (no,brandno,goodsnm,goodsnm_sub,s_price,c_price,img_step,barcode,reg_date,modi_date,memo)
	select no,b_no,name,name2,name3,price,photo,barcode,regi_date,modi_date,memo from timemecca1.model 
	";
	*/
	//,img_step #,@sel_photo:=photo #,img_step=@sel_photo
	$qry="insert into new_erp.goods (no,brandno,goodsnm,goodsnm_sub,s_price,c_price,barcode,reg_date,modi_date,memo)
	select no
	,@sel_b_no:=b_no
	,@sel_name:=name
	,@sel_name2:=name2
	,@sel_name3:=name3
	,@sel_price:=price
	,@sel_barcode:=barcode
	,@sel_regi_date:=regi_date
	,@sel_modi_date:=modi_date
	,@sel_memo:=memo 
	from timemecca1.model 
	ON DUPLICATE KEY update 
	brandno=@sel_b_no
	,goodsnm=@sel_name
	,goodsnm_sub=@sel_name2
	,s_price=@sel_name3
	,c_price=@sel_price
	,barcode=@sel_barcode
	,reg_date=@sel_regi_date
	,modi_date=@sel_modi_date
	,memo=@sel_memo
	";
	$db->query($qry,array(),'cron');

	//$db->rollBack();
	$db->commit();
	tydebug('상품ok.');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}



//재고  위치 추가되었는지 확인하고 쿼리 수정해줘야함.

$qry="insert into new_erp.goods_cnt_loc (goodsno,cur_cnt
,codeno_1,codeno_3,codeno_51,codeno_55
,codeno_66,codeno_75,codeno_85,codeno_86
,codeno_87,codeno_91,codeno_93,codeno_100
,codeno_101,codeno_104,codeno_110,codeno_112
,codeno_113,codeno_114,codeno_115
#,codeno_116
,codeno_117,codeno_125,codeno_127,codeno_128
,codeno_129,codeno_131,codeno_132
) 
select tm.m_no
,@sum_cur_cnt:=ifnull(sum(tm.cur_cnt),0)
,@sum_codeno_1:=sum(if(tm.place = '사무실',tm.cur_cnt,0))
,@sum_codeno_3:=sum(if(tm.place = '입고 예정',tm.cur_cnt,0))
,@sum_codeno_51:=sum(if(tm.place = '3자물류',tm.cur_cnt,0)) 
,@sum_codeno_55:=sum(if(tm.place = '마케팅매입',tm.cur_cnt,0)) 
,@sum_codeno_66:=sum(if(tm.place = '쿠팡',tm.cur_cnt,0)) 
,@sum_codeno_75:=sum(if(tm.place = '쇼룸 DP',tm.cur_cnt,0)) 
,@sum_codeno_85:=sum(if(tm.place = '프리스로우(원주)',tm.cur_cnt,0)) 
,@sum_codeno_86:=sum(if(tm.place = '인비트리(프라다 위탁)',tm.cur_cnt,0)) 
,@sum_codeno_87:=sum(if(tm.place = '방송',tm.cur_cnt,0)) 
,@sum_codeno_91:=sum(if(tm.place = '영인터',tm.cur_cnt,0)) 
,@sum_codeno_93:=sum(if(tm.place = 'LF사입',tm.cur_cnt,0)) 
,@sum_codeno_100:=sum(if(tm.place = '연예인협찬',tm.cur_cnt,0)) 
,@sum_codeno_101:=sum(if(tm.place = '마케팅 샘플(협찬)',tm.cur_cnt,0)) 
,@sum_codeno_104:=sum(if(tm.place = '외부 샘플',tm.cur_cnt,0)) 
,@sum_codeno_110:=sum(if(tm.place = '한성INC',tm.cur_cnt,0)) 

,@sum_codeno_112:=sum(if(tm.place = '골든 샘플',tm.cur_cnt,0)) 
,@sum_codeno_113:=sum(if(tm.place = '재고 체크',tm.cur_cnt,0)) 
,@sum_codeno_114:=sum(if(tm.place = '현대백화점 위탁',tm.cur_cnt,0)) 
,@sum_codeno_115:=sum(if(tm.place = '현대홈쇼핑',tm.cur_cnt,0)) 
#,@sum_codeno_116:=sum(if(tm.place = '발송대기',tm.cur_cnt,0)) 


,@sum_codeno_117:=sum(if(tm.place = '저스트원더',tm.cur_cnt,0)) 
,@sum_codeno_125:=sum(if(tm.place = '원마케팅',tm.cur_cnt,0)) 
,@sum_codeno_127:=sum(if(tm.place = '재고보류',tm.cur_cnt,0)) 
,@sum_codeno_128:=sum(if(tm.place = '사진 샘플',tm.cur_cnt,0)) 

,@sum_codeno_129:=sum(if(tm.place = '롯데묘미',tm.cur_cnt,0)) 
,@sum_codeno_131:=sum(if(tm.place = '11번가',tm.cur_cnt,0)) 
,@sum_codeno_132:=sum(if(tm.place = '평택',tm.cur_cnt,0)) 

from timemecca1.stock as tm  group by tm.m_no 

ON DUPLICATE KEY update cur_cnt=ifnull(@sum_cur_cnt,0)
,codeno_1=ifnull(@sum_codeno_1,0),codeno_3=ifnull(@sum_codeno_3,0),codeno_51=ifnull(@sum_codeno_51,0),codeno_55=ifnull(@sum_codeno_55,0)
,codeno_66=ifnull(@sum_codeno_66,0),codeno_75=ifnull(@sum_codeno_75,0),codeno_85=ifnull(@sum_codeno_85,0),codeno_86=ifnull(@sum_codeno_86,0)
,codeno_87=ifnull(@sum_codeno_87,0),codeno_91=ifnull(@sum_codeno_91,0),codeno_93=ifnull(@sum_codeno_93,0),codeno_100=ifnull(@sum_codeno_100,0)
,codeno_101=ifnull(@sum_codeno_101,0),codeno_104=ifnull(@sum_codeno_104,0),codeno_110=ifnull(@sum_codeno_110,0),codeno_112=ifnull(@sum_codeno_112,0)
,codeno_113=ifnull(@sum_codeno_113,0),codeno_114=ifnull(@sum_codeno_114,0),codeno_115=ifnull(@sum_codeno_115,0)

#,codeno_116=ifnull(@sum_codeno_116,0)
,codeno_117=ifnull(@sum_codeno_117,0),codeno_125=ifnull(@sum_codeno_125,0),codeno_127=ifnull(@sum_codeno_127,0),codeno_128=ifnull(@sum_codeno_128,0)
,codeno_129=ifnull(@sum_codeno_129,0),codeno_131=ifnull(@sum_codeno_131,0),codeno_132=ifnull(@sum_codeno_132,0)
";
$db->query($qry,array(),'cron');

tydebug('재고ok.');


//발송대기재고 총재고에 추가 
$qry="update goods_cnt_loc set
cur_cnt=cur_cnt+codeno_116+codeno_130
where (codeno_116>0 or codeno_130)
";
$db->query($qry,array(),'cron');

/*입고내역 - 재고 수량은 마춰줄 필요있음..다 수작업; 입고예정 수량은  goods의 3번 위치 재고량으로 다시한번 등록해줘야함.*/
/* 입고 수량이 다를수도있고, 데이터가 아에 없을수도있음. -2020-02-13 입고내역이 없는 데이터는 남은재고데이터로 입고내역 임시 등록완료됨. */
/*입고 내역 등록 후 입고내역 디비에 모델명이 널인 모델들은 지워도 상관없음( goods_cnt_loc 도 함께)*/

try{
	
	$db->beginTransaction();
	
	$qry="delete from new_erp.stock_list ";
	$db->query($qry,array(),'cron');

	$qry="ALTER TABLE new_erp.stock_list AUTO_INCREMENT=1";
	$db->query($qry,array(),'cron');
	

	$qry="insert into new_erp.stock_list  ( goodsno,stock_num_reg,stock_num,cost,cost_ori,cost_mod,group_id,calendar_date,memo,reg_date,state,admin_name)
	select m_no,cnt,cnt,cost,cost,'1',save_time,save_time,customer,save_time,'1',u_id from timemecca190426.stock ts where ts.customer not in ('재고이동','반품','사무실')  and ts.io='in' and place!='입고 예정' order by save_time 
	";
	$db->query($qry,array(),'cron');

	$qry="insert into new_erp.stock_list  ( goodsno,stock_num_reg,stock_num,cost,cost_ori,cost_mod,group_id,calendar_date,memo,reg_date,state,admin_name)
	select m_no,cnt,cnt,cost,cost,'1',save_time,save_time,customer,save_time,'1',u_id from timemecca1.stock ts where ts.customer not in ('재고이동','반품','사무실')  and ts.io='in' and !(place='입고 예정' and cur_cnt=0) order by save_time 
	";
	$db->query($qry,array(),'cron');


	$qry="select g.no,gcl.cur_cnt,gcl.codeno_3 from goods g 
	join goods_cnt_loc gcl on gcl.goodsno =g.no
	where gcl.cur_cnt > 0 
	";

	$res=$db->query($qry);

	foreach($res->results as $v){
		$data_goods[$v['no']]=$v['cur_cnt']-$v['codeno_3'];
		$data_goods_planed[$v['no']]=$v['codeno_3'];
		$data_goods_no[]=$v['no'];
	}

	$qry="select no,goodsno ,stock_num from stock_list where goodsno in('".implode("','",$data_goods_no)."') order by goodsno,reg_date desc";
	$res=$db->query($qry);


	foreach($res->results as $v){

		if($data_goods_planed[$v['goodsno']]>0){
			
			$now_cnt=($data_goods_planed[$v['goodsno']]>=$v['stock_num'])?$v['stock_num']:$data_goods_planed[$v['goodsno']];

			$uqry="update stock_list set now_cnt='".$now_cnt."', state='0' where no='".$v['no']."' ";
			$db->query($uqry,array(),'cron');

			$data_goods_planed[$v['goodsno']]-=$v['stock_num'];

		}else if($data_goods[$v['goodsno']]>0){

			if($v['stock_num']<=$data_goods[$v['goodsno']]){
				
				$data_goods[$v['goodsno']]-=$v['stock_num'];
				$now_cnt=$v['stock_num'];
			}else{
				$now_cnt=$data_goods[$v['goodsno']];
				$data_goods[$v['goodsno']]=0;	
			}

			$uqry="update stock_list set now_cnt='".$now_cnt."' where no='".$v['no']."' ";
			$db->query($uqry,array(),'cron');
		}
	}
	
	
	//입고내역이 없는모델이 있는지 체크
	$qry="select g.no, count(sl.no) sumN from goods g
	left join goods_cnt_loc gcl on gcl.goodsno = g.no
	left join stock_list sl on g.no = sl.goodsno
	where gcl.cur_cnt>0
	group by g.no 
	having sumN =0
	";
	$res=$db->query($qry);
	foreach($res->results as $v){
		$rechk_stock[]=$v['no'];
	}

	$qry="insert into new_erp.stock_list  ( goodsno,stock_num_reg,stock_num,now_cnt,cost,cost_mod,group_id,calendar_date,memo,reg_date,state)
	select m_no,cnt,cnt,cur_cnt,cost,'1',save_time,save_time,'입고내역 강제입력',save_time,'1' from timemecca1.stock ts where ts.cur_cnt>0 and ts.m_no in('".implode("','",$rechk_stock)."') order by save_time 
	";

	$db->query($qry,array(),'cron');	

	/*체크용쿼리. 입고내역없는모델
	select g.no,g.goodsnm,gcl.cur_cnt, count(sl.no) sumN, sum(sl.now_cnt) sumN2, sum(sl.stock_num) sumN3 from goods g
	left join goods_cnt_loc gcl on gcl.goodsno = g.no
	left join stock_list sl on g.no = sl.goodsno
	where gcl.cur_cnt>0
	group by g.goodsnm 
	having sumN =0
	ORDER BY `gcl`.`cur_cnt`  DESC
	*/
	
	/*
	//재고 차이나는 모델만 추출
	select g.no,g.goodsnm,gcl.cur_cnt, count(sl.no) sumN, sum(sl.now_cnt) sumN2, sum(sl.stock_num) sumN3 from goods g
	left join goods_cnt_loc gcl on gcl.goodsno = g.no
	left join stock_list sl on g.no = sl.goodsno
	where gcl.cur_cnt>0
	group by g.goodsnm 
	having sumN !=0
	and gcl.cur_cnt!=sumN2
	ORDER BY `gcl`.`cur_cnt`  DESC

	*/

	$qry="update stock_list sl 
	join goods g on sl.goodsno = g.no
	set sl.brandno = g.brandno
	,sl.goodsnm = g.goodsnm
	";
	$db->query($qry,array(),'cron');

	
	//$db->rollBack();
	$db->commit();
	tydebug('입고내역ok.');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}


//회원 회원 연동 아이디로 제한 걸어서 권한 유지
/*
try{
	
	$db->beginTransaction();

	$qry="delete from new_erp.member where id not in ('naskka','koreaadidas1','trendmecca','lyk166','timemecca1','jkm9424','UITEST','sowuzu')";
	$db->query($qry);

	$qry="insert into new_erp.member (id,pw,email,name,mobile,address,level,birth,memo,pic,join_time,modify_time)
	select id,pw,email,name,mobile,address,level,birth,memo,pic,join_time,modify_time from timemecca1.user where id not in('naskka','koreaadidas1','trendmecca','lyk166','timemecca1','jkm9424','UITEST','sowuzu')
	";
	$db->query($qry);

	//$db->rollBack();
	$db->commit();
	msg('처리되었습니다.');
}
catch( Exception $e ){
	tydebug('err');
	$db->rollBack();
	tydebug($e->getMessage());
	
}

*/
/*
28|9|5|23|27|34|31|4|20|26|24|25|17|18
28|9|5|23|27|31|4|20|26|24|25|17|18

메뉴 업데이트
$qry="update new_erp.member set menu='28|9|5|23|27|34|31|4|20|26|24|25|17|18' where id not in ('naskka','koreaadidas1','trendmecca','lyk166','timemecca1','jkm9424','UITEST')";
$db->query($qry);
*/



/*주문내역*/

//상품  . 입고횟수를 stock_list 데이터 이전후 쿼리로 등록필요.

/*입출고 로그*/

/*codedata . 처리시 변경위치확인 후 상단 재고 등록쿼리 변경해줘야함.*/



/*
상품입고횟수
*/
$qry="update goods g
set g.stock_num_cnt=(select count(*) from stock_list where goodsno=g.no)
";
$db->query($qry,array(),'cron');
?>