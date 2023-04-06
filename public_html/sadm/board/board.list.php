<?
include_once dirname(__FILE__)."/../_header.php";
include_once(dirname(__FIlE__)."/../../lib/class.Board.php");
$navi = "게시판관리 > 게시판 리스트";

 include_once dirname(__FILE__)."/../_template.php";

if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

$board = new Board($code);

if($sstr) $wArr[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);

if($sday && $eday)
	$wArr[] = "(regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
else if($sday)
	$wArr[] = "regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
else if($eday)
	$wArr[] = "regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";

if($wArr)
	$AddW = sprintf(" && %s", implode(" && ", $wArr));

if($code == "1496112561")
{
	$sqry = sprintf("select * from sw_board where code='%s'  %s", $code, $AddW);
}
else
{
	$sqry = sprintf("select * from sw_board where code='%s' AND notice <> 'Y'  %s", $code, $AddW);
}

$db->_affected($numrows ,$sqry);
$pgLimit = ($pg_num) ? $pg_num : 20;
$pgBlock = 10;
$start = ($start) ? $start : 0;
$letter_no = $numrows - $start;

$sqry .= sprintf(" order by ref desc, re_step asc limit %d, %d", $start, $pgLimit);
$qry = $db->_execute($sqry);

### Paging Parameter ###
$param['skey'] = ($sstr) ? $skey : "";
$param['sstr'] = $sstr;
$param['code'] = $code;

include_once dirname(__FILE__)."/../../lib/class.page.php";
$pg = new getPage($start, $pgLimit, $pgBlock, $numrows, $param);
?>
<script type="text/javascript">

function BoardChkDel()
{
	var f = document.cfm;

	if(Common.isChecked('chk[]'))
	{
		if(confirm("선택된 게시물을 정말 삭제하시겠습니까?"))
		{
			f.act.value = "chkdel";
			f.submit();
		}
	}
}
function setDate(s, e)
{
	document.getElementById('sday').value = s;
	document.getElementById('eday').value = e;
}

// 선택한 게시물 복사 및 이동
function select_copy() {
	var f = document.cfm;

    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert( "이동할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");
      f.target = "move";
    f.action = "./move.php";
    f.submit();
}

function pushFn(val)
{
	var f= document.pfm;

	if(confirm("선택된 게시물을 발송하시겠습니까?"))
	{
		f.act.value="push";
		f.idx.value = val;
		f.submit();
	}
}
</script>
<div class="page-header">
	<h1>
		게시판관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			<?=$board->info['name']?>
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

			<form name="pfm" action="./board.act.php" method="post">
			<input type="hidden" name="code" value="<?=$board->info['code']?>" />
			<input type="hidden" name="encData" value="<?=$encData?>" />
			<input type="hidden" name="act" />
			<input type="hidden" name="idx" />
			</form>

			<form name="sfm" method="get" action="?" autocomplete="off">
			<input type="hidden" name="code" value="<?=$code?>" />
			<table class="table table-striped table-bordered">
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
						<option value="content" <?=($skey == "content") ? "selected" : "";?>>내용</option>
					</select>
					<input type="text" name="sstr"  value="<?=$sstr?>" />
					<button type="submit" class="btn btn-white btn-info btn-xs">검색</button>
				</td>
			</tr>
			</table>
			</form>

			<div class="btnR" style="padding-bottom:10px;"><button type="button" class="btn btn-white btn-info" onClick="javascript:location.href='./board.write.php?code=<?=$code?>';">글쓰기</button></div>
			<form name="cfm" action="./board.act.php" method="post">
			<input type="hidden" name="code" value="<?=$board->info['code']?>" />
			<input type="hidden" name="encData" value="<?=$encData?>" />
			<input type="hidden" name="act" />
			<?
			include_once(dirname(__FILE__)."/./skin/".$arr_skin[$board->info['part']]."/list.php");
			?>

			 <div>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td style="padding-left:10px;">
					<img src="../img/icon/arrow.gif" />
					선택하신 게시물을
					<button type="button" class="btn btn-white btn-info btn-xs" onclick="BoardChkDel();" />선택삭제</button>
					처리 합니다.
				</td>
			</tr>
			</table>
			</div>


			<div style="padding-top:20px;">
				<button type="button" class="btn btn-white btn-info" onClick="select_copy()">게시물이동</button>
				<div class="btnR"><button type="button" class="btn btn-white btn-info" onClick="javascript:location.href='./board.write.php?code=<?=$code?>';">글쓰기</button></div>
			</div>
			<!-- <div align="center"><ul class="pagination"><?=$pg->page_return;?></ul></div> -->
      <p id="paging"><?=$pg->page_return;?></p>

			</form>



		</div>
	</div>
</div>
<? include_once dirname(__FILE__)."/../html_footer.php"; ?>
