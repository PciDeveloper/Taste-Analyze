<?
include_once(dirname(__FILE__)."/../_header.php");
header("Content-Type: text/html; charset=utf-8");

$year = ($year) ? $year : date('Y');
$mon = ($mon) ? $mon : date('n');
$arr_cnt = array();

switch($mode)
{  
	case "sday" : 
		
		$m_arr = array("", "31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");
		$arr_tit = $arr_data1 = $arr_data2 = array();

		for($d=1; $d < $m_arr[$mon]; $d++)
		{
			$date = sprintf("%4d-%02d-%02d", $year, $mon, $d);
			$sqry = sprintf("select count(*) as cnt from %s where left(regdt, 10)='%s'", "sw_counter", $date);
			$row = $db->_fetch($sqry, 1);

			$sqry2 = sprintf("select count(*) as cnt from %s where left(regdt, 10)='%s'", "sw_member", $date);
			$row2 = $db->_fetch($sqry2, 1);

			$arr_tit[] = sprintf("'%02d'", $d);
			$arr_data1[] = $row['cnt'];
			$arr_data2[] = $row2['cnt'];
		}
		
		$title = sprintf("%4d %02d Daily Visit", $year, $mon);
		$tit_chart = sprintf("[%s]", implode(",", $arr_tit));
		$data1 = implode(",", $arr_data1);
		$data2 = implode(",", $arr_data2);

		echo <<< SCRIPT
			<script type="text/javascript">
			parent.showChart("{$tit_chart}", '{$title}', '{$data1}', '{$data2}');
			</script>
SCRIPT;
	break;
}

?>