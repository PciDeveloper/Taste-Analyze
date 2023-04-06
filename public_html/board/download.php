<?
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: private");

$filepath = ($_GET[path]) ? "../upload/".$_GET[path]."/".$_GET[file] : "../upload/board/".$_GET[file];
$original = ($_GET[org]) ? $_GET[org] : $_GET[file];

$original = iconv("utf-8", "euc-kr", $original);

if(file_exists($filepath))
{
    if(eregi("msie", $_SERVER[HTTP_USER_AGENT]) && eregi("5\.5", $_SERVER[HTTP_USER_AGENT]))
	{
		header("content-type: doesn/matter");
		header("content-length: ".filesize("$filepath"));
		header("content-disposition: attachment; filename=$original");
		header("content-transfer-encoding: binary");
	}
	else
	{
		header("content-type: file/unknown");
		header("content-length: ".filesize("$filepath"));
		header("content-disposition: attachment; filename=$original");
		header("content-description: php generated data");
	}

	header("pragma: no-cache");
	header("expires: 0");
	flush();

    if(is_file("$filepath"))
	{
		$fp = fopen("$filepath", "rb");

		if(!fpassthru($fp))
			fclose($fp);
	}
	else
	{
		echo ("
			<script>
			alert('해당 파일이나 경로가 존재하지 않습니다.');
			history.back();
			</script>
		");
    }

}
else
{
	echo ("
			<script>
			alert('파일을 찾을 수 없습니다.');
			history.back();
			</script>
		");
}
?>
