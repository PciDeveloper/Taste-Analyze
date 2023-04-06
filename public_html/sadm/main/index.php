<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "HOME > Main Page";
include_once dirname(__FILE__)."/../_template.php";
?>
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
				최근 게시물
			</h4>

			<script type="text/javascript">
$(function(){

$(".boardList 	.tab-menu li:eq(0)").addClass("on");

	$(".boardList 	.tab-menu li a").click(function(){
		var data = $(this).attr("data-role");
		$(".boardList 	.tab-menu li").removeClass("on");
		$(".boardList .tab-con").hide();
		$(this).parent().addClass("on");
		$(".boardList .tab-con").eq(data).show();
	});
});
</script>
<script type="text/javascript">
<!--
	var chart;
$(document).ready(function() {

	var str_data = "";

	$.ajax({
		type:"POST",
		dataType:"text",
		async:false,
		url:"/sadm/log/log.json.php",
		data:{"mode":"home"},
		beforeSend:function(xhr){},
		success:function(data){
			//alert(data);
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
			text: ''
		},
		xAxis: {
			categories: ["<?=date('m/d', strtotime('-9 day'))?>", "<?=date('m/d', strtotime('-8 day'))?>", "<?=date('m/d', strtotime('-7 day'))?>", "<?=date('m/d', strtotime('-6 day'))?>", "<?=date('m/d', strtotime('-5 day'))?>", "<?=date('m/d', strtotime('-4 day'))?>", "<?=date('m/d', strtotime('-3 day'))?>", "<?=date('m/d', strtotime('-2 day'))?>", "<?=date('m/d', strtotime('-1 day'))?>", "오늘"]
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
		labels: {
			items: [{
				html: '최근 10일간 접속현황',
				style: {
					left: '40px',
					top: '8px',
					color: 'black'
				}
			}]
		},
		series: [{
			type: 'column',
			name: '최근 10일동안 접속현황',
			data: eval(str_data)
		}]
	});
}

//-->
</script>
	 <div class="">
<div id="chartview" style="width:95%; height:400px; margin: 0 auto"></div>
	 </div>

 <!-- <div class="">
		<h3 class="header blue lighter smaller">최근 회원가입 현황</h3>
				<?
				$sqry = "select * from sw_member where 1 order by idx desc limit 0,5";
				$db->_affected($numrows ,$sqry);
				$letter_no = $numrows;
				$qry = $db->_execute($sqry);
				?>
				<style>
					.table tbody tr td {
						vertical-align: middle;
					}
				</style>
				<table class="table  table-bordered center">
					<tbody>
					<tr bgcolor="#EFEFEF">
						<th class="center">번호</th>
						<th class="center">아이디</th>
						<th class="center">구분</th>
						<th class="center">핸드폰번호</th>
						<th class="center">가입일자</th>
						<th class="center">설정</th>
					</tr>
					<?
					while($row=mysql_fetch_array($qry))
					{
						$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);

						switch($row['level']){
								case "100" :
									$level = "관리자";
								break;
								default :
								$level = "일반회원";
							break;
						}
					?>
					<tr align="center" height="30" onMouseOver="this.style.background='#e7f6f7';" onMouseOut="this.style.background='';" class="hand">
						<td><?=$letter_no?></td>
						<td onclick="javascript:location.href='../member/member.edit.php?encData=<?=$encData?>'"><a href="#" ><?=$row['userid']?></a></td>
						<td onclick="javascript:location.href='../member/member.edit.php?encData=<?=$encData?>'"><a href="#" ><?=$level?></a></td>
						<td onclick="javascript:location.href='../member/member.edit.php?encData=<?=$encData?>'"><a href="#" ><?=$row['tel']?></a></td>
						<td onclick="javascript:location.href='../member/member.edit.php?encData=<?=$encData?>'"><?=$row['regdt']?></td>
						<td>
							<button type="button" onclick="javascript:location.href='../member/member.edit.php?encData=<?=$encData?>'" class="btn btn-white btn-info btn-sm"/>수정</button>
							<button type="button" onclick="Del('<?=$encData?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button>
						</td>
					</tr>
					<?
						$letter_no--;
					}

					if($numrows < 1)
						echo("<tr><td colspan='8' height='50' align='center' class='tdline'>최근 회원정보가 없습니다.</td></tr>");
					?>
					</tbody>
				</table>
 </div> -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
  <?php include_once dirname(__FILE__)."/../html_footer.php"; ?>
