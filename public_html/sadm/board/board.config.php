<?
include_once dirname(__FILE__)."/../_header.php";

$navi = "게시판관리 > 게시글 통합관리";
include_once dirname(__FILE__)."/../_template.php";

?>
 <script type="text/javascript"> 
function chgRank()
{
	var f = document.dfm;

	if(confirm("게시판 순위를 일괄변경 하시겠습니까?"))
	{
		f.act.value = "rank";
		f.submit();
	}
}

</script>
 
<div class="page-header">
	<h1>
		게시판
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			게시글 통합관리
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">
		<form name="dfm" method="post" action="./common.act.php">
			<input type="hidden" name="mode" value="config">
			<input type="hidden" name="act" value="">
			<table class="table table-bordered center">
			<colgroup>
			<col width="100" />
			<col width="300" />
			<col width="50" />
			<col width="100" />
			<col width="100" />
			<col width="50" />
			</colgroup>
			<tbody>
				<tr>
					<th class="center">게시판명</th>
					<th class="center">카테고리(구분자 | 로 넣으면 추가됩니다.)</th>
					<th class="center">아이콘</th>
					<th class="center">포인트지급제외</th>
					<th class="center">노출순위</th> 
					<th class="center">설정</th> 
				</tr>
				<?php
					$sqry = "select * from sw_board_cnf order by seq asc";
					$rs = $db->_execute($sqry);
					while($row = mysql_fetch_array($rs))
					{ 
				?>
				<tr> 
					<td><input type="text" name="name[<?=$row['idx']?>]" value="<?=$row['name']?>" class="input-large" style="width:100%;"><input type="hidden" name="chk[]" value="<?=$row['idx']?>" /></td>
					<td><input type="text" name="scate[<?=$row['idx']?>]" value="<?=$row['scate']?>" class="input-large" style="width:100%;"></td>
					<td><img src="/upload/icon/<?=$row['icon']?>" alt="" width="50px" height="50px;"></td>
					<td>
						<select name="push[<?=$row['idx']?>]">
						<option value="Y" <?=($row['push'] == "Y") ? "selected=\"selected\"" : "";?>>사용</option>
						<option value="N" <?=($row['push'] == "N") ? "selected=\"selected\"" : "";?>>미사용</option>
						</select>
					</td>
					<td><input type="text" name="seq[<?=$row['idx']?>]" value="<?=$row['seq']?>"  class="input-small"></td>
					<td>  
						<button type="button" onclick="Common.openLayerPopup('./ifrm.icon.php?idx=<?=$row['idx']?>', 600, 300, '', 'no');" class="btn btn-white btn-info btn-sm"/>수정</button> 
						<!-- <button type="button" onclick="Del('<?=$row['idx']?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button> --> 
					</td>
				</tr>

				<?php
					}
				?> 
				</tbody>
			</table>
			<p><button type="button" onclick="chgRank()" class="btn btn-white btn-info">일괄수정</button></p>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
<!--
	function Del(idx)
	{
		var f = document.dfm;
		if(confirm("아이콘을 정말 삭제하시겠습니까?"))
		{
			f.idx.value = idx;
			f.mode.value = "icon";
			f.act.value = "del";
			f.submit();
		}
	}
//-->
</script>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>