<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "분석 목록 > 목록 수정";
include_once dirname(__FILE__)."/../_template.php";


if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$row = $db->_fetch("select * from sw_taste where idx = '".$idx."'");

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
		분석 목록
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			목록 수정
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

<!-- <script type="text/javascript" src="./member.js"></script> -->
<form name="fm" method="post" action="/sadm/product/common.act.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="act" value="edit" />
<input type="hidden" name="encData" value="<?=$encData?>" />
<input type="hidden" name="idx" value="<?=$row['idx']?>" />
<input type="hidden" name="mood1" id="mood1" value=""/>
<input type="hidden" name="mood2" id="mood2" value=""/>
<input type="hidden" name="mood3" id="mood3" value=""/>
<input type="hidden" name="mood4" id="mood4" value=""/>
<input type="hidden" name="mood5" id="mood5" value=""/>

<style>
	.intb tbody tr {
		height: 50px;
	}
	.intb tbody tr th {
		text-align: center;
		vertical-align: middle;
	}
	.intb tbody tr td {
		vertical-align: middle;
	}
	td input[type="radio"] {
		margin : 1px 2px 0 0;
	}
	td input[type="radio"]+span {
		vertical-align: top;
		margin : 0 10px 0 0;
	}
</style>
<div class="product_div" style="display:flex;">
<table class="table table-bordered intb" style="margin:10px;">
<colgroup>
<col width="130" />
<col />
</colgroup>
<tbody>
<!-- <tr>
	<th><img src="../img/icon/icon_check.gif" /> 등록 번호</th>
  <th>등록 번호</th>
	<td><?=$row['useridx']?></td>
</tr> -->

<tr>
	<th>제목</th>
	<td><input type="text" name="title" class="input-small" value="<?=$row['title']?>"/></td>
</tr>

<tr>
	<th>내용</th>
	<td><input type="text" name="content" class="input-small" value="<?=$row['content']?>"/></td>
</tr>


<tr>
	<th>단맛</th>
	<td>
		<input type="text" name="swhappy" id="swhappy" class="input-small hap" exp="수치를"/>
		<input type="text" name="swsad" id="swsad" class="input-small hap" exp="수치를"/>
		<input type="text" name="swangry" id="swangry" class="input-small hap" exp="수치를"/>
		<input type="text" name="swsurpr" id="swsurpr" class="input-small hap" exp="수치를"/>
		<input type="text" name="swscar" id="swscar" class="input-small hap" exp="수치를"/>
		<input type="text" name="swdisgus" id="swdisgus" class="input-small hap" exp="수치를"/>
	</td>
</tr>

<tr>
	<th>쓴맛</th>
	<td>
		<input type="text" name="bithappy" id="bithappy" class="input-small hap" exp="수치를"/>
		<input type="text" name="bitsad" id="bitsad" class="input-small hap" exp="수치를"/>
		<input type="text" name="bitangry" id="bitangry" class="input-small hap" exp="수치를"/>
		<input type="text" name="bitsurpr" id="bitsurpr" class="input-small hap" exp="수치를"/>
		<input type="text" name="bitscar" id="bitscar" class="input-small hap" exp="수치를"/>
		<input type="text" name="bitdisgus" id="bitdisgus" class="input-small hap" exp="수치를"/>
	</td>
</tr>

<tr>
	<th>짠맛</th>
	<td>
		<input type="text" name="sthappy" id="sthappy" class="input-small hap" exp="수치를"/>
		<input type="text" name="stsad" id="stsad" class="input-small hap" exp="수치를"/>
		<input type="text" name="stangry" id="stangry" class="input-small hap" exp="수치를"/>
		<input type="text" name="stsurpr" id="stsurpr" class="input-small hap" exp="수치를"/>
		<input type="text" name="stscar" id="stscar" class="input-small hap" exp="수치를"/>
		<input type="text" name="stdisgus" id="stdisgus" class="input-small hap" exp="수치를"/>
	</td>
