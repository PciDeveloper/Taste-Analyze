<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "상품관리  > 상품 문의 ";
 include_once dirname(__FILE__)."/../_template.php";

 if($encData)
 {
 	$encArr = getDecode64($encData);
 	foreach($encArr as $k=>$v)
 		${$k} = urldecode($v);
 }

 if($category) $arrW[] = sprintf("a.category='%d'", $category);
 if($status) $arrW[] = sprintf("a.status='%d'", $status);
 if($sstr) $arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);

 if($sday && $eday)
 	$arrW[] = "(a.regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
 else if($sday)
 	$arrW[] = "a.regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
 else if($eday)
 	$arrW[] = "a.regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";

 if($arrW)
 	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

 $sqry = sprintf("select a.*, b.name as gname, b.category as gcategory from %s a, %s b where a.gidx=b.idx %s", SW_QNA, SW_GOODS, $AddW);

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
 $param['status'] = $status;
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

</script>
<div class="page-header">
	<h1>
		상품관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			상품 문의
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
            <option value="a.title" <?=($skey == "a.title") ? "selected=\"selected\"" : "";?>>문의 제목</option>
        		<option value="a.content" <?=($skey == "a.content") ? "selected=\"selected\"" : "";?>>문의 내용</option>
        		<option value="a.name" <?=($skey == "a.name") ? "selected=\"selected\"" : "";?>>문의자</option>
        		<option value="b.name" <?=($skey == "b.name") ? "selected=\"selected\"" : "";?>>상품명</option>
					</select>
					<input type="text" name="sstr"  value="<?=$sstr?>" />
					<button type="submit" class="btn btn-white btn-info btn-xs">검색</button>
				</td>
			</tr>
      <tr>
        <th>문의유형별 보기</th>
        <td>
          <select name="category" class="select" style="width:130px;" onchange="submit();">
          <option value="">문의유형 전체</option>
          <?
          for($i=1; $i < count($arr_qna); $i++)
          {
            if($category == $i)
              printf("<option value='%d' selected='selected'>%s</option>", $i, $arr_qna[$i]);
            else
              printf("<option value='%d'>%s</option>", $i, $arr_qna[$i]);
          }
          ?>
          </select>
        </td>
        <th>답변여부</th>
        <td>
          <select name="status" class="select" onchange="submit();">
          <option value="">답변여부 전체</option>
          <option value="1" <?=($status == 1) ? "selected=\"selected\"" : "";?>>미답변</option>
          <option value="2" <?=($status == 2) ? "selected=\"selected\"" : "";?>>답변완료</option>
          </select>
        </td>
      </tr>
			</table>
			</form>


<form name="fm" method="post" action="./goods.act.php">
<input type="hidden" name="act" />
<input type="hidden" name="encData" value="<?=$encData?>" />
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tb_list2">
<colgroup>
<col width="50" />
<col width="100" />
<col width="200" />
<col width="100" />
<col width="100" />
<col />
<col width="100" />
<col width="130" />
</colgroup>
<thead>
<tr>
	<th><input type="checkbox" name="allchk" value="1" onclick="Common.allCheck('chk[]');" /></th>
  <th>작성일시</th>
	<th>아이디</th>
	<th>작성자</th>
	<th>문의유형</th>
	<th>상품정보 / 문의제목</th>
	<th>답변여부</th>
	<th>설정</th>
</thead>
<tbody>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
?>
<tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
  <td><input type="checkbox" name="chk[]" value="<?=$row['idx']?>" /></td>
	<td><?=substr($row['regdt'], 0, 10)?></td>
	<td class="user_id"><?=$row['userid']?></td>
	<td><?=$row['name']?></td>
	<td class="help_category"><?=$arr_qna[$row['category']]?></td>
	<td style="text-align:left;padding:3px 10px;">
		<p><span class="category"><?=getCatePos($row['gcategory']);?></span> &nbsp; <span><?=$row['gname']?></span></p>
		<p class="help_subject"><?=$row['title']?></p>
	</td>
	<td><?=($row['status'] == 1) ? "<span style=\"color:#725858;\">미답변</span>" : substr($row['aregdt'], 0, 10);?></td>
	<td>
    <button type="button" onclick="Common.winOpen('./win.qna.php?idx=<?=$row['idx']?>', 'qna', 'width=800, height=800, scrollbars=yes');" class="btn btn-white btn-xs btn-info"/><?=($row['status'] == 1) ? "답변" : "답변수정";?></button>
		<button type="button" onclick="Del('<?=$row['idx']?>');" class="btn btn-white btn-xs btn-danger"/>삭제</button>
	</td>
</tr>
<?
	$letter_no--;
}

if($numrows < 1)
	echo("<tr><td colspan=\"9\" height=\"100\" align=\"center\">등록된 상품문의가 없습니다.</td></tr>");

?>
</tbody>
</table>

<p id="paging"><?=$pg->page_return;?></p>
</form>

	</div>
</div>
<? include_once dirname(__FILE__)."/../html_footer.php"; ?>
