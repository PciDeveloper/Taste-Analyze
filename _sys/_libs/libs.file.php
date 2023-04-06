<?php
/**
* File Function Library
*
* @Author		: seob
* @Update		: 2018-06-14 
* @Description	: User File PHP Function Library
*/

/**
* file upload
* @param : $nf($_FILES), $of(기존파일명), $path(업로드 경로)
*/
function _file_upload($nf, $of="", $path)
{
	if($nf['size'])
	{
		if($of) _file_delete($of, $path);
		$exTmp = explode(".", $nf['name']);
		$filename = substr(time(), 5, 5)."_";
		for($i=1; ; $i++)
		{
			$tmp = sprintf("%s%s.%s", $filename, $i, $exTmp[sizeof($exTmp)-1]);
			if(!file_exists($path."/".$tmp))
			{
				$filename = $tmp;
				break;
			}
		}
		@copy($nf['tmp_name'], $path."/".$filename);
		@unlink($nf['tmp_name']);
		return $filename;
	}
}

/**
* 배열 첨부파일 업로드
* @param : $nf($_FILES['name']), $tmp($_FILES['tmp_name']), $of(기존파일명), $path(업로드 경로)
*/
function _file_arr_upload($nf, $tmp, $of="", $path)
{
	if($nf)
	{
		if($of) _file_delete($of, $path);
		$exTmp = explode(".", $nf);
		$filename = substr(time(), 5, 5)."_";
		for($i=1; ; $i++)
		{
			$tmp_file = sprintf("%s%s.%s", $filename, $i, $exTmp[sizeof($exTmp)-1]);
			if(!file_exists($path."/".$tmp_file))
			{
				$filename = $tmp_file;
				break;
			}
		}
		@copy($tmp, $path."/".$filename);
		@unlink($tmp);
	}
	return $filename;
}


/**
* file delete
* @param : $fn(파일명), $path(파일경로)
*/
function _file_delete($fn, $path)
{
	if(file_exists($path."/".$fn))
		@unlink($path."/".$fn);
}

/**
* file copy
* @param : $fn(파일명), $op(원본경로), $np(카피할 경로)
*/
function _file_copy($fn, $op, $np="")
{
	if(file_exists($op."/".$fn))
	{
		$extmp = explode(".", $fn);
		$np = ($np) ? $np : $op;
		$filename = substr(time(), 5, 5)."-";
		for($i=1; ; $i++)
		{
			$tmp = sprintf("%s%s.%s", $filename, $i, $extmp[sizeof($extmp)-1]);
			if(!file_exists($np."/".$tmp))
			{
				$filename = $tmp;
				break;
			}
		}
		@copy($op."/".$fn, $op."/".$filename);
		return $filename;
	}
}

/**
* 고정파일명으로 덮어쓰기 함.
*/
function _file_upload_fixnm($file, $fnm, $path)
{
	if($file['size'])
	{
		copy($file['tmp_name'], $path."/".$fnm);
		@unlink($file['tmp_name']);
	}
}

/**
* image print tags
* @param : $p(상대경로), $i(이미지명), $w(width), $h(height), $n(no image 경로)- n:이미지 미출력
*/
function _get_image_tag($p, $i, $w='', $h='', $n='')
{
	if($p && $i)
	{
		$fp = $p."/".$i;
		if(!file_exists($fp))
		{
			if($n == "n") return "";	// 이미지표시를 하지 않음 //
			else if($n)
			{
				$onerror = sprintf("onerror=\"this.onerror=null;this.src='%s';\"", $n);
				$ii = @getImageSize($n);
			}
			else
			{
				$onerror = "onerror=\"this.onerror=null;this.src='/images/noimage.jpg';\"";
				$ii = @getImageSize("../../images/noimage.jpg");
			}
		}
		else
			$ii = @getImageSize($fp);

		if($w || $h)
		{
			if($w && !$h) $h = $ii[1]*$w/$ii[0];
			if($h && !$w) $w = $ii[0]*$h/$ii[1];

			$size = sprintf("width=\"%s\" height=\"%s\"", $w, $h);
		}

		if(preg_match("/^image/i", $ii['mime']))
			$img = sprintf("<img src=\"%s\" %s %s />", $fp, $size, $onerror);
		else if($onerror)
			$img = sprintf("<img src=\"\" %s %s />", $size, $onerror);
		else
			$img = "";

		return $img;
	}
	else
		return;
}

