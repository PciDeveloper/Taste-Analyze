<?php
/**
* File Handler Class PHP 7
*
* @Author		: seob
* @Update		: 2018-05-30
* @Description	: File I/O Handler
*/
class FileHandler
{
	public $fpath;
	public $fdata;
	public $tpath;
	public $tlock;
	public $fplock;
	public $fptmp;

	public function __construct()
	{
		$this->tpath = dirname(__FILE__)."/../_cfg/chkFile";
		$this->tlock = dirname(__FILE__)."/../_cfg/chkLock";
	}

	public function open($path)
	{
		if(!is_file($this->tlock)) die("파일작성중 오류가 발생하였습니다.");
		$this->fpath	= $path;
		$this->fdata	= "";
		$this->fplock	= fopen($this->tlock, 'w');

		if(!flock($this->fplock, LOCK_EX))
			return false;

		/*
		LOCK_SH: shared lock (reader)
		LOCK_EX: exclusive lock (writer)
		LOCK_UN: lock 해제
		LOCK_NB: non-blocking
		*/

		$this->fptmp = fopen($this->tpath, "w");
	}

	public function write($str)
	{
		if($this->fptmp == false) return false;
		if(!$str || strlen($str) <= 0) return false;
		if(!fwrite($this->fptmp, $str)) die("파일작성중 오류가 방생하였습니다. 계정용량 및 파일권한을 확인해주세요.");

		$this->fdata .= $str;
	}

	public function read($path)
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

	public function close()
	{
		if($this->fptmp == false) return false;
		fclose($this->fptmp);
		$this->fptmp = fopen($this->tpath, "w");
		fclose($this->fptmp);

		$fpOri = fopen($this->fpath, "w");
		fwrite($fpOri, $this->fdata);
		fclose($fpOri);

		flock($this->fplock, LOCK_UN);
		fclose($this->fplock);

		$this->fplock = false;
		$this->fptmp = false;
	}
}
?>
