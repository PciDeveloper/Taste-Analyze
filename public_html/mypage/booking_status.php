<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FILE__)."/../inc/html_header.php");
$userinfo = getUser($_SESSION['SES_USERIDX']);
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$sqry = sprintf("select * from %s where idx='%d'", "sw_booking", $idx);
	$row = $db->_fetch($sqry);

  $sqry2 = sprintf("select * from %s where idx='%d'", "sw_goods", $row['gidx']);
	$goods = $db->_fetch($sqry2);


	$exIcon = explode(",", $goods['icon']);
	if($goods['imgetc'])
		$exImg = explode(",", $goods['imgetc']);

	$exetc1 = @explode("」「", $goods['etc1']);
	$exetc2 = @explode("」「", $goods['etc2']);
	$exetc3 = @explode("」「", $goods['etc3']);
}
else
	msg("예약이 삭제되었거나 존재하지 않습니다.", -1, true);


  switch ($row['status']) {
    case 1:
      $status = "접수완료";
    break;
    case 2:
      $status = "입금대기";
    break;
    case 3:
      $status = "결제완료";
    break;
    default:
      $status = "접수완료";
    break;
  }
?>
<script>
function cancel(idx){
  var txt;
  if (confirm("예약을 정말 취소하시겠습니까?")) {
     var f = document.fm;
     f.act.value = "cancel";
     f.idx.value = idx;
     f.submit();
  } else {
    return;
  }
}
</script>
<form name="fm" action="/mypage/common.act.php" method="post">
  <input type="hidden" name="idx" value="">
  <input type="hidden" name="act" value="">
</form>
<!--컨텐츠-->
<div id="content">
<div class="reservation_detail_wrap">
        <!--예약상세보기-->
  <div class="reservation_detail">
    <ul>
      <li>예약상세보기</li>
            </ul>
        </div>
        <!--예약코드-->
        <div class="reservation_code_wrap">
            <div class="code_left">
                <p clas="code">예약코드 : <?=$row['code']?></p>
                <p class="tag"><?=$goods['shortexp']?></p>
                <p class="tit">[<?=$arr_area[$part_area_keys[$goods['etc1']]]?>]<?=$goods['name']?></p>
                <p class="info"><?=$goods['sday']?> ~ <?=$goods['eday']?> | <?php if($goods['etc2'] == "99"){?>조율가능<?php }else{?><?=$goods['etc2']?>:00<?}?> |
                                           <?php if($goods['etc1'] == "1"){?>2인이하 <?php }?>
                                          <?php if($goods['etc1'] == "2"){?>4인이하 <?php }?>
                                          <?php if($goods['etc1'] == "3"){?>6인이하 <?php }?>
                                          <?php if($goods['etc1'] == "4"){?>8인이하 <?php }?>
                                          <?php if($goods['etc1'] == "5"){?>10인이하 <?php }?>
                                          <?php if($goods['etc1'] == "6"){?>20인이하 <?php }?>
                                          <?php if($goods['etc1'] == "7"){?>30인이하 <?php }?>
                                          <?php if($goods['etc1'] == "8"){?>40인이하 <?php }?>
                                          <?php if($goods['etc1'] == "9"){?>50인이상 <?php }?> | <?=$goods['address']?></p>
                <p class="money"><?=number_format($goods['nprice'])?>원</p>
            </div>
            <div class="code_right">
                <h1><?=$status?></h1>
                <p><?=substr($row['regdt'], 0, 10)?></p>
                <button type="button" onclick="cancel('<?=$row['idx']?>')">예약취소</button>
            </div>
        </div>
        <!--무통장입금-->
        <div class="payment_notice">
            <h1>무통장 입금안내</h1>
            <ul class="bank_info" >
                <li><?=$siteinfo['AccountBank']?></li>
                <li><?=$siteinfo['AccountNum']?></li>
                <li class="bank_name">예금주:<?=$siteinfo['AccountName']?></li>
            </ul>
            <ul>
                <li>- 계좌이체까지 완료되어야 예약이 완료됩니다.</li>
                <li>- 구매자의 이름과 계좌이체시 입금자의 명이 다르면 확인이 어려울 수 있습니다.</li>
                <li>- 결제 후 영업일 기준 2일이내 입금을 하셔야 예약이 완료됩니다. </li>
                <li>- 예약완료 후 예약을 취소하는 경우 체험넷의 환불규정에 따라 전액환불이 불가 할 수 있습니다.</li>
                <li>- 체험일이 지난 후에는 환불이 불가능합니다.</li>
            </ul>
        </div>
      </ul>
</div>
</div>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
