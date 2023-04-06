<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기타/배너관리 > 팝업등록";
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
			팝업등록
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

 <form name="fm" method="post" action="./common.act.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="mode" value="popup" />
<input type="hidden" name="act" />
<input type="hidden" name="ptype" value="2"/>


<table class="table table-bordered">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th>팝업제목</th>
	<td><input type="text" name="title" class="input-xxlarge" exp="팝업창 제목을" /></td>
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
		<input type="text" name="sday" id="sday" class="date-picker" exp="팝업기간을 " />부터 ~ <input type="text" name="eday" id="eday" class="date-picker" exp="팝업기간을 " />까지
	</td>
</tr>   
<tr>
	<th> 팝업창 크기</th>
	<td>
		가로 : <input type="text" name="width" class="input-small" value="<?=$row['width']?>" exp="팝업 가로사이즈를 " /> px
		&nbsp;&nbsp; X &nbsp;&nbsp;
		세로 : <input type="text" name="height" class="input-small" value="<?=$row['height']?>" exp="팝업 세로사이즈를 "/> px
	</td>
</tr>
<tr>
	<th> 팝업창 위치</th>
	<td>
		상단 : <input type="text" name="ptop" class="input-small" value="<?=$row['ptop']?>" /> px
		&nbsp;&nbsp; X &nbsp;&nbsp;
		좌측 : <input type="text" name="pleft" class="input-small" value="<?=$row['pleft']?>" /> px
	</td>
</tr>
<tr>
	<th>이미지</th>
	<td><input type="file" name="bgimg" class="lbox w300" /></td>
</tr>
<tr>
	<th>팝업내용</th>
	<td><textarea name="content" class="autosize-transition form-control" exp="팝업내용"><?=$goods['content']?></textarea></td>
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
