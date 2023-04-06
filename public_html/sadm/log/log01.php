<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "접속통계 > 시간대별방문현황";
include_once(dirname(__FILE__)."/../_template.php");
$year = ($year) ? $year : date('Y');
$mon = ($mon) ? $mon : date('m');
?>
 <script type="text/javascript">
var chart;
var arr_data = Array();
$(document).ready(function() {

	var str_data = "";

	$.ajax({
		type:"POST",
		dataType:"text",
		async:false,
		url:"/sadm/log/log.json.php",
		data:{
				"mode":"time",
				"year":"<?=$year?>",
				"mon":"<?=$mon?>"
		},
		beforeSend:function(xhr){},
		success:function(data){
			showChart(data);
		},
		error:function(){
			alert("REVIEW FORM ERROR!!");
		}
	});
});

function showChart(str_data)
{
	chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chartview'
				},
				title: {
					text: '시간대별 접속현황'
				},
				xAxis: {
					categories: ['00시', '01시', '02시', '03시', '04시', '05시', '06시', '07시', '08시', '09시', '10시', '11시', '12시', '13시', '14시', '15시', '16시', '17시', '18시', '19시', '20시', '21시', '22시', '23시']
				},
				tooltip: {
					formatter: function() {
						var s;
						s = ''+ this.x  +': '+ this.y;

						return s;
					}
				},
				labels: {
					items: [{
						html: '전체 시간대 접속현황',
						style: {
							left: '40px',
							top: '8px',
							color: 'black'
						}
					}]
				},
				series: [{
					type: 'column',
					name: '시간대별',
					data: eval(str_data)
				}]
			});
}
</script>
 <div class="page-content-area">
<div class="page-header">
	<h1>
		접속통계현황
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			시간대별 방문현황
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">
<div class="rp30" style="height:30px;">
<form name="sfm" action="?" method="post">

	<select name="year" onchange="submit();">
	<?
	for($y=2013; $y <= date('Y'); $y++)
	{
		if($year == $y)
			printf("<option value='%s' selected>%s</option>", $y, $y);
		else
			printf("<option value='%s'>%s</option>", $y, $y);
	}
	?>
	</select>년
	&nbsp;&nbsp;
	<select name="mon" onchange="submit();">
	<?
	for($m=1; $m < 13; $m++)
	{
		if($m == $mon)
			printf("<option value='%d' selected>%02d</option>", $m, $m);
		else
			printf("<option value='%d'>%02d</option>", $m, $m);
	}
	?>
	</select>월
</form>
</div>

<div id="chartview" style="width:95%; height:500px;"></div>
</div>
</div>
  <?php include_once dirname(__FILE__)."/../html_footer.php"; ?>