/**
* webeditor 내용에서 이미지 추출후 썸네일 생성
* @param : $path(경로), $content(내용), $w(썸네일 width), $h(썸네일 height))
*/
function _extra_create_thumb($path, $content, $w, $h)
{
	preg_match_all("/<img[^>]*src=[\'\"]?([^>\'\"]+[^>\'\"]+)[\'\"]?[^>]*>/", $content, $arr);
	for($i=0; $i<count($arr[1]); $i++)
	{
		// url 파싱
		$imgurl_real	= $arr[1][$i];
		$imginfo		= parse_url($imgurl_real);
		$imgurl_path	= $path.$imginfo['path'];

		if(preg_match("/\.(gif|jpg|jpeg|png)$/i", strtolower($imgurl_path)))
		{
			$filename = _get_base_name($imgurl_path);
			$filepath = dirname($imgurl_path);
			break;
		}
	}

	if($filename && !file_exists($filepath."/thum_".$filename))
	{
		if(CreateImageFile($filename, "thum_".$filename, $filepath, $w, $h, $filepath."/thum", 'ratio', true))
			return "thum_".$filename;
	}
	else if($filename)
		return "thum_".$filename;
	else
		return "";
}

/**
* 파일명만 가져오기
*/
function _get_base_name($path)
{
	$pattern = (strncasecmp(PHP_OS, 'WIN', 3) ? '/([^\/]+)[\/]*$/' : '/([^\/\\\\]+)[\/\\\\]*$/');
	if (preg_match($pattern, $path, $matches))
		return $matches[1];

	return '';
}

/**
* webeditor 내용삭제시 첨부이미지도 삭제
*/
function _webeditor_image_del($content)
{
	preg_match_all("/<img[^>]*(src *= *['|\"]*([^'|\"| |>]*)['|\"]*)[^>]*>/i", $content, $arr);
	foreach($arr[2] as $images)
	{
		$url = parse_url($images);
		if($url['query']) continue;
		if($url['host'] && $url['host'] != $_SERVER['HTTP_HOST']) continue;
		if(strpos($url['path'], "upload/editor/") === false) continue;
		if(($realpath = realpath($_SERVER['DOCUMENT_ROOT'] . '/' . $url['path'])) == "") continue;

		@unlink($realpath);
	}
}

/**
* file size
*/
function _get_file_size($fsize)
{
	if(!$fsize) return "0Byte";
	else if($fsize === 1) return "1Byte";
	else if($fsize < 1024) return sprintf("%sBytes", number_format($fsize));
	else if($fsize >= 1024 && $fsize < 1024*1024) return sprintf("%0.1fKB", $fsize/1024);
	else return sprintf("%0.2fMB", $fsize/(1024*1024));
}

/**
* image max width기준으로 resize
*/
function _get_image_resize($path, $img, $mw)
{
	if(file_exists($path."/".$img))
	{
		$ii = getimagesize($path."/".$img);
		if($ii[0] > $mw)
		{
			$rw = $mw;
			$rh = $ii[1]*$mw/$ii[0];
		}
		else
		{
			$rw = $ii[0];
			$rh = $ii[1];
		}

		return sprintf("<img src=\"%s/%s\" width=\"%s\" height=\"%s\" />", $path, $img, $rw, $rh);
	}
}

