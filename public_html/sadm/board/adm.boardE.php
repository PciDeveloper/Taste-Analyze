<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "게시판관리 > 게시판리스트";
include_once dirname(__FILE__)."/../_template.php";

if(!$code)
	msg("게시판이 존재하지 않습니다.", -1, true);

$row = $db->_fetch("select * from ".SW_BOARD_CNF." where code='".$code."'");
if(!$row)
	msg("게시판이 삭제되었거나 존재 하지 않습니다.", -1, true);
?>

<div class="page-header">
	<h1>
		게시판정보
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			게시판관리
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">
<script type="text/javascript" src="./board.js"></script>
<form name="fm" method="post" action="./adm.boardA.php" enctype="multipart/form-data" onSubmit="return Common.checkFormHandler.checkForm(this);">
<input type="hidden" name="act" value="edit" />
<input type="hidden" name="code" value="<?=$code?>" />

<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 게시판 기본정보</div>
<table class="tb">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 게시판코드</th>
	<td class="bold"><?=$row['code']?></td>
</tr>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 게시판명</th>
	<td><input type="text" name="name" class="lbox w150" exp="게시판명을" value="<?=$row['name']?>" /></td>
</tr>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 게시판유형</th>
	<td>
		<select name="part" exp="게시판유형을">
		<?
		for($i=0; $i < count($arr_part); $i++)
		{
			if($part_keys[$i] == $row['part'])
				printf("<option value='%d' selected='selected'>%s</option>", $part_keys[$i], $arr_part[$part_keys[$i]]);
			else
				printf("<option value='%d'>%s</option>", $part_keys[$i], $arr_part[$part_keys[$i]]);
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<th>게시판 권한</th>
	<td style="padding:5px 10px;">
		<table cellpadding="0" cellspacing="0" border="0">
		<col span="4" width="120" class="bold" />
		<tr height="25" align="center">
			<td>리스트보기</td>
			<td>글내용보기</td>
			<td>글쓰기</td>
			<td>답변달기</td>
		</tr>
		<tr align="center">
			<td style="padding:5px;">
				<select name="lAct" size="1" class="select">
				<?
				for($i=0; $i < count($arr_auth); $i++)
				{
					if($row['lAct'] == $auth_keys[$i])
						printf("<option value='%d' selected>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
					else
						printf("<option value='%d'>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
				}
				?>
				</select>
			</td>
			<td>
				<select name="rAct" size="1" class="select">
				<?
				for($i=0; $i < count($arr_auth); $i++)
				{
					if($row['rAct'] == $auth_keys[$i])
						printf("<option value='%d' selected>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
					else
						printf("<option value='%d'>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
				}
				?>
				</select>
			</td>
			<td>
				<select name="wAct" size="1" class="select">
				<?
				for($i=0; $i < count($arr_auth); $i++)
				{
					if($row['wAct'] == $auth_keys[$i])
						printf("<option value='%d' selected>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
					else
						printf("<option value='%d'>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
				}
				?>
				</select>
			</td>
			<td>
				<select name="cAct" size="1" class="select">
				<?
				for($i=0; $i < count($arr_auth); $i++)
				{
					if($row['cAct'] == $auth_keys[$i])
						printf("<option value='%d' selected>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
					else
						printf("<option value='%d'>%s</option>", $auth_keys[$i], $arr_auth[$auth_keys[$i]]);
				}
				?>
				</select>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<th>게시판 스팸방지</th>
	<td><input type="checkbox" name="bspam" value="Y" <?=($row['bspam'] == 'Y') ? "checked=\"checked\"" : "";?> /> 자동등록방지문자 사용</td>
</tr>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 게시판 경로</th>
	<td><input type="text" name="path" class="lbox w300" value="<?=$row['path']?>" /> <span class="exf">※ 게시판 경로를 입력해 주세요. ex) /board.php</span></td>
</tr>
<tr>
	<th><img src="../img/icon/icon_check.gif" /> 게시판 경로(모바일)</th>
	<td><input type="text" name="mpath" class="lbox w300" value="<?=$row['mpath']?>" /> <span class="exf">※ 게시판 모바일 경로를 입력해 주세요. ex) /m/board.php</span></td>
</tr>
</tbody>
</table>

<div style="height:20px;"></div>
<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 리스트화면 설정</div>
<table class="tb">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th> 제목글자수 제한</th>
	<td><input type="text" name="cutstr" class="lbox w50" value="<?=$row['cutstr']?>" /><span class="exf"> Byte &nbsp; ※ 한글은 3Byte, 영문 및 숫자는 2Byte (기본 45byte)</span></td>
</tr>
<tr>
	<th>페이지당 게시물수</th>
	<td><input type="text" name="vlimit" class="lbox w50" value="<?=$row['vlimit']?>" /> 개 &nbsp;<span class="exf"> ※ 미입력시 기본 20개</span></td>
</tr>
<tr>
	<th>New 아이콘 표시</th>
	<td><input type="text" name="period" class="lbox w30" value="<?=$row['period']?>" /> 일 &nbsp; <span class="exf">※ 미입력시 기본 1일</span></td>
</tr>
<tr>
	<th>섬네일사이즈</th>
	<td>
		가로 <input type="text" name="thumW" class="lbox w50" value="<?=$row['thumW']?>" />px &nbsp; × &nbsp; 세로<input type="text" name="thumH" class="lbox w50" value="<?=$row['thumH']?>" />px &nbsp; <span class="exf">※ 게시판유형이 섬네일 및 갤러리 일때만 적용됨</span>
	</td>
</tr>
<tr>
	<th>이미지 노출</th>
	<td>
		<input type="radio" name="lsimg" value="1" <?=($row['lsimg']) ? "checked=\"checked\"" : "";?> /> 리스트 이미지로만 사용
		&nbsp;&nbsp;
		<input type="radio" name="lsimg" value="0" <?=(!$row['lsimg']) ? "checked=\"checked\"" : "";?> /> 상세보기에 노출 
		&nbsp;&nbsp;&nbsp;
		<span class="exf">※ 갤러리게시판, 썸네일게시판에서만 적용됨</span>
	</td>
</tr>
<tr>
	<th>이미지 클릭설정</th>
	<td>
		<input type="radio" name="imgclk" value="0" <?=(!$row['imgclk']) ? "checked=\"checked\"" : "";?> /> 이미지클릭시 글내용으로 이동 &nbsp;&nbsp;
		<input type="radio" name="imgclk" value="1" <?=($row['imgclk']) ? "checked=\"checked\"" : "";?> /> 이미지클릭시 원본이미지 팝업
	</td>
</tr>
</tbody>
</table>

<div style="height:20px;"></div>
<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 내용보기화면 설정</div>
<table class="tb">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th> View 타입</th>
	<td>
		<input type="radio" name="vtype" value="0" <?=(!$row['vtype']) ? "checked=\"checked\"" : "";?> /> 내용만 보이기 &nbsp;&nbsp;  
		<input type="radio" name="vtype" value="1" <?=($row['vtype'] == 1) ? "checked=\"checked\"" : "";?> /> 내용 + 관련글 &nbsp;&nbsp;
		<input type="radio" name="vtype" value="2" <?=($row['vtype'] == 2) ? "checked=\"checked\"" : "";?> /> 내용 + 리스트 
	</td>
</tr>
<tr>
	<th>IP 출력</th>
	<td><input type="checkbox" name="vip" value="1" <?=($row['vip']) ? "checked=\"checked\"" : "";?> /> 아이피 표시 &nbsp; <span class="exf">※ 예)123.123.♡.12</span></td>
</tr>
<tr>
	<th>코멘트(댓글)사용</th>
	<td><input type="checkbox" name="bCom" value="1" <?=($row['bCom']) ? "checked=\"checked\"" : "";?> /> 댓글기능 사용</td>
</tr>
<tr>
	<th>답변글(계층형)</th>
	<td><input type="checkbox" name="breply" value="1" <?=($row['breply']) ? "checked=\"checked\"" : "";?> /> 답변글 사용</td>
</tr>
</tbody>
</table>

<div style="height:20px;"></div>
<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 글쓰기화면 설정</div>
<table class="tb">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th> 비밀글 설정</th>
	<td>
		<input type="radio" name="bsecret" value="0" <?=(!$row['bsecret']) ? "checked=\"checked\"" : "";?> /> 무조건 일반글 &nbsp;&nbsp;
		<input type="radio" name="bsecret" value="1" <?=($row['bsecret'] == 1) ? "checked=\"checked\"" : "";?> /> 무조건 비밀글 &nbsp;&nbsp;
		<input type="radio" name="bsecret" value="2" <?=($row['bsecret'] == 2) ? "checked=\"checked\"" : "";?> /> 기본 일반글 &nbsp;&nbsp;
		<input type="radio" name="bsecret" value="3" <?=($row['bsecret'] == 3) ? "checked=\"checked\"" : "";?> /> 기본 비밀글
	</td>
</tr>
<tr>
	<th>공지글 사용여부</th>
	<td>
		<input type="checkbox" name="bnotice" value="1" <?=($row['bnotice']) ? "checked=\"checked\"" : "";?> /> 공지글 사용함.
	</td>
</tr>
<tr>
	<th>웹에디터 사용여부</th>
	<td>
		<label><input type="radio" name="beditor" value="1" <?=($row['beditor']) ? "checked=\"checked\"" : "";?> /> 웹에디터(편집기) 사용</label> &nbsp;&nbsp;
		<label><input type="radio" name="beditor" value="0" <?=(!$row['beditor']) ? "checked=\"checked\"" : "";?> /> 웹에디터(편집기) 미사용</label>
	</td>
</tr>
<tr>
	<th>파일 업로드갯수</th>
	<td>
		<input type="text" name="upcnt" class="rbox w50" value="<?=$row['upcnt']?>" /> 개
		&nbsp; <span class="exf">※ 섬네일, 자료실, 갤러리 게시판에 적용됨(기본 1개) </span>
	</td>
</tr>
<tr>
	<th>기타 입력폼</th>
	<td>
		<input type="checkbox" name="bemail" value="1" <?=($row['bemail']) ? "checked=\"checked\"" : "";?> /> 이메일 사용 &nbsp;&nbsp;
		<input type="checkbox" name="btel" value="1" <?=($row['btel']) ? "checked=\"checked\"" : "";?> /> 연락처 사용 &nbsp;&nbsp;
		<input type="checkbox" name="bhome" value="1" <?=($row['bhome']) ? "checked=\"checked\"" : "";?> /> 홈페이지 사용 &nbsp;&nbsp;
		<input type="checkbox" name="bevent" value="1" <?=($row['bevent']) ? "checked=\"checked\"" : "";?> /> 이벤트(기간입력폼 활성) 사용 &nbsp;&nbsp;
	</td>
</tr>
</tbody>
</table>

<div style="height:20px;"></div>
<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> 카테고리 설정</div>
<table class="tb">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th> 분류 사용여부</th>
	<td>
		<input type="radio" name="bcate" value="0" <?=(!$row['bcate']) ? "checked=\"checked\"" : "";?> onclick="Board.categoryShow();" /> 사용안함. &nbsp;
		<input type="radio" name="bcate" value="1" <?=($row['bcate']) ? "checked=\"checked\"" : "";?> onclick="Board.categoryShow();" /> 사용함.&nbsp;&nbsp;
	</td>
</tr>
<tr>
	<th>분류</th>
	<td><input type="text" name="scate" class="lbox w500" value="<?=$row['scate']?>" /></td>
</tr>
<!-- 
<tr>
	<th>게시판 분류사용</th>
	<td>
		<input type="radio" name="bcate" value="Y" onClick="Board.categoryHandler.chkUseCategory()" />
		분류 사용
		&nbsp;&nbsp;
		<input type="radio" name="bcate" value="N" checked="checked" onClick="Board.categoryHandler.chkUseCategory()" />
		사용 안함
		&nbsp;&nbsp;
		<span class="exf">※ 게시물의 종류을 분리하여 각각 게시물의 내용을 쉽게 구분해줍니다.</font>
	</td>
</tr>
<tr id="boardGrp" style="display:;">
	<th>게시판 분류 입력</th>
	<td style="padding:5px 10px;">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2" >
				<select id="sGroup" name="sGroup" size="5" style="width:200px" onClick="checkGroup();">
				</select>
			</td>
			<td valign="top" colspan="2">
				<input type="text" name="newGroup" class="box" style="width:200px;" maxlength="30" onKeyUp="if (event.keyCode==13) addGroup();">
				<input id="btnAddGroup" type="button" value="추가하기" mode="add" class="box" style="width:60px;" onClick="addGroup();">
			</td>
		</tr>
		<tr>
			<td valign="bottom">
				<input type="button" value="△올리기" class="box" style="width:60px;" onClick="moveGroup('UP');">
				<input type="button" value="▽내리기" class="box" style="width:60px;" onClick="moveGroup('DOWN');">
			</td>
			<td align="right" valign="bottom">
				<input type="button" value="선택삭제" class="box" style="width:60px;" onClick="delGroup();">
			</td>
		</tr>
		</table>
	</td>
</tr>
-->
</tbody>
</table>

<div style="height:20px;"></div>
<div class="tit"><img src="../img/icon/icon_tit.gif" align="absmiddle" /> HTML 설정</div>
<table class="tb">
<colgroup>
<col width="150" />
<col />
</colgroup>
<tbody>
<tr>
	<th>상단디자인</th>
	<td style="padding:5px 0 5px 10px;"><textarea name="hhtml" style="width:90%;height:100px;"><?=$row['hhtml']?></textarea> </td>
</tr>
<tr>
	<th>하단디자인</th>
	<td style="padding:5px 0 5px 10px;"><textarea name="fhtml" style="width:90%;height:100px;"><?=$row['fhtml']?></textarea> </td>
</tr>
</tbody>
</table>


<p class="btnC">
	<input type="image" src="../img/btn/btn_edit.gif" alt="수정" class="pointer middle" />
	<img src="../img/btn/btn_list.gif" alt="목록" class="pointer middle" onclick="javascript:location.href='./adm.boardL.php'" />
</p>
</form>
 </div>
 </div>
 </div> 
 <?
include_once dirname(__FILE__)."/../html_footer.php";
?>