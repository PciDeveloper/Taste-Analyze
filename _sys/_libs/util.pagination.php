<?php
/**
* Javascript Paging Function
*
* @Author		: seob
* @Update		:	2017-03-08
* @Description	:	Javascript(jquery) Paging Function
*/

function Pagination($vars)
{
	$t_page		= ceil($vars['total']/$vars['limit']);		//총페이지
	$t_block	= ceil($t_page/$vars['pageblock']);				//총블럭
	$c_block	= ceil($vars['page']/$vars['pageblock']);		//현재블럭
	$p_start	= $vars['pageblock'] * ($c_block - 1) + 1;		//시작페이지

	$first	= ($c_block > 1) ? sprintf("<a href=\"javascript:Goods.load_page('%s', '%s', %d);\">&lt;&lt;</a>", $vars['mode'], $vars['gidx'], 1) : "<a>&lt;&lt;</a>";
	$prev	= ($vars['page'] > 1) ? sprintf("<a href=\"javascript:Goods.load_page('%s', '%s', %d);\">&lt;</a>", $vars['mode'], $vars['gidx'], $vars['page']-1) : "<a>&lt;</a>";
	$next	= ($t_page > $vars['page']) ? sprintf("<a href=\"javascript:Goods.load_page('%s', '%s', %d);\">&gt;</a>", $vars['mode'], $vars['gidx'], $vars['page']+1) : "<a>&gt;</a>";
	$last	= ($c_block != $t_block && $t_block > 1) ? sprintf("<a href=\"javascript:Goods.load_page('%s', '%s', %d);\">&gt;&gt;</a>", $vars['mode'], $vars['gidx'], $t_page) : "<a>&gt;&gt;</a>";

	for($i=$p_start, $j=1; $j <= $vars['pageblock']; $i++, $j++)
	{
		if($i > $t_page) break;

		if($vars['page'] == $i)
			$arPage[] = sprintf("<a class=\"on\">%d</a>", $i);
		else
			$arPage[] = sprintf("<a href=\"javascript:Goods.load_page('%s', '%s', %d);\">%d</a>", $vars['mode'], $vars['gidx'], $i, $i);
	}

	if($arPage) $page = sprintf("<span>%s</span>", implode("\n", $arPage));

	return array(
					"first"	=> $first,
					"prev"	=> $prev,
					"page"	=> $page,
					"next"	=> $next,
					"last"	=> $last
				);
}

function printPage($arPage)
{
	if(is_array($arPage) && count($arPage) > 0)
		print(@implode("\n", $arPage));
}
?>
