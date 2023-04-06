<?
/**
* Mysql Handler Class PHP5
*
* @Author		:	kkang(sinbiweb)
* @Update		:	2014-07-29
* @Description	:	Mysql Database Handler Class
*/

class MysqlHandler
{
	protected $db_host;
	protected $db_user;
	protected $db_pass;
	protected $db_name;
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
		if(!strcmp($params['host'], "zipcode"))
		{
			$this->db_host = ZIP_HOST;
			$this->db_user = ZIP_USER;
			$this->db_pass = ZIP_PASS;
			$this->db_name = ZIP_NAME;
		}
		else if(!strcmp($params['host'], "street"))
		{
			$this->db_host = STR_HOST;
			$this->db_user = STR_USER;
			$this->db_pass = STR_PASS;
			$this->db_name = STR_NAME;
		}
		else
		{
			$this->db_host = DB_HOST;
			$this->db_user = DB_USER;
			$this->db_pass = DB_PASS;
			$this->db_name = DB_NAME;
		}

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
			@mysql_free_result($this->result);

		$result = mysql_close($this->conn);
		$this->conn = null;
		return $result;
	}

	/**
	* Connection
	*/
	private function _connect()
	{
		$this->conn = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
		if(!is_resource($this->conn))
		{
			$err['errmsg'] = "Mysql DataBase Connection Error.";
			$this->_error($err);
		}
		else
		{
			if(!mysql_select_db($this->db_name, $this->conn))
			{
				$err['errmsg'] = "Mysql DataBase Selection Error.";
				$this->_error($err);
			}

			@mysql_query("set session character_set_connection=utf8;");
			@mysql_query("set session character_set_results=utf8;");
			@mysql_query("set session character_set_client=utf8;");
		}
	}

	/**
	* mysql_query()
	* @param string
	*/
	public function _execute($sql)
	{
		$result = mysql_query($sql, $this->conn);

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
		$qry = $this->_execute($sql);
		$numrows = mysql_affected_rows();
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
		if(!is_resource($result))
			$result = self::_execute($sql);

		return (!$type) ? @mysql_fetch_array($result) : @mysql_fetch_assoc($result);
	}

	/**
	* mysql_num_rows
	* @param query
	* @return integer
	*/
	public function _count($result)
	{
		if(is_resource($result))
			$rows = mysql_num_rows($result);

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
			$sqry = sprintf("select count(*) from infomation_schema.tables where table_name'%s'", $tbnm);
			$rows = self::_fetch($sqry);

			return $rows[0];
		}
		else
			return 0;
	}

	/**
	* mysql_insert_id
	* @return integer
	*/
	public function getLastID()
	{
		return @mysql_insert_id();
	}

	/**
	* Max
	* @param string(Table Name, Field Name, Where)
	* @return integer
	*/
	public function getMaxNum($tbnm, $field, $w="")
	{
		if($w)
			$addWhere = sprintf(" AND %s", $w);

		$sqry = sprintf("select if(isnull(max(%s)), '1', max(%s)+1) as max_result from %s where 1=1 %s", $field, $field, $tbnm, $addWhere);
		$result = $this->_fetch($sqry);

		return $result['max_result'];
	}

	/**
	* Password 암호화
	* @param string(password)
	* @return password
	*/
	public function _password($str)
	{
		if($str)
		{
			$sqry = sprintf("select password('%s') as pwd", $str);
			$pwd = $this->_fetch($sqry);

			return $pwd['pwd'];
		}
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
			<tr><td>error</td><td>".mysql_error()."</td></tr>
			";
			foreach ($err as $k=>$v) echo "<tr><td>$k</td><td>$v</td></tr>";
			echo "</table></div>";
		}
	}
}
?>
