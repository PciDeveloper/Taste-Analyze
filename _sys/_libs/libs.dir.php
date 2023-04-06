<?php
/**
* Directory Function Library
*
* @Author		: seob
* @Update		: 2018-06-15
* @Description	: PHP Directory User Function Library
*/

/**
* Real Path : absolute path
*
* @param string $path
* @return string $path
*/
function _get_abs_path($path)
{
	$tmp = explode("/", $path);
	if($tmp[0] == ".")
		$path = _DOCUMENT_ROOT_."/".substr($path, 2);
	else if(!$tmp[0])
		$path = _DOCUMENT_ROOT_.$path;

	return $path;
}

/**
* make directory -- mkdir
*
* @param string $fpath, $sdir(시작디렉토리)--- 없으면 홈디렉토리부터 시작
* @return boolean
*/
function _mk_dir($fpath, $sdir="")
{
	$arPath = explode("/", $fpath);
	if($sdir)
		$path = $sdir;
	else
		$path = _DOCUMENT_ROOT_;

	for($i=0; $i < count($arPath); $i++)
	{
		if(!$arPath[$i]) continue;
		$path .= "/".$arPath[$i];

		if(!is_dir($path))
		{
			if(!ini_get("safe_mode"))
			{
				@mkdir($path, 0707);
				@chmod($path, 0707);
			}
		}
	}

	return is_dir($path);
}

/**
* Remove directory	---- rf
*/
function _rf_dir($path)
{
	$path = _get_abs_path($path);
	if(!is_dir($path)) return;
	$directory = dir($path);
	while(false !== ($entry = $directory->read()))
	{
		if(is_dir($path."/".$entry))
			_rf_dir($path."/".$entry);
		else
			@unlink($path."/".$entry);
	}
	$directory->close();
	rmdir($path);
}

/**
* get files in the target directory -- 디렉토리내의 파일목록
*
* @param string $path : Path of the target directory
* @return array : files
*/
function _get_dir_files($path)
{
	$path = _get_abs_path($path);
	if(!is_dir($path)) return;

	$directory = dir($path);
	$files = array();
	while(false !== ($entry = $directory->read()))
	{
		if($entry != "." && $entry != "..")
		{
			if(is_dir($path."/".$entry))
				continue;
			else
				$files[] = $entry;
		}
	}
	return $files;
}

/**
* read ini file and puts result into array -- ini 파일을 로드(배열로 반환)
*
* @param string $filename : Path and File name
* @return array : $array
*/
function _reads_ini_file($filename)
{
	$filename = _get_abs_path($filename);
	if(!file_exists($filename)) return;

	$arr = parse_ini_file($filename, TRUE);	//섹션별로 나누어 다차원 배열로 반환
	if(is_array($arr) && count($arr) > 0)
		return $arr;
	else
		return array();
}

/**
* rename file or directory
*
* @param string $source(변경대상), $target(변경할이름)
* @return bool : true on success Or false on failure.
*/
function _set_rename($source, $target)
{
	$source = _get_abs_path($source);
	$target = _get_abs_path($target);

	if(rename($source, $target))
		return true;
	else
		return false;
}
?>
