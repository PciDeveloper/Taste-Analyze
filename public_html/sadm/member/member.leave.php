<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "회원관리 > 탈퇴한회원";
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

$sqry = sprintf("select * from %s where `leave` = '1'  %s", "sw_member", $AddW);

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
		회원관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			탈퇴한회원
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
	<th style="padding-top:16px;">검색어</th>
	<td>
		<select name="skey">
			<option value="">전체</option>
			<option value="userid" <?=($skey == "userid") ? "selected=\"selected\"" : "";?>>아이디</option>
			<option value="tel" <?=($skey == "tel") ? "selected=\"selected\"" : "";?>>휴대폰번호</option>
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
<form name="fm" method="post" action="./member.act.php">
<input type="hidden" name="mode" value="member" />
<input type="hidden" name="act" />
<input type="hidden" name="idx" />
<input type="hidden" name="encData" value="<?=$encData?>" />

<table class="table  table-bordered center">
<colgroup>
<col width="100" />
<col width="100" />
<col width="100" />
<col width="100" />
<!-- <col span="4" width="120" /> -->
</colgroup>
<tbody>
	<tr bgcolor="#EFEFEF">
		<th class="center">아이디</th>
		<!-- <th class="center">이름</th>
		<th class="center">닉네임</th> -->
		<th class="center">핸드폰번호</th>
		<th class="center">탈퇴일</th>
		<th class="center">설정</th>
	</tr>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
?>
<tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
	<td class="user_id" style="padding-top:12px;"><?=$row['userid']?></td>
	<!-- <td><a href="./member.edit.php?encData=<?=$encData?>"><?=$row['name']?></a></td>
	<td><a href="./member.edit.php?encData=<?=$encData?>"><?=$row['nick']?></a></td> -->
	<td style="padding-top:12px;"><?=$row['tel']?></td>
	<td style="padding-top:12px;"><?=$row['leave_date']?></td>
	<td>
		<button type="button" onclick="Recover('<?=$encData?>');" class="btn btn-white btn-info btn-sm"/>회원복구</button>
		 <!-- <button type="button" onclick="Del('<?=$row['idx']?>');" class="btn btn-white btn-danger btn-sm"/>완전삭제</button> -->
		 <button type="button" onclick="Del('<?=$encData?>');" class="btn btn-white btn-danger btn-sm"/>완전삭제</button>
	</td>
</tr>
<?
}

if($numrows < 1)
	echo("<tr><td colspan=\"4\" height=\"30\" align=\"center\">탈퇴한 회원이 없습니다.</td></tr>");

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

<form name="dfm" method="post" action="./member.act.php">
<input type="hidden" name="act" />
<input type="hidden" name="encData" />
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
//회원복구
function Recover(data)
{
	var f = document.dfm;
	if(confirm("해당 회원정보를 정말 복구하시겠습니까?"))
	{
		f.encData.value = data;
		f.act.value = "recover";
		f.submit();
	}
}


// function Del(data)
// {
// 	var f = document.dfm;
// 	if(confirm("해당 회원정보를 정말 삭제하시겠습니까?"))
// 	{
// 		f.idx.value = data;
// 		f.act.value = "del2";
// 		f.submit();
// 	}
// }

function Del(data)
{
	var f = document.dfm;
	if(confirm("해당 회원정보를 정말 삭제하시겠습니까?"))
	{
		f.encData.value = data;
		f.act.value = "del2";
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
