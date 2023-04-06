<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "회원관리 > 회원등록";
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
		회원관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			회원등록
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

<script type="text/javascript" src="./member.js"></script>
<form name="fm" method="post" action="./member.act.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="act" value="" />
<input type="hidden" name="encData" value="<?=$encData?>" />

<table class="table  table-bordered">
<colgroup>
<col width="200" />
<col />
</colgroup>
<tbody>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 아이디</th>
	<td>
			<input type="text" name="userid" class="input-large" value="" exp="아이디를" chktype="id" />
			<input type="hidden" name="chk_userid" exp="아이디 중복검사를 해주세요." />
			<button type="button" onclick="Member.checkHandler.chkUserId();" class="btn btn-white btn-info">중복확인</button>
			<span id="use_message"></span>
	</td>
</tr>
<tr>
 <th><img src="../img/icon/icon_check.gif" />비밀번호</th>
 <td><input type="text" name="pwd" class="input-large" exp="비밀번호를" value=""/></td>
</tr>
<!-- <tr>
 <th>이름</th>
 <td><input type="text" name="name" class="input-large" value="<?=$row['name']?>"/></td>
</tr> -->
 <tr>
	<th>닉네임</th>
	<td><input type="text" name="nick" class="input-large" value="<?=$row['nick']?>"/></td>
</tr>
<tr>
	<th>사진</th>
	<td>
		<input type="file" name="img1">
	</td>
</tr>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 휴대폰번호</th>
	<td>
		<input type="text" name="hp" value="" exp="휴대폰번호를">
		<!-- <select name="hp1" exp="휴대폰번호를">
		<option value=""> 선택 </option>
		<?
		for($i=0;  $i < count($arr_hp); $i++)
			printf("<option value='%s'>%s</option>", $arr_hp[$i], $arr_hp[$i]);
		?>
		</select>
		-
		<input type="text" name="hp2" class="input-small" maxlength="4" exp="휴대폰번호를" chktype="number" />
		-
		<input type="text" name="hp3" class="input-small" maxlength="4" exp="휴대폰번호를" chktype="number" />
		&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="bsms" value="N" /> SMS 수신거부 -->
	</td>
</tr>
<!-- <tr>
	<th>일반전화</th>
	<td>
		<select name="tel1">
		<option value=""> 선택 </option>
		<?
		for($i=0; $i < count($arr_tel); $i++)
			printf("<option value='%s'>%s</option>", $arr_tel[$i], $arr_tel[$i]);
		?>
		</select>
		-
		<input type="text" name="tel2" class="input-small" maxlength="4" />
		-
		<input type="text" name="tel3" class="input-small" maxlength="4" />
	</td>
</tr> -->
<!-- <tr>
	<th><img src="../img/icon/icon_check.gif" /> 이메일</th>
	<td>
		<input type="text" name="email" class="input-xlarge" exp="이메일주소를" />
		<input type="hidden" name="chk_email" exp="이메일 중복검사를 해주세요." />
		<button type="button" onclick="Member.checkHandler.chkEmail();" class="btn btn-white btn-info">중복확인</button>
		<span id="email_message"></span>
		&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="mailing" value="N" /> 수신거부
	</td>
</tr> -->
<tr>
 <th>우편번호</th>
 <td>
	 <p>
		 <input type="text" name="zip" id="zip" class="input-small" style="width:50px;" readonly="readonly" value="<?php echo $row['zip']?>"/>

		 <input type="hidden" name="zip1" class="input-small" style="width:50px;" readonly="readonly"  value=""/>
		 <input type="hidden" name="zip2" class="input-small" style="width:50px;" readonly="readonly"  value=""/>


		 <button type="button" onclick="zipcodeWin1('fm','zip1','zip2','zip','adr1', 'adr2', 'adr3');" class = "btn btn-white btn-info btn-xs">주소검색</button>
	 </p>
	 <p class="mt5">
		 <input type="text" name="adr1" class="input-xxlarge" style="width:350px;" readonly="readonly"  value="<?=$row['adr1']?>" />
	 </p>
	 <p class="mt5">
		 <input type="text" name="adr2" class="input-xxlarge" style="width:350px;" value="<?=$row['adr2']?>"/>&nbsp;<span class="relation_text2">주소를 입력해 주세요.</span>
	 </p>
	 <input type="hidden" name="adr3" class="lbox w200" />
 </td>
</tr>
</tbody>
</table>


<p class="btnC">
	<button type="button" onclick="javascript:location.href='./index.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
	<button type="submit"  class="btn btn-white btn-info">등록</button>
</p>
</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
