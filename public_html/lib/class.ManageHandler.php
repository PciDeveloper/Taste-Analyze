<?
/**
* Management Handler Class PHP5
*
* @Author		:	kkang(sinbiweb)
* @Update		:	2014-09-12
* @Description	:	Management Handler Class(order, mypage, emoney)
*/

class ManageHandler extends MysqlHandler 
{
	public $isadm = false;
	public $mode;
	public $order;
	public $gitem;
	public $item;
	public $wish;
	public $cart;
	public $ordcode;
	protected $item_keys = array("gidx", "gsize", "gcolor", "gwrap", "ea");

	/** 
	* 생성자
	* @param array $params
	*/
	public function ManageHandler($mode="order", $isadm=false)
	{
		$this->isadm = $isadm;
		$this->mode = $mode;

		parent::__construct();
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* order & order item 
	*/
	public function getOrdAll($ordcode="", $idx="") 
	{
		if($ordcode)
			$sqry = sprintf("select * from %s where ordcode='%s'", SW_ORDER, $ordcode);
		else if($idx)
			$sqry = sprintf("select * from %s where idx='%s'", SW_ORDER, $idx);
		else
			msg("올바른 접속이 아닙니다.", -1, true);

		if(parent::isRecodeExists($sqry))
		{
			$this->order = parent::_fetch($sqry, 1);
			if(!strcmp($this->order['payway'], "SBANK"))
			{
				$arr_bank = explode($this->order['bankinfo'], "|");
				$this->order['sbank_number'] = $arr_bank[0];
				$this->order['sbank_name'] = $arr_bank[1];
				$this->order['sbank_owner'] = $arr_bank[2];
			}
			self::getOrderItem($this->order['ordcode']);
		}
	}

	/**
	* order item 
	*/
	public function getOrderItem($ordcode)
	{
		$sqry = sprintf("select a.gidx, a.price, a.ea, a.emoney, a.bsale, b.name, b.img3, b.price as oprice, b.icon, b.category, b.blimit, b.glimit from %s a, %s b where a.gidx=b.idx and a.ordcode='%s' order by a.idx asc", SW_ORDER_ITEM, SW_GOODS, $ordcode);
		$qry = parent::_execute($sqry);

		$arr_item = array();
		$total_ea = 0;

		while($row=mysql_fetch_assoc($qry))
		{
			$arr_item[] = $row;
			$total_ea += $row['ea']; 
		}

		if(count($arr_item) > 1)
			$ordgname = sprintf("%s 외 %d건", $arr_item[0]['name'], count($arr_item)-1);
		else
			$ordgname =  $arr_item[0]['name'];

		$this->item = array("item" => $arr_item, "total_ea"=>$total_ea, "ordgname" => $ordgname);
	}

	/**
	* 관심상품 select
	*/
	public function getWishList($limit="5")
	{
		$sqry = sprintf("select a.*, b.name, b.img3, b.price, b.icon from %s a, %s b where a.gidx=b.idx and userid='%s' order by a.idx desc", SW_WISH, SW_GOODS, $_SESSION['SES_USERID']);
		parent::_affected($total, $sqry);
		$sqry .= sprintf(" limit %d", $limit);
		$qry = parent::_execute($sqry);
		$arr_item = array();
		while($row=mysql_fetch_array($qry))
			$arr_item[] = $row;

		$this->wish = array("total"=>$total, "item"=>$arr_item);
	}

	/** 
	* 장바구니 select 
	*/
	public function getCartList()
	{
		$sqry = sprintf("select goods from %s where userid=TRIM('%s') order by idx desc limit 1", SW_CART, $_SESSION['SES_USERID']);
		if(parent::isRecodeExists($sqry))
		{
			$row = parent::_fetch($sqry, 1);
			$arCart = unserialize(stripslashes(base64_decode($row['goods'])));

			if(count($arCart) > 0)
			{
				$arr_item = array();
				for($i=0; $i < count($arCart); $i++)
				{
					$sqry = sprintf("select idx, name, icon, category, img3, delivery, dyprice, ndyprice, price, blimit, glimit, pointmod, point, pointunit from %s where idx='%d' order by idx desc limit 1", SW_GOODS, $arCart[$i][0]);
					$goods = parent::_fetch($sqry, 1);
					$arr_item[] = $goods;
				}

				$this->cart = array("total"=>count($arr_item), "item"=>$arr_item);
			}
		}
	}

	/** 
	* point save
	*/ 
	public function setEmoney()
	{
		$apoint = array();

		for($i=0; $i < count($this->item['item']); $i++)
		{
			if($this->item['item'][$i]['emoney'] > 0)
				$apoint[] = ($this->item['item'][$i]['emoney'] * $this->item['item'][$i]['ea']);
		}

		$totpoint = array_sum($apoint);
		if($totpoint > 0 && $this->order['userid'])
		{
			$mb = getMember($this->order['userid']);
			$reason = $this->item['ordgname']." 상품구매 포인트 적립";
			setCash($mb['idx'], $totpoint, 2, "+", $reason);	
		}
	}

	/**
	* 취소 및 반품시 적립금 회수
	*/
	public function reEmoney()
	{
		$apoint = array();

		for($i=0; $i < count($this->item['item']); $i++)
		{
			if($this->item['item'][$i]['emoney'] > 0)
				$apoint[] = ($this->item['item'][$i]['emoney'] * $this->item['item'][$i]['ea']);
		}

		$totpoint = array_sum($apoint);

		if($totpoint > 0 && $this->order['userid'])
		{
			$mb = getMember($this->order['userid']);
			$reason = $this->item['ordgname']." 상품구매취소로 적립금 회수";
			setCash($mb['idx'], $totpoint, 9, "-", $reason);
		}
	}

	/** 
	* 포인트 결제내역이 있으면 적립금 사용내역 재입력
	*/
	public function useEmoney()
	{
		if($this->order['upoint'] && $this->order['upoint'] > 0)
		{
			if(count($this->item['item']) > 1)
				$ordgname = sprintf("%s 외 %d건", $this->item['item'][0]['name'], count($this->item['item'])-1);
			else
				$ordgname =  $this->item['item'][0]['name'];
			
			$mb = getMember($this->order['userid']);
			$reason = $ordgname." 상품구매시 포인트사용";
			setCash($mb['idx'], $this->order['upoint'], 1, "-", $reason);	
		}
	}

	/* 
	* 주문취소 및 반품취소시 사용적립금 리워드 
	*/
	public function RewardEmoney()
	{
		if($this->order['upoint'] && $this->order['upoint'] > 0)
		{
			if(count($this->item['item']) > 1)
				$ordgname = sprintf("%s 외 %d건", $this->item['item'][0]['name'], count($this->item['item'])-1);
			else
				$ordgname =  $this->item['item'][0]['name'];

			$mb = getMember($this->order['userid']);
			$reason = $ordgname." 주문취소(반품)로 사용포인트 재적립";
			setCash($mb['idx'], $this->order['upoint'], 9, "+", $reason);
		}
	}
}