<?
//=======================================================================================
// File Name	:	class.board.php
// Author		:	kkang(sinbiweb)
// Update		:	2012-04-26 => 2014-03-10
// Description	:	Board Handler Class
//=======================================================================================

class Board
{
	var $code;
	var $info = array();

	function Board($code)
	{
		if(!$code) msg("게시판이 설정되지 않았습니다.", -1, true);

		$this->code = $code;
		$this->getBoard();
	}

	function getBoard()
	{
		global $db;

		$sqry = sprintf("select * from sw_board_cnf where code='%s' limit 1", $this->code);
		$this->info = $db->_fetch($sqry);
	}

	function getCommentCnt($bidx)
	{
		global $db;

		$sqry = sprintf("select * from sw_comment where code='%s' AND bidx='%d'", $this->code, $bidx);
		$db->_affected($cnt, $sqry);

		if($this->info['bCom'] && $cnt > 0)
			return "[".number_format($cnt)."]";
	}

	function getCommentData($bidx)
	{
		global $db;

		$sqry = sprintf("select * from sw_comment where code='%s' && bidx=%d order by idx desc", $this->code, $bidx);
		$qry = $db->_execute($sqry);

		while($row=mysql_fetch_array($qry))
			$cdata[] = $row;

		return $cdata;
	}

	function getBoardLevel($level)
	{
		if(isMobile())
			$icon = ($level > 0) ? sprintf("<div style=\"padding-left:%dpx;float:left;\"><img src=\"/image/icon/icon_answer.gif\" alt=\"답변글\" /></div>&nbsp;", $level*5) : "";
		else
			$icon = ($level > 0) ? sprintf("<img src=\"/image/icon/level.gif\" width=\"%s\" class=\"noline\" alt=\"\" /><img src=\"/image/icon/icon_answer.gif\" alt=\"답변글\" /> ", $level*5) : "";

		return $icon;
	}

	function getBoardLock($lock)
	{
		$icon = ($lock == 'Y') ? "<img src=\"/image/icon/icon_lock.gif\" alt=\"비밀글\" />" : "";

		return $icon;
	}

	function getIconNew($regdt)
	{
		//$mkToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$mkToday = strtotime(date('Ymd'));
		$mkRegdt = strtotime(substr(str_replace("-", "", $regdt),0,8));
		$diff_time = $mkToday - $mkRegdt;
		$limit_time = 86400 * $this->info['period'];

		if($diff_time <= $limit_time)
			$icon_new = "<img src=\"/img/icon/new.png\" style=\"vertical-align:middle;\" alt=\"new\" />";
		else
			$icon_new = "";

		return $icon_new;
	}

	/// 사용안됨 --- kkang(2014-03-10) 삭제처리 ///
	function getCommentForm()
	{
		global $encData;

		$encArr = getDecode64($encData);

		if(preg_match("/sadm/i", dirname($_SERVER['SCRIPT_NAME'])) && $this->info['bCom'])
			include_once("./board.reply.php");
		else
			include_once(dirname(__FILE__)."/../board/board.reply.php");
	}

	function getFileData($bidx)
	{
		global $db;

		$sqry = sprintf("select * from sw_boardfile where code='%s' && bidx=%d order by idx asc", $this->code, $bidx);
		$qry = $db->_execute($sqry);

		while($row=mysql_fetch_array($qry))
		{
			$row['downlink'] = sprintf("%s <a href=\"/board/download.php?file=%s&org=%s\">%s</a> (%s)", FileTypeImg($row['upfile']), $row['upfile'], $row['upreal'], $row['upreal'], getFileSize($row['fsize']));

			if(!strcmp($row['ftype'], "image"))
			{
				if(preg_match("/sadm/i", dirname($_SERVER['SCRIPT_NAME'])))
					$row['imgtag'] = sprintf("<div style=\"text-align:center;margin-top:10px;\">%s</div>", getImgResize('../../upload/board', $row['upfile'], '550'));
				else
					$row['imgtag'] = sprintf("<div style=\"text-align:center;margin-top:10px;\">%s</div>", getImgResize('../upload/board', $row['upfile'], '800'));
			}

			$fdata[] = $row;
		}

		return $fdata;
	}

