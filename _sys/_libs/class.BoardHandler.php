<?php
/**
* Board Handler Class PHP5
*
* @Author		: seob
* @Update		: 2016-10-31
* @Description	: Board Handler Class
*/

class BoardHandler extends MysqliHandler
{
	protected $code;
	private $is_admin = FALSE;
	private $is_mobile = FALSE;
	private $bd_path = "";
	public $vars = array();
	public $numrows = 0;

	protected static $instance;

	/**
	* 싱글톤 인스턴스 리턴
	* @param array $params
	*/
	public static function getInstance($code)
	{
		if(!isset(self::$instance))
			self::$instance = new self($code);
		else
			self::$instance->__construct($code);

		return self::$instance;
	}

	/**
	* 생성자
	* @param array $params
	*/
	public function __construct($code)
	{
		global $encData;
		if($encData)
		{
			self::_get_base64_decode($encArr, $encData);
			foreach($encArr as $k=>$v)
				${$k} = urldecode($v);
		}

		$this->code = $code;
		$this->is_admin = (preg_match("/sadm/i", dirname($_SERVER['SCRIPT_NAME']))) ? TRUE : FALSE;
		if(_is_dir_mobile() || _is_agent_mobile()) $this->is_mobile = TRUE;
		$this->bd_path = ($this->is_mobile === TRUE) ? "/m" : "";

		if(!$this->code)
		{
			msg("게시판이 설정되어 있지 않습니다.", -1, true);
			return;
		}

		parent::__construct();
		self::getBoardcnf();
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* Board Setting Information
	*
	* @param string $code
	* @return array $vars
	*/
	public function getBoardcnf()
	{
		$sqry = sprintf("select * from %s where code='%s' order by idx asc limit 1", SW_BOARD_CNF, $this->code);
		$row = parent::_fetch($sqry, 1);
		$this->vars = $row;
	}

	/**
	* Board Category Array
	*
	* @param $mode (값이 있으면 => idx를 키값으로 배열생성)
	* @return array $arr
	*/
	public function _get_board_category($mode='')
	{
		if($this->vars['bcategory'])
		{
			$sqry = sprintf("select idx, name from %s where code='%s' order by seq asc", SW_BOARD_CATE, $this->vars['code']);
			$qry = parent::_execute($sqry);
			while($row=mysqli_fetch_assoc($qry))
			{
				if($mode)
					$arr[$row['idx']] = $row['name'];
				else
					$arr[] = $row;
			}

			return $arr;
		}
	}

	/**
	* Board total recode
	*/
	private function getTotalRecode()
	{
		$sqry = sprintf("select count(*) from %s where %s", SW_BOARD, implode(" and ", $this->where));
		list($numrows) = parent::_fetch($sqry);
		$this->numrows = $numrows;
	}

	/**
	* Board reply depth(level)
	*/
	private function _set_depth($re_level)
	{
		$depth = ($re_level > 0) ? sprintf("<span style=\"display:inline-block;width:%dpx;\"></span><img src=\"/images/board/icon_re.gif\" />", 5*$re_level) : "";
		return $depth;
	}

	/**
	* Board Auto Link
	*
	* @param string $data $encData
	* @return string $link
	*/
	public function autoLink($encData, $data="")
	{
		//if(isSinbiweb())
		//	Debug($data);
		if($this->is_admin === TRUE)
			$link = sprintf("<a href=\"./board.view.php?code=%s&encData=%s\">", $this->code, $encData);
		else
		{
			// 게시판에 읽기 권한이 있을경우 //
			if($this->vars['lvr'] > 0)
			{
				if(!strcmp($data['block'], "Y"))	//비밀글인 경우
				{
					if(_is_login() && !strcmp($data['userid'], $_SESSION['SES_USERID']))
						$link = sprintf("<a href=\"?act=view&encData=%s\">", $encData);
					else if($data['pwd'])
						$link = sprintf("<a href=\"javascript:LayerPopup.iframe(400, 220, '%s/board/check.passform.php?mode=lock&code=%s&encData=%s');\">", $this->bd_path, $this->vars['code'], $encData);
					else
						$link = "<a href=\"javascript:alert('비공개 게시물입니다.');\">";
				}
				else
				{
					if(_is_login() && $this->vars['lvr'] <= $_SESSION['SES_USERLV'])	// 읽기권한이 있는 회원이면
						$link = sprintf("<a href=\"?act=view&encData=%s\">", $encData);
					else
					{
						if(_is_login())
							$link = "<a href=\"javascript:alert('회원님은 읽기권한이 없는 회원이십니다.');\">";
						else
						{
							//로그인페이지 이동
						}

					}
				}
			}
			else
			{
				if(!strcmp($data['block'], "Y"))	//비밀글인 경우
				{
					if(_is_login() && !strcmp($data['userid'], $_SESSION['SES_USERID']))
						$link = sprintf("<a href=\"?act=view&encData=%s\">", $encData);
					else if($data['pwd'])
						$link = sprintf("<a href=\"javascript:LayerPopup.iframe(400, 220, '%s/board/check.passform.php?mode=lock&code=%s&encData=%s');\">", $this->bd_path, $this->vars['code'], $encData);
					else
						$link = "<a href=\"javascript:alert('비공개 게시물입니다.');\">";
				}
				else
					$link = sprintf("<a href=\"?act=view&encData=%s\">", $encData);
			}
		}

		return $link;
	}

	/**
	* Board Act Auth --- act별 권한 설정
	*
	* @Des : 권한(list, view, edit, write)
	*/
	public function _get_board_act_auth()
	{
		global $encData;

		if($this->is_admin === TRUE)
			$auth = array(
							"L"	=> true,	// 리스트
							"R"	=> true,	// 상세읽기
							"W"	=> true,	// 새글등록
							"U"	=> true,	// 글수정
							"D"	=> true		// 글삭제
						);
		else
		{
			if($encData) $row = self::_get_board_data($encData);	// 게시물정보 가져오기 //

			// list //
			if($this->vars['lvl'] > 0)
			{
				if(_is_login() && $_SESSION['SES_USERLV'] >= $this->vars['lvl']) $L = true;
				else $L = false;
			}
			else
				$L = true;

			// view //
			if($this->vars['lvr'] > 0)
			{
				if(_is_login() && $_SESSION['SES_USERLV'] >= $this->vars['lvr'])
				{
					if(!strcmp($row['block'], "Y") && !strcmp($_SESSION['SES_USERID'], $row['userid']))
						$R = true;
					else if(!strcmp($row['block'], "Y"))
						$R = false;
					else
						$R = true;
				}
			}
			else
			{
				// 로그인 회원인 경우 //
				if(_is_login() && $row['userid'] && !strcmp($_SESSION['SES_USERID'], $row['userid'])) $R = true;
				else if(!strcmp($row['block'], "Y") && _get_cookie("CK_BD_".$row['idx'])) $R = true;
				else if(!strcmp($row['block'], "Y")) $R = false;
				else $R = true;
			}

			// write & edit & delete //
			if($this->vars['lvw'] > 0)
			{
				if(_is_login() && $_SESSION['SES_USERLV'] >= $this->vars['lvw'])
				{
					$W = true;
					if($row && !strcmp($row['userid'], $_SESSION['SES_USERID']))
						$U = $D = true;
					else
						$U = $D = false;
				}
				else
				{
					$W = $U = $D = false;
				}
			}
			else
			{
				$W = true;
				if(_is_login() && $row['userid'] && !strcmp($_SESSION['SES_USERID'], $row['userid'])) $U = $D = true;
				else if(_get_cookie("CK_BD_".$row['idx'])) $U = $D = true;
				else $U = $D = false;
			}

			$auth = array(
							"L"	=> $L,
							"R"	=> $R,
							"W"	=> $W,
							"U"	=> $U,
							"D"	=> $D
						);
		}

		return $auth;
	}

	/**
	* act별 권한 체크후 action
	*/
	public function _set_auth_action($act)
	{
		switch($act)
		{
			case "list" :
				if($this->auth['L'] !== true)
					msg($this->vars['name']."은 회원만 이용가능한 게시판입니다.", -1, true);
			break;
			case "write" :
				if($this->auth['R'] !== true)
					msg($this->vars['name']."은 회원만 이용가능한 게시판입니다.", -1, true);
			break;
			case "view" :
				if($this->auth['R'] !== true)
					msg("비공개 게시글이거나 읽기 권한이 없는 게시물입니다.", -1, true);
			break;
			case "edit" :
				if($this->auth['U'] !== true)
					msg("본인이 작성한 게시글만 수정, 삭제가 가능합니다.", -1, true);
			break;
		}
	}

	/**
	* Board List
	* @return array &$ldata
	*/
	public function _list(&$ldata)
	{
		global $encData, $skey, $sstr, $sday, $eday, $cate;

		$this->where = array();
		if($encData)
		{
			self::_get_base64_decode($encArr, $encData);
			foreach($encArr as $k=>$v)
				${$k} = urldecode($v);
		}
		$this->start = $start;
		$this->where[] = sprintf("code='%s'", $this->code);

		if($skey && $sstr)
			$this->where[] = sprintf("%s like '%%%s%%'", $skey, $sstr);
		else if($sstr)
			$this->where[] = sprintf("(title like '%%%s%%' || content like '%%%s%%')", $sstr, $sstr);

		if($cate) $this->where[] = sprintf("cate='%s'", $cate);
		if($sday) $this->where[] = sprintf("DATE_FORMAT(regdt, '%%Y-%%m-%%d') >= DATE_FORMAT('%s', '%%Y-%%m-%%d')", $sday);
		if($eday) $this->where[] = sprintf("DATE_FORMAT(regdt, '%%Y-%%m-%%d') <= DATE_FORMAT('%s', '%%Y-%%m-%%d')", $eday);

		self::getTotalRecode();

		if($this->vars['bnotice'])
			$ldata['notice'] = self::_loop('notice');

		$ldata['data'] = self::_loop();
	}

	/**
	* Board List Data
	*
	* @param string $ltype
	* @return array $data
	*/
	private function _loop($ltype="")
	{
		global $encData, $skey, $sstr, $sday, $eday, $cate;

		$data = array();
		//if(!strcmp($ltype, "notice"))
		//	array_unshift($this->where, "notice='Y'");

		if(count($this->where) > 0)
			$AddW = sprintf(" and %s", implode(" and ", $this->where));

		if(!strcmp($ltype, "notice"))
			$sqry = sprintf("select * from %s where notice='Y' %s order by ref desc, re_step asc", SW_BOARD, $AddW);
		else
			$sqry = sprintf("select * from %s where notice='N' %s order by ref desc, re_step asc", SW_BOARD, $AddW);

		parent::_affected($numrows, $sqry);

		if(!strcmp($ltype, "notice"))
			$this->notice_total = $numrows;
		else
		{
			$this->board_total = $numrows;
			$this->start = ($this->start) ? $this->start : 0;
			$letter_no = $this->board_total - $this->start;
			$this->vlimit = ($pgnum) ? $pgnum : $this->vars['limitcnt'];
			$sqry .= sprintf(" limit %d, %d", $this->start, $this->vlimit);
		}

		$param['skey'] = $skey;
		$param['sstr'] = $sstr;
		$param['cate'] = $cate;
		$param['sday'] = $sday;
		$param['eday'] = $eday;

		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			$encData = self::_get_base64_encode("idx=".$row['idx']."&start=".$this->start."&".self::_getParam($param));
			$row['title'] = _get_cut_string($row['title'], $this->vars['cutstr']);
			if(!strcmp($row['block'], "Y")) $row['title'] = sprintf("<img src=\"/images/board/icon_lock.gif\" align=\"absmiddle\" /> %s", $row['title']);

			// 검색시 검색단어 스타일처리 //
			if(!strcmp($skey, "title") && $sstr)
			{
				if(preg_match("/".$sstr."/i", $row['title'], $matches))
				{
					$this->vars['cutstr'] = $this->vars['cutstr'] + 40;
					$row['title'] = preg_replace("/$sstr/i", "<span style=\"color:#ff0000;\">".$matches[0]."</span>", $row['title']);
				}
				else
					$row['title'] = $row['title'];
			}
			else if(!strcmp($skey, "content") && $sstr)
			{
				if(preg_match("/".$sstr."/i", $row['content'], $matches))
					$row['content'] = preg_replace("/$sstr/i", "<span style=\"color:#ff0000;\">".$matches[0]."</span>", $row['content']);
				else
					$row['content'] = $row['content'];
			}
			else if($sstr)
			{
				if(preg_match("/".$sstr."/i", $row['title'], $matches))
				{
					$this->vars['cutstr'] = $this->vars['cutstr'] + 40;
					$row['title'] = preg_replace("/$sstr/i", "<span style=\"color:#ff0000;\">".$matches[0]."</span>", $row['title']);
				}
				else
					$row['title'] = $row['title'];

				if(preg_match("/".$sstr."/i", $row['content'], $matches))
					$row['content'] = preg_replace("/$sstr/i", "<span style=\"color:#ff0000;\">".$matches[0]."</span>", $row['content']);
				else
					$row['content'] = $row['content'];
			}

			$row['title'] = sprintf("%s %s", self::_set_depth($row['re_level']), $row['title']);

			// 카테고리 //
			if($this->vars['bcategory'])
			{
				$arCate = self::_get_board_category(1);
				// 분류 이미지설정부분 추가예정 --- 2017-01-24 //
				if($row['cate']) $row['v_cate'] = $arCate[$row['cate']];
			}

			// 첨부파일 //
			if($this->vars['filecnt'] > 0)
				$row['fdata'] = self::_get_upload_files($row['idx'], "ONE", "image");

			// 댓글 카운트 //
			if($this->vars['bcom'])
			{
				$comment_cnt = self::_get_comment_count($row['idx']);
				if($comment_cnt > 0)
					$v_comment_cnt = sprintf("<span style=\"color:#ff0000;\">[%s]</span>", number_format($comment_cnt));
				else
					$v_comment_cnt = "";
			}

			// 링크설정 //
			$row['link'] = self::autoLink($encData, $row);
			if(!strcmp($this->vars['skin'], "default"))
				$row['title'] = sprintf("%s%s</a> %s", $row['link'], $row['title'], $v_comment_cnt);

			$row['letter_no'] = $letter_no;
			$data[] = $row;
			$letter_no--;
		}
		return $data;
	}

