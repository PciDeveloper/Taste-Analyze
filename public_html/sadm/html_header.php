<?
include_once dirname(__FILE__)."/./_header.php";
//include_once(dirname(__FILE__)."/../conf/swCounter.php");
//디바이스 체크(앱에서 접속했을땐 로그아웃버튼 숨기기위해
$Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title><?=$cfg[shopnm]?></title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="../assets/font-awesome/4.2.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="../assets/css/jquery-ui-1.8.6.custom.css">
<link rel="stylesheet" href="../assets/css/jquery-ui.min.css" />
<!-- <link rel="stylesheet" href="../assets/css/datepicker.min.css" />
<link rel="stylesheet" href="../assets/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css" /> -->
<link rel="stylesheet" href="../assets/css/ui.jqgrid.min.css" />
<!-- <link rel="stylesheet" href="../assets/css/fullcalendar.min.css" /> -->
<!-- page specific plugin styles -->

<!-- ace styles -->
<link rel="stylesheet" href="../assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

<!--[if lte IE 9]>
	<link rel="stylesheet" href="../assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
<![endif]-->

<!--[if lte IE 9]>
  <link rel="stylesheet" href="../assets/css/ace-ie.min.css" />
<![endif]-->
<link rel="stylesheet" href="../common/css.css?date=<?=date('Y-m-d H:i:s')?>" />
<!-- ace settings handler -->
<script src="../assets/js/ace-extra.min.js"></script>

<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

<!--[if lte IE 8]>
<script src="../assets/js/html5shiv.min.js"></script>
<script src="../assets/js/respond.min.js"></script>
<![endif]-->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="/js/class.common.js"></script>
<script type="text/javascript" src="../assets/js/jquery-ui-1.8.5.custom.min.js" charset="utf-8"></script>
<script type="text/javascript" src="../assets/js/jquery.ui.core.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript"  src="/js/highcharts.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript" src="../assets/js/jquery.ui.datepicker-ko.js" charset="utf-8"></script>
<script src="../assets/js/jquery.nestable.min.js"></script>
<script src="/js/zipcode.js"></script>
<!-- <script type="text/javascript" src="/js/wSelect.min.js"></script>
<link rel="Stylesheet" type="text/css" href="../common/wSelect.css" /> -->
<style type="text/css">
#popupwrap{display:none;background:#000;position:fixed;left:0;top:0;width:100%;height:100%;opacity:.80;z-index:11;}
#popupbox{display:none;float:left;position:fixed;top:50%;left:50%;z-index:12;}
.close_btn{position:absolute; top:10px; right:10px; z-index:13;}
</style>
<script type="text/javascript">
<!--
jQuery(function($) {
	$('.date-picker').datepicker({
		  dateFormat: 'yy-mm-dd'
	});
});
//-->
</script>
<style>
.ui-datepicker {
	width: 18em;
	padding: .2em .2em 0;
	display: none;
}
</style>
</head>
<body class="no-skin">
<iframe name="hiddenFrame" style="display:none;width:0;"></iframe>
<div id="popupwrap"></div>
<div id="popupbox"></div>
<div id="navbar" class="navbar navbar-default">
  <script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
  <div class="navbar-container" id="navbar-container">
    <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
		<span class="sr-only">Toggle sidebar</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
    <div class="navbar-header pull-left"> <a href="/sadm/main" class="navbar-brand"> <small> <i class="fa fa-leaf"></i> <?=$cfg[shopnm]?> </small> </a> </div>
    <div class="navbar-buttons navbar-header pull-right" role="navigation">
      <ul class="nav ace-nav">
        <li class="light-blue"> <a data-toggle="dropdown" href="#" class="dropdown-toggle"> <span class="user-info"> <small>Welcome,</small> <?=$_SESSION[SES_USERNM]?> </span> <i class="ace-icon fa fa-caret-down"></i> </a>
          <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
             <li> <a href="../login/login.act.php?act=logout"> <i class="ace-icon fa fa-power-off"></i> Logout </a> </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  <!-- /.navbar-container -->
