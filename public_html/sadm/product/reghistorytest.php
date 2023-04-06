
<?
include_once dirname(__FILE__)."/sadm/_header.php";
$navi = "Product > 얼굴 표정 맛 분석";
include_once dirname(__FILE__)."/../_template.php";
// $navi = "기본설정 > 사이트설정";
// $sqry = sprintf("select * from %s where idx='1'", "sw_siteinfo");
// $row = $db->_fetch($sqry, 1);
$row = $db->_fetch("select * from sw_member where idx = '".$idx."'");
?>
<div class="page-header">
	<h1>
		Product
		<small><i class="ace-icon fa fa-angle-double-right"></i>얼굴 표정 맛 분석</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12" style="max-width:1000px;">
		<!-- PAGE CONTENT BEGINS -->
		<form name="fm" method="post" action="/sadm/product/history.act.php/" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" onSubmit="return Common.checkFormHandler.checkForm(this);">
			<input type="hidden" name="act" value="siteedit"/>
			<input type="hidden" name="idx" value="<?=$row['idx']?>"/>
			<!-- <input type="hidden" name="mood" id="mood" value=""/> -->
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
					<table class="table  table-bordered intb" style="margin:10px;">
						<colgroup>
							<col width="130"/>
						</colgroup>
						<tbody>
							<tr>
								<th>제목</th>
								<td><input type="text" name="title" class="input-small" exp="제목을"/></td>
							</tr>

							<tr>
								<th>내용</th>
								<td><input type="text" name="content" class="input-small" exp="내용을"/></td>
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

							<tr class="distri_company02_div_whole">
								<th>video</th>
					      <td class="distri_company02_div_span">
									<input type="file" name="video" id="img1">
					      </td>
					    </tr>

							<tr>
					      <th>기분</th>
					      <td id="check">
					        <input type="radio" name="emotion" value="1" id="">
									<span class="">매우 좋다</span>
					        <input type="radio" name="emotion" value="2" id="">
					        <span class="">좋다</span>
									<input type="radio" name="emotion" value="3" id="">
					        <span class="">보통이다</span>
									<input type="radio" name="emotion" value="4" id="">
					        <span class="">싫다</span>
									<input type="radio" name="emotion" value="5" id="">
					        <span class="">매우 싫다</span>
					      </td>
					    </tr>
						</tbody>
					</table>
			</div>
			<p class="btnC">
				<!-- <input type="button" class="btn btn-white btn-info go" onclick="save()" name="mood" id="mood" value="저장"> -->
				<!-- <input type="button" class="btn btn-white btn-info go" onclick="" name="mood" id="mood" value="저장"> -->
				<input type="button" class="btn btn-white btn-info" onclick="check()" name="mood" id="mood" value="저장"/>
				<input type="button" class="btn btn-white btn-info calc" onclick="findStep()" value="계산">
        <!-- onclick="findStep()" -->
			</p>
		</form>
	</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content -->

<script type="text/javascript">