/**
* file icon
*/
function _get_file_icon($file)
{
	$ex = @explode(".", $file);
	$ext = $ex[sizeof($ex)-1];
	$ext = strtolower($ext);

	$exdir = explode("/", dirname($_SERVER['SCRIPT_NAME']));
	if(dirname($_SERVER['SCRIPT_NAME']) == "/")
		$dir = "./";
	else
		for($d=1; $d < count($exdir); $d++) $dir .= "../";

	$path = sprintf("%simages/board/%s.gif", $dir, $ext);
	if(file_exists($path))
		$ficon = sprintf("<img src=\"%s\" alt=\"icon\" />", $path);
	else
		$ficon = "<img src=\"/images/board/file.gif\" alt=\"icon\" />";

	return $ficon;
}

/***
/* $imgName		: 원본이미지명
/* $imgRename	: 생성할 썸네일명
/* $path		: 경로(원본이미지)
/* $re_w		: 가로사이즈
/* $re_h		: 세로사이즈
/* $target_path	: 생성할 썸네일 경로(미지정시 원본경로에 생성)
/* $target_ext	: 생성할 이미지 type(png, jpg, gif)
/* $thum_type	: 썸네일 형식(ration : 이미지 가로세로비율로 축소, crop : 이미지 짜름)
/* $fixed		: 지정한 고정사이즈로 썸네일 이미지 생성
/* $transparent	: 생성이미지가 png인경우 배경없애기
***/
function _create_image($imgName, $imgRename, $path, $w=0, $h=0, $target_path="", $thumb_type="crop", $fixed=false, $target_ext="", $transparent=false)
{
	$fpath = sprintf("%s/%s", $path, $imgName);
	if(!file_exists($fpath)) return;

	list($width, $height, $type, $attrs) = getImageSize($fpath);
	if($width < 1 || $height < 1) return;

	switch($type)
	{
		case "1" : $type="gif"; break;
		case "2" : $type = "jpg"; break;
		case "3" : $type = "png"; break;
		case "6" : $type = "bmp"; break;
		default : return; break;
	}

	if(!$target_ext) $target_ext = $type;
	$target_ext = strtolower($target_ext);

	$w_per = ($w > 0 && $width >= $w) ? $w/$width : 1;
	$h_per = ($h > 0 && $height >= $h) ? $h/$height : 1;
	$per = null;
	if($thumb_type == "ratio")
	{
		$per = ($w_per > $h_per) ? $h_per : $w_per;
		$re_w = $width * $per;
		$re_h = $height * $per;
	}
	else
	{
		$per = ($w_per < $h_per) ? $h_per : $w_per;
		$re_w = $w;
		$re_h = $h;
	}

	$thumb = null;
	if(function_exists("imagecreatetruecolor"))
	{
		if($fixed === true && $w && $h)
			$thumb = imagecreatetruecolor($w, $h);
		else
			$thumb = imagecreatetruecolor($re_w, $re_h);
	}
	else if(function_exists("imagecreate"))
	{
		if($fixed === true && $w && $h)
			$thumb = imagecreate($w, $h);
		else
			$thumb = imagecreate($re_w, $re_h);
	}
	else
		return false;

	if(function_exists("imagecolorallocatealpha") && $target_ext="png" && $transparent)
	{
		imagefill($thumb, 0, 0, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
		if(function_exists("imagesavealpha"))
			imagesavealpha($thumb, true);
		if(function_exists("imagealphablending"))
			imagealphablending($thumb, true);
	}
	else
	{
		if($fixed === true && $w && $h)
			imagefilledrectangle($thumb, 0, 0, $w-1, $h-1, imagecolorallocate($thumb, 255, 255, 255));
		else
			imagefilledrectangle($thumb, 0, 0, $re_w-1, $re_h-1, imagecolorallocate($thumb, 255, 255, 255));
	}

	$src = null;
	switch($type)
	{
		case 'gif' :
			if(!function_exists('imagecreatefromgif')) return false;
			$src = @imagecreatefromgif($fpath);
		break;
		case 'jpeg' : case 'jpg' :
			if(!function_exists('imagecreatefromjpeg')) return false;
			$src = @imagecreatefromjpeg($fpath);
		break;
		case 'png' :
			if(!function_exists('imagecreatefrompng')) return false;
			$src = @imagecreatefrompng($fpath);
		break;
		case 'wbmp' : case 'bmp' :
			if(!function_exists('imagecreatefromwbmp')) return false;
			$src = @imagecreatefromwbmp($fpath);
		break;
		default :
			return;
		break;
	}

	if(!$src)
	{
		imagedestroy($thumb);
		return false;
	}

	$new_w = (int)($width * $per);
	$new_h = (int)($height * $per);

	$x = $y = 0;
	if($thumb_type == "crop")
	{
		$x = (int)($re_w/2 - $new_w/2);
		$y = (int)($re_h/2 - $new_h/2);
	}
	else
	{
		$x = ceil(($w-$new_w)/2);
		$y = ceil(($h-$new_h)/2);
	}

	if(function_exists("imagecopyresampled"))
		imagecopyresampled($thumb, $src, $x, $y, 0, 0, $new_w, $new_h, $width, $height);
	else
		imagecopyresized($thumb, $src, $x, $y, 0, 0, $new_w, $new_h, $width, $height);

	if(!$target_path) $target_path = $path;
	if(!is_dir($target_path))
	{
		@mkdir($target_path, 0707);
		@chmod($target_path, 0707);
	}

	$output = null;
	switch($type)
	{
		case 'gif' :
			if(!function_exists("imagegif")) return false;
			$output = imagegif($thumb, $target_path."/".$imgRename);
		break;
		case 'jpeg' : case 'jpg' :
			if(!function_exists('imagejpeg')) return false;
			$output = imagejpeg($thumb, $target_path."/".$imgRename, 100);
		break;
		case 'png' :
			if(!function_exists('imagepng')) return false;
			$output = imagepng($thumb, $target_path."/".$imgRename, 9);
		break;
		case 'wbmp' : case 'bmp' :
			if(!function_exists('imagewbmp')) return false;
			$output = imagewbmp($thumb, $target_path."/".$imgRename, 100);
		break;
	}
	imagedestroy($thumb);
	imagedestroy($src);

	if(!$output) return false;
	@chmod($target_path."/".$imgRename, 0644);

	return true;
}


/***
/* $imgName		: 원본이미지명
/* $imgRename	: 생성할 썸네일명
/* $Path		: 경로(원본이미지)
/* $w			: 가로사이즈
/* $h			: 세로사이즈
/* $target_path	: 생성할 썸네일 경로(미지정시 원본경로에 생성)
/* $thum_type	: 썸네일 형식(ration : 이미지 가로세로비율로 축소, crop : 이미지 짜름)
/* $fixed		: 지정한 고정사이즈로 생성
***/
function CreateImageFile($imgName, $imgRename, $Path, $w="", $h="", $target_path="", $thum_type="ratio", $fixed="")
{
	$imageInfo = @getImageSize($Path . "/" . $imgName);
	list($width, $height, $type, $attrs) = $imageInfo;

	if($width<1 || $height<1) return;

	switch($type)
	{
		case "1" : $type="gif"; break;
		case "2" : $type = "jpg"; break;
		case "3" : $type = "png"; break;
		case "4" : $type = "bmp"; break;
		default : return; break;
	}

	if($w > 0 && $width >= $w)
		$width_per = $w/$width;
	else
		$width_per = 1;

	if($h > 0 && $height >= $h)
		$height_per = $h/$height;
	else
		$height_per = 1;

	if($thum_type == 'ratio')
	{
		if($width_per > $height_per)
			$per = $height_per;
		else
			$per = $width_per;

		$rewidth = $width * $per;
		$reheight = $height * $per;
	}
	else
	{
		if($width_per < $height_per)
			$per = $height_per;
		else
			$per = $width_per;

		$rewidth = $w;
		$reheight = $h;
	}

	$per = ($per) ? $per : 1;

	if(function_exists('imagecreatetruecolor'))
	{
		if($fixed && $w && $h)
			$thumb = imagecreatetruecolor($w, $h);
		else
			$thumb = imagecreatetruecolor($rewidth, $reheight);
	}
	else if(function_exists('imagecreate'))
	{
		if($fixed && $w && $h)
			$thumb = imagecreate($w, $h);
		else
			$thumb = imagecreate($rewidth, $reheight);
	}
	else
		return false;

	if(!$thumb) return false;

	/// 배경색 설정 ///
	$white = imagecolorallocate($thumb, 255,255,255);

	if($fixed && $w && $h)
		imagefilledrectangle($thumb, 0, 0, $w, $h, $white);
	else
		imagefilledrectangle($thumb, 0, 0, $rewidth-1, $reheight-1, $white);

	switch($type)
	{
		case 'gif' :
			if(!function_exists('imagecreatefromgif')) return false;
			$src = imagecreatefromgif($Path."/".$imgName);
		break;
		case 'jpeg' : case 'jpg' :
			if(!function_exists('imagecreatefromjpeg')) return false;
			$src = imagecreatefromjpeg($Path."/".$imgName);
		break;
		case 'png' :
			if(!function_exists('imagecreatefrompng')) return false;
			$src = imagecreatefrompng($Path."/".$imgName);
		break;
		case 'wbmp' : case 'bmp' :
			if(!function_exists('imagecreatefromwbmp')) return false;
			$src = imagecreatefromwbmp($Path."/".$imgName);
		break;
		default :
			return;
		break;
	}

	$new_width = (int)($width * $per);
	$new_height = (int)($height * $per);

	if($thum_type == "crop")
	{
		$x = (int)($rewidth/2 - $new_width/2);
		$y = (int)($reheight/2 - $new_height/2);
	}
	else
	{
		$x = ceil(($w-$new_width)/2);
		$y = ceil(($h-$new_height)/2);
		/*
		if(($width/$w) < ($height/$h))	//세로기준
			$x = ceil(($w-$new_width)/2);
		else
			$x = 0;


		if(($height/$h) < ($width/$w))	//가로기준
			$y = ceil(($h-$new_height)/2);
		else
			$y = 0;
		*/
	}

	//print($height/$h . "/". $width/$w); exit;

	if($src)
	{
		if(function_exists("imagecopyresampled"))
			imagecopyresampled($thumb, $src, $x, $y, 0, 0, $new_width, $new_height, $width, $height);
		else
			imagecopyresized($thumb, $src, $x, $y, 0, 0, $new_width, $new_height, $width, $height);
	}
	else
		return false;

	if(!$target_path) $target_path = $Path;

	if(!is_dir($target_path))
	{
		@mkdir($target_path, 0707);
		@chmod($target_path, 0707);
	}

	switch($type)
	{
		case 'gif' :
			if(!function_exists("imagegif")) return false;
			$output = imagegif($thumb, $target_path."/".$imgRename);
		break;
		case 'jpeg' : case 'jpg' :
			if(!function_exists('imagejpeg')) return false;
			$output = imagejpeg($thumb, $target_path."/".$imgRename, 100);
		break;
		case 'png' :
			if(!function_exists('imagepng')) return false;
			$output = imagepng($thumb, $target_path."/".$imgRename, 9);
		break;
		case 'wbmp' : case 'bmp' :
			if(!function_exists('imagewbmp')) return false;
			$output = imagewbmp($thumb, $target_path."/".$imgRename, 100);
		break;
	}

	imagedestroy($thumb);
	imagedestroy($src);

	if(!$output) return false;
	@chmod($target_path."/".$imgRename, 0644);

	return true;
}
?>
