<?php
/**
* Array or Variable Define File
*
* @Author		: seob
* @Update		:	2016-10-28
* @Description	:	사이트 변수 설정
*/

/**
* Base Environment Configurations
*/
// Table define //
$arr_table = array(
					"sw_admin",			//관리자정보
					"sw_board_cnf",		//게시판 설정
					"sw_board_cate",	//게시판 분류설정
					"sw_board",			//게시판 게시물
					"sw_board_file",	//게시판 첨부파일
					"sw_board_cmt",		//게시판 댓글
					"sw_bank",			//상점무통장정보
					"sw_delivery",		//택배사 정보
					"sw_counter",		//접속카운터
					"sw_counter_days",	//날짜별 접속통계
					"sw_category",		//카테고리
					"sw_goods",			//상품테이블
					"sw_option",		//상품옵션 설정정보
					"sw_goods_qna",		//상품문의
					"sw_sms",			//문자발송 관리
					"sw_sms_log",		//문자발송 내역
					"sw_member",		//회원정보
					"sw_leave",			//탈퇴회원정보
					"sw_wish",			//관심상품
					"sw_emoney",		//적립금내역
					"sw_visual",		//메일비주얼관리
					"sw_banner",		//메인배너관리
					"sw_popup",			//팝업관리
					"sw_review",		//상품리뷰
					"sw_basket",		//상품 장바구니
					"sw_order_tmp",		//임시주문테이블
					"sw_order",			//주문정보
					"sw_order_item",	//주문상품정보
					"sw_order_log",		//주문상태변경 로그
					"sw_delivery_fare"	//도서산간 운임표
				);
foreach($arr_table as $v) define(strtoupper($v), $v);

// 쇼핑몰 스킨 --- 추후 지속적 추가 //
$ar_shop_skin = array(
						"default"	=> "기본쇼핑몰",
						"react"		=> "반응형쇼핑몰"
					);

// 게시판권한 //
$arr_auth = array(
					"0"		=>	"제한없음",
					"10"	=>	"일반회원",
					"20"	=>	"정회원",
					"90"	=>	"게시판관리자",
					"100"	=>	"최고관리자"
				);
$auth_keys = array_keys($arr_auth);

// sms 발송구분 //
$arr_sms_type = array("",
						"직접발송", "회원가입완료", "생일기념", "상품주문시", "무통장입금안내", "상품발송",
						"주문취소완료", "반품완료", "회원가입(관리자)", "상품주문(관리자)",
						"주문취소요청(관리자)", "반품요청(관리자)"
					);



// 게시판 상태값(상황에따라 변경해서 사용) //
$arr_board_st = array("", "진행중", "", "", "마감");
$arr_color_cd = array("#959595", "#33cc00", "#3300ff", "#ffff00", "#ff0000");

// 관리자 그룹 //
$arr_grplv = array(
					"10"	=>	"사용자",
					"100"	=>	"최고관리자"
				);
$grplv_keys = array_keys($arr_grplv);

// 요일 //
$arr_week = array("일", "월", "화", "수", "목", "금", "토");
$arr_week2 = array("", "일", "월", "화", "수", "목", "금", "토");

// 지역번호 및 휴대폰, 메일도메인 //
$arr_tel = array("02", "031", "032", "033", "041", "042", "043", "051" ,"052", "053", "054", "055", "061", "062", "063", "064", "070");
$arr_hp = array("010", "011", "016", "017", "018", "019");
$arr_email = array(
					"네이버"	=> "naver.com",
					"네이트"	=> "nate.com",
					"한메일"	=> "hanmail.net",
					"구글(G메일)"	=> "gmail.com",
					"핫메일"	=> "hotmail.com",
					"드림위즈"	=> "dreamwiz.com",
					"MSN"		=> "msn.com",
					"야후"		=> "yahoo.com",
					"엠팔"		=> "empas.com"
					);

/**
* 결제수단
*/
$ar_pay_method = array(
						"SBANK"	=> "무통장입금",
						"CARD"	=> "카드결제",
						"BANK"	=> "계좌이체",
						"VCNT"	=> "가상계좌",
						"MOBX"	=> "휴대폰결제",
						"POINT"	=> "적립금결제"
					);
