<?php
if($is_mobile)
{
	$device = ($device) ? $device : $_COOKIE['device'];
	if(!strcmp($device, "pc"))
	{
		setCookie("device", "pc", 0, "/");
	}
	else
	{
		if(!_is_dir_mobile())
		{
			if($_SERVER['REQUEST_URI'] == "/")
				gourl("http://".$_SERVER['HTTP_HOST']."/m/");
			else
			{
				if(!file_exists(_get_abs_path("/m".$_SERVER['PHP_SELF'])))
					gourl("http://".$_SERVER['HTTP_HOST']."/m/");
				else
					gourl("http://".$_SERVER['HTTP_HOST']."/m".$_SERVER['REQUEST_URI']);
			}
		}
	}
}
?>