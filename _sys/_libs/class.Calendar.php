<?
//=======================================================================================================
// Program Name	:	Calendar Handle Class
// Author		:	seob
// Description	:	Calendar & Schedule
// Update		:	2010-08-06
//=======================================================================================================
class Calendar
{
	var $year;			//년
	var $month;			//월
	var $nowday;		//현재일
	var $totalday;		//현재달 총일수
	var $firstday;		//시작요일
	var $preyear;
	var $premonth;
	var $nextyear;
	var $nextmonth;
	var $arr_holiday = array
					(
						array("1", "0101", "[신정]", true),
						array("1", "0301", "[삼일절]", true),
						array("1", "0505", "[어린이날]", true),
						array("1", "0606", "[현충일]", true),
						array("1", "0815", "[광복절]", true),
						array("1", "1003", "[개천절]", true),
						array("1", "1225", "[성탄절]", true),
						array("2", "0100", "[설날연휴]", true),
						array("2", "0101", "[설날]", true),
						array("2", "0102", "[설날연휴]", true),
						array("2", "0408", "[석가탄신일]", true),
						array("2", "0814", "[추석연휴]", true),
						array("2", "0815", "[추석]", true),
						array("2", "0816", "[추석연휴]", true),
						array("1", "1009", "[한글날]", true)
					);

	var $arr_w = array('일', '월', '화', '수', '목', '금', '토');
						// 비수기주중,		 비수기주말,	준성수기주중,		준성수기주말,	성수기주중,			성수기주말
	var $arr_color = array("N0"=>"#808080", "Y0"=>"#339900", "N1"=>"#0066ff", "Y1"=>"#3300cc", "N2"=>"#ff6600", "Y2"=>"#ff0000");

	function Calendar($year, $month)
	{
		$this->year = $year;
		$this->month = $month;
		$this->nowday = date('d');
		$this->getTotalDay();
		$this->getFirstDay();
	}

	function HolidayCheck($day)
	{
		$lunarDate = $this->Lunar($this->year, $this->month, $day, '%d-%02d-%02d');
		$exlunar = explode("-", $lunarDate);

		$cmonth = sprintf("%02d", $this->month);
		$cday = sprintf("%02d", $day);

		for($i=0; $i < count($this->arr_holiday); $i++)
		{
			if($this->arr_holiday[$i][0] == 1 && $cmonth == substr($this->arr_holiday[$i][1], 0, 2) && $cday == substr($this->arr_holiday[$i][1], 2, 2))
			{
				$hname[] = $this->arr_holiday[$i][2];
				$oData[htype] = true;
			}

			if($this->arr_holiday[$i][0] == 2 && $exlunar[1] == substr($this->arr_holiday[$i][1], 0, 2) && $exlunar[2] == substr($this->arr_holiday[$i][1], 2, 2))
			{
				$hname[] = $this->arr_holiday[$i][2];
				$oData[htype] = true;
			}
		}

		if($hname)
			$oData[name] = @implode(".", $hname);

		return $oData;
	}

