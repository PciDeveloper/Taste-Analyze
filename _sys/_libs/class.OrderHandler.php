<?php
/**
* Order Handler Class PHP5
*
* @Author		: seob
* @Update		:	2017-04-21
* @Description	:	Order Handler Class
*/

class OrderHandler extends MysqliHandler
{
	public $is_user		= 0;	// 회원여부
	public $step		= 0;	// 진행단계	(1:결제정보 입력(index.php), 2:결제정보확인(settle.php), 3:주문DB처리(order.act.php), 4:결제완료(success.php))
	public $ordcode		= "";	// 주문코드
	public $vars;				// 주문정보
	public $item;				// 구매 개별 아이템
	public $ar_item;
	public $is_direct	= false;	// 바로구매인 경우
	public $is_mobile	= false;	// 모바일여부
	public $path_m = "";			// 모바일 경로

	protected $arkeys = array("gidx", "opt", "ea");
	protected static $instance;

	/**
	* 생성자
	* @param array $params
	*/
	public function __construct($step=1, $ordcode="")
	{
		parent::__construct();
		$this->step			= $step;
		$this->is_user		= (_is_login()) ? 1 : 0;
		$this->is_direct	= ($_COOKIE['is_direct'] == true && $_COOKIE['direct']) ? true : false;
		if($ordcode) $this->ordcode = $ordcode;
		if(_is_dir_mobile() || _is_agent_mobile()) $this->is_mobile = true;
		$this->path_m = ($this->is_mobile === true) ? "/m" : "";

		if($this->step == 4 && $this->ordcode)
		{
			// 결제완료후 주문코드로 주문 정보 가져오기... //
		}
		else
			self::_get_order_tmp();
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* 임시저장 구매정보 가져오기
	*/
	protected function _get_order_tmp()
	{
		if($this->is_direct === true && $this->step == 1)
			$this->vars['goods'] = $_COOKIE['direct'];
		else
		{
			if($this->ordcode)
				$sqry = sprintf("select * from %s where ordcode='%s'", SW_ORDER_TMP, $this->ordcode);
			else if($this->is_user)
				$sqry = sprintf("select * from %s where isuser=1 and userid='%s'", SW_ORDER_TMP, $_SESSION['SES_USERID']);
			else
				$sqry = sprintf("select * from %s where isuser=0 and userid='%s'", SW_ORDER_TMP, $_SESSION['SES_TMP_USERID']);

			$this->vars = parent::_fetch($sqry, 1);
		}
		//_debug($_SESSION, true);
		//_debug($this->vars);

		if($this->vars['goods'])
		{
			$this->ar_item = unserialize(stripslashes(base64_decode($this->vars['goods'])));
			self::_get_order_item();

			if(count($this->item) > 1)
				$this->vars['goods_name'] = sprintf("%s 외 %d건", $this->item[0]['name'], count($this->item)-1);
			else
				$this->vars['goods_name'] = $this->item[0]['name'];
		}
		else
		{
			gourl($this->path_m."/goods/basket.php", "", "대단히 죄송합니다. 구매상품 정보가 올바르지 않습니다.");
			exit;
		}
	}

	/**
	* cart goods information
	* @return	: array $this->item
	*/
	public function _get_order_item()
	{
		global $cfg;

		if(!$this->ar_item) return;
		$letter_no = 0;
		foreach($this->ar_item as $k => $v)
		{
			$v =  array_combine($this->arkeys, $v);
			if($v['gidx'])
			{
				$letter_no++;
				$sqry = sprintf("select gcode, category, name, price, nprice, blimit, glimit, pointmod, point, boption, img3 from %s where idx='%d'", SW_GOODS, $v['gidx']);
				$goods = parent::_fetch($sqry, 1);
				$goods['letter_no'] = $letter_no;
				$optamt = 0;

				/// 선택옵션이 있을경우 ///
				if($v['opt'])
				{
					$gopt = explode("」「", $v['opt']);
					foreach($gopt as $vv)
					{
						$ex = explode("∏‡", $vv);
						$option = self::_get_goods_opt($goods['gcode'], $ex[0]);
						if($option)
						{
							$goods['stropt'][] = sprintf("<span class=\"size\">%s : %s %s</span>", $option['optnm'], $ex[1], (($ex[3] > 0) ? "(".$ex[2].number_format($ex[3]).")" : ""));
							if($ex[3] > 0)
							{
								if($ex[2] == "+")
									$optamt += ($ex[3] * $v['ea']);
								else
									$optamt -= ($ex[3] * $v['ea']);
							}
						}
					}
				}

				$goods['goptamt'] = $optamt;
				$goods['samt'] = ($goods['price'] * $v['ea']) + $optamt;
				/// 적립금 설정 ///
				if($goods['pointmod'] == 1)
					$goods['gpoint'] = $goods['samt'] * ($cfg['point']['point']/100);
				else if($goods['pointmod'] == 2 && $goods['point'])
					$goods['gpoint'] = $goods['point'] * $v['ea'];
				else
					$goods['gpoint'] = 0;

				$v = array_merge($v, $goods);
				$this->item[$k] = $v;
			}
		}
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
	* 회원인 경우 주문자정보
	*/
	public function _get_order_user(&$mb)
	{
		if(_is_login())
		{
			$sqry = sprintf("select name, email, mobile, phone, zip, adr1, adr2, emoney from %s where userid='%s'", SW_MEMBER, $_SESSION['SES_USERID']);
			$mb = parent::_fetch($sqry, 1);
			if($mb)
			{
				$mb['ex_email'] = explode("@", $mb['email']);
				$mb['ex_mobile'] = explode("-", $mb['mobile']);
				$mb['ex_phone'] = explode("-", $mb['phone']);
			}
		}
	}

	/**
	* 주문정보 임시 주문테이블 update
	*/
	public function _set_order_tmp($data)
	{
		$ordcode = self::_get_order_code();
		$email	= sprintf("%s@%s", $data['email1'], $data['email2']);
		$mobile	= sprintf("%s-%s-%s", $data['mobile1'], $data['mobile2'], $data['mobile3']);
		$phone	= ($data['phone1'] && $data['phone2'] && $data['phone3']) ? sprintf("%s-%s-%s", $data['phone1'], $data['phone2'], $data['phone3']) : "";
		$rmobile	= sprintf("%s-%s-%s", $data['rmobile1'], $data['rmobile2'], $data['rmobile3']);
		$rphone	= ($data['rphone1'] && $data['rphone2'] && $data['rphone3']) ? sprintf("%s-%s-%s", $data['rphone1'], $data['rphone2'], $data['rphone3']) : "";
		$uemoney = ($data['point']) ? str_replace(",", "", $data['point']) : 0;
		if($data['bankown'] && $data['banknm'] && $data['banknum'])
			$refund = sprintf("%s」「%s」「%s", $data['bankown'], $data['banknm'], $data['banknum']);

		// 결제수단 ESCROW 추가 --- 2019-10-22 //
		if(!strcmp($data['payway'], "ESBANK"))	// 계좌이체(에스크로)
		{
			$data['payway'] = "BANK";
			$data['escw']	= "Y";
		}
		else if(!strcmp($data['payway'], "ESVCNT"))	// 가상계좌(에스크로)
		{
			$data['payway'] = "VCNT";
			$data['escw']	= "Y";
		}
		else
			$data['escw']	= "N";

		if(_is_login())
			$userid = $_SESSION['SES_USERID'];
		else
		{
			$_SESSION['SES_TMP_USERID'] = ($_SESSION['SES_TMP_USERID']) ? $_SESSION['SES_TMP_USERID'] : $ordcode;
			$userid = $_SESSION['SES_TMP_USERID'];
		}

		// 바로구매인 경우 임시테이블 생성 //
		if($this->is_direct === true)
		{
			$isqry = sprintf("insert into %s set
								ordcode	= '%s',
								isuser	= '%d',
								userid	= '%s',
								ogoods	= '',
								goods	= '%s',
								name	= '%s',
								email	= '%s',
								mobile	= '%s',
								phone	= '%s',
								rname	= '%s',
								rzip	= '%s',
								radr1	= '%s',
								radr2	= '%s',
								rmobile	= '%s',
								rphone	= '%s',
								comment	= '%s',
								payway	= '%s',
								escw	= '%s',
								uemoney	= '%d',
								refund	= '%s',
								step	= 'order',
								regdt	= now(),
								updt	= now()
							ON DUPLICATE KEY UPDATE
								ordcode	= '%s',
								isuser	= '%d',
								userid	= '%s',
								ogoods	= '',
								goods	= '%s',
								name	= '%s',
								email	= '%s',
								mobile	= '%s',
								phone	= '%s',
								rname	= '%s',
								rzip	= '%s',
								radr1	= '%s',
								radr2	= '%s',
								rmobile	= '%s',
								rphone	= '%s',
								comment	= '%s',
								payway	= '%s',
								escw	= '%s',
								uemoney	= '%d',
								refund	= '%s',
								step	= 'order',
								updt	= now()", SW_ORDER_TMP, $ordcode, $this->is_user, $userid, $_COOKIE['direct'], $data['name'], $email, $mobile, $phone, $data['rname'], $data['rzip'], $data['radr1'], $data['radr2'], $rmobile, $rphone, $data['comment'], $data['payway'], $data['escw'], $uemoney, $refund,
								$ordcode, $this->is_user, $userid, $_COOKIE['direct'], $data['name'], $email, $mobile, $phone, $data['rname'], $data['rzip'], $data['radr1'], $data['radr2'], $rmobile, $rphone, $data['comment'], $data['payway'], $data['escw'], $uemoney, $refund);
		}
		else
		{
			$isqry = sprintf("update %s set
								ordcode	= '%s',
								name	= '%s',
								email	= '%s',
								mobile	= '%s',
								phone	= '%s',
								rname	= '%s',
								rzip	= '%s',
								radr1	= '%s',
								radr2	= '%s',
								rmobile	= '%s',
								rphone	= '%s',
								comment	= '%s',
								payway	= '%s',
								escw	= '%s',
								uemoney	= '%d',
								refund	= '%s',
								step	= 'order',
								updt	= now()
							where userid='%s'", SW_ORDER_TMP, $ordcode, $data['name'], $email, $mobile, $phone, $data['rname'], $data['rzip'], $data['radr1'], $data['radr2'], $rmobile, $rphone, $data['comment'], $data['payway'], $data['escw'],$uemoney, $refund, $userid);
		}

		return parent::_execute($isqry);
	}

	/**
	* 주문코드 생성
	*/
	public function _get_order_code()
	{
		$ordcode = "";
		$sqry = sprintf("select count(idx) from %s where left(regdt, 10)=CURDATE()", SW_ORDER);
		list($count) = parent::_fetch($sqry);
		for(;;)
		{
			$count++;
			$ordcode = sprintf("%s%04d", time(), $count);
			$sqry = sprintf("select idx from %s where ordcode='%s'", SW_ORDER, $ordcode);
			if(!parent::isRecodeExists($sqry))
			{
				return $ordcode;
				break;
			}
		}
	}

	/**
	* order goods amount
	*
	* @Description : 구매금액 및 할인금액 계산
	*/
	public function _get_amount_calc()
	{
		// 총결게금액 = 상품가격	= 할인가격		= 배송비	=	추가운임비(도서산간) = 옵션가격	=	사용적립금
		$this->amount = $this->gamt = $this->dcamt = $this->dyamt = $this->dyfare = $this->optamt = $this->uemoney = 0;
		if(is_array($this->item) && count($this->item) > 0)
		{
			for($i=0; $i < count($this->item); $i++)
			{
				$this->gamt += ($this->item[$i]['price'] * $this->item[$i]['ea']);
				if($this->item[$i]['opt'])
				{
					$gopt = explode("」「", $this->item[$i]['opt']);
					foreach($gopt as $v)
					{
						$ex = explode("∏‡", $v);
						if($ex[3] > 0)
						{
							if($ex[2] == "+")
								$this->optamt += ($ex[3] * $this->item[$i]['ea']);
							else
								$this->optamt -= ($ex[3] * $this->item[$i]['ea']);
						}
					}
				}
			}
		}

		$this->uemoney = ($this->vars['uemoney']) ? $this->vars['uemoney'] : 0;

		self::_get_delivery_calc();
		$this->amount = ($this->gamt + $this->dyamt + $this->optamt) - $this->dcamt - $this->uemoney;
	}
	/**
	* 배송비 계산
	*/
	public function _get_delivery_calc()
	{
		global $cfg;

		if(count($this->item) > 0)
		{
			// 도서산간 추가배송비 체크 //
			$this->dyfare = self::_get_delivery_fare();

			// 기본배송비 및 무료배송 체크 //
			if($cfg['df_dyamt'] > 0 && $cfg['non_dyamt'])
			{
				if(($this->gamt + $this->optamt) < $cfg['non_dyamt'])
					$this->dyamt = $cfg['df_dyamt'];
			}
			else if($cfg['df_dyamt'] > 0)
				$this->dyamt = $cfg['df_dyamt'];
			else
				$this->dyamt = 0;

			// 총배송비 //
			$this->dyamt = $this->dyfare + $this->dyamt;
		}
	}

	/**
	* 추가배송비 계산(도서산간지역)
	*/
	private function _get_delivery_fare()
	{
		if(parent::isTableExists('sw_delivery_fare'))
		{
			if($this->vars['rzip'])
			{
				$sqry = sprintf("select fare from %s where zipcode='%s' order by idx asc limit 1", SW_DELIVERY_FARE, $this->vars['rzip']);
				if(parent::isRecodeExists($sqry))
				{
					$row = parent::_fetch($sqry);
					return $row['fare'];
				}
			}
		}
	}

	/**
	* 상점 무통장 계좌정보
	*/
	public function _get_sbank(&$arBank)
	{
		$sqry = sprintf("select * from %s order by idx asc", SW_BANK);
		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
			$arBank[] = sprintf("%s|%s|%s", $row['banknm'], $row['banknum'], $row['bankown']);
	}

	/**
	* 구매 임시장바구니 삭제
	*/
	public function _set_ordcart_clear()
	{
		$re_cart = array();
		if(_is_login())
		{
			$sqry = sprintf("select goods from %s where userid='%s'", SW_CART, $_SESSION['SES_USERID']);
			$row = parent::_fetch($sqry, 1);
			if($row['goods'])
			{
				$cart = unserialize(stripslashes(base64_decode($row['goods'])));
				for($i=0; $i < count($cart); $i++)
				{
					$flag = true;
					for($ii=0; $ii < count($this->item); $ii++)
					{
						if(!strcmp($cart[$i][0], $this->item[$ii]['gidx']) && !strcmp($cart[$i][1], $this->item[$ii]['opt']))
						{
							$flag = false;
							break;
						}
					}

					if($flag === true) $re_cart[] = $cart[$i];
				}

				if(count($re_cart) > 0)
					$usqry = sprintf("update %s set goods='%s' where userid='%s'", SW_CART, base64_encode(serialize($re_cart)), $_SESSION['SES_USERID']);
				else
					$usqry = sprintf("delete from %s where userid='%s'", SW_CART, $_SESSION['SES_USERID']);

				if(parent::_execute($usqry))
					parent::_execute("delete from ".SW_ORDCART." where userid='".$_SESSION['SES_USERID']."'");
			}
		}
		else
		{
			$cart = unserialize(stripslashes(base64_decode($_COOKIE['cart'])));
			for($i=0; $i < count($cart); $i++)
			{
				$flag = true;
				for($ii=0; $ii < count($this->item); $ii++)
				{
					if(!strcmp($cart[$i][0], $this->item[$ii]['gidx']) && !strcmp($cart[$i][1], $this->item[$ii]['opt']))
					{
						$flag = false;
						break;
					}
				}

				if($flag === true) $re_cart[] = $cart[$i];
			}

			if(count($re_cart) > 0)
				setcookie("cart", base64_encode(serialize($re_cart)), 0, '/');
			else
				setcookie("cart", '', time()-3600, '/');

			parent::_execute("delete from ".SW_ORDCART." where userid='".$_SESSION['SES_GUEST']."'");
		}
	}

	/**
	* 포인트 결제시 적립금 사용내역
	*/
	public function _set_emoney_use()
	{
		if($this->vars['point'] > 0 && $this->vars['userid'] && isLogin())
		{
			$reason = sprintf("주문번호[%s] - 상품구매시 적립금 사용", $this->vars['ordcode']);
			return _set_cash_history($this->vars['userid'], $this->vars['point'], 1, '-', $reason);
		}
	}

	/**
	* 실 주문테이블 insert
	*/
	public function _save_order($adata)
	{
		self::_get_amount_calc();	// 결제금액 계산 //

		$isqry = sprintf("insert into %s set
							ordcode	= '%s',
							userid	= '%s',
							name	= '%s',
							email	= '%s',
							mobile	= '%s',
							phone	= '%s',
							rname	= '%s',
							rmobile	= '%s',
							rphone	= '%s',
							rzip	= '%s',
							radr1	= '%s',
							radr2	= '%s',
							comment	= '%s',
							goods	= '%s',
							payway	= '%s', ", SW_ORDER, $this->vars['ordcode'], $_SESSION['SES_USERID'], $this->vars['name'], $this->vars['email'], $this->vars['mobile'], $this->vars['phone'], $this->vars['rname'], $this->vars['rmobile'], $this->vars['rphone'], $this->vars['rzip'], $this->vars['radr1'], $this->vars['radr2'], $this->vars['comment'], $this->vars['goods'], $this->vars['payway']);

		if(!strcmp($this->vars['payway'], "SBANK"))		// 상점무통장
		{
			$status = "100";
			$isqry .= sprintf(" escw	= 'N',
								sbank	= '%s',
								buyer	= '%s',
								buyday	= '%s',
								payment	= 'N',
								okamt	= 0, ", $adata['sbank'], $adata['buyer'], $adata['buyday']);
		}
		else if(!strcmp($this->vars['payway'], "POINT"))	// 포인트결제
		{
			$status = "101";
			$isqry .= " payment	= 'Y', ";
		}
		else if(!strcmp($this->vars['payway'], "CARD"))		// 카드결제
		{
			$status = "101";
			$isqry .= sprintf(" escw		= 'N',
								tno			= '%s',
								card_cd		= '%s',
								card_name	= '%s',
								card_no		= '%s',
								quota		= '%d',
								app_no		= '%s',
								app_time	= '%s',
								payment		= 'Y',
								okamt		= '%d', ", $adata['tno'], $adata['card_cd'], $adata['card_name'], $adata['card_no'], $adata['quota'], $adata['app_no'], $adata['app_time'], $this->amount);

		}
		else if(!strcmp($this->vars['payway'], "BANK"))		// 실시간 계좌이체
		{
			$status = "101";
			$isqry .= sprintf(" escw		= '%s',
								tno			= '%s',
								bank_code	= '%s',
								bank_name	= '%s',
								app_time	= '%s',
								payment		= 'Y',
								okamt		= '%d', ", $adata['escw'], $adata['tno'], $adata['bank_code'], $adata['bank_name'], $adata['app_time'], $this->amount);
		}
		else if(!strcmp($this->vars['payway'], "VCNT"))		// 가상계좌
		{
			$status = "100";
			$isqry .= sprintf(" escw		= '%s',
								tno			= '%s',
								bankname	= '%s',
								depositor	= '%s',
								account		= '%s',
								va_date		= '%s',
								payment		= 'N',
								okamt		= 0, ", $adata['escw'], $adata['tno'], $adata['bankname'], $adata['depositor'], $adata['account'], $adata['va_date']);
		}
		else if(!strcmp($this->vars['payway'], "MOBX"))	// 휴대폰결제
		{
			$status = "101";
			$isqry .= sprintf(" escw		= 'N',
								tno			= '%s',
								commid		= '%s',
								mobile_no	= '%s',
								payment		= 'Y',
								okamt		= '%d', ", $adata['tno'], $adata['commid'], $adata['mobile_no'], $this->amount);
		}

		$isqry .= sprintf("	refund	= '%s',
							gamt	= '%d',
							optamt	= '%d',
							dcamt	= '%d',
							dyamt	= '%d',
							dyfare	= '%d',
							uemoney	= '%d',
							ccamt	= '0',
							amount	= '%d',
							device	= 'P',
							status	= '%s',
							regdt	= now(),
							updt	= now()", $this->vars['refund'], $this->gamt, $this->optamt, $this->dcamt, $this->dyamt, $this->dyfare, $this->uemoney, $this->amount, $status);

		if(parent::_execute($isqry))
			return self::_save_order_item($status);
		else
		{
			_mk_log_write($isqry, "order.log");
			return false;
		}
	}

	/**
	* 주문상품 정보 insert
	*/
	public function _save_order_item($status)
	{
		$ok = $err = 0;
		foreach($this->item as $v)
		{
			$isqry = sprintf("insert into %s set
								ordcode		= '%s',
								gidx		= '%s',
								gname		= '%s',
								gopt		= '%s',
								gea			= '%s',
								gprice		= '%s',
								goptamt		= '%d',
								gpoint		= '%d',
								sumamt		= '%d',
								status		= '%s',
								regdt	= now()", SW_ORDER_ITEM, $this->vars['ordcode'], $v['gidx'], $v['name'], $v['opt'], $v['ea'], $v['price'], $v['goptamt'], $v['gpoint'], $v['samt'], $status);
			if(parent::_execute($isqry))
			{
				$ok++;
			}
			else
			{
				_mk_log_write($isqry, "item.log");
				$err++;
			}
		}

		if($err > 0)
			return false;
		else
		{
			self::_set_order_item_stock($status);	// 상품재고 차감 //
			self::_save_status_log($status);
			return true;
		}
	}

	/**
	* 주문상태 로그 저장
	*/
	public function _save_status_log($status)
	{
		$isqry = sprintf("insert into %s set
							ordcode	= '%s',
							status	= '%s',
							isuser	= '1',
							userid	= '%s',
							updt	= now()", SW_ORDER_LOG, $this->vars['ordcode'], $status, $_SESSION['SES_USERID']);

		return parent::_execute($isqry);
	}

	/**
	* 결제완료시 처리되어야 하는 부분
	*/
	public function _set_order_finish()
	{
		if(_is_login())
		{
			// 적림금 사용시 //
			if($this->uemoney > 0)
			{
				$reason = sprintf("주문번호[%s] - 상품구매시 적립금 사용", $this->vars['ordcode']);
				_set_emoney_history($this->vars['userid'], $this->uemoney, 1, '-', $reason);
			}
		}

		// 재고 차감 //
		//self::_set_order_item_stock();

		if(!$_COOKIE['direct'])
			return self::_set_clear_ordtmp();
		else
		{
			setcookie("is_direct", "", time()-3600, "/");
			setcookie("direct", "", time()-3600, "/");

			return parent::_execute("delete from ".SW_ORDER_TMP." where userid='".$this->vars['userid']."'");
		}
	}

	/**
	* 주문완료시 장바구니 및 임시주문 테이블 clear
	*/
	public function _set_clear_ordtmp()
	{
		$rarr = array();
		if(_is_login())
		{
			$sqry = sprintf("select goods from %s where userid='%s'", SW_BASKET, $this->vars['userid']);
			list($goods) = parent::_fetch($sqry);
			$cgd = unserialize(stripslashes(base64_decode($goods)));
			$ogd = unserialize(stripslashes(base64_decode($this->vars['goods'])));
			foreach($cgd as $v)
			{
				$flag = false;
				foreach($ogd as $vv)
				{
					if($v[0] == $vv[0] && $v[1] == $vv[1])
					{
						$flag = true;
						break;
					}
				}

				if($flag === false) $rarr[] = $v;
			}

			if(count($rarr) > 0)
				$usqry = sprintf("update %s set goods='%s' where userid='%s'", SW_BASKET, base64_encode(serialize($rarr)), $this->vars['userid']);
			else
				$usqry = sprintf("delete from %s where userid='%s'", SW_BASKET, $this->vars['userid']);

			if(parent::_execute($usqry))
				return parent::_execute("delete from ".SW_ORDER_TMP." where userid='".$this->vars['userid']."'");
		}
		else
		{
			$rarr = array();
			$cgd = unserialize(stripslashes(base64_decode($_COOKIE['basket'])));
			$ogd = unserialize(stripslashes(base64_decode($this->vars['goods'])));

			foreach($cgd as $v)
			{
				$flag = false;
				foreach($ogd as $vv)
				{
					if($v[0] == $vv[0] && $v[1] == $vv[1])
					{
						$flag = true;
						break;
					}
				}

				if($flag === false) $rarr[] = $v;
			}

			if(is_array($rarr) && count($rarr) > 0)
				setcookie("basket", base64_encode(serialize($rarr)), 0, "/");
			else
				setcookie("basket", "", time()-3600, "/");

			return parent::_execute("delete from ".SW_ORDER_TMP." where userid='".$this->vars['userid']."'");
		}
	}

	/**
	* 주문시 재고 차감
	*/
	private function _set_order_item_stock($status)
	{
		if($status == "101")
		{
			foreach($this->item as $v)
			{
				if($v['blimit'] == 2)
				{
					$glimit = ($v['glimit'] >= $v['ea']) ? $v['glimit'] - $v['ea'] : 0;
					$blimit = ($glimit > 0) ? $v['blimit'] : 3;

					$u = sprintf("update %s set glimit=%d, blimit=%d where idx='%s'", SW_GOODS, $glimit, $blimit, $v['gidx']);
					parent::_execute($u);
				}
			}
		}
	}
}
?>
