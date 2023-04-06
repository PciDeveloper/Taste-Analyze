<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기본설정 > 푸시보내기";
include_once dirname(__FILE__)."/../_template.php";
$row = $db->_fetch("select * from sw_config order by idx asc limit 1");
?>

<div class="page-header">
	<h1>
		기본설정 
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			푸시보내기
		</small>
	</h1>
</div><!-- /.page-header --> 
<div class="row">
	<div class="col-xs-12"> 

		<!-- PAGE CONTENT BEGINS -->  
		<form name="fm" method="post" action="./common.act.php"   enctype="multipart/form-data"  autocomplete="off" onSubmit="return Common.checkFormHandler.checkForm(this);">
		<input type="hidden" name="act" value="push" /> 
		<table class="table  table-bordered">
		<colgroup>
		<col width="130" />
		<col />
		</colgroup>
		<tbody>
		<tr>
			<th>전송할메세지</th>
			<td> 
				<input type="text" name="msg" class="input-xxlarge"   value="" exp="전송할 메세지를"/>
			</td>
		</tr> 
		<?
		for($f=1; $f <= 1; $f++)
		{
		?>
		<tr>
			<th>전송할 이미지</th>
			<td><input type="file" name="upfile<?=$f?>" class="w300 lbox" /></td>
		</tr>
		<?}?>
		</tbody>
		</table>
 
 	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" type="submit"> <i class="icon-ok bigger-110"></i> 확인 </button>
 		</div>
	</div>
	</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<link rel="stylesheet" media="all" type="text/css" href="../assets/css/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
 <script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/js/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript">
<!--
$('#sday').datetimepicker({
	timeFormat: 'HH:mm:ss',
	dateFormat: 'yy-mm-dd',
	stepHour: 2,
	stepMinute: 10,
	stepSecond: 10
});	

$('#eday').datetimepicker({
	timeFormat: 'HH:mm:ss',
	dateFormat: 'yy-mm-dd',
	stepHour: 2,
	stepMinute: 10,
	stepSecond: 10
});	
//-->
</script>

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>