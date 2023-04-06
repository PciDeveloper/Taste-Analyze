<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기타/배너관리 > 팝업관리";
include_once dirname(__FILE__)."/../_template.php";
if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

if($stype)
	$arrW[] = sprintf("stype='%d'", $stype);

if($sstr)
	$arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);

if($sday && $eday)
	$arrW[] = "(regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
else if($sday)
	$arrW[] = "regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
else if($eday)
	$arrW[] = "regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";

if($arrW)
	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

$sqry = sprintf("select * from %s where 1=1 %s", SW_POPUP, $AddW);

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
$param['code'] = $code;
########################

include_once dirname(__FILE__)."/../../lib/class.page.php";
$pg = new getPage($start, $pgLimit, $pgBlock, $numrows, $param);
$encData = getEncode64($pg->getparm);

$recom = $db->_fetch("select * from sw_banner_grp where code='main' ");
?> 
<div class="page-header">
	<h1>
		기타/배너관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			팝업관리
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

 <script type="text/javascript">
function setDate(s, e)
{
	document.getElementById('sday').value = s;
	document.getElementById('eday').value = e;
}
</script>
			<form name="sfm" method="post" action="?" autocomplete="off">
			<table class="table table-bordered">
			<tr>
				<th>총 게시물</th>
				<td><span class="tx1">총</span> <span class="totalnum"><?=(int)($numrows);?></span> <span class="tx1">건</span></td> 
				<th >기간별 조회 :</th> 
				<td>
					<input type="text" name="sday" id="sday" class="date-picker" value="<?=$sday?>" /> ~ <input type="text" name="eday" id="eday" class="date-picker" value="<?=$eday?>" />
					<button class="btn-xs btn-info" type="button" onclick="setDate('','');" />전체</button>
					<button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d')?>','<?=date('Y-m-d')?>');" />오늘</button>
					<button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-7 day"))?>', '<?=date('Y-m-d')?>')"/>7일</button>
					<button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-10 day"))?>', '<?=date('Y-m-d')?>')" />10일</button>
					<button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-20 day"))?>', '<?=date('Y-m-d')?>')" />20일</button>
					<button class="btn-xs btn-info" type="button" onclick="setDate('<?=date('Y-m-d', strtotime("-30 day"))?>', '<?=date('Y-m-d')?>')" />30일</button>
				</td>
			</tr>
			<tr>
				<th>게시물 노출수</th>
				<td>
					<select name="pgnum" class="select" onchange="submit();">
					<option value="20" <?=($pgnum == "20") ? "selected=\"selected\"" : "";?>>20개씩</option>
					<option value="40" <?=($pgnum == "40") ? "selected=\"selected\"" : "";?>>40개씩</option>
					<option value="80" <?=($pgnum == "80") ? "selected=\"selected\"" : "";?>>80개씩</option>
					<option value="100" <?=($pgnum == "100") ? "selected=\"selected\"" : "";?>>100개씩</option>
					</select>
				</td>
				<th>검색어</th>
				<td>
					<select name="skey">
						<option value="title" <?=($skey == "title") ? "selected" : "";?>>제목</option> 
					</select>
					<input type="text" name="sstr"  value="<?=$sstr?>" />
					<button type="submit" class="btn btn-white btn-info btn-xs">검색</button>
				</td>
			</tr>
			</table>
			</form>

			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tb_list">
			<colgroup>
			<col width="50" />
			<col width="80" />
			<col />
			<col width="250" /> 
			<col width="100" />
			<col width="150" />
			</colgroup>
			<thead>
			<tr>
				<th>번호</th>
				<th>사용여부</th>
				<th>팝업창 제목</th>
				<th>노출기간(시작일~종료일)</th> 
				<th>등록일</th>
				<th>설정</th>
			</tr>
			</thead>
			<tbody>
			<?
			for($i=1; $row=mysql_fetch_array($qry); $i++)
			{
				$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
			?>
			<tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
				<td><?=$letter_no?></td>
				<td><img src="/sadm/img/icon/icon_<?=($row['buse']) ? "yes" : "no";?>.gif" /></td>
				<td><?=$row['title']?></td>
				<td><?=$row['sday']?> ~ <?=$row['eday']?></td> 
				<td><?=substr($row['regdt'], 0, 10)?></td>
				<td> 
					<button type="button" onclick="javascript:location.href='./popup.edit.php?encData=<?=$encData?>'" class="btn btn-white btn-info btn-sm"/>수정</button> 
					<button type="button" onclick="Del('<?=$encData?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button> 
				</td>
			</tr>
			<?
				$letter_no--;
			}

			if($numrows < 1)
				echo("<tr><td colspan=\"8\" height=\"100\" align=\"center\">등록된 게시물이 없습니다.</td></tr>");

			?>
			</tbody>
			</table>
			<div class="btnC"><ul class="pagination"><?=$pg->page_return;?></ul></div>

			<form name="dfm" action="./common.act.php" method="post">
			<input type="hidden" name="mode" value="popup" />
			<input type="hidden" name="act" value="del" />
			<input type="hidden" name="encData" />
			</form>

			<script type="text/javascript">
			function Del(data)
			{
				var f = document.dfm;

				if(confirm("팝업창을 정말 삭제하시겠습니까?"))
				{
					f.encData.value = data;
					f.submit();
				}
			}
			</script>
	 	</div>
 	</div>
</div>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
