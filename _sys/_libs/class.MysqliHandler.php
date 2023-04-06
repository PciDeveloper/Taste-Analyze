<?php
/**
* Mysqli Handler Class PHP7
*
* @Author		: seob
* @Update		: 2018-05-30
* @Description	: Mysqli Database Handler Class
* https://github.com/dshafik/php7-mysql-shim/blob/master/lib/mysql.php
*/

class MysqliHandler
{
	protected $db_host;
	protected $db_user;
	protected $db_pass;
	protected $db_name;
	protected $db_port;
	protected $err_report = 1;	//0:에러 미출력, 1:에러 출력

	public $conn = null;
	public $result;

	protected static $instance;	//singleton용 인스턴스

	/**
	* 싱글톤 인스턴스 리턴
	* @param array $params
	*/
	public static function getInstance($params)
	{
		if(!isset(self::$instance))
			self::$instance = new self($params);
		else
			self::$instance->__construct($params);

		return self::$instance;
	}

	/**
	* 생성자
	* @param array $params
	*/
	public function __construct($params="")
	{
		$this->db_host	= DB_HOST;
		$this->db_user	= DB_USER;
		$this->db_pass	= DB_PASS;
		$this->db_name	= DB_NAME;
		$this->db_port	= DB_PORT;

		try {
			$this->_connect();
		} catch(Exception $e) {
			echo($e->getMessage());
			$this->__destruct();
		}
	}

	/**
	* 소멸자
	*/
	public function __destruct()
	{
		if(is_resource($this->result))
			@mysqli_free_result($this->result);

		$result = mysqli_close($this->conn);
		$this->conn = null;
		return $result;
	}

	/**
	* Connection
	*/
	private function _connect()
	{
		if($this->db_port)
			$this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->db_port, '/var/lib/mysql/mysql.sock');
		else
			$this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

		if(!$this->conn)
		{
			$err['errmsg']	= sprintf("Mysqli Connect failed : %s %s", mysqli_connect_errno(), mysqli_connect_error());
			self::_error($err);
			return;
		}


