<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기본설정 > 개인정보 취급방침";
include_once dirname(__FILE__)."/../_template.php";
$row = $db->_fetch("select * from sw_rule where type='2' ");
?>
<div class="page-header">
	<h1>
		기본설정
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			개인정보 취급방침
		</small>
	</h1>
</div><!-- /.page-header --> 
<div class="row">
	<div class="col-xs-12"> 
		<!-- PAGE CONTENT BEGINS --> 
 		<form name="fm" method="post" action="./common.act.php" autocomplete="off" onSubmit="return Common.checkFormHandler.checkForm(this);">
		<input type="hidden" name="act" value="agreement2" />
		<table class="table table-bordered">
		<colgroup>
		<col width="100" />
		<col />
		</colgroup>
		<tbody> 
		<tr>
			<th>개인정보<br>취급방침</th>
			<td><textarea name="detail" class="autosize-transition form-control"  style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 254px;"><?=$row['detail']?></textarea></td>
		</tr> 
		</tbody>
		</table>

 	<p align="center"><button class="btn btn-info" type="submit"> <i class="icon-ok bigger-110"></i> 확인 </button></p>
	</form> 
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
  <?php include_once dirname(__FILE__)."/../html_footer.php"; ?>
