<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FILE__)."/../inc/html_header.php");
goLogin();
$userinfo = getUser($_SESSION['SES_USERIDX']);

//접수완료
list($step1Cnt) = $db->_fetch("select count(*) from sw_booking where useridx ='".$userinfo['idx']."' and status = '1'");
//입금대기
list($step2Cnt) = $db->_fetch("select count(*) from sw_booking where useridx ='".$userinfo['idx']."' and status = '2'");
//결제완료
list($step3Cnt) = $db->_fetch("select count(*) from sw_booking where useridx ='".$userinfo['idx']."' and status = '3'");
?>
<script>
function cancel(idx ,status){
  var txt;
  if (status == 3){
    txt = "예약을 정말 취소하시겠습니까?";
  }else{
    txt = "접수를 정말 취소하시겠습니까?";
  }
  if (confirm(txt)) {
     var f = document.fm;
     f.act.value = "cancel";
     f.idx.value = idx;
     f.status.value = status;
     f.submit();
  } else {
    return;
  }
}

function logout(){
  location.href = "/member/login.act.php?act=logout";
}

function chagePass(){
  location.href = "/mypage/chagepwd.php";
}

function issnsLogin(){
  alert("SNS 로그인한 경우 비밀번호 변경이 불가능합니다.");
}

</script>
<form name="fm" action="/mypage/common.act.php" method="post">
  <input type="hidden" name="idx" value="">
  <input type="hidden" name="act" value="">
  <input type="hidden" name="status" value="">
