<?php
/**
* Basket Handler Class PHP7
*
* @Author		: seob
* @Update		: 2018-08-09
* @Description	: Basket Handler Class
*/
class BasketHandler extends MysqliHandler
{
	public $is_direct;
	public $item;
	public $ar_item;
	public $appUserid;
	public $nonAppUserid;
  public $appTableNo;

	protected $arkeys = array("gidx", "opt", "ea");
	protected $mode;

	public function __construct($is_direct=0, $mode="" , $userid="" , $non_user="" , $tableNo = "")
	{
		$this->is_direct = $is_direct;
		$this->mode = (!$is_direct) ? (($mode) ? $mode : "basket") : "direct";
    $this->appTableNo = $tableNo;

		if($non_user){
 			$this->appUserid = $non_user;
			$this->nonAppUserid =$non_user;

		}else{
			$this->appUserid = $userid;
		}
							// error_log("appUserid ----- ".$this->appUserid."\n", 3, "/home/shop/log/custom.log");
		parent::__construct();
		self::_get_basket();

		if(is_array($this->ar_item) && count($this->ar_item) > 0) self::_get_basket_goods();
	}

	public function __destruct()
	{
		// 소멸자 //
	}


	/**
	* 장바구니에 담은 상품정보 가져오기 --- sw_basket
	*/
	protected function _get_basket()
	{
		if($this->appUserid)
		{
			$sqry = sprintf("select goods from %s where userid='%s'", SW_BASKET, $this->appUserid);
			list($goods) = parent::_fetch($sqry);
			if($goods) $this->ar_item = unserialize(stripslashes(base64_decode($goods)));


		}
		else
		{
			// if($_COOKIE[$this->mode])
			// {
				$this->ar_item = unserialize(stripslashes(base64_decode($_COOKIE[$this->mode])));
			// }

			// $sqry = sprintf("select goods from %s where userid='%s'", SW_BASKET, $his->$nonAppUserid);
			// error_log("sqry ----- ".var_export($sqry, true)."\n", 3, "/home/shop/log/custom.log");
			// list($goods) = parent::_fetch($sqry);
			// if($goods) $this->ar_item = unserialize(stripslashes(base64_decode($goods)));
		}
	}

