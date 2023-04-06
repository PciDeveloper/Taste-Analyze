<?
include_once dirname(__FILE__)."/../_header.php";

$navi = "게시판관리 > 게시글 통합관리";
include_once dirname(__FILE__)."/../_template.php";

?>
 <script type="text/javascript">
function Del(idx)
{
	var f = document.dfm;

	if(confirm("상품정보를 정말 삭제하시겠습니까?"))
	{
		f.act.value = "del";
		f.idx.value = idx;
		f.submit();
	}

}

function chgRank()
{
	var f = document.dfm;

	if(confirm("상품출력 순위를 일괄변경 하시겠습니까?"))
	{
		f.act.value = "rank";
		f.submit();
	}
}

</script> 
<div class="page-header">
	<h1>
		게시판
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			게시글 통합관리
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">
<form name="dfm" action="./goods.act.php" method="post">
<input type="hidden" name="act" />
<input type="hidden" name="idx" />
<input type="hidden" name="start" value="<?=$start?>" />
<input type="hidden" name="encData" value="<?=$encData?>" />
<table class="table table-bordered">
<colgroup>
<col width="50" />
<col width="200" />
<col />
<col span="3" width="130" />
</colgroup>
<tr>
	<th class="center">번호</th>
	<th class="center">게시판유형</th>
	<th class="center">게시판명</th>
	<th class="center">전체글수</th>
	<th class="center">오늘글수</th>
	<th class="center">보기</th>
</tr>
 <tbody>
<?
$sqry = sprintf("select * from %s order by idx asc", SW_BOARD_CNF);
$db->_affected($numrows , $sqry);
$qry = $db->_execute($sqry);
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	list($tot) = $db->_fetch("select count(idx) from ".SW_BOARD ." where code='".$row['code']."'");
	list($today) = $db->_fetch("select count(idx) from ".SW_BOARD ." where code='".$row['code']."' and regdt >= DATE_FORMAT(CURDATE(), '%Y-%m-%d 00:00:00')");

?>
<tr height="25" align="center" onMouseOver="this.style.background='#e7f6f7';" onMouseOut="this.style.background='';">
	<td><?=$i?></td>
	<td><?=$arr_part[$row['part']]?></td>
	<td><?=$row['name']?></td>
	<td><?=number_format($tot)?></td>
	<td><?=number_format($today)?></td>
	<td><a href="./board.list.php?code=<?=$row['code']?>">보기</a></td>
</tr>
 <?
}

if($numrows < 1)
	echo("<tr align=\"center\"><td colspan=\"12\" height=\"50\" class=\"tdline\">생성된 게시판이 없습니다.</td></tr>");
?>
</tbody>
</table>
</form>
</div>
</div>
</div>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>