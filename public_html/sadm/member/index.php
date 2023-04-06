<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "회원관리 > 전체회원리스트";
include_once dirname(__FILE__)."/../_template.php";

$l_id = "2";
$m_id = "100";

if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

if($user_name) $arrW[] = sprintf("name like '%%%s%%'", $user_name);
if($user_type) {
		$arrW[] = sprintf("user_type = '%s'", $user_type);
}

if($sstr) $arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);

if($sday && $eday) $arrW[] = "(regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
else if($sday) $arrW[] = "regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
else if($eday) $arrW[] = "regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";
// if($sday && $eday) $arrW[] = "(regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
// else if($sday) $arrW[] = "regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
// else if($eday) $arrW[] = "regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";

if($arrW) $AddW = sprintf(" AND %s", implode(" AND ", $arrW));

// $sqry = sprintf("select * from %s where status=1 and userlv <> '100' %s", SW_MEMBER, $AddW);
$sqry = sprintf("select * from sw_member where status=1 %s ", $AddW);
// $sqry = sprintf("select * from %s", "sw_member", $AddW);
// $sqry = sprintf("select * from seak_user", SEAK_USER, $AddW);
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
$param['user_type'] = $user_type;
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
			전체회원리스트
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

<script type="text/javascript">
// function setDate(s, e)
// {
// 	document.getElementById('sday').value = s;
// 	document.getElementById('eday').value = e;
// }
</script>

 <form name="sfm" method="get" action="?" autocomplete="off">
 <input type="hidden" name="code" value="<?=$code?>" />
 <table class="table table-striped table-bordered">
 <tr>
	 <th style="padding-top:21px;">총 게시물</th>
	 <td style="padding-top:21px;"><span class="tx1">총</span> <span class="totalnum"><?=(int)($numrows);?></span> <span class="tx1">건</span></td>
	 <th style="padding-top:21px;">기간별 조회 :</th>
	 <td style="padding-top:15px;">
			<div class="input-daterange input-group" style="width:400px;">
				<input type="text" class="input-sm form-control date-picker" name="sday" value="<?=$sday?>" />
				<span class="input-group-addon"><i class="fa fa-exchange"></i></span>
				<input type="text" class="input-sm form-control date-picker" name="eday" value="<?=$eday?>" />
			</div>
		</td>
	 <!-- <td>
		 <input type="text" name="sday" id="sday" class="date-picker" value="<?=$sday?>" /> ~ <input type="text" name="eday" id="eday" class="date-picker" value="<?=$eday?>" />
		 <button class="btn-xs btn-info" type="button" onclick="setDate('','');" />전체</button>
		 <button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d')?>','<?=date('Y-m-d')?>');" />오늘</button>
		 <button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-7 day"))?>', '<?=date('Y-m-d')?>')"/>7일</button>
		 <button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-10 day"))?>', '<?=date('Y-m-d')?>')" />10일</button>
		 <button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-20 day"))?>', '<?=date('Y-m-d')?>')" />20일</button>
		 <button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-30 day"))?>', '<?=date('Y-m-d')?>')" />30일</button>
	 </td> -->
	 <td style="text-align:center;"><button type="submit"  style="width:70px; height:40px;" class="btn btn-app btn-primary btn-sm">Search</button></td>
	 <td align="center" style="text-align:center;"><button type="button" style="top:2px; height: 40px; border-radius:10px;" class="btn btn-inverse" onclick="location.href='./index.php'">초기화</button></td>
 </tr>
 <tr>
	 <!-- <th>로그인타입</th>
	 <td>
		 <select name="user_type" class="select" onchange="submit();">
		<option value="" >전체</option>
		 <option value="0" <?=($user_type == "0") ? "selected=\"selected\"" : "";?>>이메일</option>
		 <option value="1" <?=($user_type == "1") ? "selected=\"selected\"" : "";?>>카카오톡</option>
		 <option value="2" <?=($user_type == "2") ? "selected=\"selected\"" : "";?>>네이버</option>
		 </select>
	 </td> -->
	 <th style="padding-top:17px;">검색어</th>
	 <td>
		 <select name="skey">
			 <option value="userid" <?=($skey == "userid") ? "selected" : "";?>>아이디</option>
			 <option value="tel" <?=($skey == "tel") ? "selected" : "";?>>휴대폰번호</option>
		 </select>
		 <input type="text" name="sstr"  value="<?=$sstr?>" />
		 <!-- <button type="submit" class="btn btn-white btn-info btn-xs">검색</button> -->
	 </td>
 </tr>




 </table>
</form>

<form name="fm" method="post" action="./member.act.php">
<input type="hidden" name="mode" value="member" />
<input type="hidden" name="act" />
<input type="hidden" name="encData" value="<?=$encData?>" />

<table class="table  table-bordered center">
<colgroup>
<col width="50" />
<!-- <col width="100" /> -->
<!-- <col width="100" />
<col width="100" /> -->
<col width="120" />
<col width="80" />
<col span="2" width="120" />
</colgroup>
<tbody>
	<tr bgcolor="#EFEFEF">
		<th class="center">번호</th>
		<th class="center">아이디</th>
		<!-- <th class="center">닉네임</th> -->
		<!-- <th class="center">로그인타입</th> -->
		<th class="center">핸드폰번호</th>
		<!-- <th class="center">작성글</th>
		<th class="center">댓글갯수</th> -->
		<th class="center">등록일</th>
		<th class="center">설정</th>
	</tr>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
	//작성글
	$boardCnt = $db->_fetch("select count(*) as cnt from sw_board where userid='".$row['userid']."'");
	//작성한 댓글
	$commentCnt = $db->_fetch("select count(*) as cnt from sw_comment where userid='".$row['userid']."'");
	if($row['user_type'] == 0){
		$userid = $row['userid'];
		$loginType = "이메일";
	}else if($row['user_type'] == 1){
		$userid = $row['kakaoid'];
		$loginType = "카카오톡";
	}else if($row['user_type'] == 2){
		$userid = $row['naverid'];
		$loginType = "네이버";
	}

?>
<tr style="cursor:pointer;">
	<td onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=$letter_no?></td>
	<td class="user_id" onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=$userid?></td>
	<!-- <td onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=$row['nick']?></td> -->
	<!-- <td onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=$loginType?></td> -->
	<td onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=$row['tel']?></td>
	<!-- <td onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=number_format($boardCnt['cnt'])?></td>
	<td onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=number_format($commentCnt['cnt'])?></td> -->
	<td onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" style="padding-top:14px;"><?=$row['regdt']?></td>
	<td>
		<button type="button" onclick="javascript:location.href='./member.edit.php?encData=<?=$encData?>'" class="btn btn-white btn-info btn-sm"/>수정</button>
		<!-- <button type="button" onclick="Del('<?=$encData?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button> -->
		<button type="button" onclick="leave('<?=$encData?>');" class="btn btn-white btn-danger btn-sm"/>탈퇴</button>
	</td>
</tr>
<?
$letter_no--;
}

if($numrows < 1)
	echo("<tr><td colspan=\"5\" height=\"30\" align=\"center\">가입된 회원이 없습니다.</td></tr>");

?>
</tbody>
</table>


<p id="paging"><?=$pg->page_return;?></p>
<!-- <div class="btnC"><div class="paging_simple_numbers" id="dynamic-table_paginate"><ul class="pagination"><?=$pg->page_return;?></ul></div></div> -->
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

function leave(data){
	var f = document.dfm;
	if(confirm("해당 회원을 정말 탈퇴하시겠습니까?"))
	{
		f.encData.value = data;
		f.act.value = "leave";
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
