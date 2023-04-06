<?
include_once(dirname(__FILE__)."/../_header.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '0');

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('Asia/Seoul');

/** PHPExcel 라이브러리 포함 **/
require_once(dirname(__FILE__)."/../../lib/PHPExcel/Classes/PHPExcel.php");

$lv=getMemberLv();
/** PHPExcel 클래스 선언 **/
$objPHPExcel = new PHPExcel();


/** 야래 부분이 엑셀에 쓰는 부분입니다. **/
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', '아이디')
								->setCellValue('B1', '성명')
								->setCellValue('C1', '등급')
								->setCellValue('D1', '생년월일')
								->setCellValue('E1', '성별')
								->setCellValue('F1', '휴대폰')
								->setCellValue('G1', '일반전화')
								->setCellValue('H1', '이메일')
								->setCellValue('I1', '우편번호')
								->setCellValue('J1', '주소')
								->setCellValue('K1', '구매횟수')
								->setCellValue('L1', '구매금액')
								->setCellValue('M1', '적립금')
								->setCellValue('N1', '가입일');

/** DB 가져옴 **/
$sqry = sprintf("select * from %s where status=1 order by idx asc", SW_MEMBER);
$qry = $db->_execute($sqry);

$tmpArray = array();
for($i=0; $row=mysql_fetch_assoc($qry); $i++)
{
	$result['userid'] = $row['userid'];
	$result['name'] = $row['name'];
	$result['lv'] = $lv[$row['userlv']]['name'];
	$result['birthday'] = $row['birthday'];
	$result['sex'] = ($row['sex'] == "M") ? "남자" : "여자";
	$result['hp'] = $row['hp'];
	$result['tel'] = $row['tel'];
	$result['email'] = $row['email']; 
	$result['zip'] = $row['zip'];
	$result['address'] = $row['adr1']." ".$row['adr2'];
	$result['buycnt'] = $row['buycnt'];
	$result['buymoney'] = $row['buymoney'];
	$result['emoney'] = $row['emoney'];
	$result['regdt'] = $row['regdt']; 

	$tmpArray[] = $result;
}
/** 위 배열 $tmpArray 를 A2부터 차례대로 쓴다는 말입니다. **/
$objPHPExcel->getActiveSheet()->fromArray($tmpArray, NULL, 'A2');

/** A1에서 부터 B1까지를 Bold 처리함 **/
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);


/** A1에서 I1까지의 스타일을 정의 함**/
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->applyFromArray(
	array('fill'	=>	array(	
								'type'	=>	PHPExcel_Style_Fill::FILL_SOLID, 
								'color'	=>	array('argb'	=>	'FFF1F1F1')
							), 
		'alignment'	=>	array(
								'horizontal'	=>	PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'		=>	PHPExcel_Style_Alignment::VERTICAL_CENTER
							),
		'borders'	=>	array(
								'allborders'	=>	array('style'	=>	PHPExcel_Style_Border::BORDER_THIN)
								/*
								'bottom'	=>	array('style'	=>	PHPExcel_Style_Border::BORDER_THIN),
								'left'	=>	array('style'	=>	PHPExcel_Style_Border::BORDER_DASHDOT),
								'right'		=>	array('style'	=>	PHPExcel_Style_Border::BORDER_THIN)
								*/
							)
		)
);



/** 위에서 쓴 엑셀을 저장하고 다운로드 합니다. **/
$filename = decode_cp949("회원목록(".date('Y-m-d').")");
header("Content-Type: application/vnd.ms-excel;charset=utf-8");
header("Content-Disposition: attachment;filename=".$filename.".xls");
header("Cache-Control: max-age=0");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>