	function Lunar($year,$month,$day,$type)
	{
		$kk="1212122322121,1212121221220,1121121222120,2112132122122,2112112121220,2121211212120,2212321121212,2122121121210,2122121212120,1232122121212,1212121221220,1121123221222,1121121212220,1212112121220,2121231212121,2221211212120,1221212121210,2123221212121,2121212212120,1211212232212,1211212122210,2121121212220,1212132112212,2212112112210,2212211212120,1221412121212,1212122121210,2112212122120,1231212122212,1211212122210,2121123122122,2121121122120,2212112112120,2212231212112,2122121212120,1212122121210,2132122122121,2112121222120,1211212322122,1211211221220,2121121121220,2122132112122,1221212121120,2121221212110,2122321221212,1121212212210,2112121221220,1231211221222,1211211212220,1221123121221,2221121121210,2221212112120,1221241212112,1212212212120,1121212212210,2114121212221,2112112122210,2211211412212,2211211212120,2212121121210,2212214112121,2122122121120,1212122122120,1121412122122,1121121222120,2112112122120,2231211212122,2121211212120,2212121321212,2122121121210,2122121212120,1212142121212,1211221221220,1121121221220,2114112121222,1212112121220,2121211232122,1221211212120,1221212121210,2121223212121,2121212212120,1211212212210,2121321212221,2121121212220,1212112112210,2223211211221,2212211212120,1221212321212,1212122121210,2112212122120,1211232122212,1211212122210,2121121122210,2212312112212,2212112112120,2212121232112,2122121212110,2212122121210,2112124122121,2112121221220,1211211221220,2121321122122,2121121121220,2122112112322,1221212112120,1221221212110,2122123221212,1121212212210,2112121221220,1211231212222,1211211212220,1221121121220,1223212112121,2221212112120,1221221232112,1212212122120,1121212212210,2112132212221,2112112122210,2211211212210,2221321121212,2212121121210,2212212112120,1232212122112,1212122122120,1121212322122,1121121222120,2112112122120,2211231212122,2121211212120,2122121121210,2124212112121,2122121212120,1212121223212,1211212221220,1121121221220,2112132121222,1212112121220,2121211212120,2122321121212,1221212121210,2121221212120,1232121221212,1211212212210,2121123212221,2121121212220,1212112112220,1221231211221,2212211211220,1212212121210,2123212212121,2112122122120,1211212322212,1211212122210,2121121122120,2212114112122,2212112112120,2212121211210,2212232121211,2122122121210";

		$m[ 0] = 31;
		$m[ 1] = 0 ;
		$m[ 2] = 31;
		$m[ 3] = 30;
		$m[ 4] = 31;
		$m[ 5] = 30;
		$m[ 6] = 31;
		$m[ 7] = 31;
		$m[ 8] = 30;
		$m[ 9] = 31;
		$m[10] = 30;
		$m[11] = 31;

		for($i=0; $i<160; $i++)
		{
			$dt[$i] = 0;
			for($j=0; $j<12; $j++)
			{
				if ($kk[$i*14+$j]=='1'||$kk[$i*14+$j]=='3') $dt[$i] = $dt[$i] + 29;
				if ($kk[$i*14+$j]=='2'||$kk[$i*14+$j]=='4') $dt[$i] = $dt[$i] + 30;
			}
			if ($kk[$i*14+12]=='1'||$kk[$i*14+$j]=='3') $dt[$i] = $dt[$i] + 29;
			if ($kk[$i*14+12]=='2'||$kk[$i*14+$j]=='4') $dt[$i] = $dt[$i] + 30;
		}

		$td1 = 1880*365 + 1880/4 - 1880/100 + 1880/400 + 30;
		$k11 = $year-1;
		$td2 = $k11*365 + $k11/4 - $k11/100 + $k11/400;
		$ll = $year%400==0 || $year%100!=0 && $year%4==0;

		if($ll) $m[1] = 29;
		else    $m[1] = 28;
		for($i=0; $i<$month-1; $i++) $td2 = $td2 + $m[$i];
		$td2 = $td2 + $day;
		$td = $td2 - $td1 + 1;
		$td0 = $dt[0];

		for($i=0; $i<163; $i++)
		{
			if( $td <= $td0 ) break;
			$td0 = $td0 + $dt[$i+1];
		}
		$lyear = $i + 1881;

		$td0 = $td0 - $dt[$i];
		$td = $td - $td0;
		if($kk[$i*14+12] != '0') $jcount = 13;
		else                     $jcount = 12;
		$m2 = 0;

		for($j=0; $j<$jcount; $j++)
		{
			if( $kk[$i*14+$j] <='2' ) $m2++;
			if( $kk[$i*14+$j] <='2' ) $m1 = $kk[$i*14+$j]-'0' + 28;
			else                      $m1 = $kk[$i*14+$j]-'0' + 26;
			if( $td <= $m1 ) break;
			$td = $td - $m1;
		}

		$m0 = $j;
		$lmonth = $m2;

		$lday = $td;

		$i  = ($td2+4) % 10;
		$j  = ($td2+2) % 12;
		$i1 = ($lyear+6) % 10;
		$j1 = ($lyear+8) % 12;

		$yun="";
		if( $kk[($lyear-1881)*14+12] != '0' && $kk[($lyear-1881)*14+m0] > '2' ) $yun="윤년";

		return sprintf($type,$lyear, $lmonth, $lday);
	}

