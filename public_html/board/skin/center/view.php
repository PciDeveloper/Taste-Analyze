<div class="notice_ViewArea">

	<p class="viewTitle"><?=$vdata['icon_notice']?><?=$board->getCateView($vdata['cate'])?> <?=$vdata['title']?></p>
	<p class="viewSpan">
		<span class="name"><span class="tit">작성자 : </span><?=$vdata['name']?></span> <span class="bullet">|</span> 
		<span class="day"><span class="tit">작성일 : </span><?=substr($vdata['regdt'], 0, 10)?></span> <span class="bullet">|</span> 
		<span class="count"><span class="tit">조회수 : </span><?=$vdata['hit']?></span>
	</p>
	<? 
	if(count($vdata['file']) > 0)
	{
		for($f=0, $g=1; $f < count($vdata['file']); $f++, $g++)
		{
	?>
	<p class="viewSpan">
		<span class="name"><span class="tit">첨부파일<?=$g?> : </span><?=$vdata['file'][$f]['downlink']?></span>   
	</p> 
	<?
		}
	}
	?>
	<div class="txt_Area">
		<?=$vdata['content']?>
	</div>
</div><!-- end : class :  notice_ListArea -->
 