<?
include_once(dirname(__FILE__)."/../_header.php");
header("Content-Type: text/html; charset=utf-8");

$year = ($year) ? $year : date('Y');
$mon = ($mon) ? $mon : date('n');
$arr_cnt = array();

switch($mode)
{
	case "time" :

		for($i=0; $i < 24; $i++)
		{
			$sqry = sprintf("select count(idx) as cnt from sw_counter where year='%d' and mon='%d' and hour='%d'", $year, $mon, $i);
			$row = $db->_fetch($sqry, 1);
			$arr_cnt[] = ($row['cnt']) ? $row['cnt'] : 0;
		}

		printf("[%s]", implode(",", $arr_cnt));

	break;

	case "day" :
		$m_arr = array("", "31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");

		for($i=1; $i <= $m_arr[$mon]; $i++)
		{
			$sqry = sprintf("select count(idx) as cnt from sw_counter where year='%s' and mon='%02d' and day='%02d'", $year, $mon, $i);
			$row = $db->_fetch($sqry, 1);

			$arr_cnt[] = ($row['cnt']) ? $row['cnt'] : 0;
		}

		printf("[%s]", @implode(",", $arr_cnt));

	break;

	case "month" :
		for($i=1; $i < 13; $i++)
		{
			$sqry = sprintf("select count(idx) as cnt from sw_counter where year='%s' and mon='%02d'", $year, $i);
			$row = $db->_fetch($sqry, 1);

			$arr_cnt[] = ($row['cnt']) ? $row['cnt'] : 0;
		}

		printf("[%s]", implode(",", $arr_cnt));
	break;

	case "os" :

		$os_arr = array("Window", "XP", "Windows7", "Windows8", "MAC", "Android", "Linux", "Robot", "Mozilla");
		list($tot) = $db->_fetch("select count(*) from sw_counter where year='".$year."'");

		for($i=0; $i < count($os_arr); $i++)
		{
			$sqry = sprintf("select count(idx) as cnt from sw_counter where year='%s' and osgrp='%s'", $year, $os_arr[$i]);
			$row = $db->_fetch($sqry, 1);

			if($i==5 && $row['cnt'] > 0)
			{
				if($row['cnt'])
					$arr_cnt[] = sprintf("{name:'%s', y:%s, sliced:true, selected:true}", $os_arr[$i], getPercent($tot, $row['cnt']));
				else
					$arr_cnt[] = sprintf("{name:'%s', y:0, sliced:true, selected:true}", $os_arr[$i]);
			}
			else
				$arr_cnt[] = ($row['cnt']) ? "['".$os_arr[$i]."', ".getPercent($tot, $row['cnt'])."]" : "['".$os_arr[$i]."', 0]";
		}

		printf("[%s]", implode(",", $arr_cnt));

	break;

	case "brower" :
		$bro_arr_str = array("IE Others","MSIE 8.0", "MSIE 9.0", "MSIE 10.0", "FireFox","Chrome","Netscape","Opera","Safari","Robot","Mozilla");
		list($tot) = $db->_fetch("select count(*) from sw_counter where year='".$year."'");

		for($i=0; $i < count($bro_arr_str); $i++)
		{
			$sqry = sprintf("select count(idx) as cnt from sw_counter where year='%s' and brogrp='%s'", $year, $bro_arr_str[$i]);
			$row = $db->_fetch($sqry, 1);

			if($i==5 && $row['cnt'] > 0)
			{
				if($row['cnt'])
					$arr_cnt[] = sprintf("{name:'%s', y:%s, sliced:true, selected:true}", $bro_arr_str[$i], getPercent($tot, $row['cnt']));
				else
					$arr_cnt[] = sprintf("{name:'%s', y:0, sliced:true, selected:true}", $bro_arr_str[$i]);
			}
			else
				$arr_cnt[] = ($row['cnt']) ? "['".$bro_arr_str[$i]."', ".getPercent($tot, $row['cnt'])."]" : "['".$bro_arr_str[$i]."', 0]";
		}

		printf("[%s]", implode(",", $arr_cnt));

	break;

	case "home" :
		for($i=9; $i >= 0 ; $i--)
		{
			$sqry = "select count(idx) as cnt from sw_counter where DATE_FORMAT(regdt, '%Y-%m-%d')=DATE_ADD(CURDATE(), INTERVAL ".($i*-1)." DAY)";
			//print($sqry."<br/>");
			$row = $db->_fetch($sqry, 1);

			$arr_cnt[] = ($row['cnt']) ? $row['cnt'] : 0;
		}

		printf("[%s]", implode(",", $arr_cnt));
	break;

	case "sday" : 
		
		$m_arr = array("", "31", "28", "31", "30", "31", "30", "31", "31", "30", "31", "30", "31");
		$arr_tit = $arr_data1 = $arr_data2 = array();

		for($d=1; $d < $m_arr[$mon]; $d++)
		{ 
			$date = sprintf("%4d-%02d-%02d", $year, $mon, $d);
			$sqry2 = sprintf("select count(*) as cnt from %s where left(regdt, 10)='%s'", "sw_member", $date);
			$row2 = $db->_fetch($sqry2, 1);

			$arr_tit[] = sprintf("'%02d일'", $d);
			$arr_data2[] = $row2['cnt'];
		}
		
		$title = sprintf("%4d년 %02d월 가입현황", $year, $mon);
		$tit_chart = sprintf("[%s]", implode(",", $arr_tit));
		$data2 = implode(",", $arr_data2);

		echo <<< SCRIPT
			<script type="text/javascript">
			parent.showChart("{$tit_chart}", '{$title}','{$data2}');
			</script>
SCRIPT;

	break;

	case "bank" :

		$os_arr = array("2"=>"입금대기", "3"=>"입금완료");
		$arr_keys = array_keys($os_arr);
 
		for($i=0; $i < count($os_arr); $i++)
		{
			$sqry = sprintf("select count(idx) as cnt from sw_order where payment='3' and status='%s' ", $arr_keys[$i]);
			$row = $db->_fetch($sqry, 1);

			if($i==5 && $row['cnt'] > 0)
			{
				if($row['cnt'])
					$arr_cnt[] = sprintf("{name:'%s', y:%s, sliced:true, selected:true}", $os_arr[$arr_keys[$i]], $row['cnt']);
				else
					$arr_cnt[] = sprintf("{name:'%s', y:0, sliced:true, selected:true}", $os_arr[$arr_keys[$i]]);
			}
			else
				$arr_cnt[] = ($row['cnt']) ? "['".$os_arr[$arr_keys[$i]]."', ".$row['cnt']."]" : "['".$os_arr[$arr_keys[$i]]."', 0]";
		}

		printf("[%s]", implode(",", $arr_cnt));

	break; 
}

?>