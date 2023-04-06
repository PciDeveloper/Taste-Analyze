<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "예약관리 > 상품수정";
include_once dirname(__FILE__)."/../_template.php";
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	$sqry = sprintf("select * from %s where idx='%d'", SW_GOODS, $idx);
	$row = $db->_fetch($sqry);
	$exIcon = explode(",", $row['icon']);
	// if($goods['imgetc'])
	// 	$exImg = explode(",", $row['imgetc']);

	// $exetc1 = @explode("」「", $row['etc1']);
	// $exetc2 = @explode("」「", $row['etc2']);
	// $exetc3 = @explode("」「", $row['etc3']);
}
else
	msg("상품이 삭제되었거나 존재하지 않습니다.", -1, true);
?>
<script>
function Edit()
{
	var f = document.fm;

	if(Common.checkFormHandler.checkForm(f))
	{
		editor_object.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
		editor_object2.getById["notice"].exec("UPDATE_CONTENTS_FIELD", []);
		f.act.value = "edit";
		f.submit();
	}
}
</script>
<script type="text/javascript" src="./goods.js"></script>
<div class="page-header">
	<h1>
		예약관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			상품 수정
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<form name="fm" method="post" action="./goods.act.php" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" >
		<input type="hidden" name="act" value="<?=($row['idx'] ? "edit" : "")?>" />
		<input type="hidden" name="idx" value="<?=$row['idx']?>" />
    <input type="hidden" name="encData" value="<?=$encData?>"/>
    <table class="table table-bordered">
    <colgroup>
    <col width="200" />
    <col />
    </colgroup>
    <tbody style="height:29px;">
    <tr>
    	<th>상품명</th>
    	<td>
        <select name="etc4" id="etc4">
          <option value="">--선택해주세요--</option>
          <?php for($i=0;  $i < count($arr_area); $i++){
             if($row['etc4'] == $part_area_keys[$i])
               printf("<option value='%s' selected=\"selected\">%s</option>", $part_area_keys[$i], $arr_area[$part_area_keys[$i]]);
             else
               printf("<option value='%d'>%s</option>", $part_area_keys[$i], $arr_area[$part_area_keys[$i]]);
            }?>
        </select>
        &nbsp;&nbsp;
        <input type="text" name="name" class="input-xxlarge" value="<?=$row['name']?>" exp="제목을 "/>
      </td>
    </tr>
     <tr>
    	<th>게시물노출여부</th>
    	<td>
    		<div class="radio">
    			<label>
    				<input type="radio" class="ace" name="display" id="display1" value="Y" <?php if($row['display'] == "Y"){?>checked="checked"<?php }?>>
    				<span class="lbl"> 노출</span>
    			</label>
    			<label>
    				<input type="radio" class="ace" name="display" id="display2" value="N" <?php if($row['display'] == "N"){?>checked="checked"<?php }?>>
    				<span class="lbl"> 비노출</span>
    			</label>
    		</div>
     	</td>
    </tr>
		<tr>
		 <th>메인슬라이드 노출여부</th>
		 <td>
			 <div class="radio">
				 <label>
					 <input type="radio" class="ace" name="maindisplay" id="maindisplay1" value="Y" <?php if($row['maindisplay'] == "Y"){?>checked="checked"<?php }?>>
					 <span class="lbl"> 노출</span>
				 </label>
				 <label>
					 <input type="radio" class="ace" name="maindisplay" id="maindisplay2" value="N" <?php if($row['maindisplay'] == "N"){?>checked="checked"<?php }?>>
					 <span class="lbl"> 비노출</span>
				 </label>
			 </div>
		 </td>
	 </tr>
	 <tr>
		 <th>슬라이드 내용</th>
		 <td>
			 <input type="text" name="subtitle" class="input-xxlarge" value="<?=$row['subtitle']?>" />
		 </td>
	 </tr>
    <tr>
      <th>카테고리</th>
      <td>
        <select name="category" id="category" exp="카테고리를">
            <option value="">카테고리</option>
            <option value="001" <?php if($row['category'] == "001"){?>selected="selected"<?php }?>>일상체험</option>
            <option value="002" <?php if($row['category'] == "002"){?>selected="selected"<?php }?>>취미체험</option>
            <option value="003" <?php if($row['category'] == "003"){?>selected="selected"<?php }?>>가족체험</option>
            <option value="004" <?php if($row['category'] == "004"){?>selected="selected"<?php }?>>여행체험</option>>
        </select>
      </td>
    </tr>
    <tr>
    	<th>해시태그</th>
    	<td><input type="text" name="shortexp" class="input-xxlarge" value="<?=$row['shortexp']?>"/></td>
    </tr>
     <tr>
       <th>장소</th>
       <td>
         <input type="text" name="address" id="address" class="input-xxlarge" value="<?=$row['address']?>" />
       </td>
     </tr>
      <tr>
      	<th>기간</th>
      	<td>
            <input type="text" name="sday" id="sday" class="date-picker" value="<?=$row['sday']?>" /> ~ <input type="text" name="eday" id="eday" class="date-picker" value="<?=$row['eday']?>" />
        </td>
      </tr>
      <tr>
        <th>인원</th>
        <td>
          <select name="etc1" id="etc1" exp="인원을">
              <option value="">인원</option>
              <option value="1" <?php if($row['etc1'] == "1"){?>selected="selected"<?php }?>>2인이하</option>
              <option value="2"  <?php if($row['etc1'] == "2"){?>selected="selected"<?php }?>>4인이하</option>
              <option value="3"  <?php if($row['etc1'] == "3"){?>selected="selected"<?php }?>>6인이하</option>
              <option value="4"  <?php if($row['etc1'] == "4"){?>selected="selected"<?php }?>>8인이하</option>
              <option value="5"  <?php if($row['etc1'] == "5"){?>selected="selected"<?php }?>>10인이하</option>
              <option value="6" <?php if($row['etc1'] == "6"){?>selected="selected"<?php }?>>20인이하</option>
              <option value="7" <?php if($row['etc1'] == "7"){?>selected="selected"<?php }?>>30인이하</option>
              <option value="8" <?php if($row['etc1'] == "8"){?>selected="selected"<?php }?>>40인이하</option>
              <option value="9" <?php if($row['etc1'] == "9"){?>selected="selected"<?php }?>>50인이상</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>시간</th>
        <td>
          <select name="etc2" id="etc2" exp="시간을">
              <option value="">시간</option>
              <?php for($i=9; $i<=20; $i++){
                 if($row['etc2'] == $i)
                   printf("<option value='%s' selected=\"selected\">%s</option>", $i, $i.":00");
                 else
                   printf("<option value='%d'>%s</option>", $i, $i.":00");
                }?>
            <option value="99" <?php if($row['etc2'] == "99"){?>selected="selected"<?php }?>>조율가능</option>
          </select>
        </td>
      </tr>
    <tr>
      <th>필터</th>
      <td>
        <select name="etc3" id="etc3">
            <option value="">필터</option>
            <option value="1" <?php if($row['etc3'] == "1"){?>selected="selected"<?php }?>>가족중심</option>
            <option value="2" <?php if($row['etc3'] == "2"){?>selected="selected"<?php }?>>성인중심</option>
            <option value="3" <?php if($row['etc3'] == "3"){?>selected="selected"<?php }?>>학생중심</option>
            <option value="4" <?php if($row['etc3'] == "4"){?>selected="selected"<?php }?>>애견동반</option>
        </select>
      </td>
    </tr>
    <tr>
      <th>정상가</th>
      <td>
        <input type="text" name="price" value="<?=number_format($row['price'])?>" class="input-small" onKeyUp="Common.numberHandler.toCurrency(this)" onBlur="Common.numberHandler.toCurrency(this)" >&nbsp;원
      </td>
    </tr>
    <tr>
      <th>할인가</th>
      <td>
        <input type="text" name="nprice" value="<?=number_format($row['nprice'])?>" class="input-small" onKeyUp="Common.numberHandler.toCurrency(this)" onBlur="Common.numberHandler.toCurrency(this)" >&nbsp;원
      </td>
    </tr>
    <tr>
      <th>검색키워드</th>
      <td><input type="text" name="keyword" value="<?=$row['keyword']?>" class="input-xxlarge">
    </td>
    </tr>
    <tr>
    <th>상세내용</th>
    <td bgcolor="#ffffff" style="padding:5px;" align="center">
        <script type="text/javascript" src="/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
        <textarea id="content" name="content" rows="10" cols="100" style="width:100%; height:300px"><?=$row['content']?></textarea>
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
				<textarea id="notice" name="notice" rows="10" cols="100" style="width:100%; height:300px"><?=$row['notice']?></textarea>
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
    <label><input type="radio" name="imgtype" value="1"  onClick="Goods.uploadImgChange();" <?=($row['imgtype'] == 1) ? "checked=\"checked\"" : "";?>/> 대표이미지 등록(자동 섬네일이미지 생성)</label>
    &nbsp;&nbsp;
    <label><input type="radio" name="imgtype" value="2" onClick="Goods.uploadImgChange();" <?=($row['imgtype'] == 2) ? "checked=\"checked\"" : "";?>/> 개별이미지 등록</label>
    </td>
    </tr>
    <tr>
    <th>확대(원본)이미지</th>
    <td>
    <input type="file" name="img1" class="lbox w300" />
    <?
    if($row['img1'])
    printf("<input type=\"checkbox\" name=\"del[1]\" value=\"1\" /> 삭제 (%s) <a href=\"javascript:void(window.open('../image.view.php?path=big&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>", $row['img1'], $row['img1'], getImageTag("../../upload/goods/big", $row['img1'], 20, 20, "img1"));
    ?>
    </td>
    </tr>
    <tr>
    <th>상세이미지</th>
    <td>
    <input type="file" name="img2" class="lbox w300" disabled="disabled" />
    <?
    if($row['img2'])
    printf("<input type=\"checkbox\" name=\"del[2]\" value=\"1\" /> 삭제 (%s) <a href=\"javascript:void(window.open('../image.view.php?path=middle&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>", $row['img2'], $row['img2'], getImageTag("../../upload/goods/middle", $row['img2'], 20, 20, "img1"));
    ?>
    <span class="exf">※ 최적사이즈 : 540 X 400</span>
    </td>
    </tr>
    <tr>
    <th>리스트이미지</th>
    <td>
    <input type="file" name="img3" class="lbox w300" disabled="disabled" />
    <?
    if($row['img3'])
    printf("<input type=\"checkbox\" name=\"del[3]\" value=\"1\" /> 삭제 (%s) <a href=\"javascript:void(window.open('../image.view.php?path=small&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>", $row['img3'], $row['img3'], getImageTag("../../upload/goods/small", $row['img3'], 20, 20, "img1"));
    ?>
    <span class="exf">※ 최적사이즈 : 540 X 400</span>
    </td>
    </tr>
    <tr>
    <th>메인이미지</th>
    <td>
    <input type="file" name="img4" class="lbox w300" disabled="disabled" />
    <?
    if($row['img4'])
    printf("<input type=\"checkbox\" name=\"del[4]\" value=\"1\" /> 삭제 (%s) <a href=\"javascript:void(window.open('../image.view.php?path=small&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>", $row['img4'], $row['img4'], getImageTag("../../upload/goods/small", $row['img4'], 20, 20, "img1"));
    ?>
    <span class="exf">※ 최적사이즈 : 540 X 400</span>
    </td>
    </tr>
		<th>메인슬라이드 이미지</th>
		<td>
		<input type="file" name="imgetc" class="lbox w300"  />
		<?
		if($row['imgetc'])
		printf("<input type=\"checkbox\" name=\"del[5]\" value=\"1\" /> 삭제 (%s) <a href=\"javascript:void(window.open('../image.view.php?path=slide&img=%s', '', 'width=100, height=100, top=300, left=300'))\">%s</a>", $row['imgetc'], $row['imgetc'], getImageTag("../../upload/goods/slide", $row['imgetc'], 20, 20, "img1"));
		?>
		<span class="exf">※ 최적사이즈 : 1090 X 350</span>
		</td>
		</tr>
    </tbody>
    </table>



    <p class="btnC">
    <button type="button" onclick="javascript:location.href='./index.php?encData=<?=$encData?>'" class="btn btn-white btn-danger">목록</button>
    <button type="button" onclick="javascript:Edit()" class="btn btn-white btn-info"><?=($row['idx'] ? "수정" : "등록")?></button>
    </p>
	</form>
 		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