$keys_pay_method = array_keys($ar_pay_method);
// 결제수단 kcp 코드 //
$ar_kcp_pay_method = array(
							"SBANK"	=> "111111111111",
							"CARD"	=> "100000000000",
							"BANK"	=> "010000000000",
							"VCNT"	=> "001000000000",
							"MOBX" => "000010000000"
						);
// 적립금 구분(사용, 차감, 회수) //
$ar_emoney_part = array( "",
						 "상품주문 사용",		// 1
						 "상품주문 적립",		// 2
						 "회원가입",			// 3
						 "생일축하",			// 4
						 "첫구매감사",			// 5
						 "상품평등록",			// 6
						 "주문취소 적립금회수",	// 7
						 "취소(환불) 적립금보상", // 8
						 "관리자지급",			// 9
						 "관리자차감",			// 10
						 "기타"					// 11
					);
### 탈퇴사유 ###
$ar_leave = array(
					"",
					"고객지원 불만",			// 1
					"상품종류 부족",			// 2
					"이민/장기 출국",			// 3
					"반품/환불 문제",			// 4
					"상품품질 문제",			// 5
					"타인의 개인정보 사용",		// 6
					"상품가격 불만",			// 7
					"쇼핑몰 이용장애",			// 8
					"기타",						// 9
					"관리자 강제탈퇴"			// 10
				);


### 환불은행명 ###
$arr_bank_refund = array("경남은행", "광주은행", "국민은행", "기업은행", "농협", "대구은행", "부산은행", "수협", "씨티은행", "신한은행", "우리은행", "우체국", "전북은행", "KEB하나은행", "SC은행");
### 상품문의 유형 ###
$arr_qna = array("", "상품배송", "주문취소", "교환" ,"환불" ,"A/S관련" ,"영수증/계산서", "이벤트/행사", "쇼핑몰 이용", "기타");
/**
* 주문상태 관련 배열선언
*/
$arr_status = array(
					"100"=>"주문접수",
					"101"=>"결제완료",
					"200"=>"배송준비",
					"201"=>"상품발송",
					"202"=>"상품수령",
					"300"=>"주문취소요청",
					"301"=>"주문취소완료",
					"400"=>"교환요청",
					"401"=>"교환완료",
					"500"=>"환불요청",
					"501"=>"환불완료",
					"900"=>"구매완료"
				);
$status_keys = array_keys($arr_status);
$arr_step_status = array("",
							"100"=>array("100", "101", "301"),
							"101"=>array("101", "200", "301", "900"),
							"200"=>array("200", "201", "301", "900"),
							"201"=>array("201", "202", "900"),
							"202"=>array("202", "400", "500", "900"),
							"300"=>array("300", "301"),
							"301"=>array("301"),
							"400"=>array("400", "401"),
							"401"=>array("401"),
							"500"=>array("500", "501"),
							"501"=>array("501"),
							"900"=>array("900")
						);

/*
* 지정상태로 변경가능한 주문상태배열
*/
$arr_change_status = array("",
							"100"=>array("101", "200", "201", "300", "400", "500"),
							"101"=>array("100", "200", "201"),
							"200"=>array("101", "201", "300", "400", "500"),
							"201"=>array("101", "200", "300", "400", "500"),
							"202"=>array("101", "200", "201", "300", "400", "500"),
							"300"=>array("101", "200"),
							"301"=>array("100", "101", "200", "201", "202", "300"), //주문접수, 결제완료, 배송준비, 상품발송, 상품수령, 주문취소요청
							"400"=>array("202"),
							"401"=>array("202", "400"),
							"500"=>array("202"),
							"501"=>array("202", "500"),
							"900"=>array("101", "200", "201", "202", "300", "400", "500")
						);

/**
* 상태변경 불가 상태배열
*/
$arr_disabled_status = array("301", "401", "501", "900");

/**
* 고객 상태변경 가능 상태값 배열
*/
$arr_enable_status = array(
							"cancel"	=> array("100", "101", "200"),			//주문취소
							"refund"	=> array("202"),						//반품(환불)
							"receive"	=> array("201"),						//상품수령
							"ordok"		=> array("101", "200", "201", "202")	//구매확정
						);
?>
