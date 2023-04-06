<?
//=======================================================================================
// File Name	:	class.pagenation.php
// Author		:	kkang(sinbiweb)
// Update		:	2011-07-01
// Description	:	Paging Navigation Handler
//=======================================================================================
// $start				=>		시작페이지번호
// $limit				=>		페이지당 출력 게시물수
// $pageScale			=>		출력할 페이지수(페이지블럭)
// $self				=>		현재페이지 URL
// $allRow				=>		총게시물수
// $page_return			=>		페이징 출력
//=====================================================================================

CLASS getPage
{
	var $start;				
	var $limit;			
	var $pageScale;		
	var $self;
	var $allRow;
	var $curPage;
	var $page_return;
	var $totalPage;
	var $getparm="";

	function getPage($start, $limit, $page_scale=10, $total=0, $param="")
	{
		$this->start = $start;
		$this->limit = $limit;
		$this->pageScale = $page_scale;
		$this->allRow = $total;
		$this->self = $_SERVER['PHP_SELF'];

		if($param)
			$this->getparm = $this->getParameter($param);

		$contexture = $this->limit * $this->pageScale;
		$this->totalPage = ceil($this->allRow / $this->limit);			//총페이지 수
		$offset = ($this->start) ? floor(($this->start / $this->limit) / $this->pageScale) : 0;	//현재블럭페이지
		$curBlock = ($this->start) ? ceil(ceil(($this->start+$this->limit) / $this->limit) / $this->pageScale) : 1;	//현재블럭페이지
		$totBlock = ceil($this->totalPage/$this->pageScale); //총블럭수


		$a_division = array("all"=>$this->totalPage,"offset"=>$offset);
		$a_division[offsetMax]=floor($a_division[all] / $this->pageScale);
		$a_division[from]=$a_division[offset]*$contexture;

		$a_division[curSize]=($a_division[offset]==$a_division[offsetMax]) ? ceil(($this->allRow % $contexture) / $this->limit) : $this->pageScale;
		$pos=$a_division[offset] * $this->pageScale;

		if ($a_division[offset]>0){
			$prevStr=$this->inner_other(0,"<img src=\"/m/images/btn/btn_start.gif\" alt=\"\" />", $option, "btn").$this->inner_other($a_division[from] - $this->limit,"<img src=\"/m/images/btn/btn_prev.gif\" alt=\"\" />", $option, "btn");
		}else{
			$prevStr="<a class=\"btn\"><img src=\"/m/images/btn/btn_start.gif\" alt=\"\" /></a> <a class=\"btn\"><img src=\"/m/images/btn/btn_prev.gif\" alt=\"\" /></a>";
		}

		if ($curBlock < $totBlock){
			$nextStr=$this->inner_other($a_division[from]+$contexture, "<img src=\"/m/images/btn/btn_next.gif\" alt=\"\" />", $option, "btn").$this->inner_other((ceil($this->allRow / $this->limit)-1)*$this->limit,"<img src=\"/m/images/btn/btn_last.gif\" alt=\"\" />", $option, "btn");
		}else{
			$nextStr="<a class=\"btn\"><img src=\"/m/images/btn/btn_next.gif\" alt=\"\" /></a><a class=\"btn\"><img src=\"/m/images/btn/btn_last.gif\" alt=\"\" /></a>";
		}

		for ($i=0;$i<$a_division[curSize];$i++)
		{
			$start=$i* $this->limit+$a_division[from];
			++$pos;
			$str.=($start==$this->start)? $this->inner_cur($pos) : $this->inner_other($start, $pos, $option, "");
		}

		$pageTotal=ceil($this->allRow / $this->limit);
		if($this->allRow > 0)
			$this->page_return = $prevStr.$str.$nextStr;
	}

	function inner_cur($pos)
	{
		$this->curPage = $pos;
		return "<a class=\"on\">".$pos."</a>";
	}

	function inner_other($start, $str, $option="", $class="")
	{
		$encData = "start=".$start;
		if($this->getparm)
			$encData .= "&".$this->getparm;

		$encData = getEncode64($encData);

		return sprintf("&nbsp;<a href='%s?encData=%s' class='%s'>%s</a>", $this->self, $encData, $class, $str);
	}

	function getParameter($param)
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