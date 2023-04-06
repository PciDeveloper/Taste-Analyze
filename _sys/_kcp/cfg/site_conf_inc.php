<?php
$g_conf_home_dir	= $cfg['site_path'];	// BIN 절대경로 입력 (bin전까지)
//$g_conf_log_path	= "/../log";			// log 경로지정
$g_conf_log_path	= $cfg['site_path']."/log";
$g_conf_log_level	= "3";
$g_conf_gw_port		= "8090";				// 포트번호(변경불가)
$module_type		= "01";					// 변경불가

// 테스트 //
if($cfg['site_cd'] == "T0007" || $_SERVER['REMOTE_ADDR'] == "58.150.33.163")
{
	$g_conf_gw_url    = "testpaygw.kcp.co.kr";
	$g_conf_js_url    = "https://testpay.kcp.co.kr/plugin/payplus_web.jsp";
	//$g_conf_js_url    = "https://pay.kcp.co.kr/plugin/payplus_test_un.js";
	$g_wsdl           = "KCPPaymentService.wsdl";
	$g_conf_site_cd   = "T0007";
	$g_conf_site_key  = "4Ho4YsuOZlLXUZUdOxM1Q7X__";
	$g_conf_site_name = "KCP TEST SHOP";
}
else
{
	// 리얼 //
	$g_conf_gw_url		= "paygw.kcp.co.kr";
	$g_conf_js_url		= "https://pay.kcp.co.kr/plugin/payplus_web.jsp";
	//$g_conf_js_url    = "https://pay.kcp.co.kr/plugin/payplus_un.js";
	$g_wsdl				= "real_KCPPaymentService.wsdl";
	$g_conf_site_cd		= $cfg['site_cd'];
	$g_conf_site_key	= $cfg['site_key'];
	$g_conf_site_name	= $cfg['site_name'];
}
?>
