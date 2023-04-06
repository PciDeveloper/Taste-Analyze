<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "접속통계 > OS별 방문현황";
include_once dirname(__FILE__)."/../_template.php";
$year = ($year) ? $year : date('Y');
?>
 <script type="text/javascript">
var chart;

$(document).ready(function() {

	$.ajax({
		type:"POST",
		dataType:"text",
		async:false,
		url:"/sadm/log/log.json.php",
		data:{"mode":"os", "year":"<?=$year?>"},
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
					renderTo: 'chartview',
					margin: [50, 200, 60, 170]
				},
				title: {
					text: '<?=$year?> Operating System'
				},
				plotArea: {
					shadow: null,
					borderWidth: null,
					backgroundColor: null
				},
				tooltip: {
					formatter: function() {
						return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
					}
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							formatter: function() {
								if (this.y > 5) return this.point.name;
							},
							color: 'white',
							style: {
								font: '13px Trebuchet MS, Verdana, sans-serif'
							}
						}
					}
				},
				legend: {
					layout: 'vertical',
					style: {
						left: 'auto',
						bottom: 'auto',
						right: '50px',
						top: '100px'
					}
				},
				series: [{
					type: 'pie',
					name: 'Browser share',
					data: eval(str_data)
					/*
					data: [
						['Firefox',   45.0],
						['IE',       26.8],
						{
							name: 'Chrome',
							y: 12.8,
							sliced: true,
							selected: true
						},
						['Safari',    8.5],
						['Opera',     6.2],
						['Others',   0.7]
					]
					*/
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
			OS별 방문현황
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">
<div class="rp30" style="height:30px;">
<form name="sfm" action="?" method="post">

	<select name="year" onchange="submit();">
	<?
	for($y=2012; $y <= date('Y'); $y++)
	{
		if($year == $y)
			printf("<option value='%s' selected>%s</option>", $y, $y);
		else
			printf("<option value='%s'>%s</option>", $y, $y);
	}
	?>
	</select>년
</form>
</div>

<div id="chartview" style="width:95%; height:500px; margin: 0 auto"></div>
</div>
</div>
  <?php include_once dirname(__FILE__)."/../html_footer.php"; ?>