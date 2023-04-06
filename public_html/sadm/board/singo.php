<?
include_once dirname(__FILE__)."/../_header.php";

$navi = "게시판관리 > 신고내역";
include_once dirname(__FILE__)."/../_template.php";

if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

 
if($sstr) $arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr); 

if($sday && $eday)
	$arrW[] = "(regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
else if($sday)
	$arrW[] = "regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
else if($eday)
	$arrW[] = "regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";

if($arrW)
	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

$sqry = sprintf("select * from %s where 1=1 %s", SW_SINGO, $AddW);

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
$param['category'] = $category;
########################

include_once dirname(__FILE__)."/../../lib/class.page.php";
$pg = new getPage($start, $pgLimit, $pgBlock, $numrows, $param);
$encData = getEncode64($pg->getparm);
?>
<div class="page-header">
	<h1>
		게시판관리 
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			신고내역
		</small>
	</h1>
</div><!-- /.page-header --> 
<div class="row">
	<div class="col-xs-12"> 
		<!-- PAGE CONTENT BEGINS --> 
 
<h3>* 삭제 시 신고된 게시물은 비노출상태로 변경됩니다.</h3>
<form name="fm" method="post" action="./common.act.php">
<input type="hidden" name="mode" value="singo" />
<input type="hidden" name="act" />
<input type="hidden" name="idx" />
<input type="hidden" name="encData" value="<?=$encData?>" />

<table class="table  table-bordered center">
<colgroup>
<col width="50" /> 
<col width="100" /> 
<col width="200" />
<col width="100" /> 
<col width="100" /> 
<col width="100" /> 
</colgroup>
<thead>
<tr>
	<th class="center"><input type="checkbox" name="allchk" value="1" onclick="Common.allCheck('chk[]');" /></th>
	<th class="center">신고사유</th>  
	<th class="center">신고게시물</th>  
	<th class="center">신고자(아이디)</th> 
	<th class="center">신고일자</th>
	<th class="center">설정</th>
</tr>
</thead>
<tbody>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	$G = $db->_fetch("select * from sw_board where idx='".$row['gidx']."'"); 

	$encData=getEncode64("idx=".$row['gidx']."&code=".$G['code']."&start=".$start."&skey=".$skey."&sstr=".$sstr);
	$member = getUser($row['user_no']);


	$encData3=getEncode64("idx=".$member['idx']);
?>
<tr>
	<td><input type="checkbox" name="chk[]" value="<?=$row['idx']?>" /></td>
	<td><?php echo $row['content']?></td> 
	<td><a href="../board/board.view.php?encData=<?=$encData?>" target="_blank"><?=$G['title']?></a></td> 
	<td><?=$member['nick']?>(<?=$member['userid']?>)</td> 
	<td><?=substr($row['regdt'], 0, 10)?></td> 
	<td> 
		<?php if($row['valid'] == 0){?>
		<span style="color:red;">처리완료</span>
		<?php }else{?>
		<button type="button" class="btn btn-success btn-xs" onclick="Del('<?=$row['idx']?>');">삭제</button>
		<?php }?>
	</td>
</tr>
<?
}

if($numrows < 1)
	echo("<tr><td colspan=\"7\" height=\"100\" align=\"center\">신고 내역이 없습니다.</td></tr>");

?>
</tbody>
</table>

<div class="btnC"><ul class="pagination"><?=$pg->page_return;?></ul></div>
<p class="btnC"><button type="button" class="btn btn-white btn-info" onclick="AllDel();" >일괄삭제</button></p>
</form>

<script type="text/javascript">
function Del(idx)
{
	var f = document.fm;

	if(confirm("해당 게시물을 삭제 하시겠습니까?"))
	{
		f.act.value = "del";
		f.idx.value = idx;
		f.submit();
	}
}

function AllDel()
{
	var f = document.fm;
	if(Common.isChecked("chk[]", "삭제할 게시물을 선택해 주세요."))
	{
		if(confirm("선택하신 게시물을 정말 삭제 하시겠습니까?"))
		{
			f.act.value = "sdel";
			f.submit();
		}
	}
}
</script>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>