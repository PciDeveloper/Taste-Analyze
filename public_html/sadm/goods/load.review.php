<?
header("Content-Type: text/html; charset=utf-8");
include_once(dirname(__FILE__)."/../inc/_header.php");

$sqry = sprintf("select * from %s where gidx='%d'", SW_REVIEW, $gidx);
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
<ul>

<?
while($row=mysql_fetch_array($qry))
{
?>
<li>
    <div class="review_txt">
        <p>해피누나</p>
        <p>2020.07.24작성</p>
        <div class="review">
            <span>
너무나도 힐링하기 좋은 시간이었어요. 구성이 알찬 당일치기 여행이라 일상에 지친 분들께 추천하고 싶어요.<br>
            강사님들도 친절하고 재미있으시고 특히 매니저님 완전 착하심ㅠ 제 친구를 구해주셔서 감사해요!! ㅋㅋ 캡틴님도 대원들 <br>
            모두 꼼꼼히 챙겨주셔서 진짜 행복한 여행이었어요!!
</span>
        </div>
        <div>
            <img src="/html/img/image/place6.png" alt="강릉">
            <img src="/html/img/image/place6.png" alt="강릉">
        </div>
    </div>
</li>
<?
	$letter_no--;
}
if($numrows < 1)
	echo("<tr><td colspan=\"5\" height=\"100\" align=\"center\">등록된 상품후기가 없습니다.</td></tr>");
?>
</ul>
 
<div class="paging"><?=($var['total'] > 0) ? PrintArray($aPages) : '';?></div>