</tr>

<tr>
	<th>신맛</th>
	<td>
		<input type="text" name="sohappy" id="sohappy" class="input-small hap" exp="수치를"/>
		<input type="text" name="sosad" id="sosad" class="input-small hap" exp="수치를"/>
		<input type="text" name="soangry" id="soangry" class="input-small hap" exp="수치를"/>
		<input type="text" name="sosurpr" id="sosurpr" class="input-small hap" exp="수치를"/>
		<input type="text" name="soscar" id="soscar" class="input-small hap" exp="수치를"/>
		<input type="text" name="sodisgus" id="sodisgus" class="input-small hap" exp="수치를"/>
	</td>
</tr>

<tr>
	<th id="spicy">매운맛</th>
	<td>
		<input type="text" name="sphappy" id="sphappy" class="input-small hap" exp="수치를"/>
		<input type="text" name="spsad" id="spsad" class="input-small hap" exp="수치를"/>
		<input type="text" name="spangry" id="spangry" class="input-small hap" exp="수치를"/>
		<input type="text" name="spsurpr" id="spsurpr" class="input-small hap" exp="수치를"/>
		<input type="text" name="spscar" id="spscar" class="input-small hap" exp="수치를"/>
		<input type="text" name="spdisgus" id="spdisgus" class="input-small hap" exp="수치를"/>
	</td>
</tr>

<tr>
	<th>Video</th>
	<td>
		<input type="file" name="video" class="" value="<?=$row['video']?>">
		<?php
		if($row['video'])
		{
		?>
		<a href="/board/videodownload.php?file=<?=$row['video']?>"> 영상 다운로드 </a>
	<?
			//printf("<a href=\"javascript:void(window.open('../image.view.php?path=member&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a> %s <img src=\"../img/icon/icon_x.gif\" style=\"vertical-align:middle;\" class=\"hand\" onclick=\"ImgDel('%d');\" />", $row['video'], getImageTag("../../upload/member/thum", "thum_".$row['video'], 40, 40, '','','') ,$row['video'], $row['idx']);
		}
		?>
	</td>
</tr>
<tr>
	<th>
		<label for="">기분</label>
	</th>
	<td>
		<input type="radio" name="emotion" value="1" id="" <?php if($row['emotion'] == 1):?>checked<?php endif?>>
		<span class="">매우좋다</span>
		<input type="radio" name="emotion" value="2" id="" <?php if($row['emotion'] == 2):?>checked<?php endif?>>
		<span class="">좋다</span>
		<input type="radio" name="emotion" value="3" id="" <?php if($row['emotion'] == 3):?>checked<?php endif?>>
		<span class="">보통이다</span>
		<input type="radio" name="emotion" value="4" id="" <?php if($row['emotion'] == 4):?>checked<?php endif?>>
		<span class="">싫다</span>
		<input type="radio" name="emotion" value="5" id="" <?php if($row['emotion'] == 5):?>checked<?php endif?>>
		<span class="">매우싫다</span>
	</td>
</tr>
</tbody>
</table>
</div>
<p class="btnC">
	<button type="button" onclick="javascript:location.href='/sadm/product/index.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
	<button type="button" onclick="check()" class="btn btn-white btn-info">수정</button>
