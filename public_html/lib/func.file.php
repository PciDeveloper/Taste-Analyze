<?
/**
* File function utility
*
* @Update		:	2014-07-29
* @Description	:	PHP File User Function Utility
*/
function FileUpload($aFile, $oFile="", $path)
{
	if($aFile['size'])
	{
		if($oFile)
			FileDelete($oFile, $path);

		$aTmp = explode(".", $aFile['name']);
		$tmp = explode("/", $path);
		$tmp = $tmp[sizeof($tmp) - 1];

		$filename = $tmp . substr(time(), 5, 5)."_";

		for($i=0; ; $i++)
		{
			$sTmp = sprintf("%s%s.%s", $filename, $i, $aTmp[sizeof($aTmp) -1]);

			if(!file_exists($path."/".$sTmp))
			{
				$filename = $sTmp;
				break;
			}
		}

		@copy($aFile['tmp_name'], $path."/".$filename);
		@unlink($aFile['tmp_name']);
	}

	return $filename;

}

//상품에만 사용하는 업로드
function FileUploadGood($aFile, $oFile="", $path,$aFilename)
{
	if($aFile['size'])
	{
		if($oFile)
			FileDelete($oFile, $path);

		$aTmp = explode(".", $aFile['name']);
		$tmp = explode("/", $path);
		$tmp = $tmp[sizeof($tmp) - 1];

		$filename = $aFilename;

		for($i=0; ; $i++)
		{
			$sTmp = sprintf("%s%s.%s", $filename, $i, $aTmp[sizeof($aTmp) -1]);

			if(!file_exists($path."/".$sTmp))
			{
				$filename = $sTmp;
				break;
			}
		}

		@copy($aFile['tmp_name'], $path."/".$filename);
		@unlink($aFile['tmp_name']);
	}

	return $filename;

}

function ArrFileUpload2($fname, $tmp, $ofname="", $path,$aFilename)
{
	if($fname)
	{
		if($ofname)
			FileDelete($ofname, $path);

		$aTmp = explode(".", $fname);

		$ftmp = explode('/', $path);
		$ftmp = $ftmp[sizeof($ftmp) - 1];

		$fname = $aFilename. "_";

		//중복 파일 체크
		for($i = 0; ; $i++)
		{
			$sTmp = sprintf("%s%s.%s", $fname, $i, $aTmp[sizeof($aTmp) - 1]);

			if(!file_exists($path . "/" . $sTmp))
			{
				$fname = $sTmp;

				break;
			}
		}

		@copy($tmp, $path . "/" . $fname); //파일복사
		@unlink($tmp);
	}

	return $fname;
}
function ArrFileUpload($fname, $tmp, $ofname="", $path)
{
	if($fname)
	{
		if($ofname)
			FileDelete($ofname, $path);

		$aTmp = explode(".", $fname);

		$ftmp = explode('/', $path);
		$ftmp = $ftmp[sizeof($ftmp) - 1];

		$fname = $ftmp . substr(time(),5,5) . "_";

		//중복 파일 체크
		for($i = 0; ; $i++)
		{
			$sTmp = sprintf("%s%s.%s", $fname, $i, $aTmp[sizeof($aTmp) - 1]);

			if(!file_exists($path . "/" . $sTmp))
			{
				$fname = $sTmp;

				break;
			}
		}

		@copy($tmp, $path . "/" . $fname); //파일복사
		@unlink($tmp);
	}

	return $fname;
}

