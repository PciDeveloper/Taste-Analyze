 	<h1><?=$board->info['name']?></h1>
	<div class="notice_wrap">
		<input type="text" placeholder="제목을 작성해주세요." value="<?=$wdata['re_title']?>" exp="제목을" name="title">
    <div class="secret_wrap">
      <input type="checkbox" id="secret_check" name="notice" value="Y">
      <label for="secret_check"><span>공지글 작성&nbsp;</span></label>
    </div>
		<input type="text" placeholder="작성자를 작성해주세요." value="<?=$_SESSION['SES_USERNM']?>" exp="작성자를" name="name">
		<input type="password" placeholder="비밀번호를 작성해주세요." value="" exp="비밀번호를" name="pwd">
    <script type="text/javascript" src="/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
    <textarea name="notice_write" id="notice_write" cols="30" rows="10"><?=$wdata['content']?></textarea>
  <script type="text/javascript">
  <!--
  var editor_object = [];
  nhn.husky.EZCreator.createInIFrame({
  oAppRef: editor_object,
  elPlaceHolder: "notice_write",
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
		<input type="text" placeholder="키워드를 입력하세요." name="keyword" value="">
	</div>

	<!-- <div class="write_icon">
		<ul>
			<li><a href="javascript:Board.imgaddHandler.addImg();" ><img src="/html/img/icon/image.png" alt="사진추가"></a></li>
		</ul>
	</div> -->

	<!-- <div class="add_photo">
		<ul id="filebox">
			<li>
				<input type="file" name="etcimg[]" class="lbox w300" />
			</li>
		</ul>
	</div> -->
	<div class="add_file">
		<ul>
			<?
			for($f=1; $f <= $board->info['upcnt']; $f++)
			{
			?>
			<li>
				<input type="file" name="upfile[]" class="w300 lbox" />
			</li>
			<?}?>
		</ul>
	</div>
