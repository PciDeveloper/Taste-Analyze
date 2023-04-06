<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "예약관리  > 예약상품 리스트";

 include_once dirname(__FILE__)."/../_template.php";

 if($encData)
 {
 	$encArr = getDecode64($encData);
 	foreach($encArr as $k=>$v)
 		${$k} = urldecode($v);
 }

 if($category)
 {
 	if(is_array($category))
 		$category = $category[count(getArrayNull($category))-1];

 	$arrW[] = sprintf("category LIKE '%s%%'", $category);
 }

 if($sstr)
 	$arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);

 if($arrW)
 	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

 $sqry = sprintf("select * from %s where 1=1 %s", SW_GOODS, $AddW);

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
 $param['category'] = $category;
 ########################

 include_once dirname(__FILE__)."/../../lib/class.page.php";
 $pg = new getPage($start, $pgLimit, $pgBlock, $numrows, $param);
 $encData = getEncode64($pg->getparm);
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
		예약관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			상품목록 리스트
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


<form name="fm" method="post" action="./goods.act.php">
<input type="hidden" name="act" />
<input type="hidden" name="encData" value="<?=$encData?>" />
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tb_list2">
<colgroup>
<col span="2" width="50" />
<col span="2" width="100" />
<col />
<col width="100" />
<col width="120" />
<col width="80" />
<col width="130" />
</colgroup>
<thead>
<tr>
	<th rowspan="2"><input type="checkbox" name="allchk" value="1" onclick="Common.allCheck('chk[]');" /></th>
	<th rowspan="2">NO</th>
	<th rowspan="2">상품코드</th>
	<th rowspan="2">이미지</th>
	<th>상품분류</th>
	<th>날짜</th>
	<th>정상가</th>
	<th>진열</th>
	<th rowspan="2">설정</th>
</tr>
<tr>
	<th class="sth">상품정보</th>
	<th class="sth">시간</th>
	<th class="sth">할인가</th>
	<th class="sth">진열순위</th>
</tr>
</thead>
<tbody>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
?>
<tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
	<td rowspan="2"><input type="checkbox" name="chk[]" value="<?=$row['idx']?>" /></td>
	<td rowspan="2"><?=$letter_no?></td>
	<td rowspan="2" class="bold"><?=$row['gcode']?></td>
	<td rowspan="2" style="padding:5px 0;"><img src="../../upload/goods/small/<?=$row['img3']?>" width="80px" height="80px"></td>
	<td rowspan="2" class="lp10" style="text-align:left;">
		<div style="font-weight:bold;color:#027A8F;margin-bottom:5px;"><?=getCatePos($row['category']);?></div>
		<div><?=$row['name']?></div>
	</td>
	<td><?=$row['sday']?> ~ <?=$row['eday']?></td>
	<td><?=number_format($row['price'])?>원</td>
	<td><img src="../img/icon/<?=($row['display'] == 'Y') ? 'icon_yes.gif' : 'icon_no.gif';?>" /></td>
	<td rowspan="2">
      <button type="button" onclick="javascript:location.href='./goods.edit.php?encData=<?=$encData?>'" class="btn btn-white btn-info">수정</button>
      <button type="button" onclick="javascript:Del('<?=$encData?>');" class="btn btn-white btn-danger">삭제</button>
	</td>
</tr>
<tr>
	<td><span class="item_hit"><?=$row['etc2']?>:00</span></td>
	<td><span class="item_hit"><?=number_format($row['nprice'])?></span> <span class="txt1">원</span></td>
	<td><span class="item_reply"><?=$row['seq']?></span> <span class="txt1">순위</span></td>
</tr>
<?
	$letter_no--;
}

if($numrows < 1)
	echo("<tr><td colspan=\"9\" height=\"100\" align=\"center\">등록된 상품목록이 없습니다.</td></tr>");

?>
</tbody>
</table>

<p id="paging"><?=$pg->page_return;?></p>
<!-- <p class="btnC">
	<img src="../img/btn/btn_batch_delete.gif" alt="일괄삭제" class="pointer middle" onclick="AllDel();" />
	<img src="../img/btn/btn_down_excel.gif" alt="엑셀다운로드" class="pointer middle" onclick="AllDownExcel();" />
</p> -->
</form>

			<div class="btnR" style="padding-bottom:10px;"><button type="button" class="btn btn-white btn-info" onClick="javascript:location.href='./goods.write.php?code=<?=$code?>';">글쓰기</button></div>		</div>
	</div>
</div>
<? include_once dirname(__FILE__)."/../html_footer.php"; ?>