function FileDelete($filename, $path)
{
	@unlink($path . "/" . $filename);
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

## image 출력태그 ##
function getImageTag($path, $name, $w="", $h="", $class="", $imgid="", $noimg="")
{
	$imgpath = $path."/".$name;
	$imginfo = @getImageSize($imgpath);

	if(!$noimg)
	{
		if((!file_exists($imgpath) || $name=="") && !$imginfo)
			return "";
	}

	if($class)
		$class=sprintf("class=\"%s\"", $class);

	if($imgid)
		$imgid = sprintf("id=\"%s\"", $imgid);

	$width = ($w) ? $w : $imginfo[0];
	$height = ($h) ? $h : $imginfo[1];

	if($noimg)
		$onerror = sprintf("onerror=\"javascript:this.src='%s'\"", $noimg);
	else
		$onerror = '';

	if(preg_match("/^image/i", $imginfo['mime']))
		$Tag = sprintf("<img src=\"%s\" width=\"%s\" align=\"absmiddle\" alt=\"\" %s %s %s />", $imgpath,'50px',  $class, $imgid, $onerror);
	else if(!$imginfo && $noimg)
		$Tag = sprintf("<img src=\"%s\" width=\"%s\" align=\"absmiddle\" alt=\"\" %s %s %s />", $imgpath, '50px',  $class, $imgid, $onerror);
	else
		$Tag =<<< TAGS
			<script type="text/javascript">
			setem = new setEmbed();
			setem.init("flash", "{$imgpath}", "{$width}", "{$height}");
			setem.parameter("wmode", "transparent");
			setem.show();
			</script>
TAGS;

	return $Tag;
}

function getImageTag2($path, $name, $w="", $h="", $class="", $imgid="", $noimg="")
{
	$imgpath = $path."/".$name;
	$imginfo = @getImageSize($imgpath);

	if(!$noimg)
	{
		if((!file_exists($imgpath) || $name=="") && !$imginfo)
			return "";
	}

	if($class)
		$class=sprintf("class=\"%s\"", $class);

	if($imgid)
		$imgid = sprintf("id=\"%s\"", $imgid);

	$width = ($w) ? $w : $imginfo[0];
	$height = ($h) ? $h : $imginfo[1];

	if($noimg)
		$onerror = sprintf("onerror=\"javascript:this.src='%s'\"", $noimg);
	else
		$onerror = '';

	if(preg_match("/^image/i", $imginfo['mime']))
		$Tag = sprintf("<img src=\"%s\" width=\"%s\" height=\"%s\"  align=\"absmiddle\" alt=\"\" %s %s %s />", $imgpath,$width, $height,  $class, $imgid, $onerror);
	else if(!$imginfo && $noimg)
		$Tag = sprintf("<img src=\"%s\" width=\"%s\" height=\"%s\"  align=\"absmiddle\" alt=\"\" %s %s %s />", $imgpath, $width, $height,  $class, $imgid, $onerror);
	else
		$Tag =<<< TAGS
			<script type="text/javascript">
			setem = new setEmbed();
			setem.init("flash", "{$imgpath}", "{$width}", "{$height}");
			setem.parameter("wmode", "transparent");
			setem.show();
			</script>
TAGS;

	return $Tag;
}


## image Width기준으로 Resize ##
function getImgResize($path, $imgName, $maxW)
{
	$info = @getimagesize($path."/".$imgName);

	if($info[0] > $maxW){
		$reW = $maxW;
		$reH = $info[1] * $maxW / $info[0];
	}else{
		$reW = $info[0];
		$reH = $info[1];
	}

	$viewImg = "<img src='{$path}/{$imgName}' width='{$reW}' height='{$reH}' align='absmiddle' border='0' />";

	return $viewImg;
}

## MIME Check ##
function getMimeContentType($aFile)
{
	if(!function_exists('mime_content_type') && $aFile['tmp_name'])
	{
		$f = escapeshellarg($aFile['tmp_name']);
		return shell_exec("file -bi ".$f);
	}
	else if($aFile['tmp_name'])
		return mime_content_type($aFile['tmp_name']);
}

## 유효한 MIME 체크 (추후 배열추가예정) ##
function isMimeContentType($mime)
{
	$arr_mime = array("application/x-zip-compressed", "application/zip", "multipart/x-gzip", "multipart/x-zip", "application/x-zip");

	if(in_array(trim($mime), $arr_mime))
		return true;
	else
		return false;
}

function crateThumImg1($img, $data_path, $thumb_path, $img_width = 500,$img_height = 500, $img_quality = 99, $option = 2)
{

   if (!function_exists("imagecopyresampled")) alert("GD 2.0.1 이상 버전이 설치되어 있어야 사용할 수 있습니다.");

   @mkdir($thumb_path, 0707);
   @chmod($thumb_path, 0707);

   $thumb = $thumb_path.$img;

   // 썸네일 이미지가 존재하지 않는다면

   //if (!file_exists($thumb)) {

      $file = $data_path.$img;
	  $img = "thum_".$img;
      // 업로드된 파일이 이미지라면
      if (preg_match("/\.(jp[e]?g|gif|png)$/i", $file) && file_exists($file)) {
         $size = getimagesize($file);

         if ($size[2] == 1){
            $src = imagecreatefromgif($file);
            $image_ext = "gif";
         }else if ($size[2] == 2){
            $src = imagecreatefromjpeg($file);
            $image_ext = "jpg";
         }else if ($size[2] == 3){
            $src = imagecreatefrompng($file);
            $image_ext = "png";
         }else{
            break;
         }

         if($option == 1){ // 세로 기준으로 맞춤

            if (($img_width / $img_height) > ($size[0] / $size[1])){   // 세로가 더 긴 이미지
               $rate = $img_height / $size[1];
               $width = (int)($size[0] * $rate);

               // 설정된 이미지 높이로 복사본 이미지 생성
               $dst = imagecreatetruecolor($width, $img_height);
               imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $img_height, $size[0], $size[1]);
               imagejpeg($dst, $thumb_path.$img, $img_quality);
               chmod($thumb_path.$img, 0777);
            } else {   // 가로가 더 긴 이미지
               $rate = $img_height / $size[1];
               $width = (int)($size[0] * $rate);

               // 계산된 썸네일 이미지의 높이가 설정된 이미지의 높이보다 작다면

               // 설정된 이미지 높이로 복사본 이미지 생성
               $dst = imagecreatetruecolor($img_width, $img_height);
               imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $img_height, $size[0], $size[1]);
               imagejpeg($dst, $thumb_path.$img, $img_quality);
               chmod($thumb_path.$img, 0777);
            }

         } else if($option == 2){ // 가로세로 비율 유지

            $rate = $img_width / $size[0];
            $height = (int)($size[1] * $rate);

            // 설정된 이미지 높이로 복사본 이미지 생성
            $dst = imagecreatetruecolor($img_width, $height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $img_width, $height, $size[0], $size[1]);
            imagejpeg($dst, $thumb_path.$img, $img_quality);
            chmod($thumb_path.$img, 0777);

         } else if($option == 3) { //설정된 크기로 가운데 크롭
            //원본의 이미지 리소스를 받아온다. 정사각형 크롭
            list($src, $src_w, $src_h) = get_image_resource_from_file ($file);
            if (empty($src)) die($GLOBALS['errormsg'] . "<br />\n");
            $dst_w = $img_width;
            $dst_h = $img_height;
            $dst_200X200 = get_image_cropresize($src, $src_w, $src_h, $dst_w, $dst_h);
            if ($dst_200X200 === false) die($GLOBALS['errormsg'] . "<br />\n");

            $result_save = save_image_from_resource ($dst_200X200, $thumb);//저장
         } else if($option == 4) { //원본사이즈
            $width = $size[0];
            $height = $size[1];

            // 설정된 이미지 높이로 복사본 이미지 생성
            $dst = imagecreatetruecolor($width, $height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            imagejpeg($dst, $thumb_path.$img, $img_quality);
            chmod($thumb_path.$img, 0777);

         }
         else if($option == 5){ // 가로기준 정사각형
               echo "asdas";
               $rate = $img_width / $size[0];
               $height = (int)($size[1] * $rate);

               // 설정된 이미지 높이로 복사본 이미지 생성
               $dst_200X200 = get_image_cropresize($src, $src_w, $src_h, $dst_w, $dst_h);
               $dst = imagecreatetruecolor($img_width, $height);
               imagecopyresampled($dst, $src, 0, 0, 0, 0, $img_width, $img_height, $img_width, $height);
               imagejpeg($dst, $thumb_path.$img, $img_quality);
               chmod($thumb_path.$img, 0777);


         }
      }
   //}


   if (file_exists($thumb_path.$img)){
      return $img;
   }
}

