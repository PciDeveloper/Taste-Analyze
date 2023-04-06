<?php
include $_SERVER["DOCUMENT_ROOT"].'/api/inc/_header.php';
/*
	파일 업로드 API (영상 등록)
	Return  - 회원정보
					- status 1: 성공, 2: 실패, 3: 필수정보 누락

	Parameter
	useridx
	video
*/

/* 여기는 파일 업로드 api

분석리스트 테이블로 insert

필수로 받아야 하는거 useridx , video (Parameter)

insert 후에 내려줄때 게시물의 idx 도 내려주기 */

error_log("push_token ----- ".var_export($_REQUEST, true)."\n", 3, "/home/jeonju/log/custom.log");

error_log("push_token ----- ".var_export($_FILES, true)."\n", 3, "/home/jeonju/log/custom.log");

if($_REQUEST['useridx'] == ""){
	$data_json['status'] = (int)"3";
	$data_json['msg'] = "필수정보 누락";
	$json =  json_encode($data_json);
	echo $json;
	exit;
}

if(!empty($_FILES['video']['name']))
{
	// if($_FILES['video']['size'] >= 30000000){
	// 	$data_json['status'] = (int)"2";
	// 	$data_json['msg'] = "영상은 최대 30M 등록 가능합니다.";
	// 	$json =  json_encode($data_json);
	// 	echo $json;
	// 	exit;
	// }else{
	// 	$video = fileUpload($_FILES['video'],$_FILES['video'], $_SERVER[DOCUMENT_ROOT].'/upload/goods/big');
	// }
	$video = fileUpload($_FILES['video'],$_FILES['video'], $_SERVER[DOCUMENT_ROOT].'/upload/goods/big');
}

if(!empty($_FILES['thum']['name']))
{
	$thum = fileUpload($_FILES['thum'],$_FILES['thum'], $_SERVER[DOCUMENT_ROOT].'/upload/goods/big');

}

$isqry = "insert into sw_taste set
							useridx 	 = '".$_REQUEST['useridx']."',
              video    	 = '".$video."',
							thum    	 = '".$thum."',
							regdt 		 = now()";

if($db->_execute($isqry))
{
	$bidx = $db->getLastID();
	$row = $db->_fetch("select * from sw_taste where idx = '".$bidx."'");
	$data_json['status'] = (int)"1";
	$data_json['msg'] = "성공";
  $data_json['idx']	=	(int)$bidx;
	$data_json['regdt']	=	$row['regdt'];
	$json =  json_encode($data_json);
	echo $json;
	exit;
}
else
{
	$data_json['status'] = (int)"2";
	$data_json['msg'] = "실패";
  $data_json['idx']	=	0;
	$data_json['regdt']	=	"";
	$json =  json_encode($data_json);
	echo $json;
	exit;
}

?>