	function getTotalDay()
	{
		$total = date("t", mktime(0, 0, 1, $this->month, 1, $this->year));

		$this->totalday = $total;
	}

	function getFirstDay()
	{
		$first = date('w',mktime(0,0,0,$this->month,1,$this->year));

		$this->firstday = $first;
	}

	function Room()
	{
		global $db;

		$sqry = $db->query("select * from sw_room where buse='Y' order by idx asc");
		while($row = mysql_fetch_array($sqry))
			$roomData[$row['code']] = $row;

		return $roomData;
	}

	/// 성수기, 준성수기, 비수기 ///
	function getSeasonType($y, $m, $d)
	{
		global $cnf;

		$mkcur = mktime(0,0,0,$m,$d,$y);

		/// 성수기일 경우 ///
		if($cnf['odate'])
		{
			$exOdate = explode(",", $cnf['odate']);
			for($i=0; $i < count($exOdate); $i++)
			{
				$ex1 = explode("~", $exOdate[$i]);
				if(count($ex1) > 1)
				{
					$ex2_1 = explode("-", $ex1[0]);
					$ex2_2 = explode("-", $ex1[1]);

					$mksday = mktime(0,0,0,$ex2_1[0],$ex2_1[1],$y);
					$mkeday = mktime(0,0,0,$ex2_2[0],$ex2_2[1],$y);

					if($mkcur >= $mksday && $mkcur <= $mkeday)
					{
						return 2;
						break;
					}
				}
				else
				{
					$ex2 = explode("-",  $exOdate[$i]);
					$mksday = mktime(0,0,0,$ex2[0],$ex2[1],$y);

					if($mkcur == $mksday)
					{
						return 2;
						break;
					}
				}
			}
		}

		/// 준성수기일 경우 ///
		if($cnf['sdate'])
		{
			$exOdate = explode(",", $cnf['sdate']);
			for($i=0; $i < count($exOdate); $i++)
			{
				$ex1 = explode("~", $exOdate[$i]);
				if(count($ex1) > 2)
				{
					$ex2_1 = explode("-", $ex1[0]);
					$ex2_2 = explode("-", $ex1[1]);

					$mksday = mktime(0,0,0,$ex2_1[0],$ex2_1[1],$y);
					$mkeday = mktime(0,0,0,$ex2_2[0],$ex2_2[1],$y);

					if($mkcur >= $mksday && $mkcur <= $mkeday)
					{
						return 1;
						break;
					}
				}
				else
				{
					$ex2 = explode("-",  $exOdate[$i]);
					$mksday = mktime(0,0,0,$ex2[0],$ex2[1],$y);

					if($mkcur == $mksday)
					{
						return 1;
						break;
					}
				}
			}
		}

		return 0;
	}

	/// 성수기 및 주중,주말 여부 ///
	function getSeasonWeek($mk)
	{
		$w = 1;
		$s = 'n';

		if($this->getSeasonType(date('Y', $mk), date('m', $mk), date('d', $mk)) == 2) $s = 'y';
		else if($this->getSeasonType(date('Y', $mk), date('m', $mk), date('d', $mk)) == 1) $s = 's';
		else $s = 'n';

		if(date("w", $mk) == 0 || date("w", $mk) == 6) $w = 2;
		else $w = 1;

		return $s.$w;
	}

