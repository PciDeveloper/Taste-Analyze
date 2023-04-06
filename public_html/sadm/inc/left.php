<?
$menu = array();
$aUrl = explode("/",$_SERVER['PHP_SELF']);
$folder = $aUrl[count($aUrl)-2];

if(file_exists("../{$folder}/_menu.ini"))
{
	$fp = file("../{$folder}/_menu.ini");

	foreach($fp as $v)
	{
		if(trim($v)) $v = trim($v);

		if(substr($v,0,1) == "[" && substr($v, -1, 1) == "]")
		{
			$link['title'][] = str_replace(array('[', ']'), "", $v);
		}
		else
		{
			$k = count($link['title'])-1;
			$tmp = explode("=>", $v);

			if(trim($tmp[0]))
			{
				$link['subject'][$k][] = $tmp[0];
				$url = trim(str_replace('"', '', $tmp[1]));

				if(preg_match("/^..\//", $url)) $link['value'][$k][] = $url;
				else if(preg_match("/^javascript/i", $url)) $link['value'][$k][] = $url;
				else $link['value'][$k][] = "./{$url}";
			}
		}

		$menu = array_merge($menu, $link);
	}
}
?>

<div style="padding-top:10px;"></div>

<div style="padding-left:5px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?
for ($i=0; $i<count($menu['title']); $i++)
{
	if($menu['title'][$i] && count($menu['subject'][$i]))
	{
?>
<tr>
	<td style="background:url('../img/left/left_menu_bg.gif') no-repeat;" height="25" class="lmenu"><?=$menu['title'][$i]?></td>
</tr>
<tr>
	<td style="padding:8px 0 16px 8px">

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?
		for ($j=0;$j<count($menu['subject'][$i]);$j++)
		{
			if($menu['subject'][$i][$j])
			{
?>
		<tr>
			<td style="font:9pt dotum;letter-spacing:-1px;line-height:16px;padding:2px 0 2px 6px">
				<?if(trim($menu['value'][$i][$j])){?>
				<a href="<?=$menu['value'][$i][$j]?>" <?if(preg_match('/'.str_replace('/','\/',$menu['value'][$i][$j]).'/',$_SERVER['SCRIPT_FILENAME'])){?>style="font-weight:bold;color:#3333FF;"<?}?>>
				<?}?>
				<?=trim($menu['subject'][$i][$j])?>
				<?if(trim($menu['value'][$i][$j])){?></a><?}?>
			</td>
		</tr>
<?
			}
		}
?>
		</table>
<?
	}
}

if(!strcmp($folder, "board"))
{
	$lbbs_sqry = "select * from sw_board_cnf order by idx asc";
	$lbbs_qry = $db->query($lbbs_sqry);
?>
<tr>
	<td style="background:url('../img/left/left_menu_bg.gif') no-repeat;" height="25" class="lmenu">게시판 리스트</td>
</tr>
<tr>
	<td style="padding:8px 0 16px 8px">

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<?
		while($lbbs_row=mysql_fetch_array($lbbs_qry))
		{
		?>
		<tr>
			<td style="font:9pt dotum;letter-spacing:-1px;line-height:16px;padding:2px 0 2px 6px"><a href="./board.list.php?code=<?=$lbbs_row['code']?>" <?=($code == $lbbs_row['code']) ? "style=\"font-weight:bold;color:#3333FF;\"" : "";?>><?=$lbbs_row['name']?></a></td>
		</tr>
		<?
		}
		?>
		</table>
	
	</td>
</tr>
<?
}
?>
</table>
</div>