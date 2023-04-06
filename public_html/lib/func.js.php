<?
/**
* javascript function utility
*
* @Author		:	kkang(sinbiweb)
* @Update		:	2014-07-29
* @Description	:	Javascript PHP Function
*/

### 페이지 이동 ###
function goUrl($url, $parm="", $mode="", $flag=true)
{
	if(is_array($parm))
	{
		$sParm = "?";

		foreach($parm as $key => $value)
			$sParm .= $key . "=" . $value . "&amp;";

		$url .= $sParm;
	}

	if($mode == "P")
		$sJs = "parent.location.replace(\"{$url}\");\n";
	else if($mode == "O")
		$sJs = "opener.location.replace(\"{$url}\");\n";
	else if($mode == "OC")
		$sJs = "opener.location.replace(\"{$url}\");\n window.close();\n";
	else
		$sJs = "location.replace(\"{$url}\");\n";

	echo("<script type=\"text/javascript\"> {$sJs} </script>");

	if($flag) exit;
}

### 메세지 ###
function msg($msg, $code=null, $flag=false)
{
	if($msg)
		$sJs = "alert(\"{$msg}\");\n";

	switch (getType($code))
	{
		case "integer":
			if($code) $sJs .= "history.go({$code});\n";
		break;
		case "string":
			if($code == "C")
				$sJs .= "window.close();\n";
		break;
	}
	echo "<script type=\"text/javascript\"> {$sJs} </script>";

	if($flag) exit;
}

### msgGoUrl() ###
function msgGoUrl($msg, $url, $mode="")
{
	echo("<script type=\"text/javascript\"> alert('{$msg}'); </script>");

	goUrl($url, "", $mode);
	exit;
}

### Back() ###
function back()
{
	echo("<script type=\"text/javascript\"> history.go(-1); </script>");
	exit;
}

### Window Open ###
function WinPopup($url, $name, $pp)
{
	echo <<< POPUP

		<script type="text/javascript">
		window.open("{$url}", "{$name}", "{$pp}");
		</script>
POPUP;
}

### close() ###
function Close()
{
	echo("<script type=\"text/javascript\"> top.opener=self;\n top.close();\n </script>");
	exit;
}

### reload ###
function ParentReload($mode='P')
{
	if(!strcmp($mode, 'P'))
		$sjs = "parent.location.reload();";
	else if(!strcmp($mode, 'O'))
		$sjs = "opener.location.reload();";

	printf("<script language='javascript'> %s </script>", $sjs);
}

