<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "예약관리 > 예약상품 등록";
include_once dirname(__FILE__)."/../_template.php";
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$sqry = sprintf("select * from %s where idx='%d'", "sw_member", $idx);
	$row = $db->_fetch($sqry, 1);

	//$exhp = explode("-", $row['hp']);
}
?>
<script type="text/javascript" src="./goods.js"></script>
<div class="page-header">
	<h1>
		예약관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			예약상품 등록
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<script type="text/javascript">
		function openPassword()
		{
			if($("input:checkbox[name='chgpass']").is(":checked"))
				$("#pass").css("display","block");
			else
				$("#pass").css("display","none");
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
		function Write()
		{
			var f = document.fm;

			if(Common.checkFormHandler.checkForm(f))
			{
				editor_object.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
				editor_object2.getById["notice"].exec("UPDATE_CONTENTS_FIELD", []);
				f.act.value = "";
				f.submit();
			}
		}
		</script>
		<form name="fm" method="post" action="./goods.act.php" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" >
		<input type="hidden" name="act" value="<?=($row['idx'] ? "edit" : "")?>" />
		<input type="hidden" name="idx" value="<?=$row['idx']?>" />
    <table class="table table-bordered">
    <colgroup>
    <col width="200" />
    <col />
    </colgroup>
    <tbody style="height:29px;">
    <tr>
      <th>상품코드</th>
      <td> <input type="text" name="gcode" class="input-large" value="<?=getGoodsCode()?>" readonly  /></td>
    </tr>
    <tr>
    	<th>제 목</th>
    	<td>
        <select name="etc4" id="etc4">
          <option value="">--선택해주세요--</option>
          <?php for($i=0;  $i < count($arr_area); $i++){
             printf("<option value='%d'>%s</option>", $part_area_keys[$i], $arr_area[$part_area_keys[$i]]);
            }?>
        </select>
        &nbsp;&nbsp;
        <input type="text" name="name" class="input-xxlarge" value="" exp="제목을 "/>
      </td>
    </tr>
     <tr>
    	<th>게시물노출여부</th>
    	<td>
    		<div class="radio">
    			<label>
    				<input type="radio" class="ace" name="display" id="display1" value="Y" checked>
    				<span class="lbl"> 노출</span>
    			</label>
    			<label>
    				<input type="radio" class="ace" name="display" id="display2" value="N">
    				<span class="lbl"> 비노출</span>
    			</label>
    		</div>
     	</td>
    </tr>
    <tr>
      <th>카테고리</th>
      <td>
        <select name="category" id="category" exp="카테고리를">
            <option value="">카테고리</option>
            <option value="001">일상체험</option>
            <option value="002">취미체험</option>
            <option value="003">가족체험</option>
            <option value="004">여행체험</option>>
        </select>
      </td>
    </tr>
    <tr>
    	<th>해시태그</th>
    	<td><input type="text" name="shortexp" class="input-xxlarge" /></td>
    </tr>
     <tr>
       <th>장소</th>
       <td>
         <input type="text" name="address" id="address" class="input-xxlarge" value="" />
       </td>
     </tr>
      <tr>
      	<th>기간</th>
      	<td>
            <input type="text" name="sday" id="sday" class="date-picker" value="<?=$sday?>" /> ~ <input type="text" name="eday" id="eday" class="date-picker" value="<?=$eday?>" />
        </td>
      </tr>
      <tr>
        <th>인원</th>
        <td>
          <select name="etc1" id="etc1" exp="인원을">
            <option value="">인원</option>
            <option value="1">2인이하</option>
            <option value="2">4인이하</option>
            <option value="3">6인이하</option>
            <option value="4">8인이하</option>
            <option value="5">10인이하</option>
            <option value="6">20인이하</option>
            <option value="7">30인이하</option>
            <option value="8">40인이하</option>
            <option value="99">50인이상</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>시간</th>
        <td>
          <select name="etc2" id="etc2" exp="시간을">
              <option value="">시간</option>
              <?php for($i=9; $i<=20; $i++){?>
              <option value="<?=$i?>"><?=$i?>:00</option>
            <?php }?>
            <option value="99">조율가능</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>필터</th>
        <td>
          <select name="etc3" id="etc3">
              <option value="">필터</option>
              <option value="1">가족중심</option>
              <option value="2">성인중심</option>
              <option value="3">학생중심</option>
              <option value="4">애견동반</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>정상가</th>
        <td>
          <input type="text" name="price" value="" class="input-small" onKeyUp="Common.numberHandler.toCurrency(this)" onBlur="Common.numberHandler.toCurrency(this)" >&nbsp;원
        </td>
      </tr>
      <tr>
        <th>할인가</th>
        <td>
          <input type="text" name="nprice" value="" class="input-small" onKeyUp="Common.numberHandler.toCurrency(this)" onBlur="Common.numberHandler.toCurrency(this)" >&nbsp;원
        </td>
      </tr>
      <tr>
        <th>검색키워드</th>
        <td><input type="text" name="keyword" value="" class="input-xxlarge">
      </td>
      </tr>
    <tr>
    	<th>상세내용</th>
    	<td bgcolor="#ffffff" style="padding:5px;" align="center">
    			<script type="text/javascript" src="/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
    			<textarea id="content" name="content" rows="10" cols="100" style="width:100%; height:300px"><?=$wdata['re_content']?></textarea>
    			<script type="text/javascript">
    			<!--
    				var editor_object = [];
    			nhn.husky.EZCreator.createInIFrame({
    				oAppRef: editor_object,
    				elPlaceHolder: "content",
    				sSkinURI: "/editor/SmartEditor2Skin2.html",
    				htParams : {
    					// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
    					bUseToolbar : true,
    					// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
    					bUseVerticalResizer : true,
    					// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
    					bUseModeChanger : true,
    				}
    			});
    			//-->
    			</script>
    	</td>
    </tr>
		<tr>
			<th>공지사항</th>
			<td bgcolor="#ffffff" style="padding:5px;" align="center">
					<script type="text/javascript" src="/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
					<textarea id="notice" name="notice" rows="10" cols="100" style="width:100%; height:300px"><?=$wdata['notice']?></textarea>
					<script type="text/javascript">
					<!--
						var editor_object2 = [];
					nhn.husky.EZCreator.createInIFrame({
						oAppRef: editor_object2,
						elPlaceHolder: "notice",
						sSkinURI: "/editor/SmartEditor2Skin2.html",
						htParams : {
							// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
							bUseToolbar : true,
							// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
							bUseVerticalResizer : true,
							// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
							bUseModeChanger : true,
						}
					});
					//-->
					</script>
			</td>
		</tr>
    </tbody>
    </table>
    <div style="height:20px;"></div>
<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 상품이미지 설정</div>
<table class="table table-bordered">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th>이미지등록 방식</th>
	<td>
		<label><input type="radio" name="imgtype" value="1" checked="checked" onClick="Goods.uploadImgChange();" /> 대표이미지 등록(자동 섬네일이미지 생성)</label>
		&nbsp;&nbsp;
		<label><input type="radio" name="imgtype" value="2" onClick="Goods.uploadImgChange();" /> 개별이미지 등록</label>
	</td>
</tr>
<tr>
	<th>확대(원본)이미지</th>
	<td><input type="file" name="img1" class="lbox w300" /></td>
</tr>
<tr>
	<th>상세이미지</th>
	<td><input type="file" name="img2" class="lbox w300" disabled="disabled" /> <span class="exf">※ 최적사이즈 : <?=$cfg['imgMX']?> X <?=$cfg['imgMY']?></span></td>
</tr>
<tr>
	<th>리스트이미지</th>
	<td><input type="file" name="img3" class="lbox w300" disabled="disabled" /> <span class="exf">※ 최적사이즈 : <?=$cfg['imgSX']?> X <?=$cfg['imgSY']?></span></td>
</tr>
<tr>
	<th>메인이미지</th>
	<td><input type="file" name="img4" class="lbox w300" disabled="disabled" /> <span class="exf">※ 최적사이즈 : <?=$cfg['imgHX']?> X <?=$cfg['imgHY']?></span></td>
</tr>
<tr>
	<th>메인슬라이드 이미지</th>
	<td><input type="file" name="imgetc" class="lbox w300" /> <span class="exf">※ 최적사이즈 : 1090  X 350</span></td>
</tr> 
</tbody>
</table>


		<p class="btnC">
			<button type="button" onclick="javascript:location.href='./index.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
			<button type="button" onclick="javascript:Write();"  class="btn btn-white btn-info"><?=($row['idx'] ? "수정" : "등록")?></button>
		</p>
	</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
