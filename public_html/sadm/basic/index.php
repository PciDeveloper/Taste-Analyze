<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기본설정 > 사이트설정";
include_once dirname(__FILE__)."/../_template.php";
$sqry = sprintf("select * from %s where idx='1'", "sw_siteinfo");
$row = $db->_fetch($sqry, 1);

?>
<div class="page-header">
	<h1>
		기본설정
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			사이트설정
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form name="fm" method="post" action="./admin.act.php" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return Common.checkFormHandler.checkForm(this);">
		<input type="hidden" name="act" value="siteedit" />
		<input type="hidden" name="idx" value="<?=$row['idx']?>" />
		<table class="table  table-bordered">
		<colgroup>
		<col width="130" />
		<col />
		</colgroup>
		<tbody>

		<tr>
			<th>사이트명</th>
			<td><input type="text" name="sitename"  exp="사이트명을" class="input-large" value="<?=$row['sitename']?>" /></td>
		</tr>
		<tr>
			<th>대표자명</th>
			<td><input type="text" name="ceoname"  exp="대표자명을" class="input-large" value="<?=$row['ceoname']?>" /></td>
		</tr>
		<tr>
			<th>사업자번호</th>
			<td><input type="text" name="BusinessNum"  exp="사업자번호를" class="input-large" value="<?=$row['BusinessNum']?>" /></td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td><input type="text" name="tel"   class="input-large" value="<?=$row['tel']?>" /></td>
		</tr>
		<tr>
			<th>주소</th>
			<td><input type="text" name="address"    class="input-xxlarge" value="<?=$row['address']?>" /></td>
		</tr> 
		</tbody>
		</table>

		<p class="btnC">
			<button type="submit"  class="btn btn-white btn-info"><?=($row['idx'] ? "수정" : "등록")?></button>
		</p>
	</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
