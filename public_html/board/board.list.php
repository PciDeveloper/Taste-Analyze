<?
if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

if($cate)
{
	$wArr[] = sprintf("cate='%s'", $cate);
}

/// 1:1 문의 게시판인겨우만 적용 ///
if($board->info['part'] == 20)
	$wArr[] = sprintf("(userid='%s' || re_step > 0)", $_SESSION['SES_USERID']);

if($sstr)
{
	if($skey)
		$wArr[] = "$skey like '%$sstr%'";
	else
		$wArr[] = "(title like '%$sstr%' || content like '%$sstr%')";
}

if($wArr)
	$AddW = sprintf(" AND %s", implode(" AND ", $wArr));

$sqry = sprintf("select * from %s where code='%s' AND notice <> 'Y'  %s", SW_BOARD, $code, $AddW);
$db->_affected($numrows, $sqry);
$pgLimit = ($pg_num) ? $pg_num : 20;
$pgBlock = 10;
$start = ($start) ? $start : 0;
$letter_no = $numrows - $start;

$sqry .= sprintf(" order by ref desc, re_step asc limit %d, %d", $start, $pgLimit);
$qry = $db->_execute($sqry);

### Paging Parameter ###
$param['skey'] = ($sstr) ? $skey : "";
$param['sstr'] = $sstr;
$param['cate'] = $cate;

include_once dirname(__FILE__)."/../lib/class.UserPage.php";
$pg = new getPage($start, $pgLimit, $pgBlock, $numrows, $param);
?>

<!--검색영역-->
<div id="search_wrap">
		<div class="search">
				<form name="sfm" action="?" method="post" >
				<input type="text" placeholder="검색어를 입력해주세요." name="sstr" value="<?=$_REQUEST['sstr']?>">
			</form>
		</div>
</div>
<!--게시판리스트-->

<?php if ($code == "1595387795"){?>
<div class="reservation_detail">
	<ul>
		<li>자주묻는질문</li>
	</ul>
</div>
<div class="question_wrap">
			<?
				include_once(dirname(__FILE__)."/skin/".$arr_skin[$board->info[part]]."/list.php");
			?>
</div>
	<div class="page" style="text-align:center">
		<?=$pg->page_return;?>
	</div>
	<?php if($code == "1595387805" || $code == "1595387784"){?>
	<div class="bt_wrap" style="text-align:right;">
			<input type="button" class="notice_write_bt" value="글쓰기" onclick="javascript:location.href='?act=write&code=<?=$board->info['code']?>'" style="cursor:pointer;">
	</div>
	<?php }?>
	</div>
<?php }else{?>
	<div class="<?php if($code == "1595387805"){?>qna_list<?php }else{?>notice_list<?php }?>">
	<ul>
			<div class="list">
							<?
								include_once(dirname(__FILE__)."/skin/".$arr_skin[$board->info[part]]."/list.php");
							?>
				</div>
	</ul>
	<div class="page">
		<?=$pg->page_return;?>
	</div>
	<?php if($code == "1595387805" || $code == "1595387784"){?>
	<div class="bt_wrap" style="text-align:right;">
			<input type="button" class="notice_write_bt" value="글쓰기" onclick="javascript:location.href='?act=write&code=<?=$board->info['code']?>'" style="cursor:pointer;">
	</div>
	<?php }?>
	</div>
<?php }?>

	</div>
