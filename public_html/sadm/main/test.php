<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "HOME > Main Page";
include_once dirname(__FILE__)."/../_template.php";
?>
<script type="text/javascript">
var chart;
var cindex;
$(document).ready(function(){ 
	setChart('sday');
});

var setChart =  function(mode) {
	document.hiddenFrame.location.href = "./log2.json.php?mode="+mode;
}

var showChart = function(arTit, title, data1, data2) {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container'
		},
		title: {
			text: title
		},
		xAxis: {
			categories: eval(arTit)
		},
		tooltip: {
			formatter: function() {
				var s;
				if (this.point.name) { // the pie chart
					s = ''+
						this.point.name +': '+ this.y +' fruits';
				} else {
					s = ''+
						this.x  +': '+ this.y;
				}
				return s;
			}
		}, 
		series: [{
			type: 'column',
			name: 'Visit',
			data: eval("["+data1+"]")
		}, {
			type: 'spline',
			name: 'New Member',
			data: eval("["+data2+"]")
		}]
	});
}
</script>
<div class="page-header">
	<h1>
		HOME
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Main Page
		</small>
	</h1>
</div><!-- /.page-header --> 
<div class="row">
	<div class="col-xs-12"> 
		<!-- PAGE CONTENT BEGINS --> 
			<h4 class="widget-title lighter">
				<i class="ace-icon fa fa-signal"></i>
				The Recent Visit Status
			</h4>

		<div id="container" style="width:90%; height: 600px; margin: 0 auto"></div>
 
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
  <?php include_once dirname(__FILE__)."/../html_footer.php"; ?>
