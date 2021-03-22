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

		$qry="select * from user 
		where id='".$id."'
		and pw=password('".$pwd."')
		";

		$res = $db->query($qry);
		$result=$db->fetch($res);

		if(!$result['id']){ // 일치하는 결과 값이 없는 경우
			return 'NOT_FOUND';
		}else{
			// 세션정보 저장
			$_SESSION['sess']=array(
				'm_id'=>$result['id'],
				'name'=>$result['name'],
				'email'=>$result['email'],
				'level'=>$result['lv']
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