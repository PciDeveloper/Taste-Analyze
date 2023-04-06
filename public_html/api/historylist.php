<?php
include $_SERVER["DOCUMENT_ROOT"].'/api/inc/_header.php';
/*
	APP으로부터 요청받은 데이터 처리(히스토리 리스트)
	Return  - 회원정보
          - status : 1 성공 , 0: 실패 , 3:필수정보 누락
	Parameter

  useridx   회원 idx
*/

if($useridx == ""){
  $data_json['status'] = (int)"3";
  $data_json['msg'] = "필수정보 누락";
  $json = json_encode($data_json);
  echo $json;
  exit;
}

// $sqry = "select * from sw_taste where useridx = '".$useridx."' and regdt BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW() order by regdt desc ";
// $sqry = "select * from sw_taste where useridx ='".$useridx."' and (happy != ''  and sad !='' and angry !='' and surpr !='' and scar != '' and disgus !='') and regdt BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW() order by regdt desc";
$sqry = "select * from sw_taste where useridx ='".$useridx."'  and regdt BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW() order by regdt desc";
$rs = $db->_execute($sqry);
for($i=0; $i < $row=mysql_fetch_assoc($rs); $i++){
    $list[$i]['idx']        = (int)$row['idx'];
    $list[$i]['video']	    = ($row['thum'] ? _SW_URL_."/upload/goods/big/".$row['thum'] : _SW_URL_."/img/icon/noimage.png");
    $list[$i]['emotion']    = ($row['emotion'] ? (int)$row['emotion'] : 0);
    $list[$i]['sweetstp']   = ($row['sweetstp'] ? (int)$row['sweetstp'] : 0);
    $list[$i]['bitstp']     = ($row['bitstp'] ? (int)$row['bitstp'] : 0);
    $list[$i]['saltstp']    = ($row['saltstp'] ? (int)$row['saltstp'] : 0);
    $list[$i]['sourstp']    = ($row['sourstp'] ? (int)$row['sourstp'] : 0);
    $list[$i]['spicystp']   = ($row['spicystp'] ? (int)$row['spicystp'] : 0);
    $list[$i]['regdt']	    = ($row['regdt'] ? $row['regdt'] : "");
    $list[$i]['updt']	    = ($row['updt'] ? $row['updt'] : "");
    // $data_json[$i]['video']	  =	($row['video'] ? sw_history."/upload/goods/".$row['video'] : sw_history."/upload/goods/");
}
$data_json['status']      = 1;
$data_json['msg']         = "성공";
$data_json['historyList'] = ($list) ? $list : array();
$json =  json_encode($data_json);
echo $json;
exit;

?>
