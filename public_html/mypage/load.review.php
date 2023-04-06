<?
header("Content-Type: text/html; charset=utf-8");
include_once(dirname(__FILE__)."/../inc/_header.php");

$userinfo = getUser($_SESSION['SES_USERIDX']);

$sqry = sprintf("select * from %s where userid='%s'", SW_REVIEW, $userinfo['userid']);
$db->_affected($numrows, $sqry);
$var['total'] = $numrows;
$var['limit'] = 10;
$var['pageblock'] = 10;
$var['page'] = ($page) ? $page : 1;
$var['gidx'] = $gidx;
$var['mode'] = "review";
$start = ($var['page'] - 1) * $var['limit'];
$letter_no = $var['total'] - $start;
$sqry .= sprintf(" order by idx desc limit %d, %d", $start, $var['limit']); ;
$qry = $db->_execute($sqry);
$aPages = Pagination($var);

?>
<style>
.page {
  text-align: center;
  padding-top: 20px;
}
.page .bt_wrap {
    margin-top: 50px;
    text-align: center;
}

 .page a {
  font-size: 18px;
  font-weight: 400;
  color:#7e7e7e;
  margin-left: 10px;
 }

.page a:first-child {
  margin-right: 30px;
}

.page a:last-child {
  margin-left: 30px;
}

 .page a:nth-child(2) {
    text-decoration: underline;
}

 .page img {
  width: 25px;
  height: 20px;
}


</style>
<?
while($row=mysql_fetch_array($qry))
{
  $goods = $db->_fetch("select * from sw_goods where idx='".$row['gidx']."'");
  $encData = getEncode64("idx=".$row['gidx']."&start=".$start."&".$pg->getparm);
?>


<div class="booking_review">
    <div class="booking_img" onclick="javascript:location.href='/goods/goods.view.php?encData=<?=$encData?>'" style="cursor:pointer;">
        <img src="/upload/goods/big/<?=$goods['img1']?>" alt="<?=$goods['name']?>">
    </div>
    <div class="booking_list">
        <p>[<?=$arr_area[$part_area_keys[$goods['etc1']]]?>]<?=$goods['name']?></p>
    </div>
    <div class="booking_icon">
        <div>
            <ul>
              <li><img src="/html/img/icon/map.png" alt="장소"></li>
              <li><img src="/html/img/icon/calendar.png" alt="날짜"></li>
              <li><img src="/html/img/icon/user.png" alt="인원"></li>
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

    <div class="review_reply">
      <p><?=nl2br(getCutString($row['content'], '180'))?></p>
      <p class="reply_date"><?=str_replace("-", ".", substr($goods['regdt'], 0, 10));?> </p>
    </div>
</div>


<?
	$letter_no--;
}
if($numrows < 1)
	echo("<li height=\"100\" align=\"center\">등록된 고객리뷰가 없습니다.</li>");
?>

<div class="page"><?=($var['total'] > 0) ? PrintArray($aPages) : '';?></div>
