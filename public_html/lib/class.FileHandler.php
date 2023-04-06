<?
//=======================================================================================
// File Name	:	class.FileHandler.php
// Author		:	kkang(sinbiweb)
// Update		:	2013-01-30
// Description	:	File I/O Handler
//=======================================================================================

class FileHandler
{
	var $fPath;
	var $fData;
	var $tPath;
	var $tLock;
	var $fpLock;
	var $fpTmp;

	function FileHandler()
	{
		$this->tPath = dirname(__FILE__)."/../conf/chkFile";
		$this->tLock = dirname(__FILE__)."/../conf/chkLock";
	}

	function open($path)
	{
		if(!is_file($this->tLock)) die("파일작성중 오류가 발생하였습니다.");

		$this->fPath = $path;
		$this->fData = "";
		$this->fpLock = fopen($this->tLock, "w");

		/*
		LOCK_SH: shared lock (reader)
		LOCK_EX: exclusive lock (writer)
		LOCK_UN: lock 해제
		LOCK_NB: non-blocking
		*/
 
		if(!flock($this->fpLock, LOCK_EX))
			return false;

		$this->fpTmp = fopen($this->tPath, "w");
	}

	function write($str)
	{
		if($this->fpTmp == false) return false;
		if(!$str || strlen($str) <= 0) return false;
		if(!fwrite($this->fpTmp, $str)) die("파일작성중 오류가 발생하였습니다. 계정용량 및 파일권한을 확인하세요.");

		$this->fData .= $str;
	}
	
	/** XE 참조 --- (2013-03-05) **/
	function read($path)
	{
		if(!file_exists($path)) return;

		$filesize = filesize($path);
		if($filesize < 1) return;

		if(function_exists("file_get_contents"))
			return file_get_contents($path);

		$fp = fopen($path, "r");
		$buff = "";
		if($fp)
		{
			while(!feof($fp) && strlen($buff) <= $filesize)
			{
				$str = fgets($fp, 1024);
				$buff .= $str;
			}
			fclose($fp);
		}

		return $buff;
	}

	function close()
	{
		if($this->fpTmp == false) return false;
		fclose($this->fpTmp);
		$this->fpTmp = fopen($this->tPath, "w");
		fclose($this->fpTmp);

		$fpOri = fopen($this->fPath, "w");
		fwrite($fpOri, $this->fData);
		fclose($fpOri);

		flock($this->fpLock, LOCK_UN);
		fclose($this->fpLock);

		$this->fpLock = false;
		$this->fpTmp = false;
	}
}

?>