	function getFileOneData($bidx, $ftype="image")
	{
		global $db;

		if(!strcmp($ftype, "image"))
			$sqry = sprintf("select upfile from sw_boardfile where bidx='%d' and ftype='image' order by idx asc limit 1", $bidx);
		else
			$sqry = sprintf("select upfile from sw_boardfile where bidx='%d' and ftype <> 'image' order by idx asc limit 1", $bidx);

		$row = $db->_fetch($sqry, 1);
		return $row['upfile'];
	}

	function getCateArr()
	{
		if($this->info['bcate'])
			return explode("|", $this->info['scate']);
	}

	function getCateView($cate='')
	{
		if($this->info['bcate'] && $cate)
			return sprintf("<font color='#663300'>[%s]</font>", $cate);
	}

	function getDecodeArr(&$encArr, $encData="")
	{
		if(!empty($encData))
			$encArr = getDecode64($encData);
		else
			$encArr = "";
	}

	function getButton($act)
	{
		global $arr_auth, $encData;

		switch($act)
		{
			case "list":
				if($this->info[wAct] > 0)
				{
					if(isLogin() && $this->info[wAct] <= $_SESSION['SES_USERLV'])
					{
						if($this->info[code] == "1457673779")
						{
							//견적신청
							$btn = "<a href=\"?act=write&amp;code=".$this->info[code]."\" class=\"yellow inputbtn big btnright\"><span class=\"lt\"></span><span class=\"ce\">견적신청하기</span><span class=\"rt\"></span></a>";
						}
						else
						{
							$btn = "<a href=\"?act=write&amp;code=".$this->info[code]."\" class=\"btn_made black write\"><span class=\"lt\"></span><span class=\"ce\">1:1 고객문의 작성하기</span><span class=\"rt\"></span></a>";
						}
					}
				}
				else
				{
					if($this->info[code] == "1457673779")
					{
						//견적신청
						$btn = "<a href=\"?act=write&amp;code=".$this->info[code]."\" class=\"yellow inputbtn big btnright\"><span class=\"lt\"></span><span class=\"ce\">견적신청하기</span><span class=\"rt\"></span></a>";
					}
					else
					{
						//1:1문의
						$btn = "<a href=\"?act=write&amp;code=".$this->info[code]."\" class=\"btn_made black write\"><span class=\"lt\"></span><span class=\"ce\">1:1 고객문의 작성하기</span><span class=\"rt\"></span></a>";
					}
				}
			break;
			case "view":

				$data = $this->getBoardData($encData);
				if($this->info[wAct] > 0)
				{

					if(isLogin() && !strcmp($_SESSION['SES_USERID'], $data['userid']))
					{
						$btn .= "<a href=\"javascript:Common.layerPassForm('edit', '".$this->info[code]."', '".$encData."');\"   class=\"btn_Notice_Type edit\"  value=\"수정\">수정</a>&nbsp;";
						$btn .= "<a href=\"javascript:Common.layerPassForm('del', '".$this->info[code]."', '".$encData."');\"   class=\"btn_Notice_Type del\"  value=\"삭제\">삭제</a>&nbsp;";

					}
				}
				else
				{
						$btn .= "<a href=\"?act=edit&amp;encData=".$encData.";\"   class=\"btn_Notice_Type edit\"  value=\"수정\">수정</a>&nbsp;";
						$btn .= "<a href=\"javascript:Del()\"   class=\"btn_Notice_Type del\"  value=\"삭제\">삭제</a>&nbsp;";

				}

				if(!strcmp($data['notice'], "Y")) unset($btn);

			break;
		}

		return $btn;
	}