var tasty = [
	 {taste:"sweet", mood:"happy",taste:"sweet", mood:"happy", start:0.001, end:0.053, step:1},{taste:"sweet", mood:"happy",start:0.054, end:0.149, step:2},{taste:"sweet", mood:"happy",start:0.150, end:1, step:3},
   {taste:"sweet", mood:"sad",start:0.001, end:0.212, step:1},{taste:"sweet", mood:"sad",start:0.213, end:0.373, step:2},{taste:"sweet", mood:"sad",start:0.374, end:1, step:3},
   {taste:"sweet", mood:"angry",start:0.001, end:0.065, step:1},{taste:"sweet", mood:"angry",start:0.066, end:0.133, step:2},{taste:"sweet", mood:"angry",start:0.134, end:1, step:3},
   {taste:"sweet", mood:"surprised",start:0.001, end:0.075, step:1},{taste:"sweet", mood:"surprised",start:0.076, end:0.148, step:2},{taste:"sweet", mood:"surprised",start:0.149, end:1, step:3},
   {taste:"sweet", mood:"scared",start:0.001, end:0.029, step:1},{taste:"sweet", mood:"scared",start:0.030, end:0.065, step:2},{taste:"sweet", mood:"scared",start:0.066, end:1, step:3},
   {taste:"sweet", mood:"disgusted",start:0.001, end:0.051, step:1},{taste:"sweet", mood:"disgusted",start:0.052, end:0.115, step:2},{taste:"sweet", mood:"disgusted",start:0.116, end:1, step:3},
	 {taste:"bitter", mood:"happy",taste:"bitter", mood:"happy", start:0.001, end:0.049, step:1},{taste:"bitter", mood:"happy",start:0.050, end:0.126, step:2},{taste:"bitter", mood:"happy",start:0.127, end:1, step:3},
   {taste:"bitter", mood:"sad",start:0.001, end:0.246, step:1},{taste:"bitter", mood:"sad",start:0.247, end:0.438, step:2},{taste:"bitter", mood:"sad",start:0.439, end:1, step:3},
   {taste:"bitter", mood:"angry",start:0.001, end:0.079, step:1},{taste:"bitter", mood:"angry",start:0.080, end:0.173, step:2},{taste:"bitter", mood:"angry",start:0.174, end:1, step:3},
   {taste:"bitter", mood:"surprised",start:0.001, end:0.047, step:1},{taste:"bitter", mood:"surprised",start:0.048, end:0.102, step:2},{taste:"bitter", mood:"surprised",start:0.103, end:1, step:3},
   {taste:"bitter", mood:"scared",start:0.001, end:0.024, step:1},{taste:"bitter", mood:"scared",start:0.025, end:0.050, step:2},{taste:"bitter", mood:"scared",start:0.051, end:1, step:3},
   {taste:"bitter", mood:"disgusted",start:0.001, end:0.106, step:1},{taste:"bitter", mood:"disgusted",start:0.107, end:0.242, step:2},{taste:"bitter", mood:"disgusted",start:0.243, end:1, step:3},
	 {taste:"salt", mood:"happy",taste:"salt", mood:"happy", start:0.001, end:0.058, step:1},{taste:"salt", mood:"happy",start:0.059, end:0.133, step:2},{taste:"salt", mood:"happy",start:0.134, end:1, step:3},
   {taste:"salt", mood:"sad",start:0.001, end:0.238, step:1},{taste:"salt", mood:"sad",start:0.239, end:0.432, step:2},{taste:"salt", mood:"sad",start:0.433, end:1, step:3},
   {taste:"salt", mood:"angry",start:0.001, end:0.080, step:1},{taste:"salt", mood:"angry",start:0.081, end:0.174, step:2},{taste:"salt", mood:"angry",start:0.175, end:1, step:3},
   {taste:"salt", mood:"surprised",start:0.001, end:0.080, step:1},{taste:"salt", mood:"surprised",start:0.081, end:0.174, step:2},{taste:"salt", mood:"surprised",start:0.175, end:1, step:3},
   {taste:"salt", mood:"scared",start:0.001, end:0.025, step:1},{taste:"salt", mood:"scared",start:0.026, end:0.055, step:2},{taste:"salt", mood:"scared",start:0.056, end:1, step:3},
   {taste:"salt", mood:"disgusted",start:0.001, end:0.107, step:1},{taste:"salt", mood:"disgusted",start:0.108, end:0.229, step:2},{taste:"salt", mood:"disgusted",start:0.230, end:1, step:3},
	 {taste:"sour", mood:"happy",taste:"sour", mood:"happy", start:0.001, end:0.059, step:1},{taste:"sour", mood:"happy",start:0.060, end:0.142, step:2},{taste:"sour", mood:"happy",start:0.143, end:1, step:3},
   {taste:"sour", mood:"sad",start:0.001, end:0.234, step:1},{taste:"sour", mood:"sad",start:0.235, end:0.410, step:2},{taste:"sour", mood:"sad",start:0.411, end:1, step:3},
   {taste:"sour", mood:"angry",start:0.001, end:0.066, step:1},{taste:"sour", mood:"angry",start:0.067, end:0.135, step:2},{taste:"sour", mood:"angry",start:0.136, end:1, step:3},
   {taste:"sour", mood:"surprised",start:0.001, end:0.042, step:1},{taste:"sour", mood:"surprised",start:0.043, end:0.092, step:2},{taste:"sour", mood:"surprised",start:0.093, end:1, step:3},
   {taste:"sour", mood:"scared",start:0.001, end:0.028, step:1},{taste:"sour", mood:"scared",start:0.029, end:0.061, step:2},{taste:"sour", mood:"scared",start:0.062, end:1, step:3},
   {taste:"sour", mood:"disgusted",start:0.001, end:0.114, step:1},{taste:"sour", mood:"disgusted",start:0.115, end:0.231, step:2},{taste:"sour", mood:"disgusted",start:0.232, end:1, step:3},
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

	 var vals = [
     {taste:"sweet", mood:"happy", val:swhappyTxt},
     {taste:"sweet", mood:"sad", val:swsadTxt},
     {taste:"sweet", mood:"angry", val:swangryTxt},
     {taste:"sweet", mood:"surprised", val:swsurprTxt},
     {taste:"sweet", mood:"scared", val:swscarTxt},
	   {taste:"sweet", mood:"disgusted", val:swdisgusTxt},
		 {taste:"bitter", mood:"happy", val:bithappyTxt},
     {taste:"bitter", mood:"sad", val:bitsadTxt},
     {taste:"bitter", mood:"angry", val:bitangryTxt},
     {taste:"bitter", mood:"surprised", val:bitsurprTxt},
     {taste:"bitter", mood:"scared", val: bitscarTxt},
	   {taste:"bitter", mood:"disgusted", val:bitdisgusTxt},
     {taste:"salt", mood:"happy", val:sthappyTxt},
     {taste:"salt", mood:"sad", val:stsadTxt},
     {taste:"salt", mood:"angry", val:stangryTxt},
     {taste:"salt", mood:"surprised", val:stsurprTxt},
     {taste:"salt", mood:"scared", val: stscarTxt},
	   {taste:"salt", mood:"disgusted", val:stdisgusTxt},
     {taste:"sour", mood:"happy", val:sohappyTxt},
     {taste:"sour", mood:"sad", val:sosadTxt},
     {taste:"sour", mood:"angry", val:soangryTxt},
     {taste:"sour", mood:"surprised", val:sosurprTxt},
     {taste:"sour", mood:"scared", val: soscarTxt},
	   {taste:"sour", mood:"disgusted", val:sodisgusTxt},
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
   for (var i = 0; i < vals.length; i++) {
       var taste = tasty.filter(function(item){return item.taste == vals[i].taste && item.mood == vals[i].mood}).find(function(item){return vals[i].val >= item.start && vals[i].val <= item.end});
       vals[i].step = (taste && taste.step) || 0;
   }

   alert(JSON.stringify(vals[0].step));
	 alert(JSON.stringify(vals[1].step));
	 alert(JSON.stringify(vals[2].step));
	 alert(JSON.stringify(vals[3].step));
	 alert(JSON.stringify(vals[4].step));
	 alert(JSON.stringify(vals[5].step));
   // console.log(JSON.stringify(vals));

	 //단맛 비교
	 if(vals[0].step == vals[1].step == vals[2].step == vals[3].step == vals[4].step == vals[5].step) {
		 $("#mood1").val(vals[0].step)
	 }else {
		 $("#mood1").val(0)
	 }
	 //쓴맛 비교
	 if(vals[6].step == vals[7].step == vals[8].step == vals[9].step == vals[10].step == vals[11].step) {
		 $("#mood2").val(vals[0].step)
	 }else {
		 $("#mood2").val(0)
	 }
	 //짠맛 비교
	 if(vals[12].step == vals[13].step == vals[14].step == vals[15].step == vals[16].step == vals[17].step) {
		 $("#mood3").val(vals[0].step)
	 }else {
		 $("#mood3").val(0)
	 }
	 //신맛 비교
	 if(vals[18].step == vals[19].step == vals[20].step == vals[21].step == vals[22].step == vals[23].step) {
		 $("#mood4").val(vals[0].step)
	 }else {
		 $("#mood4").val(0)
	 }
	 //매운맛 비교
	 if(vals[24].step == vals[25].step == vals[26].step == vals[27].step == vals[28].step == vals[29].step) {
		 $("#mood5").val(vals[0].step)
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
    else{findStep()}
}

</script>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