	/**
	* 장바구니 상품정보
	*/
	private function _get_basket_goods()
	{
		if(!$this->ar_item) return;
		$letter_no = 0;
		foreach($this->ar_item as $v)
		{
			if(is_array($v) && count($v) < 3) continue;
			$v = array_combine($this->arkeys, $v);
			if($v['gidx'])
			{
				$letter_no++;
				$sqry = sprintf("select gcode, category, name, img3, price, nprice, mnea, mxea, blimit, glimit, pointmod, point, boption from %s where idx='%s'", SW_GOODS, $v['gidx']);
				$goods = parent::_fetch($sqry, 1);
				$goods['letter_no'] = $letter_no;
				$optamt = 0;

				// 선택옵션이 있을경우 //
				if($v['opt'])
				{
					$gopt = explode("」「", $v['opt']);
					foreach($gopt as $vv)
					{
						$ex = explode("∏‡", $vv);
						$option = self::_get_option_info($goods['gcode'], $ex[0]);
						if($option)
						{
							$goods['stropt'][] = sprintf("%s : %s %s", $option['optnm'], $ex[1], (($ex[3] > 0) ? "(".$ex[2].number_format($ex[3]).")" : ""));
							$goods['stropt_info'][] = sprintf("%s : %s %s", $option['optnm'], $ex[1], (($ex[3] > 0) ? "(".$ex[2].number_format($ex[3]).")" : ""));
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

				// sub amount //
				$goods['samt'] = ($v['ea'] * $goods['price']) + $optamt;

				$v = array_merge($v, $goods);
				$this->item[] = $v;
			}
		}
	}

	/**
	* basket overlap check
	* @des : 상품idx 및 옵션비교후 기존장바구니에 동일한 상품이 있는지 체크
	*/
	public function _chk_basket_overlap($gidx, $gopt)
	{
		$flag = false;
		if(is_array($this->ar_item) && count($this->ar_item) > 0)
		{
			foreach($this->ar_item as $v)
			{
				if($v[0] == $gidx)
				{
					if($gopt && $v[1] && !strcmp($gopt, $v[1]))
					{
						$flag = true;
						break;
					}
					else if(!$gopt && !$v[1])
					{
						$flag = true;
						break;
					}
				}
			}
		}

		return $flag;
	}

	/**
	* add basket item
	*/
	public function _add_basket_item($gidx, array $item, array $gea)
	{
		$re_ar_item = array();
		if(!$this->is_direct)
		{
			if(is_array($item) && count($item) > 0)
			{
				for($i=0; $i < count($item); $i++)
				{
					if(self::_chk_basket_overlap($gidx, $item[$i]) === false)
					{
						$re_ar_item[] = array($gidx, $item[$i], $gea[$i]);
					}
				}
			}

			if(is_array($this->ar_item) && count($this->ar_item) > 0)
			{
				if(is_array($re_ar_item) && count($re_ar_item) > 0)
					$this->ar_item = array_merge_recursive($this->ar_item, $re_ar_item);
			}
			else
				$this->ar_item = $re_ar_item;

			return self::_set_basket();
		}
		else if($this->is_direct)
		{
			if(is_array($item) && count($item) > 0)
			{
				for($i=0; $i < count($item); $i++)
					$re_ar_item[] = array($gidx, $item[$i], $gea[$i]);
			}

			$this->ar_item = $re_ar_item;
			setcookie("is_direct", true, 0, "/");
			setcookie($this->mode, base64_encode(serialize($this->ar_item)), 0, '/');
			//return self::_set_basket_tmp('all');
			return true;
		}
	}

	/**
	* option information
	*/
	public function _get_option_info($gcode, $optcd)
	{
		$sqry = sprintf("select optnm, optval, optmark, optpay from %s where gcode='%s' and optcd='%s' limit 1", SW_OPTION, $gcode, $optcd);
		return parent::_fetch($sqry, 1);
	}

	/**
	* basket item update : 수량 변경
	*/
	public function _set_ea_update($letter_no, $ea)
	{
		$rarr = array();
		foreach($this->item as $v)
		{
			if($v['letter_no'] == $letter_no)
				$v['ea'] = $ea;

			$rarr[] = array($v['gidx'], $v['opt'], $v['ea']);
		}

		$this->ar_item = $rarr;
		return self::_set_basket();
	}

	/**
	* basket table OR basket cookie save
	*/
	public function _set_basket()
	{
		$flag = false;
		if($this->appUserid && !strcmp($this->mode, "basket"))
		{
			if(is_array($this->ar_item) && count($this->ar_item) > 0)
				$isqry = sprintf("insert into %s set userid='%s', tableNo = '%s' , goods='%s',  regdt=now(), updt=now() ON DUPLICATE KEY UPDATE goods='%s', updt=now()", SW_BASKET, $this->appUserid, $this->appTableNo,  base64_encode(serialize($this->ar_item)), base64_encode(serialize($this->ar_item)));
			else
				$isqry = sprintf("delete from %s where userid='%s'", SW_BASKET, $this->appUserid);

// error_log("isqry ----- ".$isqry."\n", 3, "/home/shop/log/custom.log");
// 			print($isqry);
// exit;
			if(parent::_execute($isqry))
			{
				$bdidx = parent::_get_insert_id();
				setcookie($this->mode, '', time()-3600, '/');
				$flag = true;
			}
		}
		else
		{
			// if(is_array($this->ar_item) && count($this->ar_item) > 0)
			// {
			// 	setcookie($this->mode, base64_encode(serialize($this->ar_item)), 0, '/');
			// 	$flag = true;
			// }
			// else
			// {
			// 	setcookie($this->mode, "", time()-3600, "/");
			// 	$flag = true;
			// }
			$userid = time();
			if(is_array($this->ar_item) && count($this->ar_item) > 0)
				$isqry = sprintf("insert into %s set userid='%s',tableNo = '%s' , goods='%s', regdt=now(), updt=now() ON DUPLICATE KEY UPDATE goods='%s', updt=now()", SW_BASKET, $userid, $this->appTableNo, base64_encode(serialize($this->ar_item)), base64_encode(serialize($this->ar_item)));
			else
				$isqry = sprintf("delete from %s where userid='%s'", SW_BASKET, $userid);


// error_log("isqry ----- ".$isqry."\n", 3, "/home/shop/log/custom.log");
			if(parent::_execute($isqry))
			{
				$bdidx = parent::_get_insert_id();
				setcookie($this->mode, '', time()-3600, '/');
				$flag = true;
			}
		}

		return $flag;
	}

	/**
	* 상품재고 정보가져오기 --- df_goods_stock
	*/
	public function _get_goods_stock($gidx)
	{
		$sqry = sprintf("select blimit, glimit from %s where idx='%s'", SW_GOODS, $gidx);
		return parent::_fetch($sqry, 1);
	}

	/**
	* basket item delete --- array(itemcd)
	*/
	public function _del_basket_item($arr)
	{
		$rarr = $gidx = array();
		if(is_array($this->item) && count($this->item) > 0)
		{
			foreach($this->item as $v)
			{
				if(!in_array($v['letter_no'], $arr))
					$rarr[] = array($v['gidx'], $v['opt'], $v['ea']);
			}
			$this->ar_item = $rarr;
		}
		else
			$this->ar_item = "";

		return self::_set_basket();
	}

	/**
	* basket item delete --- itemcd
	*/
	public function _del_basket_itemcd($itemcd)
	{
		$rarr = $gidx = array();
		foreach($this->ar_item as $v)
		{
			if(strcmp($v[1], $itemcd))
				$rarr[] = $v;
			else
				$gidx[] = $v[0];
		}

		$this->ar_item = $rarr;
		if(self::_set_basket())
		{
			self::_set_basket_status($gidx);
			return true;
		}
		else
			return false;
	}

	/**
	* 장바구니 비우기
	*/
	public function _set_empty_basket()
	{
		$this->ar_item = array();
		self::_set_basket();
	}

	/**
	* 총구매금액 계산
	*/
	public function _get_amount_calc()
	{
		// 총결게금액 = 상품가격	= 할인가격		= 배송비	=	옵션가격
		$this->amount = $this->gamt = $this->dcamt = $this->dyamt = $this->optamt = 0;

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

			self::_get_delivery_calc();
			$this->amount = $this->gamt + $this->dyamt + $this->optamt;
		}
	}

	/**
	* 배송비 계산
	*/
	private function _get_delivery_calc()
	{
		global $cfg;
		if(count($this->item) > 0)
		{
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
		}
	}

	/**
	* wishlist add (goods view -> wishlist)
	*/
	public function _add_wishlist_item($gidx, array $item, array $gea)
	{
		$ndata = $odata = array();
		$ocnt = 0;


		for($i=0; $i < count($item); $i++)
			$ndata[] = array($gidx, $item[$i], $gea[$i]);

		// 기존 위시리스트에서 동일 코드 삭제 //
		$wdata = self::_get_wishlist();
		if(is_array($wdata) && count($wdata) > 0)
		{
			foreach($wdata as $v)
			{
				if(!strcmp($v['gidx'], $gidx) && !in_array($v['opt'], $item))
					$odata[] = array($v['gidx'], $v['opt'], $v['ea']);
				else if(strcmp($v['gidx'], $gidx))
					$odata[] = array($v['gidx'], $v['opt'], $v['ea']);
			}
		}

		if(count($odata) > 0)
			$wish = array_merge_recursive($odata, $ndata);
		else
			$wish = $ndata;


		if($wish)
		{
			$isqry = sprintf("insert into %s set userid='%s', goods='%s', regdt=now(), updt=now() ON DUPLICATE KEY UPDATE goods='%s', updt=now()", SW_WISH, $this->appUserid, base64_encode(serialize($wish)), base64_encode(serialize($wish)));
			if(parent::_execute($isqry))
				return true;
			else
				return false;
		}
	}

	/**
	* wishlist select
	*/
	public function _get_wishlist()
	{
		if($this->appUserid)
		{
			$sqry = sprintf("select goods from %s where userid='%s'", SW_WISH, $this->appUserid);
			$row = parent::_fetch($sqry, 1);
			$goods = unserialize(stripslashes(base64_decode($row['goods'])));
			$letter_no = 0;
			if(is_array($goods) && count($goods) > 0)
			{
				foreach($goods as $v)
				{
					$letter_no++;
					$v = array_combine(array("gidx", "opt", "ea"), $v);
					$v['letter_no'] = $letter_no;
					$wish[] = $v;
				}
			}

			return $wish;
		}
	}

	/**
	* wishlist 해당 itemcd에 대한 정보
	*/
	public function _get_wish_item($letter_no)
	{
		$w = self::_get_wishlist();
		foreach($w as $v)
		{
			if($v['letter_no'] == $letter_no)
			{
				return $v;
				break;
			}
		}
	}

	/**
	* wishlist -> 재고확인 (바로구매시 재고체크)
	*/
	public function _get_wish_stock_item($letter_no)
	{
		$sw = self::_get_wish_item($letter_no);
		$irow = self::_get_goods_stock($sw['gidx']);
		if($irow['blimit'] == 3 || ($irow['blimit'] == 2 && $irow['glimit'] < $sw['ea']))
			return false;
		else
			return true;
	}

	/**
	* wishlist -> basket
	*/
	public function _mv_wish_basket($letter_no)
	{
		$sw = self::_get_wish_item($letter_no);
		$ar_add_item[] = array($sw['gidx'], $sw['opt'], $sw['ea']);
		if(is_array($this->ar_item) && count($this->ar_item) > 0)
		{
			if(self::_chk_basket_overlap($sw['gidx'], $sw['opt']) === false)
			{
				$irow = self::_get_goods_stock($sw['gidx']);
				if($irow['blimit'] == 3 || ($irow['blimit'] == 2 && $irow['glimit'] < $sw['ea']))
					msg("현재 재고수량이 부족하여 장바구니에 담을수 없습니다.", "", true);
				else
				{
					$this->ar_item = array_merge_recursive($this->ar_item, $ar_add_item);
					if(self::_set_basket())
					{
						self::_del_wish_item($letter_no);
						gourl("/goods/basket.php", "P");
					}
				}
			}
			else
			{
				self::_del_wish_item($letter_no);
				gourl("/goods/basket.php", "P");
			}
		}
		else
		{
			$irow = self::_get_goods_stock($letter_no);
			if($irow['blimit'] == 3 || ($irow['blimit'] == 2 && $irow['glimit'] < $sw['ea']))
				msg("현재 재고수량이 부족하여 장바구니에 담을수 없습니다.", "", true);
			else
			{
				$this->ar_item = $ar_add_item;
				if(self::_set_basket())
				{
					self::_del_wish_item($letter_no);
					gourl("/goods/basket.php", "P");
				}
			}
		}
	}

	/**
	* wishlist -> basket : 여러 아이템 장바구니 이동
	*/
	public function _mv_wish_basket_arr(array $item)
	{
		$narr = $darr = array();
		if(is_array($this->ar_item) && count($this->ar_item) > 0)
		{
			foreach($item as $v)
			{
				$sw = self::_get_wish_item($v);
				if(self::_chk_basket_overlap($sw['gidx'], $sw['opt']) === false)
				{
					$irow = self::_get_goods_stock($sw['gidx']);
					if($irow['blimit'] == 3 || ($irow['blimit'] == 2 && $irow['glimit'] < $sw['ea']))
						continue;
					else
					{
						$narr[] = array($sw['gidx'], $sw['opt'], $sw['ea']);	// 장바구니추가
						$darr[] = $v;	// 관심상품 삭제
					}
				}
			}

			if(count($narr) > 0)
			{
				$this->ar_item = array_merge_recursive($this->ar_item, $narr);
				if(self::_set_basket())
				{
					self::_del_wish_item_arr($darr);
					return true;
				}
			}
			else
				msg("현재 재고수량이 부족하여 장바구니에 담을수 없습니다.", "", true);
		}
		else
		{
			foreach($item as $v)
			{
				$sw = self::_get_wish_item($v);
				$irow = self::_get_goods_stock($sw['gidx']);
				if($irow['blimit'] == 3 || ($irow['blimit'] == 2 && $irow['glimit'] < $sw['ea']))
					continue;
				else
				{
					$narr[] = array($sw['gidx'], $sw['opt'], $sw['ea']);
					$darr[] = $v;
				}
			}

			if(count($narr) > 0)
			{
				$this->ar_item = $narr;
				if(self::_set_basket())
				{
					self::_del_wish_item_arr($darr);
					return true;
				}
			}
			else
				return false;
		}
	}

	/**
	* wishlist -> direct
	*/
	public function _set_wish_direct($letter_no)
	{
		$arr = array();
		$iwish = self::_get_wish_item($letter_no);
		if($iwish)
		{
			$arr[] = array($iwish['gidx'], $iwish['opt'], $iwish['ea']);
			if(self::_set_wish_basket_tmp($arr))
				return self::_del_wish_item($letter_no);
			else
				return false;
		}
	}

	/**
	* wishlist selected direct
	*/
	public function _set_wish_direct_arr($item)
	{
		$arr = array();
		foreach($item as $v)
		{
			$iwish = self::_get_wish_item($v);
			if($iwish)
				$arr[] = $iwish;
		}

		if(self::_set_wish_basket_tmp($arr))
			return self::_del_wish_item_arr($item);
		else
			return false;
	}

	/**
	* wishlist delete --- 한아이템 삭제
	*/
	public function _del_wish_item($letter_no)
	{
		$w = self::_get_wishlist();
		$re_wish = array();
		foreach($w as $v)
		{
			if($v['letter_no'] != $letter_no)
				$re_wish[] = array($v['gidx'], $v['opt'], $v['ea']);
		}

		if(count($re_wish) > 0)
			$isqry = sprintf("insert into %s set userid='%s', goods='%s', regdt=now(), updt=now() ON DUPLICATE KEY UPDATE goods='%s', updt=now()", SW_WISH, $this->appUserid, base64_encode(serialize($re_wish)), base64_encode(serialize($re_wish)));
		else
			$isqry = sprintf("delete from %s where userid='%s'", SW_WISH, $this->appUserid);

		if(parent::_execute($isqry))
			return true;
	}


	/**
	* wishlist array delete --- 여러아이템 삭제
	*/
	public function _del_wish_item_arr($item)
	{
		$rarr = array();
		$w = self::_get_wishlist();
		foreach($w as $v)
		{
			if(!in_array($v['letter_no'], $item))
				$rarr[] = array($v['gidx'], $v['opt'], $v['ea']);
		}

		if(count($rarr) > 0)
			$isqry = sprintf("insert into %s set userid='%s', goods='%s', regdt=now(), updt=now() ON DUPLICATE KEY UPDATE goods='%s', updt=now()", SW_WISH, $this->appUserid, base64_encode(serialize($rarr)), base64_encode(serialize($rarr)));
		else
			$isqry = sprintf("delete from %s where userid='%s'", SW_WISH, $this->appUserid);

		return parent::_execute($isqry);
	}

	/**
	* 선택주문시 임시주문 테이블 save
	*/
	public function _set_basket_tmp($type="sel", $data="")
	{
		$darr = array();
		if(!strcmp($type, "all"))
		{
			foreach($this->item as $v)
			{
				// 재고 확인후 구매상품 담기 --- seob(2019-12-26) //
				if($v['blimit'] != 3)
				{
					if($v['blimit'] == 1)
						$darr[] = array($v['gidx'], $v['opt'], $v['ea']);
					else if($v['blimit'] == 2 && $v['glimit'] >= $v['ea'])
						$darr[] = array($v['gidx'], $v['opt'], $v['ea']);
				}
			}

			//$darr = $this->ar_item;
		}
		else if($data)
		{
			foreach($this->item as $v)
			{
				if(in_array($v['letter_no'], $data) && $v['blimit'] != 3)
				{
					// 재고 확인후 구매상품 담기 --- seob(2019-12-26) //
					if($v['blimit'] == 1)
						$darr[] = array($v['gidx'], $v['opt'], $v['ea']);
					else if($v['blimit'] == 2 && $v['glimit'] >= $v['ea'])
						$darr[] = array($v['gidx'], $v['opt'], $v['ea']);
				}
			}
		}

		if(count($darr) > 0)
		{
			$ordcode = self::_get_tmp_code();
			if($this->appUserid)
			{
				$isuser = 1;
				$userid = $this->appUserid;
			}
			else
			{
				$isuser = 0;
				$userid = $this->appUserid;
			}

			$isqry = sprintf("insert into %s set
								ordcode	= '%s',
								isuser	= '%d',
								userid	= '%s',
								ogoods	= '%s',
								goods	= '%s',
								name	= '',
								email	= '',
								mobile	= '',
								phone	= '',
								rname	= '',
								rzip	= '',
								radr1	= '',
								radr2	= '',
								rmobile	= '',
								rphone	= '',
								comment	= '',
								payway	= '',
								uemoney	= '0',
								ucoupon	= '0',
								refund	= '',
								step	= 'basket',
								regdt	= now(),
								updt	= now()
							ON DUPLICATE KEY UPDATE
								ogoods	= '%s',
								goods	= '%s',
								name	= '',
								email	= '',
								mobile	= '',
								phone	= '',
								rname	= '',
								rzip	= '',
								radr1	= '',
								radr2	= '',
								rmobile	= '',
								rphone	= '',
								comment	= '',
								payway	= '',
								uemoney	= '0',
								ucoupon	= '0',
								refund	= '',
								step	= 'basket',
								updt	= now()", SW_ORDER_TMP, $ordcode, $isuser, $userid, base64_encode(serialize($this->ar_item)), base64_encode(serialize($darr)), base64_encode(serialize($this->ar_item)), base64_encode(serialize($darr)));

			if(parent::_execute($isqry))
				return true;
			else
				return false;
		}
		else
			return false;
	}

	/**
	* wishlist 바로구매
	*/
	public function _set_wish_basket_tmp(array $item)
	{
		if(is_array($item) && count($item) > 0)
		{
			$ordcd = self::_get_tmp_code();
			if($this->appUserid)
			{
				$isuser = 1;
				$userid = $this->appUserid;
			}
			else
			{
				$isuser = 0;
				$_SESSION['SES_TMP_USERID'] = ($_SESSION['SES_TMP_USERID']) ? $_SESSION['SES_TMP_USERID'] : $ordcd;
				$userid = $_SESSION['SES_TMP_USERID'];
			}

			$isqry = sprintf("insert into %s set
								ordcode	= '%s',
								isuser	= '%d',
								userid	= '%s',
								ogoods	= '',
								goods	= '%s',
								name	= '',
								email	= '',
								mobile	= '',
								phone	= '',
								rname	= '',
								rzip	= '',
								radr1	= '',
								radr2	= '',
								rmobile	= '',
								rphone	= '',
								comment	= '',
								payway	= '',
								uemoney	= '0',
								ucoupon	= '0',
								refund	= '',
								step	= 'basket',
								regdt	= now(),
								updt	= now()
							ON DUPLICATE KEY UPDATE
								ogoods	= '',
								goods	= '%s',
								name	= '',
								email	= '',
								mobile	= '',
								phone	= '',
								rname	= '',
								rzip	= '',
								radr1	= '',
								radr2	= '',
								rmobile	= '',
								rphone	= '',
								comment	= '',
								payway	= '',
								uemoney	= '0',
								ucoupon	= '0',
								refund	= '',
								step	= 'basket',
								updt	= now()", SW_ORDER_TMP, $ordcd, $isuser, $userid, base64_encode(serialize($item)), base64_encode(serialize($item)));

			if(parent::_execute($isqry))
				return true;
			else
				return false;
		}
		else
			return false;
	}

	/**
	* 임시 주문번호 생성 --- 비회원일 경우 임시아이디로 사용
	*/
	public function _get_tmp_code()
	{
		for(;;)
		{
			$ordcd = time();
			$sqry = sprintf("select idx from %s where ordcode='%s'", SW_ORDER_TMP, $ordcd);
			if(!parent::isRecodeExists($sqry))
			{
				return $ordcd;
				break;
			}
		}
	}
}
?>