	function getLink($encData)
	{
		if(preg_match("/sadm/i", dirname($_SERVER['SCRIPT_NAME'])))
			$link = sprintf("./board.view.php?code=%s&amp;encData=%s", $this->code, $encData);
		else
		{
			$data = $this->getBoardData($encData);

			if($this->info['rAct'] > 0)
			{
				if(isLogin() && $this->info['rAct'] <= $_SESSION['SES_USERLV'])
				{
					if(!strcmp($data['bLock'], "Y") && strcmp($data['lockid'], $_SESSION['SES_USERID']))
						$link = "javascript:alert('비공개 게시물입니다.');";
					else if(!strcmp($data['bLock'], "Y") && !strcmp($data['lockid'], $_SESSION['SES_USERID']))
						$link = "?act=view&amp;encData=".$encData;
					else
						$link = "?act=view&amp;encData=".$encData;
				}
				else
					$link = "javascript:alert('읽기 권한이 없습니다.');";
			}
			else
			{
				if($this->info['wAct'] > 0 && !strcmp($data['bLock'], "Y"))
				{
					if(!strcmp($data['lockid'], $_SESSION['SES_USERID']))
						$link = "?act=view&amp;encData=".$encData;
					else
						$link = "javascript:alert('비공개 게시물입니다.');";
				}
				else
				{
					if(!strcmp($data['bLock'], "Y"))
					{
						if(isMobile())
							$link = "javascript:Common.layerMobilePassForm('lock', '{$this->info[code]}', '{$encData}');";
						else
							$link = "javascript:Common.layerPassForm('lock', '{$this->info[code]}', '{$encData}');";
					}
					else
						$link = "?act=view&amp;encData=".$encData;
				}
			}
		}

		return $link;
	}

	function getBoardData($encData)
	{
		global $db;

		$encArr = getDecode64($encData);

		if($encArr['idx'])
		{
			$sqry = sprintf("select * from sw_board where idx=%d", $encArr['idx']);
			return$db->_fetch($sqry);
		}
	}

	function _act(&$adata, $act, $encData='')
	{
		global $db;

		$this->getDecodeArr($encArr, $encData);

		switch($act)
		{
			case "edit" :
				$row['file'] = $this->getFileData($encArr['idx']);
			break;
			case "del" :

				$sqry = sprintf("select ref from sw_board where idx=%d", $encArr['idx']);
				$row = $db->_fetch($sqry);

				/// 관련답변글 목록 ///
				$rsqry = sprintf("select idx from sw_board where ref=%d and re_level > 0 and idx <> %d order by idx desc", $row['ref'], $encArr['idx']);
				$rqry = $db->_execute($rsqry);
				while($rrow = mysql_fetch_array($rqry))
					$rdata[] = $rrow[0];

				$row['reply'] = $rdata;
				$row['file'] = $this->getFileData($encArr['idx']);
			break;
			case "write" :
				if($encArr['idx'])
				{
					$sqry = sprintf("select ref, re_level, re_step, lockid from sw_board where idx=%d", $encArr['idx']);
					$row = $db->_fetch($sqry);

					if($row)
						$db->_execute("update sw_board set re_step=re_step+1 where ref=".$row['ref']." and re_step > ".$row['re_step']);

					$row['re_level']++;
					$row['re_step']++;
				}
				else
				{
					$max_ref = $db->_fetch("select max(ref) from sw_board");
					$row['ref'] = $max_ref[0]+1;
					$row['re_level'] = $row['re_step'] = 0;
					$row['lockid'] = $_SESSION['SES_USERID'];
				}
			break;
		}

		$adata = $row;
	}

