<?php
/**
* Goods Handler Class PHP5
*
* @Author		:	seob
* @Update		:	2014-09-04
* @Description	:	Goods Handler Class
*/

class GoodsHandler extends MysqliHandler
{
	protected $gidx;
	public $vars = array();
	public $opt = array();
	protected static $instance;

	/**
	* 싱글톤 인스턴스 리턴
	* @param array $params
	*/
	public static function getInstance($gidx)
	{
		if(!isset(self::$instance))
			self::$instance = new self($gidx);
		else
			self::$instance->__construct($gidx);

		return self::$instance;
	}

	/**
	* 생성자
	* @param array $params
	*/
	public function __construct($gidx)
	{
		$this->gidx = $gidx;

		if(!$this->gidx)
		{
			msg("해당상품정보가 존재하지 않습니다.", -1, true);
			return;
		}

		parent::__construct();
		self::_get_goods_vars();
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* goods information
	* @return array $vars
	*/
	public function _get_goods_vars()
	{
		global $cfg;

		$sqry = sprintf("select * from %s where display='Y' and idx='%d'", SW_GOODS, $this->gidx);
		$row = parent::_fetch($sqry, 1);
		if(!$row) {
			$data_json['status']	=	(int)"2";
			$data_json['msg']   	=	"상품이 삭제되었거나 판매가 중단된 상품입니다";
			$json =  json_encode($data_json);
			echo $json;
			exit;
		}

		$row['is_sale'] = $row['is_soldout'] = FALSE;	//판매, 품절여부(기본셋팅)//
		if(_is_dir_mobile())
		{
			$row['content'] = preg_replace("/ height=(\"|\')?\d+(\"|\')?/", "", preg_replace("/ width=(\"|\')?\d+(\"|\')?/", "", $row['content']));
			$row['content'] = preg_replace("(width[\s]*:[\s]*\d+[\s]*px[\;]?|height[\s]*:[\s]*\d+[\s]*px[\;]?)", "", $row['content']);
		}

		/// 상품별 적립금 ///
		if($row['pointmod'] == 1)
			$row['point'] = $row['price'] * ($cfg['point']['point']/100);
		else if($row['pointmod'] == 2 && $row['point'])
			$row['point'] = $row['point'];
		else
			$row['point'] = 0;

		if($row['point'] > 0)
			$ar_show_column[] = sprintf("<dl><dt>적립금</dt><dd>%sP</dd></dl>", number_format($row['point']));

		/// 원산지, 제조사 및 추가항목 설정 ///
		$ar_show_column = array();
		if($row['origin'])
			$ar_show_column[] = sprintf("<dl><dt>원산지</dt><dd>%s</dd></dl>", $row['origin']);
		if($row['maker'])
			$ar_show_column[] = sprintf("<dl><dt>제조사</dt><dd>%s</dd></dl>", $row['maker']);

		for($i=1; $i < 4; $i++)
		{
			if($row['etc'.$i])
			{
				$ex_etc = explode("」「", $row['etc'.$i]);
				$ar_show_column[] = sprintf("<dl>
												<dt>%s</dt>
												<dd>%s</dd>
											</dl>", $ex_etc[0], $ex_etc[1]);
			}
		}

		if(is_array($ar_show_column) && count($ar_show_column) > 0)
			$row['show_column'] = implode("\n", $ar_show_column);


		/// 추가이미지 ///
		if($row['imgetc'])
		{
			$row['img'] = explode(",", $row['imgetc']);
			array_unshift($row['img'], $row['img2']);
		}
		else
			$row['img'][] = $row['img2'];

		/// 기본합계금액 ///
		$row['ttamt'] = $row['mnea'] * $row['price'];

		/// goods stock check ///
		if($row['blimit'] == 3 || ($row['blimit'] == 2 && $row['glimit'] < 1)) $row['is_soldout'] = TRUE;	//품절인경우//

		/// 관련상품 ///
		if($row['related'])
		{
			$rgoods = array();
			$arRelated = explode(",", $row['related']);
			$sqry = sprintf("select idx, name, img3, price, blimit, icon from %s where idx in(%s) and display='Y' order by seq asc", SW_GOODS, $row['related']);
			$qry = parent::_execute($sqry);
			while($rrow = mysqli_fetch_assoc($qry))
				$rgoods[] = $rrow;

			$row['rgoods'] = $rgoods;
		}

		/// 상품정보를 직렬화시킴(판매가,재고설정,재고량,최소구매수량,최대구매수량) --- javascript 처리에 사용함 ///
		$row['js_goods_info'] = sprintf("%s∏‡%s∏‡%s∏‡%s∏‡%s", $row['price'], $row['blimit'], $row['glimit'], $row['mnea'], $row['mxea']);

		$this->vars = $row;
		/// 상품 옵션설정 ///
		if(!strcmp($row['boption'], 'Y')) self::_get_goods_opt($row['gcode']);
	}

	/**
	* goods option
	* @param : $gcode-상품코드
	*/
	private function _get_goods_opt($gcode)
	{
		$sqry = sprintf("select * from %s where gcode='%s' order by idx asc", SW_OPTION, $gcode);

		if(parent::isRecodeExists($sqry))
		{
			$arOpt = array();
			$qry = parent::_execute($sqry);
			while($orow=mysqli_fetch_assoc($qry))
			{
				$arOpt[] = array(
									"optcd"		=> $orow['optcd'],
									"optnm"		=> $orow['optnm'],
									"optval"	=> explode("」「", $orow['optval']),
									"optmark"	=> explode("」「", $orow['optmark']),
									"optpay"	=> explode("」「", $orow['optpay']),
									"optreq"	=> $orow['optreq']
								);
			}

			$this->opt = $arOpt;
			self::_make_option_box();
			self::_make_option_box_api();
		}
	}

	/**
	* make goods option box
	*/
	private function _make_option_box()
	{
		$arr = array();
		$arr2 = array();
		for($i=0, $j=1; $i < count($this->opt); $i++, $j++)
		{
      for($o=0; $o < count($this->opt[$i]['optval']); $o++)
      {
			     $sbox = sprintf("%s∏‡%s∏‡%s∏‡%s" , $this->opt[$i]['optcd'], $this->opt[$i]['optval'][$o], $this->opt[$i]['optmark'][$o], $this->opt[$i]['optpay'][$o]);
      }

			$arr[] = $sbox;
		}

		if(count($arr) > 0)
			$this->vars['optbox'] = $arr;


		for($i=0, $j=1; $i < count($this->opt); $i++, $j++)
		{
			$sbox = "";
			if(!$this->opt[$i]['optreq'])
				$sbox .= sprintf("%s 선택안함", $this->opt[$i]['optnm']);
				$sbox .= ",";
			for($o=0; $o < count($this->opt[$i]['optval']); $o++)
			{
				$sbox .= sprintf("%s∏‡%s∏‡%s∏‡%s ", $this->opt[$i]['optcd'], $this->opt[$i]['optval'][$o], $this->opt[$i]['optmark'][$o], $this->opt[$i]['optpay'][$o], $this->opt[$i]['optval'][$o]);
				$sbox .= ",";
			}

			$arr2[] = $sbox;
		}

		if(count($arr2) > 0)
			$this->vars['optbox2'] = $arr2;
	}

	private function _make_option_box_api()
	{
		$arr = array();
		for($i=0, $j=1; $i < count($this->opt); $i++, $j++)
		{
			$sbox = "";
			$sbox['optreq'] = $this->opt[$i]['optreq'];
	        $sbox['optnm'] = $this->opt[$i]['optnm'];


			for($o=0; $o < count($this->opt[$i]['optval']); $o++)
			{
				$sbox['optval'][$o] = $this->opt[$i]['optval'][$o];
				$sbox['optpay'][$o] = (($this->opt[$i]['optpay'][$o] > 0) ? "(".$this->opt[$i]['optmark'][$o]." ".number_format($this->opt[$i]['optpay'][$o])."원)" : "0원");
			}

			$arr[] = $sbox;
		}

		if(count($arr) > 0)
			$this->vars['optboxapi'] = $arr;
	}

	/**
	* set goods hit plus
	*/
	public function _set_goods_hit()
	{
		if(!_get_session("CK_GOODS_".$this->vars['idx']))
		{
			parent::_execute("update ".SW_GOODS." set hit=hit+1 where idx='".$this->vars['idx']."'");
			_set_session("CK_GOODS_".$this->vars['idx'], true);
		}
	}

	/**
	* set today view
	*/
	public function _set_today_goods()
	{
		$max = 9;
		$ar_today_goods = array();
		$cok_time = 24 - date('H');
		$cok_time = ($cok_time) ? $cok_time : 1;
		if($_COOKIE['COK_TODAY_GOODS'])
			$ar_today_goods = explode(",", unserialize(stripslashes($_COOKIE['COK_TODAY_GOODS'])));

		if($this->vars['idx'] && !in_array($this->vars['idx'], $ar_today_goods))
		{
			array_unshift($ar_today_goods, $this->vars['idx']);
			array_splice($ar_today_goods, $max);
			setcookie("COK_TODAY_GOODS", serialize(implode(",", $ar_today_goods)), time()+3600*$cok_time, "/");
		}
	}
}
?>