	/// 숙박가능일 체크 ///
	function getStayDay($rcode, $y, $m, $d)
	{
		global $db;

		$room = $db->fetch("select rcnt from sw_room where code='".$rcode."'");
		$mk = mktime(0,0,0,$m,$d,$y);
		$cnt = 0;
		for($d=1; $d <= 21; $d++)
		{
			$m = 86400 * $d;
			$rdate = date('Y-m-d', ($mk + $m));

			$sqry = sprintf("select count(*) from sw_booking_date where rdate='%s'", $rdate);
			$row = $db->fetch($sqry);

			$cnt++;

			if($room['rcnt'] <= $row[0]) break;
		}

		return $cnt;
	}

	/// 선택한 날수에 따라 숙박가능한 호실 ///
	function getBeRoom($rcode, $rnum, $period, $y, $m, $d)
	{
		global $db;

		$result = true;
		$mk = mktime(0,0,0,$m,$d,$y);

		for($i=1; $i <= $period; $i++)
		{
			$csqry = sprintf("select count(*) from sw_booking_date where rcode='%s' && rdate='%s' && rnum='%s'", $rcode, date('Y-m-d', $mk), $exrnum[$i]);
			$crow = $db->fetch($csqry);

			if($crow[0] > 0)
			{
				$result = false;
				break;
			}
			$mk += 86400;
		}

		return $result;
	}

