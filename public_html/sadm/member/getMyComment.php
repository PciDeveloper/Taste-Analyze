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

$mb = getUser($user_no);
 
 if($user_no)
 {
	 $arrW[] = sprintf("userid = '%s'", $mb['userid']);
 } 
if($arrW)
	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

$sqry = sprintf("select * from %s where 1=1 %s  ", SW_COMMENT, $AddW);
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
			<?=$mb['nick']?> 작성한글 
		</small>
	</h1>
</div><!-- /.page-header --> 
<div class="row">
	<div class="col-xs-12"> 
		<!-- PAGE CONTENT BEGINS --> 
 
<p>
	<button type="button" onclick="javascript:location.href='./index.php?encDate=<?=$encDate?>'" class="btn btn-white btn-info">뒤로가기</button>
</p>
<form name="fm" method="post" action="./member.act.php">
<input type="hidden" name="mode" value="member" />
<input type="hidden" name="act" />
<input type="hidden" name="encData" value="<?=$encData?>" />

<table class="table  table-bordered center">
<colgroup>
<col width="80" />
<col width="200" /> 
<col width="100" /> 
</colgroup>
<thead>
<tr> 
	<th class="center">게시판</th> 
	<th class="center">댓글내용</th>
	<th class="center">등록일</th>  
</tr>
</thead>
<tbody>
<?
for($i=1; $row=mysql_fetch_array($qry); $i++)
{
	//게시판정보
	$board_info = $db->_fetch("select * from sw_board_cnf where code='".$row['code']."'");
	$encData=getEncode64("idx=".$row['idx']."&start=".$start."&skey=".$skey."&sstr=".$sstr);
?>
<tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
	<td class="user_id"><?=$board_info['name']?></td>  
	<td style="text-align:left; padding-left:20px;"><?=$row['comment']?></td>   
	<td><?=$row['regdt']?></td>   
</tr>
<?
}

if($numrows < 1)
	echo("<tr><td colspan=\"12\" height=\"100\" align=\"center\">등록된 게시물이 없습니다.</td></tr>");

?>
</tbody>
</table>

<div class="btnC"><ul class="pagination"><?=$pg->page_return;?></ul></div>
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
		f.encData.value = data;
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