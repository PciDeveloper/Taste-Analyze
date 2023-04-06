<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "접속통계 > 접속경로현황";
 include_once dirname(__FILE__)."/../_template.php";
$totcnt = $db->_fetch("select count(idx) from sw_counter");

$rqry = $db->_execute("select site, count(idx) from sw_counter group by site");
while($rrow = mysql_fetch_array($rqry))
{
	$sitearr[] = $rrow[0];
	$rcount[] = $rrow[1];
	$perc[] = sprintf("%.2f",$rrow[1]/$totcnt[0]*100);
}
?>

 <div class="page-content-area">
<div class="page-header">
	<h1>
		접속통계현황
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			접속경로현황
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

	<table border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
	<colgroup>
		<col width="50"/>
		<col />
		<col span="2" width="100"/>
	</colgroup>
	<tbody style="height:20px;">
	<tr align="center" bgcolor="#f6f6f6">
		<th>No.</th>
		<th>접속경로(URL)</th>
		<th>방문자수</th>
		<th>비율(%)</th>
	</tr>
	<?
	for($i=0; $i < count($sitearr); $i++)
	{
		if($sitearr[$i])
			$str_site = $sitearr[$i];
		else
			$str_site = "Direct Contact (Typing or Bookmark)";
	?>
	<tr bgcolor="#ffffff">
		<td align="center" class="bold"><?=$i+1?></td>
		<td style="padding:0 5px 0 5px;"><?=$str_site?></td>
		<td align="center"><?=number_format($rcount[$i])?></td>
		<td align="center"><?=$perc[$i]?>%</td>
	</tr>
	<?
	}
	if(count($sitearr) < 1)
		echo("<tr bgcolor='#ffffff' height='50'><td colspan='4' align='center'>접속경로 정보가 없습니다.</td></tr>");
	?>
	</tbody>
	</table>

</div>
</div>
   <?php include_once dirname(__FILE__)."/../html_footer.php"; ?>