function ReloadParent($mode="", $msg="", $url="")
{
	if($msg)
		$sJs = "alert(\"{$msg}\");\n";

	if($mode == "P")
		$sJs .= "parent.location.reload();\n";
	else if($mode == "O")
		$sJs .= "opener.location.reload();\n";
	else if($mode == "OC")
		$sJs .= "opener.location.reload();\n window.close();\n";
	else if($mode == "OPL")
		$sJs .= " parent.location.replace(\"{$url}\");\n window.close();\n";

	if($url)
		$sJs .= "location.replace(\"{$url}\");\n";

	printf("<script type=\"text/javascript\"> %s </script>", $sJs);
}
### message layer box ###
function LayerMessageBox($msg, $mode="", $url="", $pos="", $html=true, $flag=true)
{
	if(!strcmp($pos, "P"))
		$target = "parent.";
	else if(!strcmp($pos, "O"))
		$target = "opener.";
	else
		$target = "";

	if($url)
		$msg .= sprintf("<p class='btn'><a href='#' onclick='Common.layerMessage(&#034;c&#034;); location.replace(&#034;%s&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' border='0' /></a></p>", $url);
	else if(!strcmp($mode, "back"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessage(&#034;c&#034;); history.go(-1); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a></p>";
	else if(!strcmp($mode, "close"))
		$msg .= "<p class='btn'><a href='#' onclick='window.close(); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a></p>";
	else if(!strcmp($mode, "cart"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessage(&#034;c&#034;); Common.goUrl(&#034;/goods/goods.cart.php&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a><a href='#' onclick='Common.layerMessage(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_shopping.gif' /></a></p>";
	else if(!strcmp($mode, "m_cart"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessage(&#034;c&#034;); Common.goUrl(&#034;/m/goods/goods.cart.php&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a><a href='#' onclick='Common.layerMessage(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_shopping.gif' /></a></p>";
	else if(!strcmp($mode, "wish"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessage(&#034;c&#034;); Common.goUrl(&#034;/mypage/mywish.php&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' border='0' /></a><a href='#' onclick='Common.layerMessage(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_shopping.gif' border='0' /></a></p>";
	else
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessage(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a></p>";

	if($html)
	{
		echo <<< HTML
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<title>:: 체험넷 ::</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
			<meta name="viewport" content="width=1300"/>
			<script language="javascript" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script language="javascript" type="text/javascript" src="/js/jquery.easing.1.3.min.js"></script>
			<script language="javascript" type="text/javascript" src="/js/jquery.bxslider.min.js"></script>
			<script language="javascript" type="text/javascript" src="/js/ui.js"></script>
			<script language="javascript" type="text/javascript" src="/js/jquery.lwtCountdown-1.0.js"></script>
			<script type="text/javascript" src="/js/class.common.js"></script>
			<script type="text/javascript" src="/cheditor/cheditor.js"></script>
			<link rel="stylesheet" href="../css/ui.css"/>
			<link rel="stylesheet" href="../css/jquery.bxslider.css"/>
			<link rel="stylesheet" href="../css/index.css"/>
			</head>
			<body>
			<iframe name="ifrm" style="display:none;height:100px;width:100%;"></iframe>
			<div id="msgwrap"></div>
			<div id="msgbox"></div>
HTML;
	}
	else
		echo("<script type=\"text/javascript\" src=\"/j-script/jquery-1.7.2.min.js\"></script>");

	$msg = preg_replace("/\"/", "&#034;", $msg);

	//print($msg); exit;

	printf("<script type=\"text/javascript\">\n $(document).ready(function() { setTimeout( function() { $('#msgbox', parent.document).html(\"%s\"); parent.Common.layerMessage('o'); }, 300 ); }); </script>", $msg);

	if($html)
		echo("</body></html>");

	if($flag)
		exit;

}

function LayerMessageBoxTest($msg, $mode="", $url="", $pos="", $html=true, $flag=true)
{
	if(!strcmp($pos, "P"))
		$target = "parent.";
	else if(!strcmp($pos, "O"))
		$target = "opener.";
	else
		$target = "";

	if($url)
		$msg .= sprintf("<p class='btn'><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); location.replace(&#034;%s&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' border='0' /></a></p>", $url);
	else if(!strcmp($mode, "back"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); history.go(-1); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a></p>";
	else if(!strcmp($mode, "close"))
		$msg .= "<p class='btn'><a href='#' onclick='window.close(); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a></p>";
	else if(!strcmp($mode, "cart"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); Common.goUrl(&#034;/goods/goods.cart.php&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_shopping.gif' /></a></p>";
	else if(!strcmp($mode, "m_cart"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); Common.goUrl(&#034;/m/goods/goods.cart.php&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_shopping.gif' /></a></p>";
	else if(!strcmp($mode, "wish"))
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); Common.goUrl(&#034;/mypage/mywish.php&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' border='0' /></a><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_shopping.gif' border='0' /></a></p>";
	else
		$msg .= "<p class='btn'><a href='#' onclick='Common.layerMessageTest(&#034;c&#034;); return false;'><img src='/image/btn/btn_msg_ok.gif' /></a></p>";

	if($html)
	{
		echo <<< HTML
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<title>:: 체험넷 ::</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
			<meta name="viewport" content="width=1300"/>
			<script language="javascript" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script language="javascript" type="text/javascript" src="/js/jquery.easing.1.3.min.js"></script>
			<script language="javascript" type="text/javascript" src="/js/jquery.bxslider.min.js"></script>
			<script language="javascript" type="text/javascript" src="/js/ui.js"></script>
			<script language="javascript" type="text/javascript" src="/js/jquery.lwtCountdown-1.0.js"></script>
			<script type="text/javascript" src="/j-script/class.common.js"></script>
			<script type="text/javascript" src="/cheditor/cheditor.js"></script>
			<link rel="stylesheet" href="../css/ui.css"/>
			<link rel="stylesheet" href="../css/jquery.bxslider.css"/>
			<link rel="stylesheet" href="../css/index.css"/>
			</head>
			<body>
			<iframe name="ifrm" style="display:none;height:100px;width:100%;"></iframe>
			<div id="msgwrap"></div>
			<div id="msgbox"></div>
HTML;
	}
	else
		echo("<script type=\"text/javascript\" src=\"/j-script/jquery-1.7.2.min.js\"></script>");

	$msg = preg_replace("/\"/", "&#034;", $msg);

	//print($msg); exit;

	printf("<script type=\"text/javascript\">\n $(document).ready(function() { setTimeout( function() { $('#msgbox', parent.document).html(\"%s\"); parent.Common.layerMessageTest('o'); }, 300 ); }); </script>", $msg);

	if($html)
		echo("</body></html>");

	if($flag)
		exit;

}
### Error Message Html ###
function ErrorHtml($msg)
{
	echo <<< HTML
		<br/>
		<div align="center">
		<form>
		<table width="400" cellpadding="3" cellspacing="1" border="0" bgcolor="#666666">
		<tr bgcolor="#bbbbbb">
			<td height="30" align="center" style="font-family:Tahoma;font-size:8pt;font-weight:bold;">[ ERROR ]</td>
		</tr>
		<tr bgcolor="#efefef">
			<td align="center" height="30" style="font-family:Tahoma;font-size:8pt;">
				<br/>{$msg}<br/><br/>
				<input type="button" value="Move Back" onClick="history.back();" style="border:1px solid #b0b0b0;background:#3d3d3d;color:#ffffff;font-size:8pt;height:23px;" />
				<br/><br/>
			</td>
		</tr>
		</table>
		</form>
		</div>
HTML;

	exit;
}
?>
