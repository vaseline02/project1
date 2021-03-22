<?

class FILE
{
	function FILE($folder='')
	{
		global $_FILES, $_SERVER,$db,$_SESSION,$cfg;

		$this->db=$db;
		$this->m_id=$_SESSION['sess']['m_id'];

		if($folder){
			$this->imagepath=$folder;
		}else{
			$this->imagepath=$_SERVER[DOCUMENT_ROOT].$cfg['rootDir']."/file";
		}
	}

	function upFiles(){
		if(is_array($_FILES)){

			foreach($_FILES as $name=>$data){

				$file_num=0;
				for($i=0; $i<count($data[name]); $i++){

					$ext = $this->getExt($data[name][$i]);

					$v_filename = md5($name.time().$this->getFilename($data[name][$i])).$i.".".$ext;
					$r_filename = $data[name][$i];
					

					if(!is_dir($this->imagepath)){

						mkdir($this->imagepath,0777 );
//						mkdir($this->imagepath, 0755);
					}
					
					if(move_uploaded_file($data[tmp_name][$i],$this->imagepath.'/'.$v_filename)){
					//if(move_uploaded_file($data[tmp_name][$i],$this->imagepath.'/'.$r_filename)){

						$r_data[$name][$file_num]["name"] = $name;
						$r_data[$name][$file_num]["v_file"] = $v_filename;
						$r_data[$name][$file_num]["r_file"] = $r_filename;
						$r_data[$name][$file_num]["ext"] = $ext;
						$r_data[$name][$file_num]["error"] = false;
						
						$qry="insert into files(type,  name, hash ,m_id) values ('".$ext."','".$r_data[$name][$file_num]["r_file"]."','".$r_data[$name][$file_num]["v_file"]."','".$this->m_id."')";
						$this->db->query($qry);	
						
					}else{
						$r_data[$name][$file_num]["name"] = $name;
						$r_data[$name][$file_num]["error"] = true;
					}

					$file_num++;
				}
			}

		}
		return $r_data;
	}

	//파일형식 제한
	function chkExt(){

		$msg='';
		$chkarr=array('jpg','gif','bmp','png');

		if(is_array($_FILES)){

			foreach($_FILES as $name=>$data){

				for($i=0; $i<count($data[name]); $i++){
					if($data[name][$i]){
						$ext = $this->getExt($data[name][$i]);
						$ext = strtolower($ext);

						if(!in_array($ext,$chkarr)){

							$msg='이미지 파일만 업로드 가능합니다.';
						}
					}
				}
			}
		}

		return $msg;
	}

	function getExt($p_filename){

		return substr($p_filename,strpos($p_filename,".")+1);
	}
	function getFilename($p_filename){
		return substr($p_filename,0,strpos($p_filename,"."));
	}

	function deleteFile($img){

		foreach($img as $imgname){
			$this->removeFile($imgname);
		}

	}

	function removeFile($p_file){

		if(is_file($this->imagepath.$p_file)){
			unlink($this->imagepath.$p_file);
		}
	}

}

?>