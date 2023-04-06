<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "회원관리 > 회원수정";
include_once dirname(__FILE__)."/../_template.php";


if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$sqry = sprintf("select * from %s where idx='%d'", "sw_member", $idx);
	$row = $db->_fetch($sqry, 1);

	$exhp = explode("-", $row['hp']);
	$extel = explode("-", $row['tel']);

	if($row['user_type'] == 0){
		$userid = $row['userid'];
	}else if($row['user_type'] == 1){
		$userid = $row['kakaoid'];
	}else if($row['user_type'] == 2){
		$userid = $row['naverid'];
	}
}
?>
<script type="text/javascript">
<!--
function openChgLayer(mode)
{
	if($("input:checkbox[name='chgpass']").is(":checked"))
	{
		$("#_spass_").css("display", "none");
		$("#_cpass_").css("display", "block");
		$("#_confirmpass_").css("display", "block");
	}
	else
	{
		$("#_spass_").css("display", "block");
		$("#_cpass_").css("display", "none");
		$("#_confirmpass_").css("display", "none");
	}
}
//-->
</script>
<div class="page-header">
	<h1>
		회원관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			회원수정
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

<script type="text/javascript" src="./member.js"></script>
<form name="fm" method="post" action="./member.act.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="act" value="edit" />
<input type="hidden" name="encData" value="<?=$encData?>" />
<input type="hidden" name="idx" value="<?=$row['idx']?>" />
<table class="table  table-bordered">
<colgroup>
<col width="200" />
<col />
</colgroup>
<tbody>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 아이디</th>
	<td><?=$userid?></td>
</tr>

<tr>
 <th>비밀번호</th>
 <td>
	 <!-- <?php if($row['user_type'] == 0){?>
	 <div style="float:left;color:#72a9c9;display:;" id="_spass_">※ 비밀번호는 암호화 되어있습니다.</div>
	 <div style="float:left;display:none;" id="_cpass_"> -->
		 <div style="margin-bottom:5px;">
			 새로운 비밀번호 : <input type="password" name="newpw" class="w120 join_input" />
			 &nbsp;&nbsp;&nbsp;
			 비밀번호 확인 : <input type="password" name="newpwck" class="w120 join_input" />
		 </div>
	 <!-- </div>
	 <div style="float:left;">&nbsp;&nbsp;<input type="checkbox" name="chgpass" value="Y" onclick="openChgLayer('pass');" /> 변경 </div>
	 <?php }else{?>
	 <div style="float:left;color:#72a9c9;display:;" id="_spass_">※ SNS 회원은 비밀번호 변경 불가능합니다.</div>
	 <?php }?> -->
 </td>
</tr>

<tr>
 <th> 휴대폰번호</th>
 <td>
	 <input type="text" name="tel" value="<?=$row['tel']?>" chktype="number">
	 <!-- <input type="checkbox" name="bsms" value="N" <?=($row['bsms'] == "N") ? "checked=\"checked\"" : "";?> /> SMS 수신거부 -->
 </td>
</tr>

<tr>
 <th> 생년월일</th>
 <td>
	 <input type="text" name="birthday" value="<?=$row['birthday']?>" chktype="number">
 </td>
</tr>

</tbody>
</table>


<p class="btnC">
	<button type="button" onclick="javascript:location.href='./index.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
	<button type="submit" class="btn btn-white btn-info">수정</button>
</p>
</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<script type="text/javascript">

// function ImgDel(idx)
// {
// 	var f = document.fm;
//
// 	if(confirm("첨부파일을 삭제하시겠습니까?"))
// 	{
// 		f.act.value = "imgdel";
// 		f.submit();
// 	}
// }

</script>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
