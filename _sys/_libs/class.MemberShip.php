<?php
/**
* MemberShip Handler Class PHP5
*
* @Author		: seob
* @Update		: 2017-04-10
* @Description	: MemberShip Handler Class
*/
class MemberShipHandler extends MysqliHandler
{
	public $userid;
	public $vars = array();
	public $is_mobile = false;
	public $mobile_path = "";

	/**
	* 생성자
	* @param array $params
	*/
	public function __construct()
	{
		$this->is_mobile = _is_dir_mobile();
		if($this->is_mobile === true)
			$this->mobile_path = "/m";

		$this->userid = $_SESSION['SES_USERID'];

		parent::__construct();
		self::_get_member();

		if(!$this->vars)
		{
			unset($_SESSION['SES_USERID'], $_SESSION['SES_USERNM'], $_SESSION['SES_USERLV']);
			gourl($this->mobile_path."/member/login.php?referer=".$_SERVER['SCRIPT_NAME'], "P", "로그인 전이시거나 아직 회원이 아니십니다.");
			exit;
		}
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* member information
	*/
	protected function _get_member()
	{
		$sqry = sprintf("select * from %s where userid='%s'", SW_MEMBER, $this->userid);
		$this->vars = parent::_fetch($sqry, 1);
	}

	/**
	* member update information
	*/
	public function _get_update_inf()
	{
		$this->vars['ex_bi']	= explode("-", $this->vars['birthday']);
		$this->vars['ex_mo']	= explode("-", $this->vars['mobile']);
		$this->vars['ex_ph']	= explode("-", $this->vars['phone']);
		$this->vars['ex_em']	= explode("@", $this->vars['email']);
	}

	/**
	* get wishlist
	*/
	public function _get_wishlist_item(&$wish)
	{
		$arkeys = array("gidx", "opt", "ea");
		$sqry = sprintf("select goods from %s where userid='%s'", SW_WISH, $this->vars['userid']);
		$row = parent::_fetch($sqry, 1);

		if($row['goods'])
		{
			$optamt = 0;
			$goods = unserialize(stripslashes(base64_decode($row['goods'])));
			$letter_no = 0;
			foreach($goods as $v)
			{
				$opt = array();
				$v = array_combine($arkeys, $v);
				$letter_no++;
				$sqry = sprintf("select gcode, name, price, img3, category from %s where idx='%s'", SW_GOODS, $v['gidx']);
				$row = parent::_fetch($sqry, 1);
				$row['letter_no'] = $letter_no;

				// 옵션 값 //
				if(is_array($v['opt']) && count($v['opt']) > 0)
				{
					foreach($v['opt'] as $vv)
					{
						$ex = explode("∏‡", $vv);
						$option = self::_get_option_info($row['gcode'], $ex[0]);
						if($option)
						{
							$row['stropt'][] = sprintf("<span class=\"option\">%s : %s %s</span>", $option['optnm'], $ex[1], (($ex[3] > 0) ? "(".$ex[2].number_format($ex[3]).")" : ""));
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
				$row['samt'] = ($v['ea'] * $row['price']) + $optamt;
				$v = array_merge($v, $row);
				$wish[] = $v;
			}
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
	* mypage wish list
	*/
	public function _get_wish()
	{
		$sqry = sprintf("select a.*, b.img3, b.name, b.price from %s a, %s b where a.gidx=b.idx and a.userid='%s' order by idx asc", SW_WISH, SW_GOODS, $_SESSION['SES_USERID']);
		$qry = parent::_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			if($row['opt'])
			{
				$ex = explode("」「", $row['opt']);
				foreach($ex as $v)
				{
					$eex = explode("|", $v);
					$row['opt_ex'][] = sprintf("<span class=\"size\">%s : %s%s</span>", $eex[0], $eex[1], (($eex[2] > 0) ? "(".number_format($eex[2])."원)" : ""));
				}
			}
			$arr[] = $row;
		}

		return $arr;
	}

	/**
	* mypage lnb tabs
	*/
	public function _set_mypage_tabs()
	{
		global $_get_curr_page;
		$tabs = sprintf("<div class=\"my_tabs\">
							<ul>
								<li><a href=\"%s/mypage/\" %s>회원정보수정</a></li>
								<li><a href=\"%s/mypage/order.php\" %s>주문배송조회</a></li>
								<li><a href=\"%s/mypage/wish.php\" %s>위시리스트</a></li>
								<li><a href=\"%s/mypage/emoney.php\" %s>적립금내역</a></li>
								<li><a href=\"%s/mypage/leave.php\" %s>회원탈퇴</a></li>
							</ul>
						</div>",
						$this->mobile_path,
						(($_get_curr_page == "index.php") ? "class=\"on\"" : ""),
						$this->mobile_path,
						(($_get_curr_page == "order.php" || $_get_curr_page == "detail.php") ? "class=\"on\"" : ""),
						$this->mobile_path,
						(($_get_curr_page == "wish.php") ? "class=\"on\"" : ""),
						$this->mobile_path,
						(($_get_curr_page == "emoney.php") ? "class=\"on\"" : ""),
						$this->mobile_path,
						(($_get_curr_page == "leave.php") ? "class=\"on\"" : ""));
		return $tabs;
	}
}
?>