	function ShowCalendar()
	{
		global $db;

		$roomData = $this->Room();
		$col = 0;
		$callist = "<tr>";

		//// 1일 이전에 공백이있으면 전월 날짜 출력 //////////////////////////////////////////////////
		for($i = 0; $i < $this->firstday; $i++)
		{
			$prev_day = date("Y-n-d", mktime(0, 0, 0, $this->month, 1-($this->firstday - $i), $this->year));

			//$callist .= sprintf("<td valign='top' align='left'>%s</td>", substr($prev_day,5,strlen($prev_day)-5));
			$callist .= "<td valign='top' align='left'>&nbsp;</td>";

			$col++;
		}

		//// 날짜 출력 ////////////////////////////////////////////////////////////////////////////////////
		for($d = 1; $d <= $this->totalday; $d++)
		{
			unset($tr, $roomTags);
			$day = sprintf("%02d", $d);
			$oData = $this->HolidayCheck($d);
			$str_hnm = ($oData['htype']) ? $oData['name'] : "";

			/// 객실별 예약수 리셋 //////////////////////////////////////////////////
			foreach($roomData as $key => $value)
				$roomData[$key]['reservecnt'] = '';

			if(mktime(0, 0, 0, $this->month, $d, $this->year) > mktime(0, 0, 0, date('m'), date('d'), date('Y')))
			{
				$reserve_sqry = sprintf("select idx, fidx, rcode from sw_booking_date where status <> 3 and rdate='%d-%02d-%02d'", $this->year, $this->month, $d);
				$reserve_qry = $db->query($reserve_sqry);

				while($reserve_row = mysql_fetch_array($reserve_qry))
				{
					$info_res = $db->fetch("select rcnt from sw_booking where idx='$reserve_row[fidx]'");

					$rcnt = ($info_res[0]) ? $info_res[0] : 1;

					$roomData[$reserve_row['rcode']]['reservecnt'] = $roomData[$reserve_row['rcode']]['reservecnt'] + $rcnt;
				}

				foreach($roomData as $key => $value)
				{
					if($value['rcnt'] < 1 || $value['reservecnt'] >= $value['rcnt'])
					{
						$sTag = "<strike>";
						$eTag = "</strike>";

						$becnt = 0;
						$fcolor = "#D9D9D9";
					}
					else
					{
						$sTag = sprintf("<a href=\"/reserve/reserve.step1.php?year=%d&month=%02d&day=%02d&rcode=%s\">", $this->year, $this->month, $d, $value['code']);
						$eTag = "</a>";

						$becnt = $value['rcnt'] - $value['reservecnt'];
						$fcolor = "#348738";
					}

					$roomTags .= sprintf("<div style=\"color:%s;text-align:left;\">%s%s(%s)%s</div>", $fcolor, $sTag, $value['name'], $becnt, $eTag);
				}
			}
			//$season : 2->성수기, 1->준성수기, 0->비수기
			$season = $this->getSeasonType($this->year, $this->month, $d);

			if($season == 2)
				$season_txt = "성수기";
			else if($season == 1)
				$season_txt = "준성수기";
			else
				$season_txt = "비수기";

			/// 토요일 및 일요일 경우 ////////////////////////////////////////////
			if($col == 0)
				$vday = sprintf("<div style=\"float:left;color:#FF0000;font-weight:bold;\">%s</div><div style=\"float:right;color:%s;\">%s</div>", $day, $this->arr_color["N".$season], $season_txt."주말");
			else if($col == 6)
				$vday = sprintf("<div style=\"float:left;color:#0033FF;font-weight:bold;\">%s</div><div style=\"float:right;color:%s;\">%s</div>", $day, $this->arr_color["N".$season], $season_txt."주말");
			else
				$vday = sprintf("<div style=\"float:left;font-weight:bold;\">%s</div><div style=\"float:right;color:%s;\">%s</div>", $day, $this->arr_color["N".$season], $season_txt."주중");
			/*
			if($col == 0 || $oData[htype]) $vday = sprintf("<font color='#FF0000'>%s</font>", $day);
			else if($col == 6) $vday = sprintf("<font color='#0033FF'>%s</font>", $day);
			else $vday = sprintf("%s", $day);
			*/

			$vstr = "<table width='99%' cellpadding='0' cellspacing='0' border='0'>
					<tr height=\"20\">
						<td valign='top' align='left'>{$vday}</td>
						<td valign='top' align='right' style='color:#FF0000;'>{$str_hnm}</td>
					</tr>
					</table>";


			$callist .= sprintf("<td height='80' valign='top'>%s%s</td>",  $vstr, $roomTags);
			$col++;

			if($col == 7)
			{
				$callist .= "</tr>";

				if($d != $this->totalday) $callist .= "<tr>";

				$col = 0;
			}
		}

		//// 이후 생기는 공백에 후월 날짜 출력 ////////////////////////////////////////////////////////
		while($col > 0 && $col < 7)
		{
			$reday++;

			$next_day = date("Y-n-d", mktime(0, 0, 0, $this->month, $day+$reday, $this->year));

			//$callist .= sprintf("<td valign='top'>%s</td>", substr($next_day,5,strlen($next_day)-5));
			$callist .= "<td valign='top'>&nbsp;</td>";

			$col++;
		}

		$callist .= "</tr>";

		$cTags = sprintf("<div style='text-align:center; valign-middle; font-size:13pt;font-weight:bold;margin-bottom:10px;'><a href=\"javascript:CalendarMove('%d', '%d', 'pre');\">◀</a> %d. %02d <a href=\"javascript:CalendarMove('%d', '%d', 'next');\">▶</a></div>", $this->year, $this->month, $this->year, $this->month, $this->year, $this->month);

		$cTags .=<<< TAGS

			<table width="100%" cellpadding="0" cellspacing="1" border="0" bgcolor="#e6e6e6">
			<col span="7" style="width:100px;background-color:#ffffff;padding:5px;">
			<tr align="center" bgcolor="#f6f6f6" height='20'>
				<td class="bold"><font color="#FF0000">SUN</font></td>
				<td class="bold">MON</td>
				<td class="bold">TUE</td>
				<td class="bold">WED</td>
				<td class="bold">THU</td>
				<td class="bold">FRI</td>
				<td class="bold"><font color="##0000FF">SAT</font></td>
			</tr>
			{$callist}
			</table>
TAGS;

		return $cTags;

	}
}
?>
