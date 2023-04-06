<?
header("Content-Type: text/html; charset=utf-8");
include_once(dirname(__FILE__)."/../inc/_header.php");
$userinfo = getUser($_SESSION['SES_USERIDX']);
$sqry = sprintf("select * from %s where userid='%s'", "sw_qna",  $userinfo['userid']);
$db->_affected($numrows, $sqry);
$var['total'] = $numrows;
$var['limit'] = 10;
$var['pageblock'] = 10;
$var['page'] = ($page) ? $page : 1;
$var['gidx'] = $gidx;
$var['mode'] = "qna";
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
   $encData = getEncode64("idx=".$goods['idx']."&start=".$start."&".$pg->getparm);
?>
<div class="my_ask_wrap">
    <div class="ask_img">
        <img src="/upload/goods/big/<?=$goods['img1']?>" alt="<?=$goods['name']?>"  onclick="javascript:location.href='/goods/goods.view.php?encData=<?=$encData?>#tab04'" style="cursor:pointer;">
    </div>
    <div class="ask_list">
        <h3>[<?=$arr_area[$part_area_keys[$goods['etc1']]]?>]<?=$goods['name']?></h3>
        <p><?=nl2br($row['content'])?></p>
        <p class="ask_date"><?=str_replace("-", ".", substr($row['regdt'], 0, 10));?> 작성 </p>
    </div>
</div>

<?
	$letter_no--;
}
if($numrows < 1)
	echo("<div height=\"100\" align=\"center\">등록된 체험문의가 없습니다.</div>");
?>
<div class="page"><?=($var['total'] > 0) ? PrintArray($aPages) : '';?></div>