	/**
	* outer board list
	* @param cnt : 노출수
	* @return array &$ldata
	*/
	public function _get_outer_list(&$ldata, $cnt, $param="")
	{
		if(is_array($param) && count($param) > 0)
		{
			if($param['key'] && $param['sstr'])
				$arrW[] = sprintf("%s like '%%%s%%'", $param['key'], $param['sstr']);
			else if($param['sstr'])
				$arrW[] = sprintf("title like '%%%s%%'", $param['sstr']);

			if($arrW) $AddW = sprintf(" AND %s", implode(" AND ", $arrW));
		}

		if($this->vars['bsort'])
			$sort = "regdt desc";
		else
			$sort = "ref desc";

		if($cnt > 0)
			$sqry = sprintf("select * from %s where code='%s' and re_step < 1 %s order by %s limit %d", SW_BOARD, $this->code, $AddW, $sort, $cnt);
		else
			$sqry = sprintf("select * from %s where code='%s' and re_step < 1 %s order by %s", SW_BOARD, $this->code, $AddW, $sort);

		parent::_affected($numrows, $sqry);
		$this->numrows = $numrows;
		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			$encData = self::_get_base64_encode("idx=".$row['idx']);
			$row['encData'] = $encData;
			$row['regdt'] = substr($row['regdt'], 0, 10);
			if($this->vars['filecnt'] > 0)
				$row['fdata'] = self::_get_upload_files($row['idx'], "ONE", "image");

			$data[] = $row;
		}

