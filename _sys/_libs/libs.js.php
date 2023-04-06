<?php
/**
* Javascript Function Library
*
* @Author		: seob
* @Update		: 2018-06-01 
* @Description	: User Javascript Function Library
*/

// go url //
function gourl($url, $mode="", $msg="", $flag=true)
{
	$js = "";
	if($msg) $js .= sprintf("alert(\"%s\");\n", $msg);

	if(!strcmp($mode, "P"))
		$js .= sprintf("parent.location.replace(\"%s\");\n", $url);
	else if(!strcmp($mode, "T"))
		$js .= sprintf("top.location.replace(\"%s\");\n", $url);
	else if(!strcmp($mode, "O"))
		$js .= sprintf("opener.location.replace(\"%s\");\n", $url);
	else if(!strcmp($mode, "OC"))
		$js .= sprintf("opener.location.replace(\"%s\");\n window.close();\n", $url);
	else
		$js .= sprintf("location.replace(\"%s\");\n", $url);

	printf("<script type=\"text/javascript\"> %s </script>", $js);

	if($flag) exit;
}

// alert //
function msg($msg, $code=null, $flag=false)
{
	$js = sprintf("alert(\"%s\");\n", $msg);
	switch(getType($code))
	{
		case "integer" :
			if($code) $js .= sprintf("history.go(%d);\n", $code);
		break;
		case "string" :
			if(!strcmp($code, "C"))
				$js .= "window.close();\n";
			else if(!strcmp($code, "OC"))
				$js .= "opener.location.reload();\n window.close();\n";
		break;
	}

	printf("<script type=\"text/javascript\"> %s </script>", $js);
	if($flag) exit;
}

// back //
function back()
{
	echo("<script type=\"text/javascript\"> history.go(-1); </script>");
	exit;
}

// confirm //
function confirm($msg, $url, $mode)
{
	if(!strcmp($mode, "P"))
		$js = sprintf("parent.location.replace(\"%s\");\n", $url);
	else if(!strcmp($mode, "O"))
		$js = sprintf("opener.location.replace(\"%s\");\n", $url);
	else if(!strcmp($mode, "OC"))
		$js = sprintf("opener.location.replace(\"%s\");\n window.close();\n", $url);
	else
		$js = sprintf("location.replace(\"%s\");\n", $url);

	printf("<script type=\"text/javascript\">\n if(confirm(\"%s\")) { %s }</script>", $msg, $js);
}

// reload //
function reload($mode='P')
{
	if(!strcmp($mode, "P"))
		$js = "parent.location.reload();";
	else if(!strcmp($mode, "O"))
		$js = "opener.location.reload();";

	printf("<script language='javascript'> %s </script>", $js);
}

// msg & reload //
function msgreload($mode="", $msg="", $url="")
{
	if($msg) $js = sprintf("alert(\"%s\");\n", $msg);
	if(!strcmp($mode, "P"))
		$js .= "parent.location.reload();\n";
	else if(!strcmp($mode, "O"))
		$js .= "opener.location.reload();\n";
	else if(!strcmp($mode, "OC"))
		$js .= "opener.location.reload();\n window.close();\n";

	if($url) $js .= sprintf("location.replace(\"%s\");\n", $url);

	printf("<script type=\"text/javascript\"> %s </script>", $js);
}

// popup open //
function _popup_open($url, $name, $option)
{
	echo <<< POPUP
		<script type="text/javascript">
		window.open("{$url}", "{$name}", "{$option}");
		</script>
POPUP;
}

// send form -- get, post //
function _request_form($param, $url, $method="post", $target="")
{
	foreach($param as $k=>$v)
		$buffer .= sprintf("<input type=\"hidden\" name=\"%s\" value=\"%s\" />\n", $k, $v);

	if($target)
		$target = sprintf("document.request_form.target=\"%s\";", $target);

	echo <<< FORM
		<html>
		<body>
			<form name="request_form" action="{$url}" method="{$method}">
			{$buffer}
			</form>
		</body>
		</html>

		<script type="text/javascript">
		{$target}
		document.request_form.submit();
		</script>
FORM;
	exit;
}

/**
* 드래그 및 우클릭 방지
*/
function _set_mouse_off()
{
	global $cfg;

	if(!strcmp($cfg['mouseEvent'], "N"))
	{
		echo <<< SCRIPT
			<script type="text/javascript">
			$(document).ready(function(){
				$(this).bind('contextmenu', function(e){
					return false;
				});
				$(this).bind('selectstart', function(e){
					return false;
				});
				$(this).bind('dragstart', function(e){
					return false;
				});
			});
			</script>
SCRIPT;
	}
}

// 프로그레스바 block, none //
function _progress($mode="", $bool='show')
{
	if(!strcmp($mode, "P"))
		$js = "parent.sCommon.progress('{$bool}');";
	else if(!strcmp($mode, "O"))
		$js = "opener.sCommon.progress('{$bool}');";
	else
		$js = "sCommon.progress('{$bool}');";

	printf("<script language='javascript'> %s </script>", $js);
}
?>