	function _write(&$wdata, $encData="", $mode="")
	{
		global $db;

		if(!strcmp($mode, "edit") && !$encData)
			msg("게시판 정보가 올바르지 않습니다.", -1, true);

		$this->getDecodeArr($encArr, $encData);

		if($encArr['idx'])
		{
			if(!strcmp($mode, 'edit'))	/// 수정시
			{
				$sqry = sprintf("select * from sw_board where idx='%d'", $encArr['idx']);
				$row = $db->_fetch($sqry, 1);
				$row['file'] = $this->getFileData($row['idx']);
			}
			else	/// 답변시
			{
				$sqry = sprintf("select idx, userid, pwd, ref, re_level, re_step, title, bLock, cate, content from sw_board where idx='%d'", $encArr['idx']);
				$row = $db->_fetch($sqry, 1);

				if($row['title'])
					$row['re_title'] = sprintf("RE] %s", htmlspecialchars($row['title']));

				if($row['content'])
					$row['re_content'] = sprintf("<br><br>--------------------------------- [ 원 본 글 ] -------------------------------<br>%s", $row['content']);

				$row['re_level']++;
				$row['re_step']++;
			}
		}
		else
		{
			list($max) = $db->_fetch("select max(ref) from sw_board");
			$row['ref'] = $max+1;
			$row['re_level'] = $row['re_step'] = 0;
		}

		$wdata = $row;

		if($this->info['bsecret'] == 1)			///무조건비밀글
			$wdata['secret_tag'] = "<input type=\"hidden\" name=\"bLock\" value=\"Y\" />";
		else if($this->info['bsecret'] == 2)	///기본일반글
		{
			if(!strcmp($mode, "edit"))
				$wdata['secret_tag'] = sprintf("<input type=\"checkbox\" name=\"bLock\" value=\"Y\" %s /> 비밀글", (($row['bLock'] == "Y") ? "checked=\"checked\"" : ""));
			else if($encData && !strcmp($row['bLock'], "Y"))
				$wdata['secret_tag'] = "<input type=\"hidden\" name=\"bLock\" value=\"Y\" />";
			else
				$wdata['secret_tag'] = "<input type=\"checkbox\" name=\"bLock\" value=\"Y\" /> 비밀글";
		}
		else if($this->info['bsecret'] == 3)	///기본비밀글
		{
			if(!strcmp($mode, "edit"))
				$wdata['secret_tag'] = sprintf("<input type=\"checkbox\" name=\"bLock\" value=\"Y\" %s /> 비밀글", (($row['bLock'] == "Y") ? "checked=\"checked\"" : ""));
			else if($encData && !strcmp($row['bLock'], "Y"))
				$wdata['secret_tag'] = "<input type=\"hidden\" name=\"bLock\" value=\"Y\" />";
			else
				$wdata['secret_tag'] = "<input type=\"checkbox\" name=\"bLock\" value=\"Y\" checked=\"checked\" /> 비밀글";
		}
		else									///무조건일반글
			$wdata['secret_tag'] = "<input type=\"hidden\" name=\"bLock\" value=\"N\" />";

		if($this->info['bcate'] && $this->info['scate'])
		{
			$exCate = $this->getCateArr();
			$wdata['acate'] = $exCate;
			$arr_cate = array();

			if($this->info['tcate'] == 1)
			{
				$arr_cate[] = "<option value=\"\">분류선택</option>";
				foreach($exCate as $v)
				{
					if($v)
						$arr_cate[] = sprintf("<option value='%s' %s>%s</option>", $v, (($wdata['cate'] == $v) ? "selected=\"selected\"" : ""), $v);
				}

				$tags = sprintf("<select name=\"cate\" exp=\"분류를\" style=\"border:1px solid #ddd;padding:5px 10px\">%s</select>", implode("", $arr_cate));
			}
			else if($this->info['tcate'] == 2)
			{
				$i=0;
				foreach($exCate as $v)
				{
					if($v)
					{
						if(!$wdata['cate'])
						{
							if($i == 0)
								$arr_cate[] = sprintf("<label><input type=\"radio\" class=\"ace\" name=\"cate\" value=\"%s\" id=\"cate_%s\"  checked=\"checked\"><span class=\"lbl\"> %s</span></label>", $v, $i,   $v);
							else
								$arr_cate[] = sprintf("<label><input type=\"radio\" class=\"ace\" name=\"cate\" value=\"%s\" %s  id=\"cate_%s\"/> <span class=\"lbl\">%s</span></label>", $v, (($wdata['cate'] == $v) ? "checked=\"checked\"" : ""),$i,  $v);
						}
						else
							$arr_cate[] = sprintf("<input type=\"radio\" name=\"cate\" class=\"ace\" value=\"%s\" %s id=\"cate_%s\" /> <span class=\"lbl\"> %s</span></label>", $v, (($wdata['cate'] == $v) ? "checked=\"checked\"" : ""), $i,  $v);
					}

					$i++;
				}

				$tags = sprintf("%s", implode("&nbsp;&nbsp;&nbsp;&nbsp;", $arr_cate));
			}

			$wdata['cate_tags'] = $tags;
		}
	}

