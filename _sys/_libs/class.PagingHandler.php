<?php
/**
* Paging Handler Class PHP5
*
* @Author		: seob
* @Update		:	2017-01-24
* @Description	:	Paging Handler Class
*/

class PagingHandler
{
	protected $start;			//페이지별 게시물 시작번호
	protected $pg_limit;		//페이지당 출력 게시물수
	protected $pg_block;		//페이지블럭(노출할 페이지수)
	protected $url;				//이동할 페이지URL
	protected $vars = array();	//설정배열
	public $t_rows;				//총게시물수
	public $t_page;				//총페이지수
	public $c_page;				//현재페이지번호
	public $c_block;			//현재블럭 페이지번호
	public $url_param;			//URL 파라메타(_GET)

	public $page_result = "";	//페이지 출력태그

	protected static $instance;	//singleton 인스턴스

	/**
	* singleton instance return
	* @param : $parameter ...
	*/
	public static function getInstance($S, $L, $B=10, $T=0, $params="")
	{
		if(!isset(self::$instance))
			self::$instance = new self($S, $L, $B, $T, $params);
		else
			self::$instance->__construct($S, $L, $B, $T, $params);

		return self::$instance;
	}

	/**
	* Constructor
	* @param : $parameter ...
	*/
	public function __construct($S, $L, $B=10, $T=0, $params="")
	{
		$this->start		= $S;
		$this->pg_limit		= $L;
		$this->pg_block		= $B;
		$this->t_rows		= $T;
		$this->url			= $_SERVER['PHP_SELF'];
		$this->url_param	= ($params) ? self::_get_urlparam($params) : "";

		self::_set_paging();
	}

	/**
	* Destruct
	*/
	public function __destruct()
	{
		//소멸자....
	}

	/**
	* Paging 설정
	*/
	private function _set_paging()
	{
		$this->vars['contexture']	= $this->pg_limit * $this->pg_block;		//기본계산값 셋팅
		$this->vars['offset']		= ($this->start) ? floor(($this->start/$this->pg_limit)/$this->pg_block) : 0;	//계산용 블럭
		$this->t_page				= ceil($this->t_rows/$this->pg_limit);		//총페이지수
		$this->t_block				= ceil($this->t_page/$this->pg_block);		//총블럭수
		$this->c_block				= ($this->start) ? ceil(ceil(($this->start+$this->pg_limit)/$this->pg_limit)/$this->pg_block) : 1;	//현재블럭
		$this->c_page				= ($this->start + $this->pg_limit)/$this->pg_limit;	//현재페이지

		$this->vars['maxBlock']		= floor($this->t_page/$this->pg_block);		//마지막블럭(최대블럭)
		$this->vars['from']			= $this->vars['offset'] * $this->vars['contexture'];
		$this->vars['curSize']		= ($this->vars['offset'] == $this->vars['maxBlock']) ? ceil(($this->t_rows % $this->vars['contexture'])/$this->pg_limit) : $this->pg_block;
	}

	/**
	* get page tags
	*/
	public function _get_paging()
	{
		if($this->vars['offset'] > 0)
		{
			$this->page['first_block']	= self::_set_other_page(0, "&lt;&lt;", "");
			$this->page['prev_block']	= self::_set_other_page($this->vars['from']-$this->pg_limit, "&lt;", "");
		}
		else
		{
			$this->page['first_block']	= "<a>&lt;&lt;</a>";
			$this->page['prev_block']	= "<a>&lt;</a>";
		}

		if($this->c_block < $this->t_block)
		{
			$this->page['last_block']	= self::_set_other_page((ceil($this->t_rows/$this->pg_limit)-1)*$this->pg_limit, "&gt;&gt;", "");
			$this->page['next_block']	= self::_set_other_page($this->vars['from']+$this->vars['contexture'], "&gt;", "");
		}
		else
		{
			$this->page['last_block']	= "<a>&gt;&gt;</a>";
			$this->page['next_block']	= "<a>&gt;</a>";
		}

		$pos = $this->vars['offset'] * $this->pg_block;
		for($p=0; $p < $this->vars['curSize']; $p++)
		{
			$start = $p * $this->pg_limit + $this->vars['from'];
			++$pos;
			$this->page['page'][] = ($start == $this->start) ? self::_set_current_page($pos) : self::_set_other_page($start, $pos);
		}

		if($this->t_rows > 0)
			return sprintf("<div class=\"hy_paging\">%s\n%s\n<span>%s</span>\n%s\n%s</div>", $this->page['first_block'], $this->page['prev_block'], implode("\n", $this->page['page']), $this->page['next_block'], $this->page['last_block']);
	}

	/**
	* current page set
	*/
	private function _set_current_page($page)
	{
		return sprintf("<a class=\"on\">%s</a>", $page);
	}

	/**
	* other page set
	*/
	private function _set_other_page($start, $page, $class="")
	{
		$encData = "start=".$start;
		if($this->url_param)
			$encData .= "&".$this->url_param;

		$encData = _get_encode64($encData);
		return sprintf("<a href=\"%s?encData=%s\" %s>%s</a>", $this->url, $encData, (($class) ? "class=\"".$class."\"" : ""), $page);
	}

	/**
	* parameter -> get url parameter
	*/
	public function _get_urlparam(array $params)
	{
		if($params)
		{
			$arParam = array();
			foreach($params as $k=>$v)
				if($v) $arParam[] = sprintf("%s=%s", $k, urlencode($v));

			if($arParam)
				return @implode("&", $arParam);
		}
	}
}
?>
