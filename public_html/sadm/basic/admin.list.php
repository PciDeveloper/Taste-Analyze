<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기본설정 > 관리자 리스트";
include_once dirname(__FILE__)."/../_template.php";

if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

if($sstr)
{
	if($skey)
		$arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);
	else
		$arrW[] = sprintf("name LIKE '%%%s%%' or nick LIKE '%%%s%%'", $skey, $sstr);
}
if($arrW)
	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

$sqry = sprintf("select * from %s where 1 and userlv = '100' %s", "sw_member", $AddW);

$db->_affected($numrows, $sqry);
$pgLimit = ($pgnum) ? $pgnum : 20;
$pgBlock = 10;
$start = ($start) ? $start : 0;
$letter_no = $numrows - $start;

$sqry .= sprintf(" order by idx desc limit %d, %d", $start, $pgLimit);

$qry = $db->_execute($sqry);

### Paging Parameter ###
$param['skey'] = ($sstr) ? $skey : "";
$param['sstr'] = $sstr;
$param['pgnum'] = $pgnum;
$param['sday'] = $sday;
$param['eday'] = $eday;
########################

include_once dirname(__FILE__)."/../../lib/class.page.php";
$pg = new getPage($start, $pgLimit, $pgBlock, $numrows, $param);
$encData = getEncode64($pg->getparm);
?>
<div class="page-header">
	<h1>
		기본설정
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			관리자 리스트
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

<script type="text/javascript">
function setDate(s, e)
{
	document.getElementById('sday').value = s;
	document.getElementById('eday').value = e;
}
</script>
 <form name="sfm" method="post" action="?" autocomplete="off">
<table class="table table-bordered">
<colgroup>
<col width="120" />
<col />
</colgroup>
<tbody>
<tr>
	<th>검색어</th>
	<td>
		<select name="skey">
			<option value="">전체</option>
			<option value="name" <?=($skey == "name") ? "selected=\"selected\"" : "";?>>이름</option>
			<option value="nick" <?=($skey == "nick") ? "selected=\"selected\"" : "";?>>닉네임</option>
			<option value="hp" <?=($skey == "hp") ? "selected=\"selected\"" : "";?>>전화번호</option>
		</select>
		<input type="text" name="sstr" class="input-large" value="<?=$sstr?>" />
	</td>
</tr>
<tr>
	<td colspan="2" align="center"><button type="submit" class="btn btn-inverse btn-sm">검색</button></td>
</tr>
</tbody>
</table>
</form>
<form name="fm" method="post" action="./admin.act.php">
<input type="hidden" name="act" />
<input type="hidden" name="idx" value="<?=$idx?>" />

<table class="table  table-bordered center">
<colgroup>
<col width="100" />
<col span="2" width="120" />
<col width="100" />
<col width="100" />
<col width="120" />
</colgroup>
<thead>
<tr>
	<th class="center">아이디</th>
	<th class="center">이름</th>
	<th class="center">닉네임</th>
	<th class="center">핸드폰번호</th>
	<th class="center">등록일</th>
	<th class="center">설정</th>
</tr>
</thead>
<tbody>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
	//작성글
	$boardCnt = $db->_fetch("select count(*) as cnt from sw_board where userid='".$row['userid']."'");
	//작성한 댓글
	$commentCnt = $db->_fetch("select count(*) as cnt from sw_comment where userid='".$row['userid']."'");

?>
<tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
	<td class="user_id"><?=$row['userid']?></td>
	<td><a href="./admin.php?encData=<?=$encData?>"><?=$row['name']?></a></td>
	<td><a href="./admin.php?encData=<?=$encData?>"><?=$row['nick']?></a></td>
	<td><?=$row['hp']?></td>
	<td><?=$row['regdt']?></td>
	<td>
		<button type="button" onclick="javascript:location.href='./admin.php?encData=<?=$encData?>'" class="btn btn-white btn-info btn-sm"/>수정</button>
		<button type="button" onclick="Del('<?=$row['idx']?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button>
	</td>
</tr>
<?
}

if($numrows < 1)
	echo("<tr><td colspan=\"12\" height=\"100\" align=\"center\">등록된 관리자가 없습니다.</td></tr>");

?>
</tbody>
</table>

<p id="paging"><?=$pg->page_return;?></p>
<!--
<p class="btnC">
	<img src="../img/btn/btn_batch_delete.gif" alt="일괄삭제" class="pointer middle" onclick="AllDel();" />
	<img src="../img/btn/btn_down_excel.gif" alt="엑셀다운로드" class="pointer middle" onclick="AllDownExcel();" />
</p>
-->
</form>

<script type="text/javascript">
function AllDel()
{
	var f = document.fm;
	if(Common.isChecked("chk[]", "삭제할 회원목록을 선택해 주세요."))
	{
		if(confirm("선택하신 회원을 정말 삭제(탈퇴)처리 하시겠습니까?"))
		{
			f.act.value = "sdel";
			f.submit();
		}
	}
}

function Del(data)
{
	var f = document.fm;
	if(confirm("해당 회원정보를 정말 삭제하시겠습니까?"))
	{
		f.idx.value = data;
		f.act.value = "del";
		f.submit();
	}
}
function AllDownExcel()
{
	location.href = "./member.excel.php";
}

</script>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
