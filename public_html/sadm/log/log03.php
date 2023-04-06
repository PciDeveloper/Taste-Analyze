<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "접속통계 > 일일방문현황";
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
		data:{"mode":"month", "year":"<?=$year?>"},
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
					text: '<?=$year?>년 월별접속현황'
				},
				xAxis: {

					categories: ['01월', '02월', '03월', '04월', '05월', '06월', '07월', '08월', '09월', '10월', '11월', '12월']
				},
				tooltip: {
					formatter: function() {
						var s = ''+this.x  +': '+ this.y;
						return s;
					}
				},
				labels: {
					items: [{
						html: '전체 월별 접속현황',
						style: {
							left: '40px',
							top: '8px',
							color: 'black'
						}
					}]
				},
				series: [{
					type: 'column',
					name: '월별접속현황',
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
			월별방문현황
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
