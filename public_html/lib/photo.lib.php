<?php
/*************************************************************************
**
**  사진 함수 모음
**
**  사진이 저장되는 경로는 /data/$type/
**
*************************************************************************/

//불러오기
function photo_get($id, $field="*") {

	if(!$id) {
		echo "no id";;
		return false;
	}

	$q = "select {$field} from photo where id='{$id}'";
	$data = sql_fetch($q);

	return $data;
}

//대표사진불러오기
function photo_get_rep($type, $type_pk, $field="*") {
    
	$q = "select {$field} from photo where type='{$type}' and type_pk='{$type_pk}' order by id desc limit 1";
	$data = sql_fetch($q);

	return $data;
}

//사진 업로드
function photo_upload($type, $type_pk) {

	global $_FILES, $config;
	$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
    
    $err = array('type'=>0, 'filename'=>'');
    
	if(!$type || !$type_pk) {
		return false;
	}

	$file_upload_msg = "";
	$upload = array();
	for ($i=0; $i<count($_FILES['files']['name']); $i++) 
	{
		$tmp_file  = $_FILES['files']['tmp_name'][$i];
		$filesize  = $_FILES['files']['size'][$i];
		$filename  = $_FILES['files']['name'][$i];
		$filename  = preg_replace('/(\s|\<|\>|\=|\(|\))/', '_', $filename);


			echo "<pre>";
			print_r($_FILES);
			echo "</pre>";

 
		// 서버에 설정된 값보다 큰파일을 업로드 한다면
		if ($filename)
		{
			if ($_FILES['files']['error'][$i] == 1)
			{
				//$file_upload_msg .= "\'{$filename}\' 파일의 용량이 서버에 설정($upload_max_filesize)된 값보다 크므로 업로드 할 수 없습니다.\\n";
				$err['type'] = 1;
				$err['filesize'] = $filesize;
                $err['filename'] = $filename;
                return $err;
			}
			else if ($_FILES['files']['error'][$i] != 0)
			{
				//$file_upload_msg .= "\'{$filename}\' 파일이 정상적으로 업로드 되지 않았습니다.\\n";
                $err['type'] = 2;
                $err['filename'] = $filename;
                return $err;
			}
		}
 
		if (is_uploaded_file($tmp_file)) 
		{
			//=================================================================\
			// 090714
			// 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
			// 에러메세지는 출력하지 않는다.
			//-----------------------------------------------------------------
			$timg = @getimagesize($tmp_file);
			// image type
			if ( preg_match("/\.($config[cf_image_extension])$/i", $filename) ||
				 preg_match("/\.($config[cf_flash_extension])$/i", $filename) ) 
			{
				if ($timg[2] < 1 || $timg[2] > 16)
				{
					//$file_upload_msg .= "\'{$filename}\' 파일이 이미지나 플래시 파일이 아닙니다.\\n";
                    $err['type'] = 3;
                    $err['filename'] = $filename;
                    return $err;
				}
			}
			//=================================================================

			$upload[$i]['image'] = $timg;
			
			// 프로그램 원래 파일명
			$upload[$i]['source'] = $filename;
			$upload[$i]['filesize'] = $filesize;

			// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
			$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

			shuffle($chars_array);
			$shuffle = implode("", $chars_array);

			// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
			//$upload[$i][file] = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode($filename)); 
			$upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename))); 

			$dest_file = "../data/file/{$type}/" . $upload[$i]['file'];

			// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
			$error_code = @move_uploaded_file($tmp_file, $dest_file);
            if ($error_code != '1') {
                $err['type'] = 4;
				$err['error_num'] = getcwd();
                $err['filename'] = $filename;
                return $err;
            }

			// 올라간 파일의 퍼미션을 변경합니다.
			chmod($dest_file, 0606);

			//$upload[$i][image] = @getimagesize($dest_file);

			//db에 넣기
			$q = "insert into photo set type='{$type}', type_pk='{$type_pk}', filename_org='{$filename}', filename='" . $upload[$i]['file'] . "', filesize='{$filesize}', regdate=now()";
			sql_query($q);
		}
	}
    return $err;
}

//사진 리스트
function photo_list($options) {

	$search_where = "";

	//검색조건
	if(isset($options['type']) && $options['type']) $search_where .= " and type='" . $options['type'] . "' ";
	if(isset($options['type_pk']) && $options['type_pk']) $search_where .= " and type_pk='" . $options['type_pk'] . "' ";
	if(isset($options['ids']) && $options['ids']) $search_where .= " and id in (" . $options['ids'] . ") ";
    
	//정렬
	$order_field = "id";
	$order_sort = "desc";
	if(isset($options['order_field']) && $options['order_field']) $order_field = $options['order_field'];
	if(isset($options['order_sort']) && $options['order_sort']) $order_sort = $options['order_sort'];

	$q = "select * from photo where 1=1 {$search_where}";

	//페이징
	$page_rows = (isset($options['page_rows']) && $options['page_rows'])? $options['page_rows'] : 10;
	$total_count = sql_total($q);
	$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
	$page = (isset($options['page']) && $options['page'])? $options['page'] : 1;
	$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

	//쿼리 1차 생성
	$q .= " order by {$order_field} {$order_sort} limit {$from_record}, {$page_rows}";
	$list = sql_list($q);

	if(count($list)) {
		foreach($list as $k => $v) {
		    $type = '';
		    if (isset($options['type'])) $type = $options['type'];
			$list[$k]['filepath'] = "/data/file/" . $type . "/" . $v['filename'];
		}
	}

	$result['list'] = $list;
	$result['total_count'] = $total_count;
	$result['total_page'] = $total_page;

	return $result;
}


//삭제
function photo_del($ids) {

	if(!$ids) {
		echo "no id";
		return false;
	}

	$options['ids'] = $ids;
	$list = photo_list($options);

	if(count($list['total_count'])) {
		foreach($list['list'] as $k => $v) {
			//@unlink("/data/file/{$v[type]}/".$v['filename']);
			$q = "delete from photo where id='" . $v['id'] . "'";
			//echo $q.'<br>';
			sql_query($q);
		}
	}
}

?>