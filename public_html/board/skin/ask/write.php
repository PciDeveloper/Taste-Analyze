<h1><?=$board->info['name']?></h1>
<div class="notice_wrap">
	<input type="text" placeholder="제목을 작성해주세요." value="<?=$wdata['re_title']?>" exp="제목을" name="title">
	<div class="secret_wrap">
		<input type="checkbox" id="secret_check" name="bLock" value="Y">
		<label for="secret_check"><span>비밀글 작성&nbsp;</span></label>
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
<style>
#image_preview {
    display:none;
}
</style>
<input type="text" placeholder="키워드를 입력하세요 *최대 3개까지 가능" name="keyword" >
</div>
<div class="write_icon">
	<input type="file" id="profileFile" name="profileFile" style="visibility:hidden;" accept=".gif, .jpg, .png">
	<input type="file" id="AttachFile" name="AttachFile" style="visibility:hidden;">
	<input type="file" id="VideoFile" name="VideoFile" style="visibility:hidden;">
	<ul>
		<li><a href="javascript:void(0);"><img src="/img/icon/image.png" alt="사진추가" id="profileImg"></a></li>
		<li><a href="javascript:void(0);"><img src="/img/icon/video.png" alt="비디오추가" id="video_file"></a></li>
		<li><a href="javascript:void(0);"><img src="/img/icon/clip_2.png" alt="파일추가" id="attachfile"></a></li>
	</ul>
</div>
<div class="add_photo" style="display:none">
	<ul>
		<li>
			<img src="#"  id="image_preview">
			<button class="delete_bt"><img src="/img/icon/delete.png"></button>

		</li>
	</ul>
</div>
<div class="add_file" id="video_div" style="display:none">
	<ul>
		<li id="video_preview">
		</li>
	</ul>
</div>

<div class="add_file" id="file_div" style="display:none">
	<ul>
		<li id="file_preview">
		</li>
	</ul>
</div>

<script type="text/javascript">
	//이미지 파일
 jQuery('#profileFile').on('change', function () {
    ext = jQuery(this).val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        resetFormElement(jQuery(this));
        window.alert('Not an image!');
    } else {
        file = jQuery('#profileFile').prop("files")[0];
        blobURL = window.URL.createObjectURL(file);
        jQuery('#image_preview').attr('src', blobURL);
        jQuery('#image_preview').slideDown();
				jQuery('.add_photo').css("display" , "block");
        jQuery(this).slideUp();
    }
});

jQuery('.delete_bt').bind('click', function () {
    resetFormElement(jQuery('#profileFile'));
    jQuery('#profileFile').slideDown();
    jQuery(this).parent().slideUp();
    return false;
});

function resetFormElement(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}


$(document).on('click', '#profileImg', function(){
    $('#profileFile').trigger('click');
});

$(document).on('click', '#attachfile', function(){
    $('#AttachFile').trigger('click');
});

$(document).on('click', '#video_file', function(){
    $('#VideoFile').trigger('click');
});

$(document).ready(function (e){
	 $("#AttachFile").change(function(e){

		 //div 내용 비워주기
		 $('#file_preview').empty();

		 var files = e.target.files;
		 var arr =Array.prototype.slice.call(files);

		 //업로드 가능 파일인지 체크
		 for(var i=0;i<files.length;i++){
			 if(!checkExtension(files[i].name,files[i].size)){
				 return false;
			 }
		 }

		 preview(arr);
	 });//file change

	 function checkExtension(fileName,fileSize){

		 var regex = new RegExp("(.*?)\.(exe|sh|zip|alz)$");
		 var maxSize = 20971520;  //20MB

		 if(fileSize >= maxSize){
			 alert('파일 사이즈 초과');
			 $("#AttachFile").val("");  //파일 초기화
			 return false;
		 }

		 if(regex.test(fileName)){
			 alert('업로드 불가능한 파일이 있습니다.');
			 $("#AttachFile").val("");  //파일 초기화
			 return false;
		 }
		 return true;
	 }

	 function preview(arr){
		 jQuery('#file_div').css("display" , "block");
		 arr.forEach(function(f){

			 //파일명이 길면 파일명...으로 처리
			 var fileName = f.name;

			 //div에 이미지 추가
			 var str = '<img src="/img/icon/clip_2.png">';
			 str += '<span>'+fileName+'</span>';

			 //이미지 파일 미리보기

				 var reader = new FileReader(); //파일을 읽기 위한 FileReader객체 생성
				 reader.onload = function (e) { //파일 읽어들이기를 성공했을때 호출되는 이벤트 핸들러
					 //str += '<button type="button" class="delBtn" value="'+f.name+'" style="background: red">x</button><br>';
					// str += '<button type="button" disabled><img src="'+e.target.result+'" title="'+f.name+'" width=100 height=100 /></button>';
					str += '<button type="button" class="delBtn" onclick="delFile()"><img src="/img/icon/delete.png"></button>';
					 $(str).appendTo('#file_preview');
				 }
				 reader.readAsDataURL(f);

		 });//arr.forEach
	 }

	 //video_div
	 $("#VideoFile").change(function(e){

		 //div 내용 비워주기
		 $('#video_preview').empty();

		 var files = e.target.files;
		 var arr =Array.prototype.slice.call(files);

		 //업로드 가능 파일인지 체크
		 for(var i=0;i<files.length;i++){
			 if(!checkExtensionVideo(files[i].name,files[i].size)){
				 return false;
			 }
		 }

		 previewVideo(arr);
	 });//file change

	 function checkExtensionVideo(fileName,fileSize){

		 var regex = new RegExp("(.*?)\.(exe|sh|zip|alz)$");
		 var maxSize = 20971520;  //20MB

		 if(fileSize >= maxSize){
			 alert('파일 사이즈 초과');
			 $("#VideoFile").val("");  //파일 초기화
			 return false;
		 }

		 if(regex.test(fileName)){
			 alert('업로드 불가능한 파일이 있습니다.');
			 $("#VideoFile").val("");  //파일 초기화
			 return false;
		 }
		 return true;
	 }

	 function previewVideo(arr){
		 jQuery('#video_div').css("display" , "block");
		 arr.forEach(function(f){

			 //파일명이 길면 파일명...으로 처리
			 var fileName = f.name;

			 //div에 이미지 추가
			 var str = '<img src="/img/icon/video.png">';
			 str += '<span>'+fileName+'</span>';

			 //이미지 파일 미리보기

				 var reader = new FileReader(); //파일을 읽기 위한 FileReader객체 생성
				 reader.onload = function (e) { //파일 읽어들이기를 성공했을때 호출되는 이벤트 핸들러
					 //str += '<button type="button" class="delBtn" value="'+f.name+'" style="background: red">x</button><br>';
					// str += '<button type="button" disabled><img src="'+e.target.result+'" title="'+f.name+'" width=100 height=100 /></button>';
					str += '<button type="button" class="delBtn" onclick="delFileVideo()"><img src="/img/icon/delete.png"></button>';
					 $(str).appendTo('#video_preview');
				 }
				 reader.readAsDataURL(f);

		 });//arr.forEach
	 }
 });

 function delFile(){
		 $("#AttachFile").val("");
		 $('#file_preview').empty();
 }

 function delFileVideo(){
	 $("#VideoFile").val("");
	 $('#video_preview').empty();
 }
</script>
