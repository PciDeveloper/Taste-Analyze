<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "예약관리 > 상품수정";
include_once dirname(__FILE__)."/../_template.php";
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$sqry = sprintf("select a.name as bkname,a.phone as bkphone , a.* , b.* from %s as a left join %s as b on a.gidx = b.idx where a.idx='%d'", SW_BOOKING,SW_GOODS, $idx);
	$row = $db->_fetch($sqry);
	$exIcon = explode(",", $row['icon']);
	if($goods['imgetc'])
		$exImg = explode(",", $row['imgetc']);

	$exetc1 = @explode("」「", $row['etc1']);
	$exetc2 = @explode("」「", $row['etc2']);
	$exetc3 = @explode("」「", $row['etc3']);
}
else
	msg("상품이 삭제되었거나 존재하지 않습니다.", -1, true);
?>
<script>
function Edit()
{
	var f = document.fm;

	if(Common.checkFormHandler.checkForm(f))
	{
		editor_object.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
		editor_object2.getById["notice"].exec("UPDATE_CONTENTS_FIELD", []);
		f.act.value = "edit";
		f.submit();
	}
}
</script>
<div class="page-header">
	<h1>
		예약관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			상품 수정
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
    <div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 예약 상품</div>
    <table class="table table-bordered">
    <colgroup>
    <col width="130" />
    <col />
    </colgroup>
    <tbody>
    <tr>
      <th>예약코드</th>
      <td><?=$row['code']?></td>
    </tr>
    <tr>
      <th>해시코드</th>
      <td><?=$row['shortexp']?></td>
    </tr>
    <tr>
      <th>상품명</th>
      <td>[<?=$arr_area[$part_area_keys[$row['etc1']]]?>]<?=$row['name']?></td>
    </tr>
    <tr>
      <th>상품가격</th>
      <td><?=number_format($row['nprice'])?>원</td>
    </tr>
    <tr>
      <th>접수일자</th>
      <td><?=$row['regdt']?></td>
    </tr>
    <tr>
    	<th>상태 변경</th>
    	<td>
    		<form name="cfm" action="./common.act.php" method="post" target="hiddenFrame">
    		<input type="hidden" name="encData" value="<?=$encData?>" />
        <input type="hidden" name="mode" value="status">
    		<select name="status" onchange="chgStatus();">
    		<option value="">++ 상태 선택 ++</option>
    		<?
        for($i=1; $i < count($arr_booking_status); $i++)
        {
          if($part_booking_keys[$i] == $row['status'])
            printf("<option value='%d' selected='selected'>%s</option>", $part_booking_keys[$i], $arr_booking_status[$part_booking_keys[$i]]);
          else
            printf("<option value='%d'>%s</option>", $part_booking_keys[$i], $arr_booking_status[$part_booking_keys[$i]]);
        }
    		?>
    		</select>
    		</form>
    	</td>
    </tr>
    </tbody>
    </table>

    <div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 예약자 정보</div>
    <table class="table table-bordered">
    <colgroup>
    <col width="130" />
    <col />
    </colgroup>
    <tbody>
    <tr>
      <th>예약자명</th>
      <td><?=$row['bkname']?></td>
    </tr>
    <tr>
      <th>예약자 연락처</th>
      <td><?=$row['bkphone']?></td>
    </tr>
    </tbody>
    </table>

    <div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 입금자 정보</div>
    <table class="table table-bordered">
    <colgroup>
    <col width="130" />
    <col />
    </colgroup>
    <tbody>
    <tr>
      <th>입금자명</th>
      <td><?=$row['AccountName']?></td>
    </tr>
    <tr>
      <th>입금자 연락처</th>
      <td><?=$row['AccountPhone']?></td>
    </tr>
    </tbody>
    </table>

    <p class="btnC">
    <button type="button" onclick="javascript:location.href='./booking.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
    </p>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<script type="text/javascript">
function chgStatus()
{
	var f = document.cfm;

	if(confirm("거래상태를 ["+$("select[name='status'] option:selected").text()+"]상태로 변경하시겠습니까?"))
		f.submit();
	else
		$("select[name='status'] option:eq(0)").attr("selected", "selected");
}
</script>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
