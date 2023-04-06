<?
/**
* Calendar Handler Class PHP5
* 
* @Author		:	kkang(sinbiweb)
* @Update		:	2014-11-18
* @Description	:	Calendar & Schedule
*/

class CalendarHandler extends MysqlHandler 
{
	public $year;				//년
	public $month;				//월
	public $curday;				//현재일
	public $totday;				//현재월 총일수
	public $fweek;				//시작요일
	public $arr_w = array("일","월","화","수","목","금","토");
	
	protected $arr_holiday = array(
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
									array("2", "0816", "[추석연휴]", true)
								);
	protected static $instance;


	/**
	* 싱글톤 인스턴스 리턴
	* @param $year, $month
	*/
	public static function getInstance($year, $month)
	{
		if(!isset(self::$instance))
			self::$instance = new self($year, $month);
		else
			self::$instance->__construct($year, $month);

		return self::$instance;
	}

	/** 
	* 생성자
	*/
	public function __construct($year, $month)
	{
		$this->year = $year;
		$this->month = $month;
		$this->curday = date('d');

		parent::__construct();
		self::getTotalDayCnt();
		self::getFirstWeek();
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* 현재월 총일수
	*/
	public function getTotalDayCnt()
	{
		$this->totday = date("t", mktime(0, 0, 1, $this->month, 1, $this->year));
	}

	/**
	* 현재월 시작요일
	*/
	public function getFirstWeek()
	{
		$this->fweek = date('w', mktime(0,0,0,$this->month, 1, $this->year));
	}

	/** 
	* Calendar show 
	* @param list : 리스트형, calendar : 캘린더형
	*/
	public function showCalendar($type="")
	{
		$cTags = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ffffff\">";
		$cTags .= "<tr height=\"60\"><td width=\"200\" class=\"lp20\">";
		$cTags .= ($type=="list") ? "<img src=\"../img/btn/btn_calendar1_on.gif\" /> " : "<a href=\"?year=".$this->year."&month=".$this->month."&vtype=list\"><img src=\"../img/btn/btn_calendar1_off.gif\" /></a> ";
		$cTags .= (!$type) ? "<img src=\"../img/btn/btn_calendar2_on.gif\" />" : "<a href=\"?year=".$this->year."&month=".$this->month."&vtype=\"><img src=\"../img/btn/btn_calendar2_off.gif\" border=\"0\" /></a>";
		$cTags .= "</td>";
		$cTags .= "<td>";
		$cTags .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"auto\">";
		$cTags .= "<tr>";
		$cTags .= sprintf("<td><a href=\"javascript:claendarMove('%s', '%s', '%s', 'pre');\"><img src=\"../img/btn/btn_calendar_prev.gif\" border=\"0\" /></a></td>", $this->year, $this->month, $type);
		$cTags .= "<td width=\"8\"></td>";
		$cTags .= sprintf("<td><p class=\"year up2\">%4d. %02d</p></td>", $this->year, $this->month);
		$cTags .= "<td width=\"8\"></td>";
		$cTags .= sprintf("<td><a href=\"javascript:claendarMove('%s', '%s', '%s', 'next');\"><img src=\"../img/btn/btn_calendar_next.gif\" border=\"0\" /></a></td>", $this->year, $this->month, $type);
		$cTags .= "</tr></table>";
		$cTags .= "</td><td width=\"200\" align=\"right\" class=\"rp20\">";
		$cTags .= sprintf("<a href=\"#\" onclick=\"calendarAdd('%s'); return false;\"><img src=\"../img/btn/btn_calendar_write.gif\" border=\"0\"></a> ", date('Y-m-d'));
		$cTags .= sprintf("<a href=\"?vtype=%s\"><img src=\"../img/btn/btn_calendar_today.gif\" border=\"0\"></a>", $type);
		$cTags .= "</td></tr></table>";

		if(!strcmp($type, "list"))
		{
			$col = $this->fweek;
			// 현재월의 날짜 출력 //
			for($d=1; $d <= $this->totday; $d++)
			{ 
				if($col == 0)
					$class = "sun1";
				else if($col == 6)
					$class = "sat1";
				else
					$class = "day1";

				// 오늘 날짜 class //
				if(date('Y-m-d') == sprintf("%4d-%02d-%02d", $this->year, $this->month, $d))
					$class_bg = "class=\"todaybg\"";
				else
					$class_bg = "";

				$callist .= sprintf("<tr height=\"40\" onclick=\"calendarAdd('%s');\" %s >", sprintf("%4d-%02d-%02d", $this->year, $this->month, $d), $class_bg);
				$callist .= sprintf("<td align=\"center\"><span class=\"%s\">%4d. %02d. %02d <span style=\"font-weight:normal;\">%s</span></span></td>", $class, $this->year, $this->month, $d, $this->arr_w[$col]);

				$sqry = sprintf("select * from %s where cdate='%d-%02d-%02d' order by idx asc", SW_CALENDAR, $this->year, $this->month, $d);
				if(parent::isRecodeExists($sqry))
				{
					$msg = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"pointer\">";

					$qry = parent::_execute($sqry);
					while($row=mysql_fetch_array($qry))
					{
						$msg .= sprintf("<tr height=\"40\"><td width=\"149\" align=\"center\" onclick=\"event.cancelBubble=true; calendarEdit('%s');\"><p class=\"calendar_time\">%s ~ %s</p></td>", $row['code'], $row['stime'], $row['etime']);
						$msg .= sprintf("<td class=\"lline lp10\" onclick=\"event.cancelBubble=true; calendarEdit('%s');\" ><p><span class=\"calendar_memo\">%s</span></p></td></tr>",$row['code'], $row['title']);
					}

					$msg .= "</table>";

					$callist .= sprintf("<td colspan=\"2\" class=\"lline\">%s</td>", $msg);
				}
				else
				{
					$callist .= "<td class=\"lline\"></td><td class=\"lline\"></td>";
				}

				$callist .= "</tr>";
				$callist .= "<tr height=\"1\"><td colspan=\"5\" style=\"background-color:#d9d9d9;\"></td></tr>";

				$col++;
				if($col == 7)
					$col = 0;
			}

			$cTags .=<<< TAGS
				<table cellspacing="0" class="calendar_tb">
				<colgroup>
				<col width="150" />
				<col width="150" />
				<col />
				</colgroup>
				<thead>
				<tr height="31">
					<th class="lline">년월일</th>
					<th class="lline">시간</th>
					<th class="lline">내용</th>
				</tr>
				</thead>
				</table>

				<table cellspacing="0" class="list_calendar">
				<colgroup>
				<col span="2" width="150">
				<col />
				</colgroup>
				{$callist}
				</table>
TAGS;

		}
		else
		{
			$col = 0;
			$callist = "<tr>";

			// 1일 이전에 공백이 있으면 전월날짜 출력 //
			for($i=0; $i < $this->fweek; $i++)
			{
				if($col == 0)
					$class = "sun2";
				else if($col == 6)
					$class = "sat2";
				else
					$class = "day2";

				$prev_day = date("Y-n-d", mktime(0,0,0,$this->month, 1-($this->fweek - $i), $this->year));
				$callist .= "<td align=\"center\" valign=\"top\"><div style=\"clear:both;position:relative;left:0px;top:0px;width:100%;\">";
				$callist .= sprintf("<div style=\"position:absolute;z-index:1;left:4px;top:3px;text-align:left;\"><span class=\"%s\">%s</span></div>", $class, substr($prev_day,5,strlen($prev_day)-5));
				$callist .= "</div></td>";

				$col++;
			}

			// 현재월의 날짜 출력 //
			for($d=1; $d <= $this->totday; $d++)
			{
				unset($msg);
				$sqry = sprintf("select * from %s where cdate='%d-%02d-%02d' order by idx asc", SW_CALENDAR, $this->year, $this->month, $d);
				$qry = parent::_execute($sqry);
				while($row=mysql_fetch_array($qry))
				{
					$msg .= sprintf("<div class=\"calendar_list pointer\" onclick=\"event.cancelBubble=true; calendarEdit('%s');\"><div><p class=\"calendar_time\">%s ~ %s</p><p><span class=\"calendar_memo\">%s</span></p></div></div>", $row['code'], $row['stime'], $row['etime'], $row['title']);
				}

				if($col == 0)
					$class = "sun1";
				else if($col == 6)
					$class = "sat1";
				else
					$class = "day1";

				// 오늘 날짜 class //
				if(date('Y-m-d') == sprintf("%4d-%02d-%02d", $this->year, $this->month, $d))
					$class_bg = "class=\"todaybg\"";
				else
					$class_bg = "";

				$callist .= sprintf("<td align=\"center\" valign=\"top\" onclick=\"calendarAdd('%s');\" %s><div style=\"clear:both;position:relative;left:0px;top:0px;width:100%%;\">", sprintf("%4d-%02d-%02d", $this->year, $this->month, $d), $class_bg);
				$callist .= sprintf("<div style=\"z-index:1;left:4px;top:3px;text-align:left;\"><span class=\"%s\">%02d</span></div>", $class, $d);
				$callist .= sprintf("</div>%s</td>", $msg);
				$col++;

				if($col == 7)
				{
					$callist .= "</tr>";
					if($d != $this->totday)
						$callist .= "<tr>";

					$col = 0;
				}
			}

			// 이후 생기는 공백에 후월 날짜 출력 //
			while($col > 0 && $col < 7)
			{
				if($col == 0)
					$class = "sun2";
				else if($col == 6)
					$class = "sat2";
				else
					$class = "day2";

				$reday++;
				$next_day = date("Y-n-d", mktime(0,0,0,$this->month,$d+$reday, $this->year));
				$callist .= "<td align=\"center\" valign=\"top\"><div style=\"clear:both;position:relative;left:0px;top:0px;width:100%;\">";
				$callist .= sprintf("<div style=\"position:absolute;z-index:1;left:4px;top:3px;text-align:left;\"><span class=\"%s\">%s</span></div>", $class, substr($next_day,5,strlen($next_day)-5));
				$callist .= "</div></td>";

				$col++;
			}

			$callist .= "</tr>";


			$cTags .=<<< TAGS
				<table cellspacing="0" class="calendar_tb">
				<colgroup>
				<col width="15%" />
				<col width="14%" />
				<col width="14%" />
				<col width="14%" />
				<col width="14%" />
				<col width="14%" />
				<col width="15%" />
				</colgroup>
				<thead>
				<tr>
					<th><font color="#ff3b43">일</font></th>
					<th class="lline">월</th>
					<th class="lline">화</th>
					<th class="lline">수</th>
					<th class="lline">목</th>
					<th class="lline">금</th>
					<th class="lline"><font color="#6589dc">토</font></th>
				</tr>
				</thead>
				<tbody>
				{$callist}
				</tbody>
				</table>
TAGS;

		}

		return $cTags;
	}
}
?>