<?php
/**
* Sale Handler Class PHP7
*
* @Author		: seob
* @Update		: 2018-08-16
* @E-mail		: iosdeveloper3@kaka.com
* @Description	: Sale Handler Class --- 판매관리
*/
class SaleHandler extends MysqliHandler
{
	public $vars;
	public $status;
	public $item;
	private $is_admin = false;

	public function __construct()
	{
		$this->is_admin = (preg_match("/wooriyo-adm/i", dirname($_SERVER['SCRIPT_NAME'])) && $_SESSION['SES_ADM_ID']) ? true : false;
		parent::__construct();
	}

	public function __destruct()
	{
		//소멸자....
	}

	/**
	* 주문정보
	*/
	public function _get_order_vars($data)
	{
		if(is_numeric($data) === true)
			$sqry = sprintf("select * from %s where idx='%s'", SW_ORDER, $data);
		else
		{
			$encArr = _get_decode64($data);
			if($encArr['idx'])
				$sqry = sprintf("select * from %s where idx='%s'", SW_ORDER, $encArr['idx']);
		}

		$this->vars = parent::_fetch($sqry, 1);
		if($this->vars['ordcode'])
			self::_get_order_item($this->vars['ordcode'], "view");
	}

	/**
	* order item
	*/
	public function _get_order_item($ordcode, $type="")
	{
		$item =  $sitem = array();
		$totea = 0;
		$sqry = sprintf("select a.*, b.gcode, b.name, b.img3, b.category, b.glimit, b.blimit from %s a, %s b where a.gidx=b.idx and a.ordcode='%s'  order by a.idx asc", SW_ORDER_ITEM, SW_GOODS, $ordcode);
		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			if($row['gopt'])
			{
				$gopt = explode("」「", $row['gopt']);
				foreach($gopt as $vv)
				{
					$ex = explode("∏‡", $vv);
					$option = self::_get_goods_opt($row['gcode'], $ex[0]);
					if($option)
					{
						$row['stropt'][] = sprintf("%s : %s %s", $option['optnm'], $ex[1], (($ex[3] > 0) ? "(".$ex[2].number_format($ex[3]).")" : ""));
					}
				}
			}

			$totea += $row['gea'];
			$item[] = $row;
		}

		$goption = "";

		if(count($item) > 1)
			$gname = sprintf("%s 외 %d건", $item[0]['name'], count($item)-1);
		else if($item)
		{
			$gname = $item[0]['name'];
			$goption = ($item[0]['stropt']) ? $item[0]['stropt'] : "";
		}

