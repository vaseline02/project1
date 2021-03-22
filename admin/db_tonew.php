<?
include "../_header.php";member_chk();


//브랜드
/*디비 이전테스트
try{
	
	$db->beginTransaction();

	$qry="truncate table new_erp.brand";
	$db->query($qry);

	$qry="insert into new_erp.brand (no,brandnm,brand_img_folder,memo,save_time)
	select no,name,brand_img_folder,memo,save_time from timemecca1.brand 
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
	
}1
*/
/*
//상품
try{
	
	$db->beginTransaction();

	$qry="delete from new_erp.goods";
	$db->query($qry);

	$qry="insert into new_erp.goods (no,brandno,goodsnm,goodsnm_sub,name3,c_price,img_step,barcode,material,size,waterproof,origin,reg_date,registrant,modi_date,memo)
	select no,b_no,name,name2,name3,price,photo,barcode,material,size,waterproof,origin,regi_date,registrant,modi_date,memo from timemecca1.model 
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

//회원 회원 연동 아이디로 제한 걸어서 권한 유지
/*
try{
	
	$db->beginTransaction();

	$qry="delete from new_erp.member where id not in ('naskka','koreaadidas1','trendmecca','lyk166','timemecca1','jkm9424','UITEST')";
	$db->query($qry);

	$qry="insert into new_erp.member (id,pw,email,name,mobile,adress,level,birth,memo,pic,join_time,modify_time)
	select id,pw,email,name,mobile,adress,level,birth,memo,pic,join_time,modify_time from timemecca1.user where id not in('naskka','koreaadidas1','trendmecca','lyk166','timemecca1')
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



/*재고 코드데이터가 업데이트 될수있기때문에 확인이 필요하다.*/

insert into new_erp.goods_cnt_loc (goodsno,cur_cnt) select tm.m_no,@sum_score:=ifnull(sum(tm.cur_cnt),0) from timemecca_test2.stock as tm  group by tm.m_no ON DUPLICATE KEY update cur_cnt=ifnull(@sum_score,0)



insert into new_erp.goods_cnt_loc (goodsno,cur_cnt,codeno_1,codeno_3,codeno_51,codeno_55
,codeno_66,codeno_75,codeno_85,codeno_86,codeno_87,codeno_91,codeno_93,codeno_100,codeno_101,codeno_104,codeno_110,codeno_111) 
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
,@sum_codeno_111:=sum(if(tm.place = '칼레이먼',tm.cur_cnt,0)) 

from timemecca_test2.stock as tm  group by tm.m_no 

ON DUPLICATE KEY update cur_cnt=ifnull(@sum_cur_cnt,0),codeno_1=ifnull(@sum_codeno_1,0),codeno_3=ifnull(@sum_codeno_3,0)
,codeno_51=ifnull(@sum_codeno_51,0),codeno_55=ifnull(@sum_codeno_55,0),codeno_66=ifnull(@sum_codeno_66,0),codeno_75=ifnull(@sum_codeno_75,0)

,codeno_85=ifnull(@sum_codeno_85,0),codeno_86=ifnull(@sum_codeno_86,0),codeno_87=ifnull(@sum_codeno_87,0),codeno_91=ifnull(@sum_codeno_91,0)
,codeno_93=ifnull(@sum_codeno_93,0),codeno_100=ifnull(@sum_codeno_100,0),codeno_101=ifnull(@sum_codeno_101,0),codeno_104=ifnull(@sum_codeno_104,0)
,codeno_110=ifnull(@sum_codeno_110,0),codeno_111=ifnull(@sum_codeno_111,0)



/*=====================================================================================================*/

/*
try{
	
	$db->beginTransaction();

	$qry="truncate table new_erp.codedata";
	$db->query($qry);

	$qry="insert into new_erp.brand (no,brandnm,brand_img_folder,memo,save_time)
	select no,name,brand_img_folder,memo,save_time from timemecca1.brand 
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

//goods_cnt_loc 테이블에 재고방 갯수만큼 시퀀스로 컬럼 생성해줘야함. 후에 재고방 생성 기능에서 컬럼이 추가되어야함. 재고 가감시 총재고와 위치별 재고에서 가감 필요.
//alter table goods_cnt_loc no_1 int default 0

/*
브랜드 테이블은 정리 필요(카테고리와 분리) 
*/

/*

alter table goods_cnt_loc add codeno_1 int default 0;
alter table goods_cnt_loc add codeno_3 int default 0;
alter table goods_cnt_loc add codeno_51 int default 0;
alter table goods_cnt_loc add codeno_55 int default 0;
alter table goods_cnt_loc add codeno_66 int default 0;
alter table goods_cnt_loc add codeno_75 int default 0;
alter table goods_cnt_loc add codeno_85 int default 0;
alter table goods_cnt_loc add codeno_86 int default 0;
alter table goods_cnt_loc add codeno_87 int default 0;
alter table goods_cnt_loc add codeno_91 int default 0;
alter table goods_cnt_loc add codeno_93 int default 0;
alter table goods_cnt_loc add codeno_100 int default 0;
alter table goods_cnt_loc add codeno_101 int default 0;
alter table goods_cnt_loc add codeno_104 int default 0;
alter table goods_cnt_loc add codeno_110 int default 0;
alter table goods_cnt_loc add codeno_111 int default 0;

*/

/* 회원 테이블 이전후 테이블명 member로 변경  시퀀스 추가*/


/* stock_list 테이블 데이터 이전은 입고를 기준으로 뽑아서 등록.*/

/*

입고내역
SELECT SUM( IF( io = 'IN', cnt, 0 ) ) sumin, SUM( IF( io = 'OUT', cnt, 0 ) ) sumout ,sum(cur_cnt) cc
FROM stock
WHERE customer NOT
IN (
'재고이동'
)
AND place != '입고 예정'
AND m_no = '1767'


위 쿼리로 필터하면 수량이 잘 안맞음. 
-사진촬영용 샘플을 빼면 기록패턴이 같은지.
*/


?>




