<?
/**
* Order Handler Class PHP5
*
* @Author		:	kkang(sinbiweb)
* @Update		:	2014-09-05
* @Description	:	Order Handler Class
*/

class OrderHandler extends MysqlHandler
{
	public $ordtmp = 0;
	public $order;
	public $gitem;
	public $item;
	public $ordcode;
	protected $item_keys = array("gidx", "optnm", "optval", "optpay", "ea");
	protected static $instance;

	/**
	* 싱글톤 인스턴스 리턴
	* @param array $params
	*/
	public static function getInstance($ordcode, $ordtmp=0)
	{
		if(!isset(self::$instance))
			self::$instance = new self($ordcode, $ordtmp);
		else
			self::$instance->__construct($ordcode, $ordtmp);

		return self::$instance;
	}

	/**
	* 생성자
	* @param array $params
	*/
	public function __construct($ordcode, $ordtmp=0)
	{
		$this->ordtmp = $ordtmp;
		$this->ordcode = $ordcode;

		parent::__construct();

		if($this->ordtmp == 1)
		{
			$sqry = sprintf("select * from %s where ordcode='%s' order by idx desc limit 1", SW_ORDER, $ordcode);
			if(parent::isRecodeExists($sqry))
			{
				$this->order = parent::_fetch($sqry, 1);
				self::getOrderGoods();


				if(count($this->item) > 1)
					$this->order['ordgname'] = sprintf("%s 외 %d건", $this->item[0]['name'], count($this->item)-1);
				else
					$this->order['ordgname'] = $this->item[0]['name'];

				if(!strcmp($this->order['payway'], "SBANK"))
				{
					$exbank = @explode("|", $this->order['bankinfo']);
					$this->order['bank']['banknm'] = $exbank[0];
					$this->order['bank']['banknum'] = $exbank[1];
					$this->order['bank']['bankown'] = $exbank[2];
				}
			}
		}
		else
		{
			$sqry = sprintf("select * from %s where ordcode='%s' order by idx desc limit 1", SW_ORDER_TMP, $ordcode);
			if(parent::isRecodeExists($sqry))
			{
				$this->order = parent::_fetch($sqry, 1);
				$this->gitem = unserialize(stripslashes(base64_decode($this->order['goods'])));
				self::getOrderGoods();

				if(count($this->item) > 1)
					$this->order['ordgname'] = sprintf("%s 외 %d건", $this->item[0]['name'], count($this->item)-1);
				else
					$this->order['ordgname'] = $this->item[0]['name'];
			}
		}

		if(count($this->item) > 1)
			$this->order['goods_name'] = sprintf("%s 외 %d건", $this->item[0]['name'], count($this->item)-1);
		else
			$this->order['goods_name'] = $this->item[0]['name'];
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* 구매상품 정보
	*/
	public function getOrderGoods()
	{
		global $swshop;
		$ii=0;

		if($this->ordtmp == 1)
		{
			$sqry = sprintf("select idx, gidx, ea, emoney, dyamt, optamt, optnm, optval, optpay from %s where ordcode='%s' order by idx asc", SW_ORDER_ITEM, $this->ordcode);
			$qry = parent::_execute($sqry);

			while($row=mysql_fetch_array($qry))
			{
				$sqry = sprintf("select name, category, img3, delivery, price, nprice, blimit, glimit, icon, pointmod, point, pointunit, bsale from %s where idx='%d' limit 1", SW_GOODS, $row['gidx']);
				$goods = parent::_fetch($sqry);

				/// 타임세일 상품일 경우 ///
				if($goods['bsale'])
					$goods = self::getSaleGoods($goods);

				/// 적립금 설정 ///
				if($goods['pointmod'] == 2 && $goods['point'] > 0)
				{
					if(!strcmp($goods['pointunit'], "p"))
						$goods['pamt'] = ($goods['price'] * ($goods['point']/100)) * $v['ea'];
					else
						$goods['pamt'] = $goods['point'] * $v['ea'];
				}
				else if($goods['pointmod'] == 1)
				{
					if(!strcmp($swshop['punit'], "Y") && $swshop['point'] > 0)
						$goods['pamt'] = ($goods['price'] * ($swshop['point']/100)) * $v['ea'];
					else
						$goods['pamt'] = 0;
				}
				else
					$goods['pamt'] = 0;

				/// 주문상품별 옵션 ///
				if($row['optnm'])
				{
					$exoptnm = explode("」「", $row['optnm']);
					$exoptval = explode("」「", $row['optval']);
					$exoptpay = explode("」「", $row['optpay']);

					for($o=0; $o < count($exoptnm); $o++)
					{
						if($exoptnm[$o] && $exoptval[$o])
							$goods['ordopt'][] = sprintf("%s : %s%s", $exoptnm[$o], $exoptval[$o], (($exoptpay[$o] && $exoptpay[$o] > 0) ? "(+".number_format($exoptpay[$o]).")" : ""));
					}
				}

				$v = array_merge($row, $goods);
				$this->item[$ii] = $v;
				$ii++;
			}
		}
		else
		{
			if(!$this->gitem) return;

			foreach($this->gitem as $k => $v)
			{
				$v = self::array_comb($this->item_keys, $v);

				if($v['gidx'])
				{
					$goods = parent::_fetch("select name, category, img3, delivery, dyprice, ndyprice, price, nprice, blimit, glimit, icon, pointmod, point, pointunit, bsale from ".SW_GOODS." where idx='".$v['gidx']."' order by idx desc limit 1");

					/// 타임세일 상품일 경우 ///
					if($goods['bsale'])
						$goods = self::getSaleGoods($goods);

					/// 적립금 설정 ///
					if($goods['pointmod'] == 2 && $goods['point'] > 0)
					{
						if(!strcmp($goods['pointunit'], "p"))
							$goods['pamt'] = ($goods['price'] * ($goods['point']/100)) * $v['ea'];
						else
							$goods['pamt'] = $goods['point'] * $v['ea'];
					}
					else if($goods['pointmod'] == 1)
					{
						if(!strcmp($swshop['punit'], "Y") && $swshop['point'] > 0)
							$goods['pamt'] = ($goods['price'] * ($swshop['point']/100)) * $v['ea'];
						else
							$goods['pamt'] = 0;
					}
					else
						$goods['pamt'] = 0;

					/// 주문상품별 옵션 ///
					if($v['optnm'])
					{
						$exoptnm = explode("」「", $v['optnm']);
						$exoptval = explode("」「", $v['optval']);
						$exoptpay = explode("」「", $v['optpay']);

						for($o=0; $o < count($exoptnm); $o++)
						{
							if($exoptnm[$o] && $exoptval[$o])
								$goods['ordopt'][] = sprintf("%s : %s%s", $exoptnm[$o], $exoptval[$o], (($exoptpay[$o] && $exoptpay[$o] > 0) ? "(+".number_format($exoptpay[$o]).")" : ""));
						}
					}

					$v = array_merge($v, $goods);
					$this->item[$ii] = $v;
					$ii++;
				}
			}
		}
	}

	/**
	* time sale goods
	*/
	public function getSaleGoods($goods)
	{
		$sqry = sprintf("select * from %s where status=1 and idx='%d'", SW_SALE, $goods['bsale']);
		$row = parent::_fetch($sqry);
		if($row)
		{
			$status = chkSalePeriod($row['sday'], $row['shour'], $row['smin'], $row['eday'], $row['ehour'], $row['emin']);
			if($status == 1) /// 진행중일 경우 ///
			{
				$goods['nprice'] = $goods['price'];
				$goods['price'] = $row['price'];
				$goods['bsale'] = $row['idx'];
			}
			else
				$goods['bsale'] = "0";
		}
		else
			$goods['bsale'] = "0";

		return $goods;
	}

	/**
	* 주문금액 산출
	*/
	public function getOrderCalc()
	{
		///	총결제금액	=	구매상품금액	=	옵션금액	= 0
		$this->amount = $this->goodsamt = $this->optionamt =  0;
		for($i=0; $i < count($this->item); $i++)
		{
			### 옵션별 가격적용 ###
			if($this->item[$i]['optnm'])
			{
				$exoptpay = $aPrice = array();
				$optItemPrice = 0;
				$exoptpay = @explode("」「", $this->item[$i]['optpay']);

				for($j=0; $j < count($exoptpay); $j++)
					if($exoptpay[$j])
						$aPrice[] = $exoptpay[$j] * $this->item[$i]['ea'];

				$optItemPrice = array_sum($aPrice);
			}

			$goodsprice = $this->item[$i]['price'] * $this->item[$i]['ea'];
			$this->goodsamt += $goodsprice;
			$this->goodsea += $this->item[$i]['ea'];
			$this->optionamt += $optItemPrice;
			$this->wrapamt += $this->item[$i]['wrapamt'];
			//$this->delivery_amt += $this->item[$i]['dyamt'];
		}

		if($this->optionamt > 0)
			$this->tmpTotalamt = $this->goodsamt + $this->optionamt;
		else
			$this->tmpTotalamt = $this->goodsamt;

		self::getDelivery();

		$this->amount = $this->goodsamt + $this->delivery_amt + $this->optionamt;

		### 쿠폰사용시 ###
		if($this->order['couponamt'] > 0)
			$this->amount = $this->amount - $this->order['couponamt'];

		### 적립금 사용시 계산 ###
		if($this->order['upoint'] > 0)
			$this->amount = $this->amount - $this->order['upoint'];
	}

	/**
	* 배송비 계산
	*/
	public function getDelivery()
	{
		global $cfg;

		$delivery_money = 0;
		$gmoney = 0;	/// 개별배송을 뺀 상품금액(기본배송정책의 배송비계산목적) ///

		for($i=0; $i < count($this->item); $i++)
		{
			if($this->item[$i]['delivery'] == 2)
			{
				if($this->item[$i]['dyprice'] && $this->item[$i]['dyprice'] > 0)
				{
					if($this->item[$i]['ndyprice'] && $this->item[$i]['ndyprice'] > 0)
						$delivery_money += (($this->item[$i]['price'] * $this->item[$i]['ea']) >= $this->item[$i]['ndyprice']) ? 0 : $this->item[$i]['dyprice'];
					else
						$delivery_money += $this->item[$i]['dyprice'];
				}
				else
					$gmoney += $this->item[$i]['price'] * $this->item[$i]['ea'];
			}
			else
				$gmoney += $this->item[$i]['price'] * $this->item[$i]['ea'];
		}

		if($this->tmpTotalamt > 0)
		{
			$delivery_money += ($cfg['ntransM'] <= $gmoney) ? 0 : $cfg['transM'];
			$this->delivery_amt = $delivery_money;
		}
		else
			$this->delivery_amt = 0;
	}

	/**
	* 주문완료시 선택주문한 상품만 장바구니에서 삭제
	*/
	public function setOrdcartClear()
	{
		$newCart = $arr_cart = $arr_ordcart = array();

		if($_SESSION['SES_USERID'])
		{
			$sqry1 = sprintf("select goods from %s where userid=TRIM('%s')", SW_CART, $_SESSION['SES_USERID']);
			if(parent::isRecodeExists($sqry1))
			{
				$row1 = parent::_fetch($sqry1, 1);
				$cgoods = unserialize(stripslashes(base64_decode($row1['goods'])));
			}

			$sqry2 = sprintf("select goods from %s where userid=TRIM('%s')", SW_ORDCART, $_SESSION['SES_USERID']);
			if(parent::isRecodeExists($sqry2))
			{
				$row2 = parent::_fetch($sqry2, 1);
				$ogoods = unserialize(stripslashes(base64_decode($row2['goods'])));
			}
		}
		else
		{
			$cgoods = unserialize(stripslashes(base64_decode($_COOKIE['cart'])));
			$sqry = sprintf("select goods from %s where guestid=TRIM('%s')", SW_ORDCART, $_SESSION['SES_GUEST']);
			if(parent::isRecodeExists($sqry))
			{
				$row = parent::_fetch($sqry, 1);
				$ogoods = unserialize(stripslashes(base64_decode($row['goods'])));
			}
		}

		if($cgoods)
		{
			foreach($cgoods as $k=>$v)
			{
				$v = self::array_comb($this->item_keys, $v);
				$flag = false;

				foreach($ogoods as $key=>$val)
				{
					$val = self::array_comb($this->item_keys, $val);
					if(!strcmp($v['gidx'], $val['gidx']) && !strcmp($v['optnm'], $val['optnm']) && !strcmp($v['optval'], $val['optval']))
						$flag = true;
				}

				if(!$flag)
					$newCart[] = array_values($v);
			}
		}

		if($_SESSION['SES_USERID'])
		{
			if(count($newCart) > 0)
				$isqry = sprintf("update %s set goods='%s' where userid=TRIM('%s')", SW_CART, base64_encode(serialize($newCart)), $_SESSION['SES_USERID']);
			else
				$isqry = sprintf("delete from %s where userid=TRIM('%s')", SW_CART, $_SESSION['SES_USERID']);

			if(parent::_execute($isqry))
				parent::_execute("delete from ".SW_ORDCART." where userid='".$_SESSION['SES_USERID']."'");
		}
		else
		{
			if(count($newCart) > 0)
				setcookie("cart", base64_encode(serialize($newCart)), 0, '/');
			else
				setcookie("cart", '', time()-3600, '/');

			parent::_execute("delete from ".SW_ORDCART." where guestid='".$_SESSION['SES_GUEST']."'");
		}
	}

	/**
	* 상점계좌정보
	*/
	public function getBankInfo(&$arr_bank)
	{
		$arr_bank = array();
		$qry = parent::_execute("select * from ".SW_BANK." order by idx asc");
		while($row=mysql_fetch_array($qry))
			$arr_bank[] = sprintf("%s|%s|%s", $row['banknum'], $row['banknm'], $row['bankown']);
	}

	/**
	* 포인트 결제시 적립금 사용내역
	*/
	public function useEmoney()
	{
		if(strcmp($this->order['userfb'], "Y") && $this->order['upoint'] && $this->order['upoint'] > 0)
		{
			if(count($this->item) > 1)
				$ordgname = sprintf("%s 외 %d건", $this->item[0]['name'], count($this->item)-1);
			else
				$ordgname =  $this->item[0]['name'];

			$reason = $ordgname." 상품구매시 포인트사용";
			setCash($_SESSION['SES_USERIDX'], $this->order['upoint'], 1, "-", $reason);
		}
	}

	/**
	* array_combine : php 5이상 가능 ==> php 4버전에서 사용가능하게
	* @return array
	*/
	protected function array_comb($skey, $sval)
	{
		if(!function_exists("array_combine"))
		{
			if(!is_array($skey)) return false;
			if(!is_array($sval)) return false;

			$rarr = array();
			if(count($skey) < count($sval)) return false;
			else
			{
				$i = 0;
				foreach($skey as $v)
				{
					$rarr[$v] = $sval[$i];
					$i++;
				}
			}
		}
		else
			$rarr = array_combine($skey, $sval);

		return $rarr;
	}
}
?>