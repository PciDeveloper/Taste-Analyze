<?php
/**
* Common Handler Class PHP5
*
* @Author		: seob
* @Update		: 2017-04-17
* @Description	: Common Handler Class
*/

class CommonHandler extends MysqlHandler
{
	protected	$param = array();
	protected static $instance;

	/**
	* 싱글톤 인스턴스 리턴
	* @param array $params
	*/
	public static function getInstance($param)
	{
		if(!isset(self::$instance))
			self::$instance = new self($param);
		else
			self::$instance->__construct($param);

		return self::$instance;
	}

	/**
	* 생성자
	* @param array $params
	*/
	public function __construct($param="")
	{
		$this->param = $param;
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
	* board outer
	*/
	public function _get_board_data($code, $limit, $param="")
	{
		if($param)
		{
			$arrW = array();
			foreach($param as $k=>$v)
				$arrW[] = sprintf("%s='%s'", $k, $v);

			if(count($arrW) > 0)
				$AddW = sprintf(" and %s", implode(" and ", $arrW));
		}

		$sqry = sprintf("select idx, title, video, regdt from %s where code='%s' %s order by ref desc, re_step asc limit %d", SW_BOARD, $code, $AddW, $limit);
		$qry = parent::_execute($sqry);
		while($row=mysql_fetch_assoc($qry))
		{
			$row['fdata'] = self::_get_board_file($code, $row['idx'], "ONE", "image");
			$arr[] = $row;
		}

		return $arr;
	}

	/**
	* get board upfile
	*/
	public function _get_board_file($code, $bidx, $mode="ALL", $type="")
	{
		if($type)
			$AddW = sprintf(" and ftype='%s'", $type);

		$sqry = sprintf("select idx, upfile, upreal from %s where code='%s' and bidx='%d' %s order by idx asc", SW_BOARDFILE, $code, $bidx, $AddW);
		if(!strcmp($mode, "ONE"))
		{
			$sqry .= " limit 1";
			$fdata = parent::_fetch($sqry, 1);
		}
		else
		{
			$qry = parent::_execute($sqry);
			while($row = mysql_fetch_assoc($qry))
				$fdata[] = $row;
		}

		return $fdata;
	}
}
?>