		$ldata = $data;
	}

	/**
	* Board Data Delete
	*
	* @param string $encData
	* @return bool
	*/
	public function _del($encData)
	{
		self::_act($ddata, "del", $encData);
		if($ddata['idx'])
		{
			$dsqry = sprintf("delete from %s where idx='%d'", SW_BOARD, $ddata['idx']);
			if(parent::_execute($dsqry))
			{
				/// 첨부파일 삭제 //
				for($f=0; $f < count($ddata['fdata']); $f++)
				{
					_file_delete($ddata['fdata'][$f]['upfile'], "../upload/board/".$this->vars['code']);
					if(!strcmp($this->vars['bthumb'], "Y") && !strcmp($ddata['fdata'][$f]['ftype'], "image"))
						_file_delete("thum_".$ddata['fdata'][$f]['upfile'], "../upload/board/".$this->vars['code']);
				}
				parent::_execute("delete from ".SW_BOARD_FILE." where code='".$this->vars['code']."' and bdidx='".$ddata['idx']."'");
				/// 에디터 첨부파일 삭제 ///
				_webeditor_image_del($ddata['content']);

				return true;
			}
			else
				return false;
		}
		else
			return false;
	}

	/**
	* Board Write Or Board Reply Or Board Edit
	*
	* @param string $mode : edit(수정)
	* @return array $wdata
	*/
	public function _write(&$wdata, $mode="")
	{
		global $encData, $arr_auth;

		if($encData)
			self::_get_base64_decode($encArr, $encData);

		if($encArr['idx'])
		{
			$row = self::_get_board_data($encArr['idx']);
			if(!strcmp($mode, "edit"))
			{
				$row['file'] = self::_get_upload_files($row['idx']);
			}
			else
			{
				$row['re_title']	= sprintf("RE] %s", htmlspecialchars($row['title']));
				$row['re_content']	= ($this->vars['beditor']) ? sprintf("<br /><br />--------------------------------- [ 원 본 글 ] -------------------------------<br />%s", $row['content']) : sprintf("\n\n--------------------------------- [ 원 본 글 ] -------------------------------\n%s", $row['content']);
			}
		}
		// 비밀글 및 일반글 설정셋팅 //
		switch($this->vars['bsecret'])
		{
			case 1 :		// 무조건비밀글
				$row['secret_tag'] = "<input type=\"hidden\" name=\"block\" value=\"Y\" />";
			break;
			case 2 :		//기본일반글
				if(!strcmp($mode, "edit") || $row)
					$row['secret_tag'] = sprintf("<label><input type=\"checkbox\" name=\"block\" value=\"Y\" %s /> 비밀글</label>", (($row['block'] == "Y") ? "checked=\"checked\"" : ""));
				else
					$row['secret_tag'] = "<label><input type=\"checkbox\" name=\"block\" value=\"Y\" /> 비밀글 </label>";
			break;
			case 3 :		//기본비밀글
				if(!strcmp($mode, "edit"))
					$row['secret_tag'] = sprintf("<label><input type=\"checkbox\" name=\"block\" value=\"Y\" %s /> 비밀글 </label>", (($row['block'] == "Y") ? "checked=\"checked\"" : ""));
				else
					$row['secret_tag'] = "<label><input type=\"checkbox\" name=\"block\" value=\"Y\" checked=\"checked\" /> 비밀글 </label>";
			break;
			default :		//무조건일반글
				$row['secret_tag'] = "<input type=\"hidden\" name=\"block\" value=\"N\" />";
			break;
		}

		// Notice tag //
		if($this->vars['bnotice'] && $this->is_admin === TRUE)
		{
			$checked = ($mode == "edit" && $row['notice'] == "Y") ? "checked=\"checked\"" : "";
			$row['notice_tag'] =<<< NOTICE_TAG
				<tr>
					<th>공지여부</th>
					<td><label><input type="checkbox" name="notice" value="Y" {$checked} /> 공지글</label></td>
				</tr>
NOTICE_TAG;
		}

		// password tag //
		if(!_is_login() && !$this->is_admin)
		{
			$pass_th = ($mode == "edit") ? "비밀번호확인" : "비밀번호";
			$row['password_tag'] =<<< PASS_TAG
				<tr>
					<td><label for="pass">{$pass_th}</label></td>
					<td><input type="password" name="pwd" class="inputType" id="pass" title="패스워드를 입력하세요" exp="비밀번호를" /></td>
				</tr>
PASS_TAG;
		}

		// E-mail input tag //
		if($this->vars['bemail'])
		{
			$row['email_tag'] =<<< EMAIL_TAG
				<tr>
					<th>E-Mail</th>
					<td><input type="text" name="email" class="w250 lbox" chkval="email" value="{$row['email']}" /></td>
				</tr>
EMAIL_TAG;
		}

		// Phone input tag //
		if($this->vars['bphone'])
		{
			if($row['phone'])
				$exphone = explode("-", $row['phone']);

			$row['phone_tag'] =<<< PHONE_TAG
				<tr>
					<th>연락처</th>
					<td>
						<input type="text" name="phone1" class="w50 lbox" chkval="number" value="{$exphone[0]}" maxlength="3" /> -
						<input type="text" name="phone2" class="w50 lbox" chkval="number" value="{$exphone[1]}" maxlength="4" /> -
						<input type="text" name="phone3" class="w50 lbox" chkval="number" value="{$exphone[2]}" maxlength="4" />
					</td>
				</tr>
PHONE_TAG;
		}

		// Event input tag (sday, eday) //
		if($this->vars['bevent'])
		{
			$status1 = ($row['status'] == 1 || !$row['status']) ? "checked=\"checked\"" : "";
			$status2 = ($row['status'] == 2) ? "checked=\"checked\"" : "";
			$status3 = ($row['status'] == 3) ? "checked=\"checked\"" : "";
			$status4 = ($row['status'] == 4) ? "checked=\"checked\"" : "";

			$row['event_tag'] =<<< EVENT_TAG
				<tr>
					<th>Event 기간</th>
					<td>
						<input type="text" name="sday" class="w100 lbox" value="{$row['sday']}" maxlength="10" /> ~
						<input type="text" name="eday" class="w100 lbox" value="{$row['eday']}" maxlength="10" />
					</td>
				</tr>
				<tr>
					<th>진행상태</th>
					<td>
						<label><input type="radio" name="status" value="1" {$status1} /> 진행중 </label> &nbsp;
						<label><input type="radio" name="status" value="4" {$status4} /> 마감 </label> &nbsp;
					</td>
				</tr>
EVENT_TAG;
		}

		// Category tag //
		if($this->vars['bcategory'])
		{
			$arCate = self::_get_board_category();
			foreach($arCate as $v)
			{
				if($row['cate'] == $v['idx'])
					$arr_opt[] = sprintf("<option value=\"%d\" selected=\"selected\">%s</option>", $v['idx'], $v['name']);
				else
					$arr_opt[] = sprintf("<option value=\"%d\">%s</option>", $v['idx'], $v['name']);
			}

			if(count($arr_opt) > 0)
			{
				array_unshift($arr_opt, "<option value=\"\">:: 분류 선택 ::</option>");
				$opt_tag = sprintf("<select name=\"cate\" exp=\"분류를\" class=\"w150\">%s</select>", implode("\n", $arr_opt));
				$row['category_tag'] =<<< CATEGORY_TAG
					<tr>
						<th>분류선택</th>
						<td>{$opt_tag}</td>
					</tr>
CATEGORY_TAG;
			}
		}

		$wdata = $row;
	}

	/**
	* Board db insert, update, delete
	*
	* @param string $act, $encData
	* @return array $adata
	*/
	public function _act(&$adata, $act, $encData="")
	{
		if($encData)
		{
			self::_get_base64_decode($encArr, $encData);
			$row = self::_get_board_data($encArr['idx']);
		}

		switch($act)
		{
			case "edit" :
				$row['fdata'] = self::_get_upload_files($row['idx']);
			break;
			case "del" :
				// 관련답변글 목록 //
				$sqry = sprintf("select idx from %s where ref='%d' and re_level > 0 and idx <> %d order by idx desc", SW_BOARD, $row['ref'], $row['idx']);
				$qry = parent::_execute($sqry);
				while($rrow = mysqli_fetch_assoc($qry))
					$reply[] = $rrow['idx'];

				$row['reply'] = $reply;
				$row['fdata'] = self::_get_upload_files($row['idx']);
			break;
			case "write" :
				if($row)
				{
					$row['re_level']++;
					$row['re_step']++;
				}
				else
				{
					list($max) = parent::_fetch("select max(ref) from ".SW_BOARD);
					$row['ref'] = $max+1;
					$row['re_level'] = $row['re_step'] = 0;

					if($this->is_admin === TRUE)
						$row['lockid'] = "";
					else
						$row['lockid'] = $_SESSION['SES_USERID'];
				}
			break;
		}

		$adata = $row;
	}

	/**
	* Board View
	*
	* @param string $encData
	* @return array $vdata
	*/
	public function _view(&$vdata, $encData)
	{
		if($encData)
			self::_get_base64_decode($encArr, $encData);

		$row = self::_get_board_data($encArr['idx']);
		$row['encData'] = $encData;
		if($encArr['sstr'] && !strcmp($encArr['skey'], 'title'))
		{
			if(preg_match("/".$encArr['sstr']."/i", $row['title'], $matches))
			{
				$row['title'] = preg_replace("/".$encArr['sstr']."/i", "<span style=\"color:#ff0000;\">".$matches[0]."</span>", $row['title']);
			}
		}

		if($this->is_mobile === TRUE)
		{
			$row['content'] = preg_replace("/ height=(\"|\')?\d+(\"|\')?/", "", preg_replace("/ width=(\"|\')?\d+(\"|\')?/", "", $row['content']));
			$row['content'] = preg_replace("(width[\s]*:[\s]*\d+[\s]*px[\;]?|height[\s]*:[\s]*\d+[\s]*px[\;]?)", "", $row['content']);
		}

		// 카테고리 표시 //
		if($this->vars['bcategory'])
		{
			$arCate = self::_get_board_category(1);
			$row['title'] = sprintf("<span style=\"color:#663300;\">[%s]</span> %s", $arCate[$row['cate']], $row['title']);
		}

		if(!$this->vars['beditor'])
			$row['content'] = nl2br($row['content']);

		/// 첨부파일 다운로드링크 및 이미지 태그 ///
		$upload = self::getShowFiles($row['idx']);
		if(is_array($upload['downlink']) && count($upload['downlink']) > 0)
			$row['downlink'] = $upload['downlink'];
		if(is_array($upload['imgtags']) && count($upload['imgtags']) > 0)
			$row['imgtags'] = $upload['imgtags'];

		/// 관련글표시 (이전글, 다음글) ///
		if($this->vars['viewlist'])
		{
			$relation = self::getViewType($encData);
			$row = array_merge($row, $relation);
		}

		/// hit plus ///
		if(!$this->is_admin)
			self::setHitPlus($encArr['idx']);

		$vdata = $row;
	}

	/**
	* 관련글(prev, next)
	*
	* @param string $encData
	* @return array
	*/
	private function getViewType($encData)
	{
		self::_get_base64_decode($encArr, $encData);
		$page = ($encArr['page']) ? $encArr['page'] : 1;

		if($this->vars['viewlist'] == 2 || $this->vars['viewlist'] == 3)
		{
			$inner_script =<<< SCRIPT
				<script type="text/javascript">
				function loadList(page)
				{
					page = (page) ? page : 1;
					$(":hidden[name='page']").val(page);
					$.post("/board/board.innerList.php", $("form[name='fm']").serializeArray(), function(data){
						if(data)
						{
							$(".v-list").html(data);
							$(".with-media div:nth-child(4n+1)").css("margin-left","0px");
						}
					});
				}

				function search()
				{
					if(!$(":text[name='sstr']").val())
					{
						alert("검색어를 입력해 주세요.");
						$(":text[name='sstr']").focus();
					}
					else
						loadList(1);
				}

				$(document).ready(function(){
					loadList({$page});
				});
				</script>
SCRIPT;
		}

		/// 관련글 ///
		if($this->vars['viewlist'] == 1 || $this->vars['viewlist'] == 3)
		{
			$wArr = array();

			if($encArr['skey'] && $encArr['sstr'])
				$wArr[] = sprintf("%s like '%%%s%%'", $encArr['skey'], $encArr['sstr']);
			else if($encArr['sstr'])
				$wArr[] = sprintf("title like '%%%s%%' || content like '%%%s%%'", $encArr['sstr'], $encArr['sstr']);

			if($wArr)
				$AddW = sprintf(" AND (%s)", implode(" AND ", $wArr));

			list($prev_idx, $prev_tit, $prev_regdt) = parent::_fetch(sprintf("select idx, title, regdt from %s where code='%s' and idx < %d %s order by ref desc, re_step asc limit 1", SW_BOARD, $this->code, $encArr['idx'], $AddW));
			list($next_idx, $next_tit, $next_regdt) = parent::_fetch(sprintf("select idx ,title, regdt from %s where code='%s' and idx > %d %s order by ref asc, re_step desc limit 1", SW_BOARD, $this->code, $encArr['idx'], $AddW));

			if($prev_idx) $prev_data = _get_re_encode64($encData, array("idx"=>$prev_idx));
			if($next_idx) $next_data = _get_re_encode64($encData, array("idx"=>$next_idx));

			$prev = array("idx"=>$prev_idx, "title"=>$prev_tit, "regdt"=>$prev_regdt, "encData"=>$prev_data);
			$next = array("idx"=>$next_idx, "title"=>$next_tit, "regdt"=>$next_regdt, "encData"=>$next_data);
		}

		return array(
						"prev" => $prev,
						"next" => $next,
						"inner_script"	=> $inner_script
					);
	}

	/**
	* 뷰하단 목록
	*
	* @param array :
	*/
	public function getInnerList(&$vars)
	{
		if($vars['encData'])
			self::_get_base64_decode($encArr, $vars['encData']);

		$vars['param']['sstr'] = ($vars['param']['sstr']) ? $vars['param']['sstr'] : $encArr['sstr'];
		$vars['param']['skey'] = ($vars['param']['skey']) ? $vars['param']['skey'] : $encArr['skey'];
		$vars['param']['cate'] = ($vars['param']['cate']) ? $vars['param']['cate'] : $encArr['cate'];

		$arrW = $ldata = array();
		if($vars['param']['sstr'] && $vars['param']['skey'])
			$arrW[] = sprintf("%s like '%%%s%%'", $vars['param']['skey'], $vars['param']['sstr']);
		else if($vars['param']['sstr'])
			$arrW[] = sprintf("(title like '%%%s%%' || content like '%%%s%%')", $vars['param']['sstr'], $vars['param']['sstr']);

		if($vars['cate']) $arrW[] = sprintf("cate='%s'", $vars['param']['cate']);
		if($arrW) $AddW = sprintf(" and %s", implode(" and ", $arrW));

		$start = ($vars['page'] - 1) * $vars['limit'];
		$sqry = sprintf("select idx, title, cate, regdt from %s where code='%s' %s", SW_BOARD, $this->vars['code'], $AddW);
		parent::_affected($numrows, $sqry);
		$vars['total'] = $numrows;
		$sqry .= sprintf(" order by ref desc, re_step asc limit %d, %d", $start, $vars['limit']);
		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			$row['encData'] = self::_get_base64_encode("idx=".$row['idx']."&page=".$vars['page']."&skey=".$vars['param']['skey']."&sstr=".$vars['param']['sstr']);
			$row['title'] = _get_cut_string($row['title'], $this->vars['lenStr']);

			if($this->vars['fileCnt'] > 0)
				$row['fdata'] = self::_get_upload_files($row['idx'], "ONE", "image");

			$vars['list'][] = $row;
		}
	}

	public function getInnerPage(array $vars)
	{
		require_once(dirname(__FILE__)."/./util.pagination.php");

		$arPage = Pagination($vars);
		printPage($arPage);
	}

	/**
	* GET parameter
	*
	* @param array $param : array param
	* @return string $param
	*/
	private function _getParam(array $param)
	{
		if(is_array($param) && count($param) > 0)
		{
			foreach($param as $k=>$v)
				if($v) $arParam[] = sprintf("%s=%s", $k, urlencode($v));

			if($arParam)
				return @implode("&", $arParam);
		}
	}

	/**
	* page setting
	*
	* @param string $act : list, view, write, edit
	* @return array : 태그 및 설정값
	*/
	public function _setPage($act)
	{
		global $cate, $encData;

		if($encData)
		{
			self::_get_base64_decode($encArr, $encData);
			foreach($encArr as $k=>$v)
				if(!${$k})
					${$k} = urldecode($v);

		}

		switch($act)
		{
			case "list" :
				// category //
				if($this->vars['bCategory'])
				{
					$arCate = self::_get_board_category();
					if(count($arCate) > 0)
					{
						$arr_tags = array();
						foreach($arCate as $v)
							$arr_tags[] = sprintf("<li><a href=\"javascript:Board.search.category('%d');\" %s>%s</a></li>", $v['idx'], (($cate == $v['idx']) ? "class=\"on\"" : ""), $v['name']);

						$set['category_tab'] = "<ul class=\"photoTab\">";
						$set['category_tab'] .= @implode("\n", $arr_tags);
						$set['category_tab'] .= "</ul>";
					}
				}

				return $set;
			break;
		}
	}

	/**
	* 댓글 count
	* @update : 2020-04-13
	*/
	private function _get_comment_count($bdidx)
	{
		$sqry = sprintf("select count(*) as total from %s where code='%s' and bdidx='%d'", SW_BOARD_CMT, $this->vars['code'], $bdidx);
		$row = parent::_fetch($sqry, 1);
		return $row['total'];
	}

	/**
	* get comment --- 댓글리스트
	*/
	public function _get_comment($bdidx)
	{
		$sqry = sprintf("select * from %s where bdidx='%d'", SW_BOARD_CMT, $bdidx);
		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
			$arr[] = $row;

		return $arr;
	}

	/**
	* get comment info
	*/
	public function _get_comment_inf(&$comment, $cidx)
	{
		$sqry = sprintf("select * from %s where idx='%s'", SW_BOARD_CMT, $cidx);
		$comment = parent::_fetch($sqry, 1);
	}

	/**
	* Board Upload Files
	*
	* @param
	* @return array
	*/
	private function _get_upload_files($bdidx, $mode="ALL", $type="")
	{
		if($type)
			$AddW = sprintf(" and ftype='%s'", $type);

		$sqry = sprintf("select * from %s where code='%s' and bdidx='%d' %s order by idx asc", SW_BOARD_FILE, $this->code, $bdidx, $AddW);
		if(!strcmp($mode, "ONE"))
		{
			$sqry .= " limit 1";
			$fdata = parent::_fetch($sqry, 1);
		}
		else
		{
			$qry = parent::_execute($sqry);
			while($row = mysqli_fetch_assoc($qry))
				$fdata[] = $row;
		}

		return $fdata;
	}

	/**
	* Board Upload Files Select & Download TAGS, Images TAGS
	*
	* @param interger $bidx
	* @return array $downlink(다운로드), $imgtags(이미지)
	*/
	private function getShowFiles($bdidx)
	{
		$fdata = self::_get_upload_files($bdidx);
		if(is_array($fdata) && count($fdata) > 0)
		{
			for($f=0; $f < count($fdata); $f++)
			{
				if($this->vars['bdown'])
					$downlink[] = sprintf("%s <a href=\"/common/download.php?path=board/%s&file=%s&org=%s\">%s</a> (%s)", _get_file_icon($fdata[$f]['upfile']), $this->vars['code'], $fdata[$f]['upfile'], $fdata[$f]['upreal'], $fdata[$f]['upreal'], _get_file_size($fdata[$f]['fsize']));

				if(!$this->vars['imglist'] && !strcmp($fdata[$f]['ftype'], "image"))
					$imgtags[] = sprintf("<div style=\"text-align:center;margin-top:10px;\"><a href=\"javascript:void(window.open('/common/image.zoom.php?path=board/%s&img=%s', 'zoom', 'width=100, height=100, left=0, top=0'));\">%s</a></div>", $this->vars['code'], $fdata[$f]['upfile'], _get_image_resize('../../upload/board/'.$this->vars['code'], $fdata[$f]['upfile'], $this->vars['imgmw']));
			}

			return array(
							"downlink"	=> $downlink,
							"imgtags"	=> $imgtags
						);
		}
	}

	/**
	* Board List Paging
	*/
	public function getPaging()
	{
		if($this->is_admin === TRUE)
			return self::set_adm_page();
		else
			return self::set_user_page();
	}

	private function set_adm_page()
	{
		global $skey, $sstr, $sday, $eday, $pgnum;
		require_once(dirname(__FILE__)."/./class.page.php");

		$pgLimit = ($pgnum) ? $pgnum : $this->vars['limitcnt'];
		$pgBlock = 10;
		$start = ($this->start) ? $this->start : 0;
		$param['skey'] = ($sstr) ? $skey : "";
		$param['sstr'] = $sstr;
		$param['code'] = $this->code;
		$param['sday'] = $sday;
		$param['eday'] = $eday;
		$param['cate'] = $cate;

		$pg = new getPage($start, $pgLimit, $pgBlock, $this->numrows, $param);
		$encData = self::_get_base64_encode($pg->getparm);

		return $pg->page_return;
	}

	private function set_user_page()
	{
		global $skey, $sstr, $sday, $eday, $pgnum;
		require_once(dirname(__FILE__)."/./class.PagingHandler.php");

		$pgLimit = ($pgnum) ? $pgnum : $this->vars['limitcnt'];
		$pgBlock = 10;
		$start = ($this->start) ? $this->start : 0;
		$param['skey'] = ($sstr) ? $skey : "";
		$param['sstr'] = $sstr;
		$param['code'] = $this->code;
		$param['sday'] = $sday;
		$param['eday'] = $eday;
		$param['cate'] = $cate;

		$pg = new PagingHandler($start, $pgLimit, $pgBlock, $this->numrows, $param);
		$encData = self::_get_base64_encode($pg->getparm);

		return $pg->_get_paging();
	}

	/**
	* Board 해당게시물 정보
	*
	* @param interger $idx
	* @return array $data
	*/
	public function _get_board_data($idx)
	{
		if($idx)
		{
			$sqry = sprintf("select * from %s where code='%s' and idx='%s' order by idx desc limit 1", SW_BOARD, $this->code, $idx);
			return parent::_fetch($sqry, 1);
		}
		else
			return;
	}

	/**
	* Board hit plus
	*/
	private function setHitPlus($idx)
	{
		if(!_get_session("SES_BD_".$idx))
		{
			$usqry = sprintf("update %s set hit=hit+1 where idx='%d'", SW_BOARD, $idx);
			if(parent::_execute($usqry))
				_set_session("SES_BD_".$idx, true);
		}
	}

	/**
	* Board WebEditor(cheditor)
	*
	* @param string $id, $w, $h
	*/
	public function _webeditor($id, $w="100%", $h="300px")
	{
		if($this->vars['beditor'])
		{
			$webeditor =<<< EDITOR
				<script type="text/javascript">
				var {$id} = new cheditor();				// 에디터 개체를 생성합니다.
				{$id}.config.editorHeight = '{$h}';		// 에디터 세로폭입니다.
				{$id}.config.editorWidth = '{$w}';		// 에디터 가로폭입니다.
				{$id}.inputForm = 'content';			// textarea의 ID 이름입니다.
				{$id}.run();                            // 에디터를 실행합니다.
				</script>
EDITOR;
			return $webeditor;
		}
	}

	/**
	* board button set
	*/
	public function _set_button($act, $data="")
	{
		global $encData;

		switch($act)
		{
			case "list" :
				if($this->vars['lvw'] > 0)		// 쓰기권한이 회원이상일 경우 //
				{
					if(_is_login() && $this->vars['lvw'] <= $_SESSION['SES_USERLV'])
						$button['write'] = "<div class=\"btn_R_Area\"><a href=\"?act=write\" class=\"hy_Btn write\">글쓰기</a></div>";
				}
				else	// 비회원부터 가능 //
					$button['write'] = "<div class=\"btn_R_Area\"><a href=\"?act=write\" class=\"hy_Btn write\">글쓰기</a></div>";
			break;
			case "view" :
				$button['list'] = sprintf("<a href=\"?encData=%s\" class=\"hy_Btn list\">목록</a>", $encData);

				if($this->vars['lvw'] > 0)	// 글쓰기가 회원이상일 경우 //
				{
					if(_is_login() && !strcmp($_SESSION['SES_USERID'], $data['userid']))
					{
						$button['edit'] = sprintf("<a href=\"%s?act=edit&encData=%s\" class=\"hy_Btn edit\">수정</a>", (($this->is_mobile) ? $this->vars['path_mobile'] : $this->vars['path']), $encData);
						$button['del'] = sprintf("<a href=\"javascript:void(0);\" class=\"hy_Btn delete\" data-action=\"del\">삭제</a>", $encData);
					}
					else
					{
						//$button['edit'] = "<a href=\"javascript:alert('본인이 작성한 게시물만 수정가능합니다.');\" class=\"hy_Btn edit\">수정</a>";
						//$button['del'] = "<a href=\"javascript:alert('본인이 작성한 게시물만 삭제가능합니다.');\" class=\"hy_Btn delete\">삭제</a>";
					}
				}
				else						// 비회원인 경우 //
				{
					if($data['isadm'] == 1)
					{
						$button['edit'] = "<a href=\"javascript:alert('본인작성글만 수정 하실수 있습니다.');\" class=\"hy_Btn edit\">수정</a>";
						$button['del'] = "<a href=\"javascript:alert('본인작성글만 삭제 하실수 있습니다.');\" class=\"hy_Btn delete\">삭제</a>";
					}
					else
					{
						if(_is_login() && !strcmp($_SESSION['SES_USERID'], $data['userid']))
						{
							$button['edit'] = sprintf("<a href=\"%s?act=edit&encData=%s\" class=\"hy_Btn edit\">수정</a>", (($this->is_mobile) ? $this->vars['path_mobile'] : $this->vars['path']), $encData);
							$button['del'] = sprintf("<a href=\"javascript:void(0);\" class=\"hy_Btn delete\" data-action=\"del\">삭제</a>", $encData);
						}
						else
						{
							$button['edit'] = sprintf("<a href=\"javascript:LayerPopup.iframe(400, 220, '%s/board/check.passform.php?mode=edit&code=%s&encData=%s');\" class=\"hy_Btn edit\">수정</a>", $this->bd_path, $this->vars['code'], $encData);
							$button['del'] = sprintf("<a href=\"javascript:LayerPopup.iframe(400, 220, '%s/board/check.passform.php?mode=del&code=%s&encData=%s');\" class=\"hy_Btn delete\">삭제</a>", $this->bd_path, $this->vars['code'], $encData);
						}
					}
				}

				if($this->vars['lvw'] > 0)		// 쓰기권한이 회원이상일 경우 //
				{
					if(_is_login() && $this->vars['lvw'] <= $_SESSION['SES_USERLV'])
						$button['write'] = "<a href=\"?act=write\" class=\"hy_Btn write\">글쓰기</a>";
				}
				else	// 비회원부터 가능 //
					$button['write'] = "<a href=\"?act=write\" class=\"hy_Btn write\">글쓰기</a>";

			break;
		}

		return $button;
	}

	/**
	* Thumbnail Board Linespacing
	*
	* @param : $cnt(현재출력번호), $tcol(열여백태그), $trow(행여백태그)
	* @return : none
	*/
	public function setLinespacing($cnt, $tcol="", $trow="")
	{
		print($this->vars['limgcnt']);
		if(!($cnt%$this->vars['limgcnt']))
			printf("</tr>%s<tr>", $trow);
		else if($tcol);
			echo($tcol);
	}

	/**
	* Thumbnail Board Empty TD
	*/
	public function setEmptyTags($tcol="")
	{
		if($this->numrows > 0 && ($this->numrows%$this->vars['limgcnt']) > 0)
		{
			$tdCnt = $this->vars['limgcnt'] - ($this->numrows%$this->vars['limgcnt']);
			for($e=1; $e <= $tdCnt; $e++)
			{
				echo("<td>&nbsp;</td>");
				if($tcol && $tdCnt > $e)
					echo($tcol);
			}
		}
	}

	/**
	* Board Parameter Base64 Decode OR Encode
	*
	* @param string $encData
	* @return array $encArr
	*/
	private function _get_base64_decode(&$encArr, $encData)
	{
		if(!empty($encData))
			$encArr = _get_decode64($encData);
		else
			$encArr = "";
	}

	private function _get_base64_encode($str)
	{
		return _get_encode64($str);
	}
}
?>
