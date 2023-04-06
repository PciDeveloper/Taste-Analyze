<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "접속통계 > 접속통계현황";
include_once dirname(__FILE__)."/../_template.php";
if($del)
{
	$db->_execute("delete from sw_counter");
	goUrl("./index.php");
}
?>
<script type="text/javascript">
function setCounter()
{
	if(confirm("현재까지의 모든 로그가 삭제됩니다.\n\n정말 초기화 하시겠습니까?"))
	{
		location.href = "index.php?del=1";
	}
}

function ShowTime()
{
	if(!document.layers && !document.all && !document.getElementById) return

	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth()+1;
	var day = date.getDate();
	var hour = date.getHours();
	var min = date.getMinutes();
	var sec = date.getSeconds();

	if(min <= 9) min = "0"+min;
	if(sec <= 9) sec = "0"+sec;

	strClock = year+"년 "+month+"월 "+day+"일 "+hour+":"+min+":"+sec;

	if(document.layers)
	{
		document.layers.vtime.document.write(strClock);
		document.layers.vtime.document.close();
	}
	else if(document.all)
		vtime.innerHTML = strClock;
	else if(document.getElementById)
		document.getElementById("vtime").innerHTML = strClock;

	setTimeout("ShowTime()", 1000);
}

window.onload = ShowTime;
</script>

<div class="page-content-area">
<div class="page-header">
	<h1>
		접속통계현황
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			일반접속 통계
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

<div style="width:98%;margin-bottom:10px;border:3px solid #F8F8F8;">
<div style="border:1px solid #eeeeee;padding:5px;background-color:#ffffff;">

	<div style="margin:5px;"><b>현재시간 : </b><span id="vtime"></span></div>

	<table class="tb">
	<?
	/// 금일 ////////////////////////////////////////////////////////////////////////////
	list($tocnt) = $db->_fetch("select count(idx) from sw_counter where year='".date('Y')."' AND mon='".date('m')."' AND day='".date('d')."'");
	list($tocnt_ip) = $db->_fetch("select count(idx) from sw_counter where year='".date('Y')."' AND mon='".date('m')."' AND day='".date('d')."' group by ip");

	/// 이달 ////////////////////////////////////////////////////////////////////////////
	list($mcnt) = $db->_fetch("select count(idx) from sw_counter where year='".date('Y')."' AND mon='".date('m')."'");
	list($mcnt_ip) = $db->_fetch("select count(idx) from sw_counter where year='".date('Y')."' AND mon='".date('m')."' group by ip");

	/// 전체 ////////////////////////////////////////////////////////////////////////////
	list($totcnt) = $db->_fetch("select count(idx) from sw_counter");
	list($totcnt_ip) = $db->_fetch("select count(idx) from sw_counter group by ip");


	?>
	<tbody class="list1">
	<tr align="center" bgcolor="#f6f6f6">
		<th colspan="2" class="bold">금 일</th>
		<th colspan="2" class="bold">이 달</th>
		<th colspan="2" class="bold">전 체</th>
	</tr>
	<tr align="center" bgcolor="#ffffff">
		<td>방문자수</td>
		<td>IP별 방문자수</td>
		<td>방문자수</td>
		<td>IP별 방문자수</td>
		<td>방문자수</td>
		<td>IP별 방문자수</td>
	</tr>
	<tr align="center" bgcolor="#ffffff">
		<td><?=number_format($tocnt)?>명</td>
		<td><?=number_format($tocnt_ip)?>명</td>
		<td><?=number_format($mcnt)?>명</td>
		<td><?=number_format($mcnt_ip)?>명</td>
		<td><?=number_format($totcnt)?>명</td>
		<td><?=number_format($totcnt_ip)?>명</td>
	</tr>
	</tbody>
	</table>

</div>
</div>

<p class="btnR" style="width:98%;">
	<button type="button" value="초기화" class="btn btn-info" onClick="setCounter();" style="width:80px;50px;"/>초기화</button>
<p>
</div>
</div>
<? include_once dirname(__FILE__)."/../html_footer.php"; ?>
