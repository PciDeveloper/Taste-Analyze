<?php
include $_SERVER["DOCUMENT_ROOT"].'/api/inc/_header.php';
/*
	영상 분석 결과 API
	Return  - 회원정보
					- status
	Parameter
	useridx
	idx
*/

/* 여기는 분석 결과 보여주는 api

필수로 받아야 하는거 regpost 에서 내려준 idx , useridx

select 분석테이블 조건 idx

결과 모두 내려주기

최근 분석결과 idx 1개, 리스트 전부 1개  idx가 -1일때는 전체 , else 해당 idx 조회
앱에서 보내온 파라미터 idx 로 비교 */

if($useridx == ""){
  $data_json['status'] = (int)"4";
  $data_json['msg'] = "필수정보 누락";
  $json =  json_encode($data_json);
  echo $json;
  exit;
}

$sqry = "select * from sw_taste where idx = '".$_REQUEST['idx']."'";
$qry = $db->_fetch($sqry);

for($i =0; $i < $row=mysqli_fetch_assoc($qry); $i++){
  $list[$i]['idx'] = $row['idx'];
  if($row['idx']){
    $data_json['status']       = 1;
    $data_json['msg']          = "성공";
    $data_json['idx']          = ($row['idx'] ? $row['idx'] : "");
    $data_json[$i]['video']	   = ($row['video'] ? _SW_URL_."/upload/goods/big".$row['video'] : _SW_URL_."/upload/goods/big");
		$data_json[$i]['happy'] 	 = ($row['happy'] ? $row['happy'] : "");
		$data_json[$i]['sad'] 		 = ($row['sad'] ? $row['sad'] : "");
		$data_json[$i]['angry'] 	 = ($row['angry'] ? $row['angry'] : "");
		$data_json[$i]['surpr'] 	 = ($row['surpr'] ? $row['surpr'] : "");
		$data_json[$i]['scar'] 		 = ($row['scar'] ? $row['scar'] : "");
		$data_json[$i]['disgus'] 	 = ($row['disgus'] ? $row['disgus'] : "");
    $data_json[$i]['emotion']  = ($row['emotion'] ? $row['emotion'] : 0);
		$data_json[$i]['mood'] 		 = ($row['mood'] ? $row['mood'] : "");
		$data_json[$i]['sweetstp'] = ($row['sweetstp'] ? $row['sweetstp'] : 0);
		$data_json[$i]['bitstp'] 	 = ($row['bitstp'] ? $row['bitstp'] : 0);
		$data_json[$i]['saltstp']  = ($row['saltstp'] ? $row['saltstp'] : 0);
		$data_json[$i]['sourstp']  = ($row['sourstp'] ? $row['sourstp'] : 0);
    $data_json[$i]['spicystp'] = ($row['spicystp'] ? $row['spicystp'] : 0);
  }else{
		$data_json['status']       = 0;
    $data_json['msg']          = "실패";
    $data_json['idx']          = ($row['idx'] ? $row['idx'] : "");
    $data_json[$i]['video']	   =	($row['video'] ? _SW_URL_."/upload/goods/big".$row['video'] : _SW_URL_."/upload/goods/big");
		$data_json[$i]['happy'] 	 = ($row['happy'] ? $row['happy'] : "");
		$data_json[$i]['sad'] 		 = ($row['sad'] ? $row['sad'] : "");
		$data_json[$i]['angry'] 	 = ($row['angry'] ? $row['angry'] : "");
		$data_json[$i]['surpr'] 	 = ($row['surpr'] ? $row['surpr'] : "");
		$data_json[$i]['scar'] 		 = ($row['scar'] ? $row['scar'] : "");
		$data_json[$i]['disgus'] 	 = ($row['disgus'] ? $row['disgus'] : "");
    $data_json[$i]['emotion']  = ($row['emotion'] ? $row['emotion'] : 0);
		$data_json[$i]['mood'] 		 = ($row['mood'] ? $row['mood'] : "");
		$data_json[$i]['sweetstp'] = ($row['sweetstp'] ? $row['sweetstp'] : 0);
		$data_json[$i]['bitstp'] 	 = ($row['bitstp'] ? $row['bitstp'] : 0);
		$data_json[$i]['saltstp']  = ($row['saltstp'] ? $row['saltstp'] : 0);
		$data_json[$i]['sourstp']  = ($row['sourstp'] ? $row['sourstp'] : 0);
    $data_json[$i]['spicystp'] = ($row['spicystp'] ? $row['spicystp'] : 0);
  }
}

if ($row['idx']) {
  $data_json['status']      = 2;
  $data_json['msg']         = "성공 idx";
	$data_json['idx'] 				= $row['idx'];
  $data_json['historyList']         = $list ? $list : array();
}else {
  $data_json['status']      = 3;
  $data_json['msg']         = "실패";
	$data_json['idx'] = $row['idx'];
  $data_json['historyList']         = $list ? $list : array();
}

$json =  json_encode($list);
echo $json;
exit;

?>
