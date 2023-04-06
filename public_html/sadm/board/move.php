<?
include_once(dirname(__FILE__)."/../_header.php");
if ($wr_id)
    $wr_id_list = $wr_id;
else {
    $comma = '';
    for ($i=0; $i<count($_POST['chk']); $i++) {
        $wr_id_list .= $comma . $_POST['chk'][$i];
        $comma = ',';
    }
}
 

 $sql = " select * from sw_board_cnf order by idx desc"; 
 $rs = $db->_execute($sql); 
	for ($i=0; $row=mysql_fetch_array($rs); $i++)
	{
		$list[$i] = $row;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>::: 게시물이동 :::</title>
<link rel="stylesheet" href="../common/css.css" type="text/css" />
<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="../assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="/js/class.common.js"></script>

<style>
.copymove_current {float:right;color:#ff3061}
.copymove_currentbg {background:#f4f4f4}
</style>
</head>
<body style="background-color:#fff">
	<div class="contents_box">
	   <form name="fboardmoveall" method="post" action="./move_update.php" onsubmit="return fboardmoveall_submit(this);">
    <input type="hidden" name="act" value="move">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>"> 
	<input type="hidden" name="wr_id_list" value="<?php echo $wr_id_list ?>">
 
        <table class="table table-bordered"> 
        <thead>
        <tr> 
            <th class="center" colspan="2">게시판</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i=0; $i<count($list); $i++) {
            $atc_mark = '';
            $atc_bg = '';
            if ($list[$i]['code'] == $code) { // 게시물이 현재 속해 있는 게시판이라면
                $atc_mark = '<span class="copymove_current">현재<span class="sound_only">게시판</span></span>';
                $atc_bg = 'copymove_currentbg';
            }
        ?>
        <tr class="<?php echo $atc_bg; ?>">
            <td class="td_chk"> 
                <input type="radio" value="<?php echo $list[$i]['code'] ?>" id="chk<?php echo $i ?>" name="chk_bo_table[]" checked>
            </td>
            <td>
                <label for="chk<?php echo $i ?>">
                    <?php
                    echo $list[$i]['name'] . ' &gt; ';
                    $save_gr_subject = $list[$i]['name'];
                    ?>
                    <?php echo $list[$i]['name'] ?> 
                    &nbsp;&nbsp;<?php echo $atc_mark; ?>
                </label>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
		
		<div align="center">
		<button type="submit" class="btn btn-white btn-info">이동</button>
		<button type="button" onclick="javascript:self.close();" class="btn btn-white btn-info">취소</button>
		</div>
    </form>

	</div>
</body>
</html>