		if(!$type)
			return array("gname"=>$gname, "img"=>$item[0]['img3'], "goption"=>$goption, "totea"=>$totea, "item"=>$item);
		else if(!strcmp($type, "view"))
			$this->item = $item;
		else if(!strcmp($type, "each"))
			return $sitem;
		else if(!strcmp($type, "gname"))
			return $gname;
		else
			return $item;
	}

	/**
	* get option information
	* @param : $optcd (옵션코드)
	*/
	public function _get_goods_opt($gcode, $optcd)
	{
		$sqry = sprintf("select optnm, optval, optmark, optpay from %s where gcode='%s' and optcd='%s' order by idx asc limit 1", SW_OPTION, $gcode, $optcd);
		return parent::_fetch($sqry, 1);
	}

	/**
	* order item stock check
	* @des : 주문상품 재고 체크
	*/
	public function _chk_order_stock()
	{
		$flag = true;
		foreach($this->item as $v)
		{
			if($v['blimit'] == 3)
			{
				$flag = false;
				break;
			}
			else if($v['blimit'] == 2 && $v['glimit'] < $v['gea'])
			{
				$flag = false;
				break;
			}
		}
		return $flag;
	}

	/**
	* 주문상태 변경 및 주문상태로그
	*/
	public function _set_order_status($status)
	{
		if($status == "101") $add_qry = ", payment='Y'";	// 결제완료시 주문테이블 결제완료 등록 //
		else $add_qry = "";

		$usqry = sprintf("update %s set status='%s' %s where idx='%d'", SW_ORDER, $status, $add_qry, $this->vars['idx']);
		switch($status)
		{
			case "101" :	// 결제완료 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('100') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "200" :	// 배송준비 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('100', '101') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "201" :	// 상품발송 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('100', '101', '200') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "202" :	// 상품수령 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('100', '101', '200', '201') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "300" :	// 주문취소요청 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('100', '101', '200') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "301" :	// 주문취소완료 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('100', '101', '200', '300') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "400" :	// 교환요청 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('202') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "401" :	// 교환완료 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('202', '400') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "500" :	// 환불(반품)요청 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('202') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "501" :	// 환불(반품)완료 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('202', '500') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
			case "900" :	// 구매완료 //
				$us = sprintf("update %s set status='%s', updt=now() where status in('101', '200', '201', '202') and ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);
			break;
		}

		if(parent::_execute($usqry))
		{
			if(parent::_execute($us))
			{
				self::_save_status_log($this->vars['ordcode'], $status);
				return true;
			}
		}
		else
			return false;
	}

	/**
	* 주문상태 로그 저장
	*/
	public function _save_status_log($ordcode, $status)
	{
		if($this->is_admin === true)
		{
			$isuser = 2;
			$userid = $_SESSION['SES_ADM_ID'];
		}
		else
		{
			$isuser = 1;
			$userid = (_is_login()) ? $_SESSION['SES_USERID'] : "";
		}

		$isqry = sprintf("insert into %s set
							ordcode	= '%s',
							status	= '%s',
							isuser	= '%d',
							userid	= '%s',
							updt	= now()", SW_ORDER_LOG, $ordcode, $status, $isuser, $userid);

		return parent::_execute($isqry);
	}

	/**
	* 주무상품 재고 차감(결제완료) 및 가산(주문취소완료 및 환불완료)
	*/
	public function _set_item_stock($mode='-')
	{
		$ok = $err = 0;
		foreach($this->item as $v)
		{
			if($v['blimit'] != 1)
			{
				if(!strcmp($mode, "+"))
					$usqry = sprintf("update %s set blimit=2, glimit=glimit+%d where idx='%d'", SW_GOODS, $v['gea'], $v['gidx']);
				else if(!strcmp($mode, "-"))
				{
					if($v['blimit'] == 2 && ($v['glimit'] > $v['gea']))
						$usqry = sprintf("update %s set glimit=glimit-%d where idx='%d'", SW_GOODS, $v['gea'], $v['gidx']);
					else if($v['blimit'] == 2)
						$usqry = sprintf("update %s set blimit=3, glimit=0 where idx='%d'", SW_GOODS, $v['gidx']);
				}

				if(parent::_execute($usqry))
					$ok++;
				else
					$err++;
			}
		}

		if($err < 1)
			return true;
		else
			return false;
	}

	/**
	* 주문 구매완료시 적립금 적립
	*/
	public function _set_order_cash()
	{
		// 적립금 지급 주문상태 //
		$ar_status_cash = array('100', '101', '200', '201', '202', '300', '400', '401', '500');
		$ar_cash = array();
		if($this->vars['userid'])
		{
			foreach($this->item as $v)
			{
				if(in_array($v['status'], $ar_status_cash) && $v['gpoint'] > 0)
					$ar_cash[] = $v['gpoint'];
			}

			if(is_array($ar_cash) && count($ar_cash) > 0)
			{
				$reason = (count($this->item) > 1) ? $this->item[0]['name']."외 ".(count($this->item)-1)."건 상품구매 적립" : $this->item[0]['name']." 상품구매 적립";
				$cash = array_sum($ar_cash);
				if($cash > 0)
					return _set_emoney_history($this->vars['userid'], $cash, 2, '+', $reason);
			}
		}
	}

	/**
	* 주문취소완료(301), 반품취소완료(501) 사용적립금 리워드 및 사용쿠폰 리워드
	*/
	public function _set_reward_cash()
	{
		$flag = true;
		if($this->vars['userid'])
		{
			if($this->vars['uemoney'] > 0)
			{
				$reason = sprintf("[%s] 주문취소(반품)로 사용적립금 재적립", $this->vars['ordcode']);
				$flag = _set_emoney_history($this->vars['userid'], $this->vars['uemoney'], 8, '+', $reason);
			}

			if($this->vars['ucoupon'] > 0)
			{
				$dsqry = "delete from sw_coupon_log where od_id = '".$this->vars['ordcode']."'";
				parent::_execute($dsqry);
			}
		}

		return $flag;
	}

	/**
	* 주문상품 재고 가감처리
	* @param : $mode(기본 차감(-) 아니면 가산(+)
	*/
	public function _set_order_stock($mode="-")
	{
		for($i=0; $i < count($this->item); $i++)
		{
			if(!strcmp($mode, "+"))
			{
				if($this->item[$i]['blimit'] != 1)
				{
					$usqry = sprintf("update %s set blimit=2, glimit=glimit + %d where idx='%d'", SW_GOODS, $this->item[$i]['gea'], $this->item[$i]['gidx']);
					parent::_execute($usqry);
				}
			}
			else
			{
				if($this->item[$i]['blimit'] == 2 && $this->item[$i]['glimit'] > $this->item[$i]['gea'])
				{
					$usqry = sprintf("update %s set glimit=glimit-%d where idx='%d'", SW_GOODS, $this->item[$i]['gea'], $this->item[$i]['gidx']);
					parent::_execute($usqry);
				}
				else if($this->item[$i]['blimit'] == 2)
				{
					$usqry = sprintf("update %s set blimit=3, glimit=0 where idx='%d'", SW_GOODS, $this->item[$i]['gidx']);
					parent::_execute($usqry);
				}
			}
		}
	}

	/**
	* 택배사 정보 가져오기
	*/
	public function _get_delivery(&$delivery, $type='')
	{
		$sqry = sprintf("select code, name, url from %s order by idx asc", SW_DELIVERY);
		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			if($type)
				$delivery[$row['code']] = $row;
			else
				$delivery[] = $row;
		}
	}

	/**
	* 주문정보 가져오기
	*/
	public function _get_order($data, $field="*")
	{
		if(is_array($data) && $data['ordcode'])
			$sqry = sprintf("select %s from %s where ordcode='%s'", $field, SW_ORDER, $data['ordcode']);
		else
		{
			if(is_numeric($data) === true)
				$sqry = sprintf("select %s from %s where idx='%s'", $field, SW_ORDER, $data);
			else
			{
				$encArr = _get_decode64($data);
				$sqry = sprintf("select %s from %s where idx='%s'", $field, SW_ORDER, $encArr['idx']);
			}
		}

		return parent::_fetch($sqry, 1);
	}

	/**
	* 개별주문상품 정보
	*/
	public function _get_item_info($idx)
	{
		$sqry = sprintf("select a.ordcode, b.name from %s a, %s b where a.gidx=b.idx and a.idx='%d'", SW_ORDER_ITEM, SW_GOODS, $idx);
		return parent::_fetch($sqry, 1);
	}

	/**
	* 주문상태별 주문상품명 --- sms 문자발송 목적
	*/
	public function _get_sms_gname($status)
	{
		$ar = array();
		$sqry = sprintf("select b.name from %s a, %s b where a.gidx=b.idx and a.ordcode='%s' and a.status='%s'", SW_ORDER_ITEM, SW_GOODS, $this->vars['ordcode'], $status);
		$qry = parent::_execute($sqry);
		while($row = mysqli_fetch_assoc($qry))
			$ar[] = $row['name'];

		if(count($ar) > 1)
			$gname = sprintf("%s 외 %d건", $ar[0], count($ar)-1);
		else
			$gname = $ar[0];

		return $gname;
	}

	/**
	* 사용자 개별(상품별) 주문상태 변경(주문취소요청, 교환요청, 반품(환불)요청)
	*/
	public function _set_status_item($data)
	{
		if($this->vars['ordcode'])
		{
			if(!strcmp($data, "receive"))
				$status = "202";
			else if(!strcmp($data, "cancel"))
				$status = "300";
			else if(!strcmp($data, "exchange"))
				$status = "400";
			else if(!strcmp($data, "refund"))
				$status = "500";
			else if(!strcmp($data, "ordok"))
				$status = "900";

			$usqry = sprintf("update %s set status='%s' where ordcode='%s'", SW_ORDER_ITEM, $status, $this->vars['ordcode']);

			if(parent::_execute($usqry))
			{
				$usqry2 = sprintf("update %s set status='%s' where ordcode='%s'", SW_ORDER, $status, $this->vars['ordcode']);
				if(parent::_execute($usqry2))
				{
					self::_save_status_log($this->vars['ordcode'], $status);
					if($status == "900")
					{
						self::_set_order_cash();	// 구매완료시 주문상품 적립금 적립 //
						//self::_set_first_order();	// 구매완료시 첫구매 적립금 및 쿠폰발급 //
					}
					return true;
				}
				else
					return false;
			}
		}
		else
			return false;
	}

	/**
	* 사용자 일괄 주문상태변경
	*/
	public function _set_status_order($data)
	{
		$row = self::_get_order($data['encData'], 'ordcode');
		if($row)
		{
			if(!strcmp($data['act'], "s-cancel"))		// 선택일괄 주문취소요청 //
			{
				$status = "300";
				if(count($data['chk']) > 0)
				{
					$ok = $err = 0;
					for($i=0; $i < count($data['chk']); $i++)
					{
						if($data['chk'][$i])
						{
							$usqry = sprintf("update %s set status='300' where ordcode='%s' and idx='%d'", SW_ORDER_ITEM, $row['ordcode'], $data['chk'][$i]);
							if(parent::_execute($usqry))
								$ok++;
							else
								$err++;
						}
					}

					$ord = self::_get_status_count($row['ordcode']);
					if($ord['itemcnt'] == $ord['status'][$status])
						$u2 = sprintf("update %s set status='%s' where ordcode='%s'", SW_ORDER, $status, $row['ordcode']);
					else
						$u2 = sprintf("update %s set sstatus='%s' where ordcode='%s'", SW_ORDER, $status, $row['ordcode']);

					return parent::_execute($u2);
				}
			}
			else if(!strcmp($data['act'], "s-refund"))	// 선택일괄 환불요청 //
			{
				$status = "500";
				if(count($data['chk']) > 0)
				{
					$ok = $err = 0;
					for($i=0; $i < count($data['chk']); $i++)
					{
						if($data['chk'][$i])
						{
							$usqry = sprintf("update %s set status='500' where ordcode='%s' and idx='%d'", SW_ORDER_ITEM, $row['ordcode'], $data['chk'][$i]);
							if(parent::_execute($usqry))
								$ok++;
							else
								$err++;
						}
					}

					$ord = self::_get_status_count($row['ordcode']);
					if($ord['itemcnt'] == $ord['status'][$status])
						$u2 = sprintf("update %s set status='%s' where ordcode='%s'", SW_ORDER, $status, $row['ordcode']);
					else
						$u2 = sprintf("update %s set sstatus='%s' where ordcode='%s'", SW_ORDER, $status, $row['ordcode']);

					return parent::_execute($u2);
				}
			}
			else if(!strcmp($data['act'], "receive"))	// 일괄상품 수령 //
			{
				$status = "202";
				$usqry = sprintf("update %s set status='202' where ordcode='%s' and status in ('201')", SW_ORDER_ITEM, $row['ordcode']);
				if(parent::_execute($usqry))
					$u2 = sprintf("update %s set status='%s' where ordcode='%s'", SW_ORDER, $status, $row['ordcode']);
				else
					return false;

			}
			else if(!strcmp($data['act'], "ordok"))		// 일괄상품 구매완료 //
			{
				$status = "900";
				$usqry = sprintf("update %s set status='900' where ordcode='%s' and status in ('201','202')", SW_ORDER_ITEM, $row['ordcode']);
				if(parent::_execute($usqry))
					$u2 = sprintf("update %s set status='%s' where ordcode='%s'", SW_ORDER, $status, $row['ordcode']);
				else
					return false;
			}

			if($u2 && $status)
			{
				if(parent::_execute($u2))
				{
					if($status == "900")
					{
						self::_set_order_cash();	// 구매완료시 주문상품 적립금 적립 //
						self::_set_first_order();	// 구매완료시 첫구매 적립금 및 쿠폰발급 //
					}

					return true;
				}
			}
			else
				return false;
		}
		else
			return false;
	}

	/**
	* 첫구매 감사적립금
	*/
	public function _set_first_order()
	{
		global $cfg;

		if($this->vars['userid'] && !strcmp($cfg['point']['fbuse'], "Y") && $cfg['point']['fcash'] > 0)
		{
			$sqry = sprintf("select a.idx from %s a, %s b where a.ordcode=b.ordcode and a.ordcode <> '%s' and b.userid='%s' and a.status='900'", SW_ORDER_ITEM, SW_ORDER, $this->vars['ordcode'], $this->vars['userid']);
			if(parent::isRecodeExists($sqry) === false)
			{
				// 첫구매 감사 적립금 //
				$reason = sprintf("첫구매 감사 적립금(%s원) 적립", number_format($cfg['point']['fcash']));
				$flag = _set_emoney_history($this->vars['userid'], $cfg['point']['fcash'], 5, '+', $reason);
			}
		}
	}

	/**
	* 사용자 주문버튼 활성 check
	*/
	public function _chk_status_act($mode)
	{
		global $ar_enable_status;

		$flag = false;
		foreach($this->status as $k=>$v)
		{
			if(!strcmp($mode, "cancel"))		// 취소요청
			{
				if(in_array($k, $ar_enable_status['300']) && $v > 0)
					$flag = true;
			}
			else if(!strcmp($mode, "receive"))	// 상품수령
			{
				if(in_array($k, $ar_enable_status['202']) && $v > 0)
					$flag = true;
			}
			else if(!strcmp($mode, "refund"))	// 환불(반품)
			{
				if(in_array($k, $ar_enable_status['500']) && $v > 0)
					$flag = true;
			}
			else if(!strcmp($mode, "ordok"))	// 구매완료
			{
				if(in_array($k, $ar_enable_status['900']) && $v > 0)
					$flag = true;
			}
		}

		return $flag;
	}

	/**
	*  관리자 주문취소, 환불(반품)완료, 결제완료시 결제금액 및 취소금액 업데이트
	*/
	public function _set_payment_update($ordcode)
	{
		$ar_status_ok = array("101", "200", "201", "202", "300", "400", "401", "500", "900");
		$ar_status_cancel = array("301", "501");
		$ord = self::_get_order(array("ordcode"=>$ordcode));
		$sss = self::_get_status_count($ordcode);
		$okamt = $ccamt = 0;

		//_debug($sss);

		foreach($sss['payment'] as $k=>$v)
		{
			if(in_array($k, $ar_status_ok))
				$okamt += $v;
			else if(in_array($k, $ar_status_cancel))
				$ccamt += $v;
		}

		// 배송비가 있을경우 배송비 포함 //
		if($okamt > 0 && $this->vars['dyamt'] > 0)
			$okamt += $this->vars['dyamt'];

		// 적립금사용 && 취소(환불)이 아닌 일반상품이 있을경우 적립금 차감 //
		if($okamt >0 && $sss['norcnt'] > 0 && $sss['norcnt'] > $sss['cancel_nor'])
			$okamt -= $this->vars['uemoney'];

		if($ccamt < 1)
			$usqry = sprintf("update %s set okamt='%d', ccamt='%d' where ordcode='%s'", SW_ORDER, $ord['amount'], $ccamt, $ordcode);
		else if($okamt < 1)
			$usqry = sprintf("update %s set okamt='%d', ccamt='%d' where ordcode='%s'", SW_ORDER, $okamt, $ord['amount'], $ordcode);
		else
			$usqry = sprintf("update %s set okamt='%d', ccamt='%d' where ordcode='%s'", SW_ORDER, $okamt, $ccamt, $ordcode);

		return parent::_execute($usqry);
	}

	/**
	* kcp 공통 통보 페이지의 주문건 검색
	* 주문코드 및 kcp 거래번호로 주문정보 검색
	*/
	public function _get_kcp_order($ordcode, $tno)
	{
		$sqry = sprintf("select * from %s where ordcode='%s' and tno='%s'", SW_ORDER, $ordcode, $tno);
		$this->vars = parent::_fetch($sqry, 1);
	}

	//=============================================================================================
	// 주문완료후 주문상태 처리에 대한 메소드
	//=============================================================================================
	/**
	* 일괄주문취소완료 및 환불(반품)완료시 재고PLUS, kcp결제취소, 사용쿠폰 리워드, 사용적립금 리워드
	*
	* @param : $idx(주문idx), $statu(변경처리할 주문상태)
	*/
	public function _set_order_cancel($idx, $status)
	{
		if($status == "301") $g_status = "300";			// 취소완료처리이면 요청상태인 주문건 가져옴
		else if($status == "501") $g_status = "500";	// 환불(반품)완료처리이면 요청상태인 주문건 가져옴

		$ord = self::_get_order($idx);
		$item = self::_get_order_item_inf($ord['ordcode'], $g_status);

		$cancel_amt = 0;	// 취소금액
		// 재고 및 사용쿠폰 리워드 //
		for($i=0; $i < count($item); $i++)
		{
			$usqry = sprintf("update %s set status='%s' where idx='%d'", SW_ORDER_ITEM, $status, $item[$i]['idx']);
			if(parent::_execute($usqry))
			{
				// 재고 가산 //
				$u2 = sprintf("update %s set stock=stock+1 where itemcd='%s'", SW_GOODS_ITEM, $item[$i]['itemcd']);
				if(parent::_execute($u2))
				{
					// 쿠폰을 사용했을경우 미사용처리 //
					if($item[$i]['coupon'])
						parent::_execute("update ".SW_COUPON_NUM." set ordcode='', usedt='', status=0 where cpnno='".$item[$i]['coupon']."'");
				}
			}

			$cancel_amt += $item[$i]['samt'];
		}

		// kcp 결제취소 처리 //
		if(!strcmp($ord['payment'], "Y") && (!strcmp($ord['payway'], "CARD") || !strcmp($ord['payway'], "BANK") || !strcmp($ord['payway'], "VCNT")))
		{
			require_once(dirname(__FILE__)."/../_kcp/cfg/site_conf_inc.php");
			require_once(dirname(__FILE__)."/../_kcp/sample/pp_cli_hub_lib.php");

			$c_PayPlus = new C_PP_CLI;
			$c_PayPlus->mf_clear();
			$tran_cd = "00200000";
			$cust_ip = getenv("REMOTE_ADDR"); // 요청 IP
			$mod_desc = ($status == 301) ? "주문취소" : "환불(반품)";

			if(($ord['amount'] - $ord['ccamt'] - $ord['dyamt']) > $cancel_amt)
				$mod_type = "STPC";		//부분취소
			else
				$mod_type = "STSC";		//전체취소

			$c_PayPlus->mf_set_modx_data( "tno",      $ord['tno']); // KCP 원거래 거래번호
			$c_PayPlus->mf_set_modx_data( "mod_type", $mod_type ); // 원거래 변경 요청 종류
			$c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip  ); // 변경 요청자 IP
			$c_PayPlus->mf_set_modx_data( "mod_desc", $mod_desc ); // 변경 사유

			if($mod_type == "STPC")
			{
				$mod_mny = $cancel_amt;		//취소금액
				$c_PayPlus->mf_set_modx_data( "mod_mny", $mod_mny);								// 취소요청금액
				$c_PayPlus->mf_set_modx_data( "rem_mny", ($ord['amount'] - $ord['ccamt']));		// 취소가능잔액
			}

			$c_PayPlus->mf_do_tx($trace_no, $g_conf_home_dir, $g_conf_site_cd, "", $tran_cd, "", $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ord['ordcode'], $cust_ip, "3" , 0, 0, $g_conf_key_dir, $g_conf_log_dir);
			$res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
			$res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
			$str_log = sprintf("주문코드:%s/취소구분:%s/취소금액:%s -- kcp결과코드:%s/결과메세지:%s", $ord['ordcode'], (($mod_type == "STPC") ? "부분취소" : "전체취소"), $cancel_amt, $res_cd, $res_msg);
			_mk_log_write($str_log, "cancel.log");
		}

		return true;
	}

	/**
	* 주문아이템 정보 가져오기
	* @param : $ordcode(주문코드), $status(주문상태인 주문상품정보만 없으면 전체를 가져옴)
	*/
	public function _get_order_item_inf($ordcode, $status='')
	{
		$item = array();
		if($status)
			$sqry = sprintf("select idx, itemcd, coupon, samt, status from %s where ordcode='%s' and status='%s'", SW_ORDER_ITEM, $ordcode, $status);
		else
			$sqry = sprintf("select idx, itemcd, coupon, samt, status from %s where ordcode='%s'", SW_ORDER_ITEM, $ordcode);

		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
			$item[] = $row;

		return $item;
	}
}
?>
