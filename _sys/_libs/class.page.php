<?php
/**
* Paging Navigation Handler
*
* @Author		: seob
* @Update		: 2016-10-31
* @Description	: Paging Navigation Handler
*---------------------------------------------
* $start				=>		시작페이지번호
* $limit				=>		페이지당 출력 게시물수
* $pageScale			=>		출력할 페이지수(페이지블럭)
* $self					=>		현재페이지 URL
* $allRow				=>		총게시물수
* $page_return			=>		페이징 출력
*/

class getPage
{
	protected $start;
	protected $limit;
	protected $pageScale;
	protected $self;
	protected $vars = array();

	public $allRow;
	public $curPage;
	public $page_return;
	public $totalPage;
	public $getparm="";

	public function __construct($start, $limit, $page_scale=10, $total=0, $param="")
	{
		$this->start = $start;
		$this->limit = $limit;
		$this->pageScale = $page_scale;
		$this->allRow = $total;
		$this->self = $_SERVER['PHP_SELF'];

		if($param)
			$this->getparm = $this->getParameter($param);

		self::_set_page();
	}

	private function _set_page()
	{
		$this->vars['contexture'] = $this->limit * $this->pageScale;
		$this->totalPage = ceil($this->allRow / $this->limit);														//총페이지 수
		$this->vars['offset'] = ($this->start) ? floor(($this->start / $this->limit) / $this->pageScale) : 0;						//현재블럭페이지
		$curBlock = ($this->start) ? ceil(ceil(($this->start+$this->limit) / $this->limit) / $this->pageScale) : 1;	//현재블럭페이지
		$totBlock = ceil($this->totalPage/$this->pageScale);														//총블럭수
		$curPage = ceil(($this->start+$this->limit) / $this->limit);												//현재페이지

		//$a_division = array("all"=>$this->totalPage,"offset"=>$offset);

		$this->vars['offsetMax'] = floor($this->totalPage / $this->pageScale);
		$this->vars['from'] = $this->vars['offset'] * $this->vars['contexture'];

		$this->vars['curSize'] = ($this->vars['offset'] == $this->vars['offsetMax']) ? ceil(($this->allRow % $this->vars['contexture']) / $this->limit) : $this->pageScale;
		$pos = $this->vars['offset'] * $this->pageScale;

		if($curBlock > 1)
			$prevStr = $this->inner_other(($this->vars['contexture'] * ($curBlock - 1))-$this->limit, "<i class=\"ace-icon fa fa-angle-double-left\"></i>", "");
		else
			$prevStr = "<li class=\"disabled\"><a href=\"#\"><i class=\"ace-icon fa fa-angle-double-left\"></i></a></li>";

		if($curBlock < $totBlock)
			$nextStr = $this->inner_other($this->vars['contexture'] * $curBlock, "<i class=\"ace-icon fa fa-angle-double-right\"></i>", "");
		else
			$nextStr = "<li class=\"disabled\"><a href=\"#\"><i class=\"ace-icon fa fa-angle-double-right\"></i></a></li>";


		for ($i=0;$i<$this->vars['curSize'];$i++)
		{
			$start=$i* $this->limit+$this->vars['from'];
			++$pos;
			$str.=($start==$this->start)? $this->inner_cur($pos) : $this->inner_other($start, $pos, "");
		}

		$pageTotal=ceil($this->allRow / $this->limit);
		if($this->allRow > 0)
		{
			$this->page_return = "<ul class=\"pagination\">".$prevStr.$str.$nextStr."</ul>";
		}
	}

	private function inner_cur($pos)
	{
		$this->curPage = $pos;
		return "<li class=\"active\"><a href=\"#\">".$pos."</a></li>";
	}

	private function inner_other($start, $str, $class='')
	{
		$encData = "start=".$start;
		if($this->getparm)
			$encData .= "&".$this->getparm;

		$encData = _get_encode64($encData);

		return sprintf("<li class=\"%s\"><a href='%s?encData=%s'>%s</a></li>", $class, $this->self, $encData, $str);
	}

	private function getParameter($param)
	{
		if($param)
		{
			foreach($param as $k=>$v)
				if($v) $strParam[] = $k."=".urlencode($v);

			if($strParam)
				return @implode("&", $strParam);
		}
	}
}
?>
