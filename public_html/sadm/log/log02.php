<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "접속통계 > 일일방문현황";
include_once(dirname(__FILE__)."/../_template.php");
$year = ($year) ? $year : date('Y');
$mon = ($mon) ? $mon : date('n');
?>
 <script type="text/javascript">
var chart;
var arr_cnt = new Array();
var mcnt = new Array("0", "31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");

$(document).ready(function() {

	for(var d=1; d <= mcnt['<?=$mon?>']; d++)
	{
		arr_cnt[d-1] = "'"+ d + "일" + "'";
	}

	var sday = "[" + arr_cnt.join(", ") + "]";

	$.ajax({
		type:"POST",
		dataType:"text",
		async:false,
		url:"/sadm/log/log.json.php",
		data:{
				"mode":"day",
				"year":"<?=$year?>",
				"mon":"<?=$mon?>"
		},
		beforeSend:function(xhr){},
		success:function(data){
			showChart(sday, data);
		},
		error:function(){
			alert("REVIEW FORM ERROR!!");
		}
	});
});

function showChart(sday, str_data)
{
	chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chartview'
				},
				title: {
					text: '<?=$year?>년 <?=$mon?>월 일별접속현황'
				},
				xAxis: {

					categories: eval(sday)
				},
				tooltip: {
					formatter: function() {
						var s = ''+ this.x  +': '+ this.y;

						return s;
					}
				},
				labels: {
					items: [{
						html: '전체 일일 접속현황',
						style: {
							left: '40px',
							top: '8px',
							color: 'black'
						}
					}]
				},
				series: [{
					type: 'column',
					name: '일일접속현황',
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
			일일방문현황
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


<div id="chartview" style="width:100%; height:500px;"></div>
</div>
</div>
<?php include_once dirname(__FILE__)."/../html_footer.php"; ?>

