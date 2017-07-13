<?php
 	$sFileInfo = '';
	$headers = array();

	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		}
	}

	/**
	 * 파일을 저장할 절대경로를 반환한다
	 */
	function getFilePath() {
		$path = '/home/dprinting/nimda/attach/notice_file/' . date("Y");
		if(!is_dir($path))
			mkdir($path);

		$path .= '/' . date("m");

		if(!is_dir($path))
			mkdir($path);

		$path .= '/' . date("d");
		if(!is_dir($path))
			mkdir($path);

		return "/" . date("Y")
			. "/" . date("m") . "/" . date("d") . "/";
	}

	/**
	 * 중복되지않는 파일명생성
	 */
	function getUniqueNm(){

		$filename = substr(time() . md5(uniqid()) , 0 , 20);

		if (is_file($filename)) {
			$this->getUniqueNm();
		}

		return $filename;
	}

	$file = new stdClass;
	$file->name = str_replace("\0", "", rawurldecode($headers['file_name']));
	$file->size = $headers['file_size'];
	$file->content = file_get_contents("php://input");
	$filename_ext = strtolower(array_pop(explode('.',$file->name)));
	$allow_file = array("jpg", "png", "bmp", "gif");

	if(!in_array($filename_ext, $allow_file)) {
		echo "NOTALLOW_".$file->name;
	} else {
		$uploadDir = '/home/dprinting/nimda/attach/notice_file' . getFilePath();

        $file->name = getUniqueNm() . "." . $filename_ext;
		$newPath = $uploadDir.iconv("utf-8", "cp949", $file->name);

		if(file_put_contents($newPath, $file->content)) {
			$sFileInfo .= "&bNewLine=true";
			$sFileInfo .= "&sFileName=".$file->name;
			$sFileInfo .= "&sFileURL=/attach/notice_file" . getFilePath() .$file->name;
		}

		echo $sFileInfo;
	}
?>