</p>
</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<script type="text/javascript">
<!--
var tasty1 = [
	 {taste:"sweet", mood:"happy",taste:"sweet", mood:"happy", start:0.001, end:0.053, step:1},{taste:"sweet", mood:"happy",start:0.054, end:0.149, step:2},{taste:"sweet", mood:"happy",start:0.150, end:1, step:3},
   {taste:"sweet", mood:"sad",start:0.001, end:0.212, step:1},{taste:"sweet", mood:"sad",start:0.213, end:0.373, step:2},{taste:"sweet", mood:"sad",start:0.374, end:1, step:3},
   {taste:"sweet", mood:"angry",start:0.001, end:0.065, step:1},{taste:"sweet", mood:"angry",start:0.066, end:0.133, step:2},{taste:"sweet", mood:"angry",start:0.134, end:1, step:3},
   {taste:"sweet", mood:"surprised",start:0.001, end:0.075, step:1},{taste:"sweet", mood:"surprised",start:0.076, end:0.148, step:2},{taste:"sweet", mood:"surprised",start:0.149, end:1, step:3},
   {taste:"sweet", mood:"scared",start:0.001, end:0.029, step:1},{taste:"sweet", mood:"scared",start:0.030, end:0.065, step:2},{taste:"sweet", mood:"scared",start:0.066, end:1, step:3},
   {taste:"sweet", mood:"disgusted",start:0.001, end:0.051, step:1},{taste:"sweet", mood:"disgusted",start:0.052, end:0.115, step:2},{taste:"sweet", mood:"disgusted",start:0.116, end:1, step:3}
 ];

 var tasty2 = [
	 {taste:"bitter", mood:"happy",taste:"bitter", mood:"happy", start:0.001, end:0.049, step:1},{taste:"bitter", mood:"happy",start:0.050, end:0.126, step:2},{taste:"bitter", mood:"happy",start:0.127, end:1, step:3},
   {taste:"bitter", mood:"sad",start:0.001, end:0.246, step:1},{taste:"bitter", mood:"sad",start:0.247, end:0.438, step:2},{taste:"bitter", mood:"sad",start:0.439, end:1, step:3},
   {taste:"bitter", mood:"angry",start:0.001, end:0.079, step:1},{taste:"bitter", mood:"angry",start:0.080, end:0.173, step:2},{taste:"bitter", mood:"angry",start:0.174, end:1, step:3},
   {taste:"bitter", mood:"surprised",start:0.001, end:0.047, step:1},{taste:"bitter", mood:"surprised",start:0.048, end:0.102, step:2},{taste:"bitter", mood:"surprised",start:0.103, end:1, step:3},
   {taste:"bitter", mood:"scared",start:0.001, end:0.024, step:1},{taste:"bitter", mood:"scared",start:0.025, end:0.050, step:2},{taste:"bitter", mood:"scared",start:0.051, end:1, step:3},
   {taste:"bitter", mood:"disgusted",start:0.001, end:0.106, step:1},{taste:"bitter", mood:"disgusted",start:0.107, end:0.242, step:2},{taste:"bitter", mood:"disgusted",start:0.243, end:1, step:3}
 ];

 var tasty3 = [
	 {taste:"salt", mood:"happy",taste:"salt", mood:"happy", start:0.001, end:0.058, step:1},{taste:"salt", mood:"happy",start:0.059, end:0.133, step:2},{taste:"salt", mood:"happy",start:0.134, end:1, step:3},
 	 {taste:"salt", mood:"sad",start:0.001, end:0.238, step:1},{taste:"salt", mood:"sad",start:0.239, end:0.432, step:2},{taste:"salt", mood:"sad",start:0.433, end:1, step:3},
 	 {taste:"salt", mood:"angry",start:0.001, end:0.080, step:1},{taste:"salt", mood:"angry",start:0.081, end:0.174, step:2},{taste:"salt", mood:"angry",start:0.175, end:1, step:3},
 	 {taste:"salt", mood:"surprised",start:0.001, end:0.080, step:1},{taste:"salt", mood:"surprised",start:0.081, end:0.174, step:2},{taste:"salt", mood:"surprised",start:0.175, end:1, step:3},
 	 {taste:"salt", mood:"scared",start:0.001, end:0.025, step:1},{taste:"salt", mood:"scared",start:0.026, end:0.055, step:2},{taste:"salt", mood:"scared",start:0.056, end:1, step:3},
 	 {taste:"salt", mood:"disgusted",start:0.001, end:0.107, step:1},{taste:"salt", mood:"disgusted",start:0.108, end:0.229, step:2},{taste:"salt", mood:"disgusted",start:0.230, end:1, step:3}
 ];

 var tasty4 = [
	 {taste:"sour", mood:"happy",taste:"sour", mood:"happy", start:0.001, end:0.059, step:1},{taste:"sour", mood:"happy",start:0.060, end:0.142, step:2},{taste:"sour", mood:"happy",start:0.143, end:1, step:3},
 	 {taste:"sour", mood:"sad",start:0.001, end:0.234, step:1},{taste:"sour", mood:"sad",start:0.235, end:0.410, step:2},{taste:"sour", mood:"sad",start:0.411, end:1, step:3},
 	 {taste:"sour", mood:"angry",start:0.001, end:0.066, step:1},{taste:"sour", mood:"angry",start:0.067, end:0.135, step:2},{taste:"sour", mood:"angry",start:0.136, end:1, step:3},
 	 {taste:"sour", mood:"surprised",start:0.001, end:0.042, step:1},{taste:"sour", mood:"surprised",start:0.043, end:0.092, step:2},{taste:"sour", mood:"surprised",start:0.093, end:1, step:3},
 	 {taste:"sour", mood:"scared",start:0.001, end:0.028, step:1},{taste:"sour", mood:"scared",start:0.029, end:0.061, step:2},{taste:"sour", mood:"scared",start:0.062, end:1, step:3},
 	 {taste:"sour", mood:"disgusted",start:0.001, end:0.114, step:1},{taste:"sour", mood:"disgusted",start:0.115, end:0.231, step:2},{taste:"sour", mood:"disgusted",start:0.232, end:1, step:3}
 ];

 var tasty5 = [
	 {taste:"spicy", mood:"happy",taste:"spicy", mood:"happy", start:0.001, end:0.032, step:1},{taste:"spicy", mood:"happy",start:0.033, end:0.085, step:2},{taste:"spicy", mood:"happy",start:0.086, end:1, step:3},
 	 {taste:"spicy", mood:"sad",start:0.001, end:0.226, step:1},{taste:"spicy", mood:"sad",start:0.227, end:0.384, step:2},{taste:"spicy", mood:"sad",start:0.385, end:1, step:3},
 	 {taste:"spicy", mood:"angry",start:0.001, end:0.073, step:1},{taste:"spicy", mood:"angry",start:0.074, end:0.150, step:2},{taste:"spicy", mood:"angry",start:0.151, end:1, step:3},
 	 {taste:"spicy", mood:"surprised",start:0.001, end:0.074, step:1},{taste:"spicy", mood:"surprised",start:0.075, end:0.148, step:2},{taste:"spicy", mood:"surprised",start:0.149, end:1, step:3},
 	 {taste:"spicy", mood:"scared",start:0.001, end:0.035, step:1},{taste:"spicy", mood:"scared",start:0.036, end:0.077, step:2},{taste:"spicy", mood:"scared",start:0.078, end:1, step:3},
 	 {taste:"spicy", mood:"disgusted",start:0.001, end:0.087, step:1},{taste:"spicy", mood:"disgusted",start:0.088, end:0.205, step:2},{taste:"spicy", mood:"disgusted",start:0.206, end:1, step:3}
 ];