</div>
<div class="main-container" id="main-container">
<div id="sidebar" class="sidebar responsive">
    <script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>

    <!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">

			<li>
				<a href="../main/index.php"><i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> HOME </span></a>
			</li>

			<li  <?if(getCurDir()=="member"):?>class="active open"<?endif?>> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-tachometer"></i> <span class="menu-text">Member</span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b>
        <ul class="submenu">
          <li class="<?php if($getCurPage == "index.php"):?>active<?php endif?>"> <a href="../member/index.php"> <i class="menu-icon fa fa-caret-right"></i>전체회원 목록</a> <b class="arrow"></b> </li>
					<li class="<?php if($getCurPage == "member.leave.php"):?>active<?php endif?>"> <a href="../member/member.leave.php"> <i class="menu-icon fa fa-caret-right"></i>탈퇴회원 목록</a> <b class="arrow"></b> </li>
					<!-- <li class="<?php if($getCurPage == "admin.list.php"):?>active<?php endif?>"> <a href="../product/admin.list.php"> <i class="menu-icon fa fa-caret-right"></i> 관리자 설정</a> <b class="arrow"></b> </li>
          <li class="<?php if($getCurPage == "admin.php"):?>active<?php endif?>"> <a href="../product/admin.php"> <i class="menu-icon fa fa-caret-right"></i> 관리자 등록</a> <b class="arrow"></b> </li> -->
        </ul>
      </li>

			<li <?if(getCurDir()=="product"):?>class="active open"<?endif?>> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-tachometer"></i> <span class="menu-text">Product</span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b>
        <ul class="submenu">
					<li class="<?php if($getCurPage == "index.php"):?>active<?php endif?>"> <a href="../product/index.php"> <i class="menu-icon fa fa-caret-right"></i>분석 목록</a> <b class="arrow"></b> </li>
          <li class="<?php if($getCurPage == "reghistory.php"):?>active<?php endif?>"> <a href="../product/reghistory.php"> <i class="menu-icon fa fa-caret-right"></i>얼굴 표정 맛 분석</a> <b class="arrow"></b> </li>
					<!-- <li class="<?php if($getCurPage == "admin.list.php"):?>active<?php endif?>"> <a href="../product/admin.list.php"> <i class="menu-icon fa fa-caret-right"></i> 관리자 설정</a> <b class="arrow"></b> </li>
          <li class="<?php if($getCurPage == "admin.php"):?>active<?php endif?>"> <a href="../product/admin.php"> <i class="menu-icon fa fa-caret-right"></i> 관리자 등록</a> <b class="arrow"></b> </li> -->
        </ul>
      </li>

      <li  <?if(getCurDir()=="basic"):?>class="active open"<?endif?>> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-tachometer"></i> <span class="menu-text">Setting</span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b>
        <ul class="submenu">
          <li class="<?php if($getCurPage == "index.php"):?>active<?php endif?>"> <a href="../basic/index.php"> <i class="menu-icon fa fa-caret-right"></i> 사이트 설정</a> <b class="arrow"></b> </li>
					<!-- <li class="<?php if($getCurPage == "admin.list.php"):?>active<?php endif?>"> <a href="../basic/admin.list.php"> <i class="menu-icon fa fa-caret-right"></i> 관리자 설정</a> <b class="arrow"></b> </li> -->
          <!-- <li class="<?php if($getCurPage == "admin.php"):?>active<?php endif?>"> <a href="../basic/admin.php"> <i class="menu-icon fa fa-caret-right"></i> 관리자 등록</a> <b class="arrow"></b> </li> -->
        </ul>
      </li>




    </ul>


    <!-- /.nav-list -->

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse"> <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i> </div>
    <script type="text/javascript">
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	</script>
  </div>
