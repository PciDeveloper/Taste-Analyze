<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "게시판관리 > 게시판리스트";
include_once dirname(__FILE__)."/../_template.php";

$sqry = "select * from ".SW_BOARD_CNF." order by idx asc";
$db->_affected($numrows,$sqry);
$qry = $db->_execute($sqry);
?>
<script type="text/javascript">
function Del(code)
{
	var f = document.fm;

	if(confirm("게시판 삭제시 관련 데이타도 모두 삭제됩니다.\n\n게시판을 정말 삭제하시겠습니까?"))
	{
		f.act.value = "del";
		f.code.value = code;
		f.submit();
	}

}

</script>
<form name="fm" action="adm.boardA.php" method="post">
<input type="hidden" name="act" />
<input type="hidden" name="code" />
</form>
 
<div class="page-header">
	<h1>
		게시판정보
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			게시판관리
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

<table class="table table-bordered">
<colgroup>
<col width="50" />
<col span="2" width="120" />
<col />
<col width="100" />
<col span="2" width="50" />
</colgroup>
<tr>
	<th>번호</th>
	<th>게시판코드</th>
	<th>게시판유형</th>
	<th>게시판명</th>
	<th>생성일</th>
	<th>수정</th>
	<th>삭제</th>
</tr>
<tbody>
<?
for($i=1; $row = mysql_fetch_array($qry); $i++)
{
?>
<tr>
	<td><?=$i?></td>
	<td class="bold"><?=$row['code']?></td>
	<td><?=$arr_part[$row['part']]?></td>
	<td><a href="board.list.php?code=<?=$row['code']?>"><?=$row['name']?></a></td>
	<td><?=str_replace("-", ".", substr($row['regdt'], 0, 10))?></td>
	<td><a href="./adm.boardE.php?code=<?=$row['code']?>"><img src="../img/btn/btn_edit_s.gif" /></a></td>
	<td><a href="javascript:Del('<?=$row['code']?>');"><img src="../img/btn/btn_del_s.gif" /></a></td>
</tr>
 <?
}

if($numrows < 1)
	echo("<tr align=\"center\"><td colspan=\"7\" height=\"50\" class=\"tdline\">생성된 게시판이 없습니다.</td></tr>");
?>
</tbody>
</table>
</div>
</div>
</div>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>