function findStep(){

// 콤보박스 value 값, happy ~ disgusTxt
   // var tastVal = $("#taste").val();
   var swhappyTxt = $("#swhappy").val();
   var swsadTxt = $("#swsad").val();
   var swangryTxt = $("#swangry").val();
   var swsurprTxt = $("#swsurpr").val();
   var swscarTxt = $("#swscar").val();
   var swdisgusTxt = $("#swdisgus").val();

   var bithappyTxt = $("#bithappy").val();
   var bitsadTxt = $("#bitsad").val();
   var bitangryTxt = $("#bitangry").val();
   var bitsurprTxt = $("#bitsurpr").val();
   var bitscarTxt = $("#bitscar").val();
   var bitdisgusTxt = $("#bitdisgus").val();

   var sthappyTxt = $("#sthappy").val();
   var stsadTxt = $("#stsad").val();
   var stangryTxt = $("#stangry").val();
   var stsurprTxt = $("#stsurpr").val();
   var stscarTxt = $("#stscar").val();
   var stdisgusTxt = $("#stdisgus").val();

   var sohappyTxt = $("#sohappy").val();
   var sosadTxt = $("#sosad").val();
   var soangryTxt = $("#soangry").val();
   var sosurprTxt = $("#sosurpr").val();
   var soscarTxt = $("#soscar").val();
   var sodisgusTxt = $("#sodisgus").val();

   var sphappyTxt = $("#sphappy").val();
   var spsadTxt = $("#spsad").val();
   var spangryTxt = $("#spangry").val();
   var spsurprTxt = $("#spsurpr").val();
   var spscarTxt = $("#spscar").val();
   var spdisgusTxt = $("#spdisgus").val();

	 var vals1 = [
     {taste:"sweet", mood:"happy", val:swhappyTxt},
     {taste:"sweet", mood:"sad", val:swsadTxt},
     {taste:"sweet", mood:"angry", val:swangryTxt},
     {taste:"sweet", mood:"surprised", val:swsurprTxt},
     {taste:"sweet", mood:"scared", val:swscarTxt},
	   {taste:"sweet", mood:"disgusted", val:swdisgusTxt}
   ];

	 var vals2 = [
		 {taste:"bitter", mood:"happy", val:bithappyTxt},
     {taste:"bitter", mood:"sad", val:bitsadTxt},
     {taste:"bitter", mood:"angry", val:bitangryTxt},
     {taste:"bitter", mood:"surprised", val:bitsurprTxt},
     {taste:"bitter", mood:"scared", val: bitscarTxt},
	   {taste:"bitter", mood:"disgusted", val:bitdisgusTxt}
	 ];

	 var vals3 = [
		 {taste:"salt", mood:"happy", val:sthappyTxt},
     {taste:"salt", mood:"sad", val:stsadTxt},
     {taste:"salt", mood:"angry", val:stangryTxt},
     {taste:"salt", mood:"surprised", val:stsurprTxt},
     {taste:"salt", mood:"scared", val: stscarTxt},
	   {taste:"salt", mood:"disgusted", val:stdisgusTxt}
	 ];

	 var vals4 = [
		 {taste:"sour", mood:"happy", val:sohappyTxt},
		 {taste:"sour", mood:"sad", val:sosadTxt},
		 {taste:"sour", mood:"angry", val:soangryTxt},
		 {taste:"sour", mood:"surprised", val:sosurprTxt},
		 {taste:"sour", mood:"scared", val: soscarTxt},
		 {taste:"sour", mood:"disgusted", val:sodisgusTxt},
	 ];

	 var vals5 = [
		 {taste:"spicy", mood:"happy", val:sphappyTxt},
     {taste:"spicy", mood:"sad", val:spsadTxt},
     {taste:"spicy", mood:"angry", val:spangryTxt},
     {taste:"spicy", mood:"surprised", val:spsurprTxt},
     {taste:"spicy", mood:"scared", val: spscarTxt},
	   {taste:"spicy", mood:"disgusted", val:spdisgusTxt}
	 ];


// 위의 5가지의 맛과 수치들을 담은 변수 tasty 와,
// 위의 vals 변수의 length 만큼 filter
// 해당하는 수치가 없을 경우는 0 으로 표기
   for (var i = 0; i < vals1.length; i++) {
       var taste1 = tasty1.filter(function(item){return item.taste == vals1[i].taste && item.mood == vals1[i].mood}).find(function(item){return vals1[i].val >= item.start && vals1[i].val <= item.end});
       vals1[i].step = (taste && taste1.step) || 0;
   }
	 for (var i = 0; i < vals2.length; i++) {
       var taste2 = tasty2.filter(function(item){return item.taste == vals2[i].taste && item.mood == vals2[i].mood}).find(function(item){return vals2[i].val >= item.start && vals2[i].val <= item.end});
       vals2[i].step = (taste && taste2.step) || 0;
   }

	 for (var i = 0; i < vals3.length; i++) {
				var taste3 = tasty3.filter(function(item){return item.taste == vals3[i].taste && item.mood == vals3[i].mood}).find(function(item){return vals3[i].val >= item.start && vals3[i].val <= item.end});
				vals3[i].step = (taste && taste3.step) || 0;
		}

	 for (var i = 0; i < vals4.length; i++) {
       var taste4 = tasty4.filter(function(item){return item.taste == vals4[i].taste && item.mood == vals4[i].mood}).find(function(item){return vals4[i].val >= item.start && vals4[i].val <= item.end});
       vals4[i].step = (taste && taste4.step) || 0;
   }

	 for (var i = 0; i < vals5.length; i++) {
       var taste5 = tasty5.filter(function(item){return item.taste == vals5[i].taste && item.mood == vals5[i].mood}).find(function(item){return vals5[i].val >= item.start && vals5[i].val <= item.end});
       vals5[i].step = (taste && taste5.step) || 0;
   }

	 // alert(JSON.stringify(vals));
   // console.log(JSON.stringify(vals));

	 //단맛 비교
	 if((vals1[0].step == vals1[1].step) && (vals1[0].step == vals1[2].step) && (vals1[0].step == vals1[3].step) && (vals1[0].step == vals1[4].step) && (vals1[0].step == vals1[5].step)) {
		 $("#mood1").val(vals1[0].step)
	 }else {
		 $("#mood1").val(0)
	 }
	 //쓴맛 비교
	 if((vals2[0].step == vals2[1].step) && (vals2[0].step == vals2[2].step) && (vals2[0].step == vals2[3].step) && (vals2[0].step == vals2[4].step) && (vals2[0].step == vals2[5].step)) {
		 $("#mood2").val(vals2[0].step)
	 }else {
		 $("#mood2").val(0)
	 }
	 //짠맛 비교
	 if((vals3[0].step == vals3[1].step) && (vals3[0].step == vals3[2].step) && (vals3[0].step == vals3[3].step) && (vals3[0].step == vals3[4].step) && (vals3[0].step == vals3[5].step)) {
		 $("#mood3").val(vals3[0].step)
	 }else {
		 $("#mood3").val(0)
	 }
	 //신맛 비교
	 if((vals4[0].step == vals4[1].step) && (vals4[0].step == vals4[2].step) && (vals4[0].step == vals4[3].step) && (vals4[0].step == vals4[4].step) && (vals4[0].step == vals4[5].step)) {
		 $("#mood4").val(vals4[0].step)
	 }else {
		 $("#mood4").val(0)
	 }
	 //매운맛 비교
	 if((vals5[0].step == vals5[1].step) && (vals5[0].step == vals5[2].step) && (vals5[0].step == vals5[3].step) && (vals5[0].step == vals5[4].step) && (vals5[0].step == vals5[5].step)) {
		 $("#mood5").val(vals5[0].step)
	 }else {
		 $("#mood5").val(0)
	 }
	 document.fm.submit();
}

function check(){
    var sum=0;
    for(i=0;i<document.fm.emotion.length;i++){
          if(document.fm.emotion[i].checked == false){
              sum +=sum;
          }
          else{
              sum = sum+1;
          }
    }
    if(sum == 0){
			alert("기분을 선택해주세요.");
			return false;
    }
    else{findStep();}
}

function ImgDel(idx)
{
	var f = document.fm;

	if(confirm("첨부파일을 삭제하시겠습니까?"))
	{
		f.act.value = "imgdel";
		f.submit();
	}
}
//-->
</script>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
