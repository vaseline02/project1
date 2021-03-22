<?php
/*
	Session 클래스
*/
class session {

	var $m_no;
	var $m_id;
	var $level;
	var $groupsno;
	var $dc;

	function session() {
		if($_SESSION['sess']['m_no']) {
			$this->m_no=$_SESSION['sess']['m_no'];
			$this->m_id=$_SESSION['sess']['m_id'];
			$this->level=$_SESSION['sess']['level'];
			$this->groupsno=$_SESSION['sess']['groupsno'];
			$this->dc=$_SESSION['sess']['dc'];
		}
		else {
			$this->m_no=false;
			$this->m_id='';
			$this->level='';
			$this->groupsno='';
			$this->dc='';
		}
	}


	function login($id,$pwd) {

		global $db;

		$qry="select * from member 
		where id=:id
		and pw='".hash('sha256',$pwd)."'
		and state='y'
		";
		
		$param=array(":id"=>$id);

		$res = $db->query($qry,$param);

		$result=$res->results[0];
		
		
		if(!$result['id']){ // 일치하는 결과 값이 없는 경우
			return '2';
		}else if(!$result['email']){
			return '3';
		}else{
			$_SESSION['login_no']=$result['no'];

			$rand_num = sprintf('%06d',rand(000000,999999));
			$to = $result['email'];
			$subject = "인증메일";
			$contents = "인증코드 : ".$rand_num;
			$headers = "From: 트랜드메카\r\n";

			mail($to, $subject, $contents, $headers);

			$iqry="insert into member_login_code set
			m_no='".$result['no']."'
			,code='".$rand_num."'
			,reg_date=now()
			";
			$db->query($iqry);


			return "1";
		}
	}

	
	function login2($mno,$code) {

		global $db;

		$qry="select * from member 
		where no=:no
		";
		
		$param=array(":no"=>$mno);

		$res = $db->query($qry,$param);

		$result=$res->results[0];
		
		if(!$result['id']){ // 일치하는 결과 값이 없는 경우
			return '2';
		}else if(!$result['email']){
			return '3';
		}else{

			$sqry="select * from member_login_code 
			where m_no='".$mno."'
			and reg_date > DATE_FORMAT(DATE_ADD(now(),INTERVAL -3 MINUTE),'%Y-%m-%d %H:%i:%s')
			order by no desc limit 1";
			$sres=$db->query($sqry);
			$mailcode=$sres->results[0]['code'];

			if($mailcode != $code){
				return '4';
			}else{
				// 세션정보 저장
				$_SESSION['sess']=array(
					'm_no'=>$result['no'],	
					'm_id'=>$result['id'],
					'name'=>$result['name'],
					'email'=>$result['email'],
					'level'=>$result['level'],
					'level'=>$result['level'],
					'h_level'=>$result['h_level'],
					'menu'=>$result['menu']
				);
			

				$this->session();

				unset( $_SESSION['login_no'] );

				return "1";
			}
		}
	}

	function login_ori($id,$pwd) {

		global $db;

		$qry="select * from member 
		where id=:id
		and pw='".hash('sha256',$pwd)."'
		and state='y'
		";
		
		$param=array(":id"=>$id);

		$res = $db->query($qry,$param);

		$result=$res->results[0];
		
		if(!$result['id']){ // 일치하는 결과 값이 없는 경우
			return 'NOT_FOUND';
		}else{
			// 세션정보 저장
			$_SESSION['sess']=array(
				'm_no'=>$result['no'],	
				'm_id'=>$result['id'],
				'name'=>$result['name'],
				'email'=>$result['email'],
				'level'=>$result['level'],
				'level'=>$result['level'],
				'h_level'=>$result['h_level'],
				'menu'=>$result['menu']
			);
		

			$this->session();

			return true;
		}
	}
	/*
		로그아웃
	*/
	function logout() {
		session_destroy();
	}

}


?>