<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기타/배너관리 > 배너수정";
include_once dirname(__FILE__)."/../_template.php";

if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$row = $db->_fetch("select * from ".SW_BANNER." where idx='".$idx."'");
}
else
	msg("배너가 삭제되었거나 존재하지 않습니다.", -1, true);
?>
<div class="page-header">
	<h1>
		기타/배너관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			배너수정
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

 <form name="fm" method="post" action="./common.act.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="mode" value="banner" />
<input type="hidden" name="act" value="edit" />
<input type="hidden" name="encData" value="<?=$encData?>" />


<table class="table table-bordered">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th>배너명</th>
	<td><input type="text" name="name" class="input-xxlarge" exp="배너명을" value="<?=$row['name']?>"/></td>
</tr>
<tr>
	<th>출력여부</th>
	<td>
    <label><input type="radio" name="buse" value="Y" <?=($row['buse'] == "Y") ? "checked=\"checked\"" : "";?> /> 출력</label>
    <label><input type="radio" name="buse" value="N" <?=($row['buse'] == "N") ? "checked=\"checked\"" : "";?> /> 미출력</label>
	</td>
</tr>
<tr>
	<th>출력기간</th>
	<td>
		<input type="text" name="sday" id="sday" class="date-picker" value="<?=$row['sday']?>" exp="출력기간을 " />부터 ~ <input type="text" name="eday" id="eday" class="date-picker" value="<?=$row['eday']?>" exp="출력기간을 " />까지
	</td>
</tr>
<tr>
	<th> 배너이미지</th>
	<td><span>권장사이즈 : 1090 * 200</span><br>
    <input type="file" name="img" class="input-large" />  
    <?
    if($row['img'])
    printf("<input type=\"checkbox\" name=\"imgdel\" value=\"1\" /> 삭제 (%s) <a href=\"javascript:void(window.open('../image.view.php?path=design&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>", $row['img'], $row['img'], getImageTag("../../upload/design", $row['img'], 20, 20, "img"));
    ?>
  </td>
</tr>
<tr>
	<th> 링크타겟</th>
	<td>
    <label><input type="radio" name="target" value="_parent" <?=($row['target'] == "_parent") ? "checked=\"checked\"" : "";?> /> 현재창 </label> &nbsp;&nbsp;
		<label><input type="radio" name="target" value="_blank" <?=($row['target'] == "_blank") ? "checked=\"checked\"" : "";?> /> 새창 </label> &nbsp;&nbsp;
		<label><input type="radio" name="target" value="nolink" <?=($row['target'] == "nolink") ? "checked=\"checked\"" : "";?> /> 링크없음 </label>
	</td>
</tr>
<tr>
	<th> 링크주소</th>
	<td><input type="text" name="url" class="lbox w500" value="<?=$row['url']?>" /></td>
</tr>
</tbody>
</table>
<p class="btnC">
	<button type="button" onclick="javascript:location.href='./banner.list.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
	<button type="submit" class="btn btn-white btn-info">수정</button>
</p>
</form>

	 	</div>
 	</div>
</div>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