		mysqli_set_charset($this->conn, "utf8");
	}

	/**
	* transaction start	- xe 참조
	*/
	public function _begin($transactionLevel = 0)
	{
		if(!$transactionLevel)
			self::_execute("begin");
		else
			self::_execute("SAVEPOINT SP".$transactionLevel);

		return true;
	}

	/**
	* transaction commit
	*/
	public function _commit()
	{
		$result = mysqli_commit($this->conn);

		if(!$result)
		{
			$debug = @debug_backtrace();
			if($debug)
			{
				krsort($debug);
				foreach($debug as $v)
					$arr_debug[] = sprintf("%s (line : %s)", $v['file'], $v['line']);

				if($arr_debug)
					$arr_debug = implode("<br />", $arr_debug);
			}

			$err['query'] = $sql;
			$err['file'] = $arr_debug;
			self::_error($err);
		}
		else
			return $result;
	}

	/**
	* transaction rollback
	*/
	public function _rollback($transactionLevel=0)
	{
		$result = mysqli_rollback($this->conn);
		if(!$result)
		{
			$debug = @debug_backtrace();
			if($debug)
			{
				krsort($debug);
				foreach($debug as $v)
					$arr_debug[] = sprintf("%s (line : %s)", $v['file'], $v['line']);

				if($arr_debug)
					$arr_debug = implode("<br />", $arr_debug);
			}

			$err['query'] = $sql;
			$err['file'] = $arr_debug;
			self::_error($err);
		}
		else
			return $result;
	}

	/**
	* mysql_query()
	* @param string
	*/
	public function _execute($sql)
	{
		$result = mysqli_query($this->conn, $sql);

		if(!$result)
		{
			$debug = @debug_backtrace();
			if($debug)
			{
				krsort($debug);
				foreach($debug as $v)
					$arr_debug[] = sprintf("%s (line : %s)", $v['file'], $v['line']);

				if($arr_debug)
					$arr_debug = implode("<br />", $arr_debug);
			}

			$err['query'] = $sql;
			$err['file'] = $arr_debug;
			self::_error($err);
		}
		else
			return $result;
	}

	/**
	* mysql_affected_rows
	* @param string
	* @return integer
	*/
	public function _affected(&$numrows, $sql)
	{
		$qry = self::_execute($sql);
		$numrows = mysqli_affected_rows($this->conn);
	}

	/**
	* is table recode
	* @param string query
	* @return boolean (TRUE or FALSE)
	*/
	public function isRecodeExists($sql)
	{
		self::_affected($numrows, $sql);

		if($numrows > 0)
			return TRUE;
		else
			return FALSE;
	}

	/**
	* mysql_fetch_array OR mysql_fetch_assoc
	* @param string
	* @return array
	*/
	public function _fetch($sql, $type=0)
	{
		$result = self::_execute($sql);
		return (!$type) ? @mysqli_fetch_array($result) : @mysqli_fetch_assoc($result);
	}

	/**
	* one recode select
	* @param string : tbname(테이블명), wfield(검색 필드명->디폴트 idx), val(검색 조건)
	* @return array : recode result
	*/
	public function _select(&$row, $tbnm, $wfd='idx', $val)
	{
		if(is_numeric($val) === true)
			$sqry = sprintf("select * from %s where %s='%s' limit 1", $tbnm, $wfd, $val);
		else
		{
			$encArr = _get_decode64($val);
			$sqry = sprintf("select * from %s where %s='%s' limit 1", $tbnm, $wfd, $encArr[$wfd]);
		}

		$row = self::_fetch($sqry, 1);
	}

	/**
	* mysql_num_rows
	* @param query
	* @return integer
	*/
	public function _count($result)
	{
		if(is_resource($result))
			$rows = mysqli_num_rows($result);

		if($rows !== null)
			return $rows;
	}

	/**
	* check table exists
	* @param string(Table Name)
	* @return integer
	*/
	public function isTableExists($tbnm)
	{
		if($tbnm)
		{
			$sqry = sprintf("select count(*) from information_schema.tables where table_name='%s'", $tbnm);
			$rows = self::_fetch($sqry);

			return $rows[0];
		}
		else
			return 0;
	}

	/**
	* mysqli_real_escape_string
	* @param string(query string)
	* @return string(query string)
	*/
	public function _get_real_escape_string($sql)
	{
		return mysqli_real_escape_string($this->conn, $sql);
	}

	/**
	* mysql_insert_id
	* @return integer
	*/
	public function _get_insert_id()
	{
		return @mysqli_insert_id($this->conn);
	}

	/**
	* Max
	* @param string(Table Name, Field Name, Where)
	* @return integer
	*/
	public function _get_max_field($tbnm, $field, $w="")
	{
		if($w)
			$addWhere = sprintf(" AND %s", $w);

		$sqry = sprintf("select if(isnull(max(%s)), '1', max(%s)+1) as max_result from %s where 1=1 %s", $field, $field, $tbnm, $addWhere);
		$result = $this->_fetch($sqry);

		return $result['max_result'];
	}

	/**
	* truncate
	* @param string(Table name)
	*/
	public function _truncate($tb)
	{
		if($tb)
		{
			$sqry = sprintf("truncate table %s", $tb);
			return $this->_execute($sqry);
		}
	}

	/**
	* database disconnection
	* @param
	* @return
	*/
	public function _close()
	{
		@mysqli_close($this->conn);
	}


	/**
	* Error Report
	* @param array param
	*/
	public function _error($err)
	{
		if($this->err_report)
		{
			echo "
			<div style='background-color:#f7f7f7;padding:2'>
			<table width=100% border=1 bordercolor='#cccccc' style='border-collapse:collapse;font:9pt tahoma'>
			<col width=100 style='padding-right:10;text-align:right;font-weight:bold'><col style='padding:3 0 3 10'>
			<tr><td>error</td><td>".mysqli_error($this->conn)."</td></tr>
			";
			foreach ($err as $k=>$v) echo "<tr><td>$k</td><td>$v</td></tr>";
			echo "</table></div>";
		}
	}
}
?>