	function _webeditor($id, $w="100%", $h="300px")
	{
		if($this->info['beditor'])
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

	function _view(&$vdata, $encData)
	{
		global $db;

		if($encData)
			$this->getDecodeArr($encArr, $encData);
		else
			msg("게시판 정보가 올바르지 않습니다.", -1, true);

		$sqry = sprintf("select * from %s where idx=%d", SW_BOARD, $encArr['idx']);
		$row = $db->_fetch($sqry);

		if(!$this->info['beditor'])
			$row['content'] = nl2br($row['content']);
		else
			$row['content'] = preg_replace("/(\<img )([^\>]*)(\>)/i", "\\1 alt=\"\" name=\"objImage[]\" \\2 \\3", $row['content']);

		$row['reply'] = $this->getCommentData($row['idx']);

		if(!$this->info['lsimg'])
			$row['file'] = $this->getFileData($row['idx']);

		if(!strcmp($row['notice'], "Y"))
			$row['icon_notice'] = "<img src=\"/img/icon/notice _bt.png\" class=\"middle\" alt=\"공지사항\" /> ";

		if($this->info['vtype'] == 1)		/// 내용 + 관련글(이전글,다음글) ///
		{
			$wArr = array();

			if($encArr['skey'] && $encArr['sstr'])
				$wArr[] = $encArr['skey']." like '%".$encArr['sstr']."%'";
			else if($encArr['sstr'])
				$wArr[] = "title like '%".$encArr['sstr']."%' || content like '%".$encArr['sstr']."%'";

			if($wArr)
				$AddW = sprintf(" AND (%s)", implode(" AND ", $wArr));

			list($pre_idx, $pre_title) = $db->_fetch("select idx, title from sw_board where code='".$this->info['code']."' and idx < ".$encArr['idx']." ".$AddW." order by idx desc limit 1");
			list($nex_idx, $nex_title) = $db->_fetch("select idx, title from sw_board where code='".$this->info['code']."' and idx > ".$encArr['idx']." ".$AddW." order by idx asc limit 1");

			$row['prev']['idx'] = $pre_idx;
			$row['prev']['title'] = $pre_title;
			$row['next']['idx'] = $nex_idx;
			$row['next']['title'] = $nex_title;
		}
		else if($this->info['vtype'] == 2)	/// 내용 + 리스트 ///
		{

			/// 추후 작업예정 ///
		}

		$vdata = $row;
	}

	function _list()
	{
		global $db, $param, $start, $numrows, $nnumrows, $pgLimit, $pgBlock, $encData, $skey, $sstr, $sday, $eday;
		$i = 1;

		$lData = array();

		if($encData)
		{
			$encArr = getDecode64($encData);

			foreach($encArr as $k=>$v)
				${$k} = urldecode($v);
		}

		if($skey && $sstr)
			$wArr[] = "$skey like '%$sstr%'";

		if($sday && $eday)
			$wArr[] = "(regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
		else if($sday)
			$wArr[] = "regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
		else if($eday)
			$wArr[] = "regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";

		if($wArr)
			$AddW = sprintf(" && %s", implode(" && ", $wArr));

		$nsqry = sprintf("select * from sw_board where code='%s' && notice='Y' %s order by ref desc", $this->code, $AddW);
		$db->_affected($nnumrows, $nsqry);
		$nqry = $db->_execute($nsqry);

		for($i=$i; $nrow = mysql_fetch_array($nqry); $i++)
		{
			$fsqry = sprintf("select * from sw_boardfile where code='%s' && bidx='%d' order by idx asc", $this->code, $nrow['idx']);
			$fqry = $db->_execute($fsqry);
			while($frow = mysql_fetch_array($fqry))
				$lData['file'][$nrow['idx']][] = $frow;

			$nrow['no'] = $i;
			$lData['notice'][] = $nrow;
		}

		$sqry = sprintf("select * from sw_board where code='%s' AND notice <> 'Y'  %s", $this->code, $AddW);
		$db->_affected($numrows, $sqry);
		$pgLimit = ($pg_num) ? $pg_num : 20;
		$pgBlock = 10;
		$start = ($start) ? $start : 0;
		$letter_no = $numrows - $start;

		$sqry .= sprintf(" order by ref desc, re_step asc limit %d, %d", $start, $pgLimit);
		$qry = $db->_execute($sqry);

		for($i=$i; $row=mysql_fetch_array($qry); $i++)
		{
			$fsqry = sprintf("select * from sw_boardfile where code='%s' && bidx='%d' order by idx asc", $this->code, $row['idx']);

			$fqry = $db->_execute($fsqry);
			while($frow = mysql_fetch_array($fqry))
				$lData['file'][$row['idx']][] = $frow;

			$row['letter_no'] = $letter_no;
			$row['no'] = $i;
			$lData['data'][] = $row;

			$letter_no--;
		}

		### Paging Parameter ###
		$param['skey'] = ($sstr) ? $skey : "";
		$param['sstr'] = $sstr;
		$param['code'] = $code;

		return $lData;
	}

	function setBoardAct($act, $encData='')
	{
		global $arr_auth, $db;

		switch($act)
		{
			case "list":
				if($this->info[lAct] > 0)
				{
					if(!isLogin())
						$this->BoardLoginChk($this->info[path]);
					else
					{
						if($_SESSION['SES_USERLV'] < $this->info[lAct])
							msgGoUrl("[".$arr_auth[$this->info[lAct]]."] 등급이상만 [".$this->info[name]."] 글목록을 보실수 있습니다.", "/");
					}
				}
			break;
			case "view":

				$data = $this->getBoardData($encData);

				if($this->info[rAct] > 0)
				{
					if(!isLogin())
						$this->BoardLoginChk($this->info[path]);
					else
					{
						if($_SESSION['SES_USERLV'] < $this->info[lAct])
							msg("[".$arr_auth[$this->info[rAct]]."] 등급이상만 [".$this->info[name]."] 글내용을 보실수 있습니다.", -1);
						else
							if(!strcmp($data['bLock'], "Y") && strcmp($data['lockid'], $_SESSION['SES_USERID']))
								msg("비공개 게시물입니다.", -1);
					}
				}
				else
				{
					if($this->info['wAct'] > 0 && !strcmp($data['bLock'], "Y"))
					{
						if(strcmp($data['lockid'], $_SESSION['SES_USERID']))
							msgGoUrl("비공개 게시물입니다.\\n\\n작성자 본인만 확인가능합니다.", $this->info[path]);
					}
					else
					{
						if(!strcmp($data['bLock'], "Y") && !$_COOKIE['LOCK_'.$data['idx']])
							msgGoUrl("비공개 게시물입니다.\\n\\n작성자 본인만 확인가능합니다.", $this->info[path]);
					}
				}

				$db->_execute("update sw_board set hit=hit+1 where idx='".$data['idx']."'");

			break;
			case "edit":

				$data = $this->getBoardData($encData);

				if($this->info[wAct] > 0)
				{
					if(!isLogin())
						$this->BoardLoginChk($this->info[path]);
					else
					{
						if(strcmp($data['userid'], $_SESSION['SES_USERID']))
							msg("본인이 작성한 게시물만 수정가능합니다.", -1, true);
					}
				}
				else
				{
					if(!$_COOKIE['LOCK_'.$data['idx']])
						msg("본인이 작성한 게시물만 수정가능합니다.", -1, true);
				}
			break;
			case "write":
				if($encData)
				{
					if($this->info[cAct] > 0)
					{
						if(!isLogin())
							$this->BoardLoginChk($this->info[path]);
						else
							if($encData && $_SESSION['SES_USERID'] < $this->info[cAct])
								msg("[".$arr_auth[$this->info[cAct]]."] 등급이상만 [".$this->info[name]."] 답변쓰기 권한이 있습니다.", -1);
					}
				}
				else
				{
					if($this->info[wAct] > 0)
					{
						if(!isLogin())
							$this->BoardLoginChk($this->info[path]);
						else
							if(!$encData && $_SESSION['SES_USERID'] < $this->info[wAct])
								msg("[".$arr_auth[$this->info[wAct]]."] 등급이상만 [".$this->info[name]."] 글쓰기 권한이 있습니다.", -1);
					}
				}
			break;
		}
	}

	function BoardLoginChk($referer, $encData='')
	{

print <<< SCRIPT

	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<form name="confrm" method="post">
	<input type="hidden" name="referer" value="{$referer}">
	<input type="hidden" name="code" value="{$this->code}">
	<input type="hidden" name="encData" value="{$encData}">
	</form>

	<script language="javascript">
	<!--
	if(confirm("회원로그인이 필요한 페이지 입니다. \\n\\n로그인 하시겠습니다."))
	{
		document.confrm.action = "/member/login.php#loginDiv";
		document.confrm.submit();
	}
	else
		history.go(-1);
	//-->
	</script>

SCRIPT;

	}

}
?>
