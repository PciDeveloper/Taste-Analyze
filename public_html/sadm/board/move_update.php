<?
include_once dirname(__FILE__)."/../_header.php";
  
  echo "<pre>";
  print_r($_REQUEST);
  echo "</pre>";
 

if(!count($_POST['chk_bo_table']))
	msg("게시물을 이동할 게시판을 한개 이상 선택해 주십시오.", -1); 
 

$save = array();
$save_count_write = 0;
$save_count_comment = 0;
$cnt = 0;

$wr_id_list = preg_replace('/[^0-9\,]/', '', $_POST['wr_id_list']);
$arraychk = explode(",", $wr_id_list);

 

    for ($i=0; $i<count($arraychk); $i++)
    {
		$sqry  =  "update sw_board set code='".$_POST['chk_bo_table'][0]."' where idx='".$arraychk[$i]."'";
		if($db->_execute($sqry))
		{
			//댓글도 이동
			$db->_execute("update sw_comment set code='".$_POST['chk_bo_table'][0]."' where bidx='".$arraychk[$i]."'");
		}
 
    }
 
 

$msg = '해당 게시물을 선택한 게시판으로 이동 하였습니다.';
$opener_href  = './board.list.php?code='.$_POST['chk_bo_table'][0];
$opener_href1 = str_replace('&amp;', '&', $opener_href);

echo <<<HEREDOC
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<script>
alert("$msg");
opener.document.location.href = "$opener_href1";
window.close();
</script>
<noscript>
<p>
    "$msg"
</p>
<a href="$opener_href">돌아가기</a>
</noscript>
HEREDOC;
?> 