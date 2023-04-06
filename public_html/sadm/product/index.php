<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "회원관리 > 전체회원리스트";
include_once dirname(__FILE__)."/../_template.php";

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
$sqry = sprintf("select * from sw_taste where 1 %s ",  $AddW);
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
   <td align="center" style="text-align:center;"><button type="submit" style="width:70px; height:40px;" class="btn btn-app btn-primary btn-sm">Search</button></td>
   <td colspan="4" align="center"><button type="button" class="btn btn-inverse" style="top:2px; height: 40px; border-radius:10px;" onclick="location.href='./index.php'">초기화</button></td>
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
			 <!-- <option value="userid" <?=($skey == "userid") ? "selected" : "";?>>아이디</option> -->
			 <option value="title" <?=($skey == "title") ? "selected" : "";?>>제목</option>
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

<table class="table table-bordered center">
<colgroup>
<col width="50" />
<col width="120" />
<col width="100" />
<col width="100" />
<col width="100" />
<col width="60" />
<col width="60" />
<col width="60" />
<col width="60" />
<col width="60" />
<col width="80" />
<col span="2" width="120" />
</colgroup>
<tbody>
	<tr bgcolor="#EFEFEF">
		<th class="center">번호</th>
		<th class="center">아이디</th>
		<th class="center">제목</th>
		<th class="center">내용</th>
		<th class="center">Video</th>
		<th class="center">단맛</th>
		<th class="center">쓴맛</th>
		<th class="center">짠맛</th>
		<th class="center">신맛</th>
	  <th class="center">매운맛</th>
	  <th class="center">Emotion</th>
	  <th class="center">등록일</th>
		<th class="center">설정</th>
	</tr>

<?

for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
	$mb1 = $db->_fetch("select * from sw_member where idx = '".$row['useridx']."'");
	switch($row['emotion']){
			case "1" :
				$emotion = "매우좋다";
			break;
			case "2" :
				$emotion = "좋다";
			break;
			case "3" :
				$emotion = "보통이다";
			break;
			case "4" :
				$emotion = "싫다";
			break;
			default :
			$emotion = "매우싫다";
		break;
	}

	switch($row['sweetstp']){
			case "0" :
				$sweetstp = "0 단계";
			break;
			case "1" :
				$sweetstp = "1 단계";
			break;
			case "2" :
				$sweetstp = "2 단계";
			break;
			default :
			$sweetstp = "3 단계";
		break;
	}

	switch($row['bitstp']){
			case "0" :
				$bitstp = "0 단계";
			break;
			case "1" :
				$bitstp = "1 단계";
			break;
			case "2" :
				$bitstp = "2 단계";
			break;
			default :
			$bitstp = "3 단계";
		break;
	}

	switch($row['saltstp']){
			case "0" :
				$saltstp = "0 단계";
			break;
			case "1" :
				$saltstp = "1 단계";
			break;
			case "2" :
				$saltstp = "2 단계";
			break;
			default :
			$saltstp = "3 단계";
		break;
	}

	switch($row['sourstp']){
			case "0" :
				$sourstp = "0 단계";
			break;
			case "1" :
				$sourstp = "1 단계";
			break;
			case "2" :
				$sourstp = "2 단계";
			break;
			default :
			$sourstp = "3 단계";
		break;
	}

	switch($row['spicystp']){
			case "0" :
				$spicystp = "0 단계";
			break;
			case "1" :
				$spicystp = "1 단계";
			break;
			case "2" :
				$spicystp = "2 단계";
			break;
			default :
			$spicystp = "3 단계";
		break;
	}
?>
<tr style="cursor:pointer;">
	<td style="padding-top:14px;"><?=$letter_no?></td>
	<td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$mb1['userid']?></a></td>
	<td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$row['title']?></a></td>
  <td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$row['content']?></a></td>
  <td style="padding-top:14px;"><a href="#"><?=$row['video']?></a></td>
  <td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$sweetstp?></a></td>
  <td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$bitstp?></a></td>
  <td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$saltstp?></a></td>
  <td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$sourstp?></a></td>
  <td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$spicystp?></a></td>
  <td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><a href="#"><?=$emotion?></a></td>
	<td style="padding-top:14px;" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'"><?=$row['regdt']?></td>
	<td>
		<button type="button" onclick="javascript:location.href='/sadm/product/history.edit.php?encData=<?=$encData?>'" class="btn btn-white btn-info btn-sm"/>수정</button>
		<button type="button" onclick="Del('<?=$encData?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button>
	</td>
</tr>
<?
$letter_no--;
}

if($numrows < 1)
	echo("<tr><td colspan=\"13\" height=\"30\" align=\"center\">등록된 목록이 없습니다.</td></tr>");

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

<form name="dfm" method="post" action="/sadm/product/common.act.php">
<input type="hidden" name="act" />
<input type="hidden" name="encData" />
</form>

<script type="text/javascript">

function Del(data)
{
	var f = document.dfm;
	if(confirm("해당 목록을 정말 삭제하시겠습니까?"))
	{
		f.encData.value = data;
		f.act.value = "del2";
		f.submit();
	}
}

</script>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