</form>
<!--컨텐츠-->
<div id="content">
    <!--유저설정영역-->
    <div class="user_setting">
        <div class="left_setting">
          <?php if($userinfo['user_type'] == 0 ){?>
          <?php if ($userinfo['photo']){?>
            <img src="/upload/member/thum/thum_<?=$userinfo['photo']?>" alt="프로필" onclick="javascript:location.href='/mypage/setting.php'" style="cursor:pointer">
          <?php } else {?>
            <img src="/img/icon/user_2.png" alt="프로필" onclick="javascript:location.href='/mypage/setting.php'" style="cursor:pointer">
          <?php }?>
        <?php }else{?>
          <img src="<?=$userinfo['photo']?>" alt="프로필" onclick="javascript:location.href='/mypage/setting.php'" style="cursor:pointer">
        <?php }?>
          <div>
              <p><?=$userinfo['name']?>님 안녕하세요!</p>
              <p><?=$userinfo['email']?></p>
          </div>
        </div>
        <div class="right_setting">
            <ul>
                <li><input type="button" value="계정설정" onclick="javascript:location.href='/mypage/setting.php'"></li>
                <?php if($userinfo['user_type'] == 0 ){?>
                <li><input type="button" value="비밀번호변경" onclick="chagePass()"></li>
              <?php }else{?>
                <li><input type="button" value="비밀번호변경" onclick="issnsLogin()"></li>
              <?php }?>
                <li><input type="button" value="로그아웃" onclick="logout()"></li>
            </ul>
        </div>
    </div>
    <!--나의예약-->
    <div class="mybooking_wrap">
        <div class="mybooking">
            <ul>
                <li>나의예약</li>
            </ul>
        </div>
        <div class="booking_all">
            <ul>
                <li><a href="./index.php">전체내역</a></li>
                <li>|</li>
                <li><a href="./index.php?status=3">결제완료</a></li>
                <li>|</li>
                <li><a href="./index.php?status=99">취소내역</a></li>
            </ul>
        </div>
        <div class="booking_process">
            <ul>
                <li>접수준비</li>
                <li><?=$step1Cnt?></li>
            </ul>
            <ul>
                <li>입금대기</li>
                <li><?=$step2Cnt?></li>
            </ul>
            <ul>
                <li>결제완료</li>
                <li><?=$step3Cnt?></li>
            </ul>
        </div>
  <!--나의예약 상세리스트-->
  <div class="booking_list_wrap">
    <?php
    if($status)
    {
      if ($status == "99"){
        	$wArr[] = "(status = '99' or status = '101') ";
      }else{
      	$wArr[] = "status = '".$status."'";
      }

    }

    if($wArr)
    	$AddW = sprintf(" AND %s", implode(" AND ", $wArr));

    $mybooking_sql = "select * from sw_booking where useridx = '".$_SESSION['SES_USERIDX']."'  $AddW   order by idx desc";
    $mybookingqry =  $db->_execute($mybooking_sql);
    $i = 1;
    for($i=$i; $row=mysql_fetch_array($mybookingqry); $i++)
    {
      $encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
      $goods = $db->_fetch("select * from sw_goods where idx='".$row['gidx']."'");
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
        case 4:
          $status = "환불예정";
        break;
        case 5:
          $status = "환불완료";
        break;
        case 99:
          $status = "접수취소완료";
        break;
        case 101:
          $status = "예약취소";
        break;
        default:
          $status = "접수완료";
        break;
      }
    ?>
    <div class="booking">
      <div class="booking_img">
        <img src="/upload/goods/big/<?=$goods['img1']?>" alt="<?=$goods['name']?>" onclick="location.href='/mypage/booking_status.php?encData=<?=$encData?>'" style="cursor:pointer;">
      </div>
      <div class="booking_list" onclick="location.href='/mypage/booking_status.php?encData=<?=$encData?>'" style="cursor:pointer;">
        <p>[<?=$arr_area[$part_area_keys[$goods['etc1']]]?>]<?=$goods['name']?></p>
      </div>
      <div class="booking_icon">
        <div>
          <ul>
            <li><img src="/img/icon/map.png" alt="장소"></li>
            <li><img src="/img/icon/calendar.png" alt="날짜"></li>
            <li><img src="/img/icon/user.png" alt="인원"></li>
          </ul>
          <ul class="booking_icon_txt">
            <li><?=$goods['address']?></li>
            <li><?=$goods['sday']?>~<br><?=$goods['eday']?></li>
            <li>
              <?php if($goods['etc1'] == "1"){?>2인이하 <?php }?>
              <?php if($goods['etc1'] == "2"){?>4인이하 <?php }?>
              <?php if($goods['etc1'] == "3"){?>6인이하 <?php }?>
              <?php if($goods['etc1'] == "4"){?>8인이하 <?php }?>
              <?php if($goods['etc1'] == "5"){?>10인이하 <?php }?>
              <?php if($goods['etc1'] == "6"){?>20인이하 <?php }?>
              <?php if($goods['etc1'] == "7"){?>30인이하 <?php }?>
              <?php if($goods['etc1'] == "8"){?>40인이하 <?php }?>
              <?php if($goods['etc1'] == "9"){?>50인이상 <?php }?>
            </li>
          </ul>
        </div>
      </div>
      <div class="booking_bt">
        <ul>
          <?php if ($row['status'] == 99){?>
            <li><button type="button" disabled><?=$status?></button></li>
          <?php }else{?>
            <?php
            $time = time();
            if (date("Y-m-d",strtotime("now", $time)) > $row['eday']){
            ?>
            <li><button type="button" style="background-color:#DCDBDB;" disabled><?=$arr_booking_status[$part_booking_keys[$row['status']]]?></button></li>
            <li><button type="button" style="background-color:#DCDBDB;" onclick="cancel('<?=$row['idx']?>' , '<?=$row['status']?>')"><?php if($row['status'] == 3){ echo "예약취소"; }else{ echo "접수취소"; }?></button></li>
          <?php }else{?>
            <li><button type="button" disabled><?=$arr_booking_status[$part_booking_keys[$row['status']]]?></button></li>
            <li><button type="button" onclick="cancel('<?=$row['idx']?>' , '<?=$row['status']?>')"><?php if($row['status'] == 3){ echo "예약취소"; }else{ echo "접수취소"; }?></button></li>
          <?php }?>
          <?php }?>

        </ul>
      </div>
    </div>
  <?php } ?>
  <?php
  if($i < 2)
  	echo("<div class='booking'><p>예약정보가 없습니다.</p></div>")
   ?>
    <!--내가찜한체험-->
    <div class="mybooking">
      <ul>
        <li>찜한 체험</li>
      </ul>
    </div>
     <div id="category_price">
     <div class="price_wrap">
      <ul>
        <?php
        $like_sql = "select * from sw_like where useridx = '".$_SESSION['SES_USERIDX']."' order by idx desc";
        $likeqry =  $db->_execute($like_sql);
        $i = 1;
        for($i=$i; $row=mysql_fetch_array($likeqry); $i++)
        {

          $goods = $db->_fetch("select * from sw_goods where idx='".$row['wr_id']."'");
          $encData = getEncode64("idx=".$goods['idx']."&start=".$start."&".$pg->getparm);
        ?>
        <li>
          <a href="/goods/goods.view.php?encData=<?=$encData?>&cate=<?=$goods['category']?>">
            <div>
              <img src="/upload/goods/big/<?=$goods['img1']?>" alt="<?=$goods['name']?>">
            </div>
            <p class="tag"><?=$goods['shortexp']?></p>
            <a href="/goods/goods.view.php?encData=<?=$encData?>&cate=<?=$goods['category']?>">
              <p class="title">[<?=$arr_area[$part_area_keys[$goods['etc1']]]?>]<?=$goods['name']?></p>
              <span class="price1"><?=number_format($goods['nprice'])?>원</span>
              <span class="price2"><?=number_format($goods['price'])?>원</span>
              <img  class="heart" src="/img/icon/heart2.png" alt="좋아요" onclick="GoodsLike.checkHandler.chkLike()">
              <input type="hidden" name="gidx" value="<?=$row['idx']?>">
          </a>
        </li>
      <?php }?>
      </ul>
    </div>

    <!--나의리뷰-->
    <div class="mybooking">
      <ul>
        <li>나의리뷰</li>
      </ul>
    </div>
      <div class="booking_reiew_wrap" id="review">

        </div>


          <!--나의문의-->
          <div class="mybooking">
            <ul>
              <li>나의문의</li>
            </ul>
          </div>
            <div class="booking_reiew_wrap" id="qna">

            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$(function(){
  LoadReview();
  LoadQna();
});