function crateThumImg2($img, $data_path, $thumb_path, $img_width ,$img_height , $img_quality = 99, $option = 2)
{

   if (!function_exists("imagecopyresampled")) alert("GD 2.0.1 이상 버전이 설치되어 있어야 사용할 수 있습니다.");

   @mkdir($thumb_path, 0707);
   @chmod($thumb_path, 0707);

   $thumb = $thumb_path.$img;

   // 썸네일 이미지가 존재하지 않는다면

   //if (!file_exists($thumb)) {

      $file = $data_path.$img;
	  $img = $img;
      // 업로드된 파일이 이미지라면
      if (preg_match("/\.(jp[e]?g|gif|png)$/i", $file) && file_exists($file)) {
         $size = getimagesize($file);

         if ($size[2] == 1){
            $src = imagecreatefromgif($file);
            $image_ext = "gif";
         }else if ($size[2] == 2){
            $src = imagecreatefromjpeg($file);
            $image_ext = "jpg";
         }else if ($size[2] == 3){
            $src = imagecreatefrompng($file);
            $image_ext = "png";
         }else{
            break;
         }

         if($option == 1){ // 세로 기준으로 맞춤

            if (($img_width / $img_height) > ($size[0] / $size[1])){   // 세로가 더 긴 이미지
               $rate = $img_height / $size[1];
               $width = (int)($size[0] * $rate);

               // 설정된 이미지 높이로 복사본 이미지 생성
               $dst = imagecreatetruecolor($width, $img_height);
               imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $img_height, $size[0], $size[1]);
               imagejpeg($dst, $thumb_path.$img, $img_quality);
               chmod($thumb_path.$img, 0777);
            } else {   // 가로가 더 긴 이미지
               $rate = $img_height / $size[1];
               $width = (int)($size[0] * $rate);

               // 계산된 썸네일 이미지의 높이가 설정된 이미지의 높이보다 작다면

               // 설정된 이미지 높이로 복사본 이미지 생성
               $dst = imagecreatetruecolor($img_width, $img_height);
               imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $img_height, $size[0], $size[1]);
               imagejpeg($dst, $thumb_path.$img, $img_quality);
               chmod($thumb_path.$img, 0777);
            }

         } else if($option == 2){ // 가로세로 비율 유지

            $rate = $img_width / $size[0];
            $height = (int)($size[1] * $rate);

            // 설정된 이미지 높이로 복사본 이미지 생성
            $dst = imagecreatetruecolor($img_width, $height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $img_width, $height, $size[0], $size[1]);
            imagejpeg($dst, $thumb_path.$img, $img_quality);
            chmod($thumb_path.$img, 0777);

         } else if($option == 3) { //설정된 크기로 가운데 크롭
            //원본의 이미지 리소스를 받아온다. 정사각형 크롭
            list($src, $src_w, $src_h) = get_image_resource_from_file ($file);
            if (empty($src)) die($GLOBALS['errormsg'] . "<br />\n");
            $dst_w = $img_width;
            $dst_h = $img_height;
            $dst_200X200 = get_image_cropresize($src, $src_w, $src_h, $dst_w, $dst_h);
            if ($dst_200X200 === false) die($GLOBALS['errormsg'] . "<br />\n");

            $result_save = save_image_from_resource ($dst_200X200, $thumb);//저장
         } else if($option == 4) { //원본사이즈
            $width = $size[0];
            $height = $size[1];

            // 설정된 이미지 높이로 복사본 이미지 생성
            $dst = imagecreatetruecolor($width, $height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            imagejpeg($dst, $thumb_path.$img, $img_quality);
            chmod($thumb_path.$img, 0777);

         }
         else if($option == 5){ // 가로기준 정사각형
               echo "asdas";
               $rate = $img_width / $size[0];
               $height = (int)($size[1] * $rate);

               // 설정된 이미지 높이로 복사본 이미지 생성
               $dst_200X200 = get_image_cropresize($src, $src_w, $src_h, $dst_w, $dst_h);
               $dst = imagecreatetruecolor($img_width, $height);
               imagecopyresampled($dst, $src, 0, 0, 0, 0, $img_width, $img_height, $img_width, $height);
               imagejpeg($dst, $thumb_path.$img, $img_quality);
               chmod($thumb_path.$img, 0777);


         }
      }
   //}


   if (file_exists($thumb_path.$img)){
      return $img;
   }
}
?>
