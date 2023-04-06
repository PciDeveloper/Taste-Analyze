<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기타/배너관리 > 배너등록";
include_once dirname(__FILE__)."/../_template.php";
if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}
?>
<div class="page-header">
	<h1>
		기타/배너관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			배너등록
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

 <form name="fm" method="post" action="./common.act.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="mode" value="banner" />
<input type="hidden" name="act" />


<table class="table table-bordered">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th>배너명</th>
	<td><input type="text" name="name" class="input-xxlarge" exp="배너명을" /></td>
</tr>
<tr>
	<th>출력여부</th>
	<td>
		<label><input type="radio" name="buse" value="Y" checked="checked" /> 출력</label>
		<label><input type="radio" name="buse" value="N" /> 미출력</label>
	</td>
</tr>
<tr>
	<th>출력기간</th>
	<td>
		<input type="text" name="sday" id="sday" class="date-picker" exp="출력기간을 " />부터 ~ <input type="text" name="eday" id="eday" class="date-picker" exp="출력기간을 " />까지
	</td>
</tr>
<tr>
	<th> 배너이미지</th>
	<td><span>권장사이즈 : 1090 * 200</span><br><input type="file" name="img" class="lbox w300" />  </td>
</tr>
<tr>
	<th> 링크타겟</th>
	<td>
		<label><input type="radio" name="target" value="_parent" checked="checked" /> 현재창 </label> &nbsp;&nbsp;
		<label><input type="radio" name="target" value="_blank" /> 새창 </label> &nbsp;&nbsp;
		<label><input type="radio" name="target" value="nolink" /> 링크없음 </label>
	</td>
</tr>
<tr>
	<th> 링크주소</th>
	<td><input type="text" name="url" class="input-xxlarge" /></td>
</tr>
</tbody>
</table>
<p class="btnC">
	<button type="button" onclick="javascript:location.href='./index.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
	<button type="submit" class="btn btn-white btn-info">확인</button>
</p>
</form>

	 	</div>
 	</div>
</div>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