function act(mode, act)
{
var f = document.fm;

if(Common.checkFormHandler.checkForm(f))
{
  if(mode)
  {
    f.action = "/mypage/common.act.php";
    f.mode.value = mode;
    f.act.value = act;
    f.target = "ifrm";
    f.submit();
  }
}
}

function LoadReview(gidx, page)
{
  gidx = (gidx) ? gidx : $(":hidden[name='gidx']").val();
  page = (page) ? page : 1;
  $.post("./load.review.php", {"gidx" : gidx, "page" : page}, function(data){
    $("#review").html(data);
  });
}

function LoadQna(gidx, page)
{
  gidx = (gidx) ? gidx : $(":hidden[name='gidx']").val();
  page = (page) ? page : 1;

  $.post("./load.qna.php", {"gidx" : gidx, "page" : page}, function(data){
    $("#qna").html(data);
  });
}

function goPage(gidx, page, mode)
{
  if(mode == "qna")
    LoadQna(gidx, page);
  else
    LoadReview(gidx, page);
}

(function(){
	this.GoodsLike || (this.GoodsLike = {});

	GoodsLike = {
		checkHandler :
		{
			// 아이디 검사 //
			chkLike : function() {
					$.post("./common.act.php",
						{
							gidx : $(":input[name='gidx']").val(),
							act : "like"
						},
						function(data){
              if(data == 001)
              {
                 alert("좋아요 취소");
              }
              else if(data == 002)
              {
                alert("좋아요 취소");
              }
						}
					);
			}
		}
	};
})(window);

</script>
<?php
include_once(dirname(__FILE__)."/../inc/html_footer.php");
 ?>
