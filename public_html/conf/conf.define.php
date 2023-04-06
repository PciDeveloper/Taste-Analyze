<?
//=======================================================================================
// File Name	:	conf.define.php
// Author		:	seob
// Update		:	2014-07-29
// Description	:	사이트 변수설정 파일
//=======================================================================================

### table define ###
$arr_table = array(
					"sw_admin",
					"sw_admlv",
					"sw_config",
					"sw_bank",
					"sw_board_cnf",
					"sw_board",
					"sw_boardfile",
					"sw_comment",
					"sw_counter",
					"sw_popup",
					"sw_category",
					"sw_member",
					"sw_fbuser",
					"sw_delivery",
					"sw_goods",
					"sw_goption",
					"sw_icon",
					"sw_sms",
					"sw_smslog",
					"sw_calendar",
					"sw_help",
					"sw_qna",
					"sw_review",
					"sw_emoney",
					"sw_coupon_cfg",
					"sw_coupon",
					"sw_banner_grp",
					"sw_banner",
					"sw_visual",
					"sw_event",
					"sw_wish",
					"sw_booking"
			);
foreach($arr_table as $v)
	define(strtoupper($v), $v);

unset($arr_table);

### admin menu ###
$arr_menu = array(
				basic => "쇼핑몰기본관리",
				member => "회원관리",
				order => "주문관리",
				goods => "상품관리",
				board => "게시판관리",
				design => "팝업관리",
				log => "통계"

			);

$arr_adm_menu = array(
						home		=>	"관리자 홈",
						order		=>	"주문,배송관리",
						goods		=>	"상품,메뉴관리",
						member		=>	"고객,지원관리",
						promotion	=>	"프로모션",
						board		=>	"기타기능",
						log			=>	"통계분석",
						design		=>	"디자인",
						basic		=>	"환경설정"
					);

$arr_sms_type = array("",
						"직접발송", "회원가입완료", "생일기념", "상품주문시", "무통장입금안내", "상품발송",
						"주문취소완료", "반품완료", "회원가입(관리자)", "상품주문(관리자)",
						"주문취소요청(관리자)", "반품요청(관리자)"
					);

### 목록 출력수 ###
$arr_cnt = array("10", "20", "40", "60", "100");

### 게시판권한 ###
$arr_auth = array(
					"0" => "제한없음",
					"10" => "준회원",
					"20" => "정회원",
					"90" => "관리자"
				);

$auth_keys = array_keys($arr_auth);

### 게시판유형 ###
$arr_part = array(
					"10" => "일반게시판",
					"20" => "1:1문의",
					"30" => "FAQ",
					"40" => "event",
					"50" => "갤러리",
					"60" => "썸네일",
					"70" => "예약게시판"
				);

$part_keys = array_keys($arr_part);

### 게시판스킨폴더 ###
$arr_skin = array(
					"10" => "default",
					"20" => "ask",
					"30" => "faq",
					"40" => "event",
					"50" => "gallery",
					"60" => "thum",
					"70" => "goods"
				);

### 월배열 ###
$arr_mon = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

### 요일배열 ###
$arr_w = array("일","월","화","수","목","금","토");

### 컬러코드 배열 ###
$arr_color = array("#f1f1f1", "#ffffff","#E9FEE7","#DFEBFD","#ffdfd0","#FDBCB5","#E9CFFE","#DFDFDF","#ffffc8");

### 자동메일 ###
$arr_email = array("", "주문확인메일", "입금확인메일", "배송/발송메일", "회원가입메일", "비밀번호찾기", "회원탈퇴메일");

### number ###
$arr_number = array("", "①", "②", "③", "④", "⑤", "⑥", "⑦", "⑧", "⑨", "⑩", "⑪", "⑫", "⑬", "⑭", "⑮");

### 국번 ###
$arr_tel = array("02", "031", "032", "033", "041", "042", "043", "051" ,"052", "053", "054", "055", "061", "062", "063", "064");

### 핸드폰 ###
$arr_hp = array("010", "011", "016", "017", "018", "019");

### 결제방법 ###
$arr_paymethod = array("3"=>"무통장입금", "1"=>"신용카드", "2"=>"계좌이체");
$arr_kcp_method = array("1"=>"card", "3"=>"acnt", "2"=>"vcnt");
$paymethod_keys = array_keys($arr_paymethod);

### 결제방법 코드(kcp) ###
$arr_payway_code = array("SBANK"=>"111111111111", "CARD"=>"100000000000", "BANK"=>"010000000000", "VCNT"=>"001000000000");

### 주문상태 ###
$arr_status = array(
					"100"=>"서비스신청",
					"101"=>"결제완료",
					"300"=>"신청취소"
				);
$status_keys = array_keys($arr_status);

$arr_step_status = array("",
							"100"=>array("100", "101", "300"),
							"101"=>array("100", "101", "300"),
							"300"=>array("100", "101", "300")
						);

$arr_help = array("", "상품배송", "주문취소", "교환" ,"환불" ,"A/S관련" ,"영수증/계산서", "이벤트/행사", "쇼핑몰 이용", "기타");
$arr_qna = array("", "상품문의", "요구사항", "기타");
$arr_review = array("", "매우불만족", "불만족", "보통", "만족", "매우만족");

### 기획전 진행상태 ###
$arr_sale_status = array("종료", "진행중", "진행예정");
$arr_sale_color = array("#dddddd", "#ff0000", "#0033ff");

### 적립금 구분 ###
//							1				2			3			4				5			6			7				8		9
$arr_point = array("", "주문차감", "상품주문적립", "회원가입", "생일축하", "첫구매감사", "상품평작성", "관리자지급", "관리자차감", "기타");

### 지역 ###
$arr_sido = array("강원도", "경기도", "경상남도", "경상북도", "광주광역시", "대구광역시", "대전광역시", "부산광역시", "서울특별시", "세종특별자치시", "울산광역시", "인천광역시", "전라남도", "전라북도", "제주특별자치도", "충청남도", "충청북도");
$arr_area = array(
					"0"=>"선택",
					"1"=>"강원",
					"2"=>"경기",
					"3"=>"경남",
					"4"=>"경북",
					"5"=>"광주",
					"6"=>"대구",
					"7"=>"대전",
					"8"=>"부산",
					"9"=>"서울",
					"10"=>"세종",
					"11"=>"울산",
					"12"=>"인천",
					"13"=>"전남",
					"14"=>"전북",
					"15"=>"제주",
					"16"=>"충남",
					"17"=>"충북"
				);
$part_area_keys = array_keys($arr_area);


$arr_booking_status = array(
					"0"=>"",
					"1"=>"접수완료",
					"2"=>"입금대기",
					"3"=>"결제완료",
					"4"=>"환불예정",
					"5"=>"환불완료",
					"99"=>"접수취소",
					"101"=>"예약취소"
				);
$part_booking_keys = array_keys($arr_booking_status);

?>
