<?
//=======================================================================================
// Sinbiweb mall Ver2.0 DBSchema
//---------------------------------------------------------------------------------------
// @Author		:	kkang(sinbiweb)
//---------------------------------------------------------------------------------------
// @Update		:	2014-10-24
//=======================================================================================

### 접속현황 ###
create table sw_counter
(
	idx int(11) unsigned not null auto_increment,	//index
	hour tinyint not null,							//시간
	ip varchar(15) not null,						//ip
	brower varchar(50) not null,					//브라우져
	brover varchar(50),								//브라우져 버전
	os varchar(50),									//OS
	brogrp varchar(20),								//브라우져그룹(그래프용)
	osgrp varchar(20),								//os그룹(그래프용)
	resolution varchar(50),							//해상도
	agent varchar(255),								//agent 정보
	referer varchar(200),							//유입경로(referer)
	rhost varchar(50),								//유입 HOST
	keyword varchar(100),							//검새키워드
	regdt datetime,									//등록일
	primary key(idx), 
	key iidx1(ip, regdt), 
	key iidx2(brower, regdt), 
	key iidx3(os, regdt), 
	key iidx4(rhost, regdt),
	key iidx5(brogrp, regdt), 
	key iidx6(osgrp, regdt)
)

create table sw_counter
(
	idx int(11) unsigned not null auto_increment, 
	hour tinyint not null, 
	ip varchar(15) not null, 
	brower varchar(50) not null,
	brover varchar(50), 
	os varchar(50),
	brogrp varchar(20),
	osgrp varchar(20),
	resolution varchar(50), 
	agent varchar(255), 
	referer varchar(200),
	rhost varchar(50), 
	keyword varchar(100), 
	regdt datetime, 
	primary key(idx), 
	key iidx1(ip, regdt), 
	key iidx2(brower, regdt), 
	key iidx3(os, regdt), 
	key iidx4(rhost, regdt),
	key iidx5(brogrp, regdt), 
	key iidx6(osgrp, regdt)
)

### 택배사 정보 ###
create table sw_delivery
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//고유코드
	name varchar(50),									//택배사명
	home varchar(50),									//홈페이지
	tel varchar(20),									//전화번호
	url varchar(200),									//택배사 URL
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(code)
)

create table sw_delivery
(
	idx int(11) unsigned not null auto_increment, 
	code varchar(20) not null, 
	name varchar(50), 
	home varchar(50),
	tel varchar(20),
	url varchar(200), 
	regdt datetime, 
	primary key(idx), 
	key iidx(code)
)

### 관리자관리 테이블 ###
create table sw_admin
(
	idx int(11) unsigned not null auto_increment,		//index
	buse tinyint not null default 1,					//사용여부(1:사용, 0:미사용)
	grplv int(3) not null,								//관리자그룹레벨
	admid varchar(30) not null,							//관리자아이디
	admpw varchar(30) not null,							//관리자비번
	name varchar(30) not null,							//관리자명
	tel varchar(20),									//전화번호
	hp varchar(20),										//핸드폰번호
	email varchar(60),									//메일주소
	logdt datetime,										//최근로그인
	vcnt int(3) default 0,								//방문회수
	memo text,											//메모
	regdt datetime,										//등록일
	primary key(idx)
)

create table sw_admin
(
	idx int(11) unsigned not null auto_increment,
	buse tinyint not null default 1,			
	grplv int(3) not null,						
	admid varchar(30) not null,					
	admpw varchar(100) not null,					
	name varchar(30) not null,					
	tel varchar(20),							
	hp varchar(20),								
	email varchar(60),							
	logdt datetime,								
	vcnt int(3) default 0,						
	memo text,									
	regdt datetime,								
	primary key(idx)
)

insert into sw_admin values (1,1,100,'admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441','관리자','','','','',0,'',now());

### 무통장 계좌관리 ###
create table sw_bank 
(
	idx int(11) unsigned not null auto_increment,		//index
	buse enum('Y', 'N') default 'Y',					//사용여부(Y:사용, N:미사용)
	banknm varchar(30) not null,						//은행명
	banknum varchar(30) not null,						//계좌번호
	bankown varchar(30) not null,						//예금주
	regdt datetime,										//등록일
	primary key(idx)
)

create table sw_bank 
(
	idx int(11) unsigned not null auto_increment, 
	buse enum('Y', 'N') default 'Y', 
	banknm varchar(30) not null, 
	banknum varchar(30) not null, 
	bankown varchar(30) not null, 
	regdt datetime, 
	primary key(idx)
)

### SMS 설정 및 자동발송 ###
create table sw_sms
(
	idx int(11) unsigned not null auto_increment,		//index
	gubun enum('U', 'A') default 'U',					//구분(U:사용자, A:관리자)
	mode varchar(10) not null,							//조건
	buse enum('Y', 'N') default 'N',					//사용여부
	subject varchar(200),								//조건내용
	msg varchar(200),									//메세지
	etc text,											//설명
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(mode)
)

create table sw_sms
(
	idx int(11) unsigned not null auto_increment, 
	gubun enum('U', 'A') default 'U', 
	mode varchar(10) not null, 
	buse enum('Y', 'N') default 'N', 
	subject varchar(200), 
	msg varchar(200), 
	etc text, 
	regdt datetime, 
	primary key(idx), 
	key iidx(mode)
)

### SMS 발송내역 ###
create table sw_smslog 
(
	idx int(11) unsigned not null auto_increment,		//index
	stype tinyint default 0,							//발송유형						
	admid varchar(30),									//관리자 아이디
	shp varchar(20),									//발송번호
	rhp varchar(20),									//수신번호
	msg text,											//발송메세지
	scode varchar(20),									//결과코드
	status tinyint default 0,							//상태(미사용)
	regdt datetime,										//발송일
	primary key(idx)
)

create table sw_smslog 
(
	idx int(11) unsigned not null auto_increment, 
	style tinyint default 0, 
	admid varchar(30), 
	shp varchar(20), 
	rhp varchar(20), 
	msg text, 
	scode varchar(20), 
	status tinyint default 0, 
	regdt datetime, 
	primary key(idx)
)

### 회원테이블 ###
create table sw_member
(
	idx int(11) unsigned not null auto_increment,		//index
	name varchar(30) not null,							//성명
	nick varchar(30),									//닉네임
	birthday varchar(10),								//생년월일
	birtype enum('+', '-') default '+',					//생일구분(+:양력, -:음력)
	sex enum('M', 'W') default 'M',						//성별(M:남자, W:여자)
	userid varchar(30) not null,						//회원아이디
	userlv tinyint default 0,							//회원등급
	pwd varchar(100) not null,							//회원비밀번호(password암호화)
	email varchar(100),									//이메일주소
	mailing enum('Y','N') default 'Y',					//메일링(Y:수신, N:수신거부)
	zip varchar(7) not null,							//우편번호
	adr1 varchar(100) not null,							//주소
	adr2 varchar(100) not null,							//상세주소
	tel varchar(20),									//연락처
	hp varchar(20) not null,							//핸드폰번호
	bsms enum('Y','N') default 'Y',						//sms수신여부(Y:수신, N:수신거부)
	emoney int(7) default 0,							//회원마일리지
	buycnt int(3) default 0,							//회원구매횟수
	buymoney int(7) default 0,							//회원총구매금액
	ip varchar(15),										//가입ip
	logdt datetime,										//최근로그인일
	vcnt int(3) default 0,								//총방문회수
	status tinyint default 0,							//승인상태(1:승인, 0:탈퇴)
	leave_ex varchar(30),								//탈퇴사유
	leave_memo text,									//탈퇴메모
	memo text,											//관리자메모
	regdt datetime,										//가입일
	primary key(idx), 
	key iidx1(userid)
)

create table sw_member
(
	idx int(11) unsigned not null auto_increment, 
	name varchar(30) not null, 
	nick varchar(30),
	birthday varchar(10), 
	birtype enum('+', '-') default '+', 
	sex enum('M', 'W') default 'M', 
	userid varchar(30) not null, 
	userlv tinyint default 0, 
	pwd varchar(100) not null, 
	email varchar(100), 
	mailing enum('Y','N') default 'Y',
	zip varchar(7) not null, 
	adr1 varchar(100) not null, 
	adr2 varchar(100) not null, 
	tel varchar(20), 
	hp varchar(20) not null, 
	bsms enum('Y','N') default 'Y', 
	emoney int(7) default 0,
	buycnt int(3) default 0,
	buymoney int(7) default 0, 
	ip varchar(15), 
	logdt datetime, 
	vcnt int(3) default 0, 
	status tinyint default 0, 
	leave_ex varchar(30),
	leave_memo text,
	memo text, 
	regdt datetime, 
	primary key(idx), 
	key iidx1(userid) 
)

### 페북 User ###
create table sw_fbuser
(
	idx int(11) unsigned not null auto_increment, 
	name varchar(30) not null, 
	sex enum('M', 'W') default 'M', 
	birthday varchar(10), 
	userid varchar(30) not null, 
	userlv tinyint default 0, 
	email varchar(100), 
	zip varchar(7) not null, 
	adr1 varchar(100) not null, 
	adr2 varchar(100) not null, 
	tel varchar(20), 
	hp varchar(20) not null, 
	ip varchar(15),
	regdt datetime, 
	primary key(idx), 
	key iidx1(userid) 
)

### 상품분류 ###
create table sw_category
(
	idx int(11) unsigned not null auto_increment,		//index
	seq int(3) not null,								//노출순위
	code char(12) not null,								//카테고리 코드
	pcode char(12),										//부모 카테고리 코드
	name varchar(100) not null,							//카테고리명
	buse tinyint not null default 1,					//사용여부(1:사용, 0:미사용)
	titimg varchar(30),									//타이틀 이미지
	topimg varchar(30),									//상단 비주얼 이미지
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(code)
)

create table sw_category
(
	idx int(11) unsigned not null auto_increment, 
	seq int(3) not null, 
	code char(12) not null, 
	pcode char(12), 
	name varchar(100) not null, 
	buse tinyint not null default 1,
	titimg varchar(30), 
	topimg varchar(30),
	regdt datetime, 
	primary key(idx), 
	key iidx(code)
)

### 상품정보 테이블 ###
create table sw_goods 
(
	idx int(11) unsigned not null auto_increment,		//index
	gcode varchar(20) not null,							//상품코드
	seq int(11) not null default 0,						//진열순위
	hit int(3) not null default 0,						//조회수
	category char(12) not null,							//카테고리
	display enum('Y', 'N') default 'Y',					//진열여부
	name varchar(100) not null,							//상품명
	origin varchar(30),									//원산지
	maker varchar(30),									//제조사
	keyword varchar(200),								//검색키워드
	icon varchar(30),									//상품 아이콘
	cbest tinyint default 0,							//분류별 메인진열상품
	mbest tinyint default 0,							//베스트상품
	mnew tinyint default 0,								//신상품
	bsale int(11) default 0,							//기획상품(타임 및 기간세일상품) --- 기획전의 idx값
	price int(7) not null default 0,					//판매가
	nprice int(7) not null default 0,					//원가
	blimit tinyint not null default 1,					//재고설정(1:무제한, 2:제한, 3:품절)
	glimit int(7),										//재고량
	minea int(3) not null default 1,					//최소구매수량
	maxea int(3) not null default 0,					//최대구매수량
	pointmod tinyint not null default 0,				//적립금 설정(0:사용안함, 1:기본정책, 2:개별적립금)
	point int(3) not null default 0,					//개별적립금
	pointunit enum('p', 'w') default 'p',				//단위(p:%, w:원)
	delivery tinyint not null default 1,				//배송비설정(1:기본정책, 2:선불)
	dyprice int(3),										//선불금액
	ndyprice int(7),									//무료배송 금액
	bopt enum('Y', 'N') default 'N',					//옵션사용여부
	relation varchar(100),								//관련상품배열
	imgtype tinyint default 1,							//이미지등록 방식
	img1 varchar(100),									//확대이미지
	img2 varchar(100),									//상세이미지
	img3 varchar(100),									//리스트 이미지
	img4 varchar(100),									//메인 이미지
	imgetc varchar(255),								//기타추가 이미지
	etc1 varchar(200),									//추가항목1
	etc2 varchar(200),									//추가항목2
	etc3 varchar(200),									//추가항목3
	shortexp varchar(255),								//간략설명
	content mediumtext,									//상품설명
	mcontent mediumtext,								//모바일 상품설명
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	unique key(gcode), 
	key iidx1(category), 
	foreign key(category) references sw_category(code) on delete set null
)

create table sw_goods 
(
	idx int(11) unsigned not null auto_increment, 
	gcode varchar(20) not null, 
	seq int(11) not null default 0, 
	hit int(3) not null default 0, 
	category char(12) not null, 
	display enum('Y', 'N') default 'Y', 
	name varchar(100) not null, 
	origin varchar(30), 
	maker varchar(30), 
	keyword varchar(200), 
	icon varchar(30), 
	cbest tinyint default 0,
	mbest tinyint default 0, 
	mnew tinyint default 0, 
	bsale int(11) default 0,
	price int(7) not null default 0, 
	nprice int(7) not null default 0, 
	blimit tinyint not null default 1, 
	glimit int(7), 
	minea int(3) not null default 1, 
	maxea int(3) not null default 0, 
	pointmod tinyint not null default 0, 
	point int(3) not null default 0, 
	pointunit enum('p', 'w') default 'p', 
	delivery tinyint not null default 1, 
	dyprice int(3), 
	ndyprice int(7),
	bopt enum('Y', 'N') default 'N', 
	relation varchar(100),
	imgtype tinyint default 1, 
	img1 varchar(100),
	img2 varchar(100), 
	img3 varchar(100), 
	img4 varchar(100), 
	imgetc varchar(255), 
	etc1 varchar(200), 
	etc2 varchar(200), 
	etc3 varchar(200), 
	shortexp varchar(255), 
	content mediumtext, 
	mcontent mediumtext,
	regdt datetime, 
	updt datetime, 
	primary key(idx),
	unique key(gcode), 
	key iidx1(category), 
	foreign key(category) references sw_category(code) on delete set null
)

### 상품옵션 ###
create table sw_goption 
(
	idx int(11) unsigned not null auto_increment,		//index
	gcode varchar(20) not null,							//상품코드(sw_goods 테이블)
	optnm varchar(100),									//옵션명('」「' 구분)
	optval varchar(200),								//옵션값('」「' 구분)
	optpay varchar(200),								//옵션가격('」「' 구분)
	optreq varchar(100),								//선택필수여부('」「' 구분)
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx1(gcode), 
	foreign key(gcode) references sw_goods(gcode) on delete cascade 
)

create table sw_goption 
(
	idx int(11) unsigned not null auto_increment, 
	gcode varchar(20) not null, 
	optnm varchar(100), 
	optval varchar(200), 
	optpay varchar(200), 
	optreq varchar(100), 
	regdt datetime, 
	primary key(idx), 
	key iidx1(gcode), 
	foreign key(gcode) references sw_goods(gcode) on delete cascade 
)

### 게시판 설정테이블 ###
create table sw_board_cnf
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//게시판코드
	name varchar(30) not null,							//게시판명
	part tinyint not null,								//게시판유형
	lAct tinyint default 0,								//리스트권한
	rAct tinyint default 0,								//읽기권한
	wAct tinyint default 0,								//쓰기권한
	cAct tinyint default 0,								//댓글권한	
	bspam enum('Y','N') default 'N',					//스팸코드 사용유무
	path varchar(100),									//게시판위치
	cutstr int(3),										//노출글자수 
	vlimit int(3),										//노출목록수
	period tinyint default 1,							//new 아이콘 노출일
	thumW int(3),										//썸네일 width
	thumH int(3),										//썸네일 height
	lsimg tinyint default 0,							//첨부이미지는 리스트 이미지로만 사용시 체크
	imgclk tinyint default 0,							//이미지클릭시 액션
	vtype tinyint default 0,							//상세페이지 타입
	vip tinyint default 0,								//아이피 노출여부
	bCom tinyint default 0,								//댓글 노출여부
	breply tinyint default 0,							//답변글 쓰기 여부(계층형게시판)
	bsecret tinyint default 0,							//비밀글 사용여부
	bnotice tinyint default 0,							//공지글 등록가능 여부
	beditor tinyint default 1,							//에디터 사용여부(1:사용, 0:미사용)
	upcnt tinyint,										//첨부파일 갯수 제한
	bemail tinyint default 0,							//이메일사용여부
	btel tinyint default 0,								//전화번호 입력폼 사용여부
	bhome tinyint default 0,							//홈페이지사용여부
	bevent tinyint default 0,							//이벤트 사용시 (시작일, 종료일 입력폼 활성화)
	bcate tinyint default 0,							//카테고리 사용여부
	hhtml text,											//상단 html
	fhtml text,											//하단 html
	regdt datetime,										//게시판 생성일
	primary key(idx), 
	key iidx(code)
)

create table sw_board_cnf
(
	idx int(11) unsigned not null auto_increment, 
	code varchar(20) not null, 
	name varchar(30) not null,
	part tinyint not null,
	lAct tinyint default 0,	
	rAct tinyint default 0,	
	wAct tinyint default 0,	
	cAct tinyint default 0,
	bspam enum('Y','N') default 'N', 
	path varchar(100), 
	cutstr int(3), 
	vlimit int(3),	
	period tinyint default 1,
	thumW int(3),			
	thumH int(3), 
	lsimg tinyint default 0, 
	imgclk tinyint default 0,
	vtype tinyint default 0, 
	vip tinyint default 0,
	bCom tinyint default 0, 
	breply tinyint default 0,
	bsecret tinyint default 0,
	bnotice tinyint default 0, 
	beditor tinyint default 1,
	upcnt tinyint,	
	bemail tinyint default 0, 
	btel tinyint default 0, 
	bhome tinyint default 0, 
	bevent tinyint default 0,
	bcate tinyint default 0,
	hhtml text, 
	fhtml text, 
	regdt datetime,			
	primary key(idx), 
	key iidx(code)
)

### 게시판 data ###
create table sw_board
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//게시판코드
	hit int(3) default 0,								//조회수
	isadm tinyint default 0,							//관리자 여부(1:관리자, 0:사용자)
	userid varchar(30),									//작성자 아이디
	pwd varchar(30),									//작성자 패스워드
	name varchar(30),									//작성자명
	title varchar(200),									//제목
	sday varchar(20),									//시작일(이벤트 게시판시 사용)
	eday varchar(20),									//종료일(이벤트 게시판시 사용)
	email varchar(60),									//이메일
	tel varchar(20),									//연락처
	home varchar(100),									//홈페이지URL
	bLock enum('Y', 'N') default 'N',					//비밀글
	lockid varchar(30),									//비밀글 아이디
	notice enum('Y', 'N') default 'N',					//공지
	ip varchar(20),										//아이피
	cate int(11) default 0,								//category idx
	ref int(11) not null,								//답변글 관련
	re_step int(11) not null,							//답변글 레벨
	re_level int(11) not null,							//답변글 관련
	content text,										//내용
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx1(code), 
	foreign key(code) references sw_board_cnf(code) on delete cascade
)

create table sw_board
(
	idx int(11) unsigned not null auto_increment, 
	code varchar(20) not null, 
	hit int(3) default 0, 
	isadm tinyint default 0, 
	userid varchar(30), 
	pwd varchar(30), 
	name varchar(30), 
	title varchar(200), 
	sday varchar(20), 
	eday varchar(20),
	email varchar(60), 
	tel varchar(20),
	home varchar(100), 
	bLock enum('Y', 'N') default 'N', 
	lockid varchar(30),
	notice enum('Y', 'N') default 'N', 
	ip varchar(20), 
	cate int(11) default 0,
	ref int(11) not null,
	re_step int(11) not null, 
	re_level int(11) not null, 
	content text, 
	regdt datetime,			
	primary key(idx),
	key iidx1(code), 
	foreign key(code) references sw_board_cnf(code) on delete cascade
)

### 게시판 첨부파일 ###
create table sw_boardfile
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//게시판코드
	bidx int(11) not null,								//게시글 idx
	upfile varchar(30) not null,						//첨부파일명(변경파일명)
	upreal varchar(100),								//원본파일명(변경전 파일명)
	ftype varchar(10),									//업로드 파일형식
	fsize int(3),										//파일사이즈
	dcnt int(3),										//다운로드 회수
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx1(code), 
	key iidx2(bidx), 
	foreign key(bidx) references sw_board(idx) on delete cascade
)

create table sw_boardfile
(
	idx int(11) unsigned not null auto_increment,
	code varchar(20) not null, 
	bidx int(11) not null, 
	upfile varchar(30) not null, 
	upreal varchar(100), 
	ftype varchar(10),
	fsize int(3),
	dcnt int(3), 
	regdt datetime, 
	primary key(idx),
	key iidx1(code), 
	key iidx2(bidx), 
	foreign key(bidx) references sw_board(idx) on delete cascade
)

### 게시판 댓글 ###
create table sw_comment 
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//게시판코드
	bidx int(11) not null,								//게시글 idx
	isadm tinyint default 0,							//관리자 여부
	userid varchar(30),									//작성자 id
	pwd varchar(30),									//작성자 패스워드
	name varchar(30) not null,							//작성자명
	bLock enum('Y','N') default 'N',					//비밀글
	comment text,										//댓글 내용
	ip varchar(20),										//아이피
	regdt datetime,										//등록일
	primary key(idx),
	key iidx1(code), 
	key iidx2(bidx), 
	foreign key(bidx) references sw_board(idx) on delete cascade
)

create table sw_comment 
(
	idx int(11) unsigned not null auto_increment,
	code varchar(20) not null, 
	bidx int(11) not null, 
	isadm tinyint default 0,
	userid varchar(30), 
	pwd varchar(30), 
	name varchar(30) not null, 
	bLock enum('Y','N') default 'N',
	comment text, 
	ip varchar(20), 
	regdt datetime, 
	primary key(idx),
	key iidx1(code), 
	key iidx2(bidx), 
	foreign key(bidx) references sw_board(idx) on delete cascade
)

### 팝업관리 ###
create table sw_popup
(
	idx int(11) unsigned not null auto_increment,		//index
	buse enum('Y','N') default 'Y',						//팝업사용여부(Y:사용, N:미사용)
	title varchar(100) not null,						//팝업타이틀
	sday varchar(10),									//팝업노출 시작일
	eday varchar(10),									//팝업노출 종료일
	width int(3),										//팝업가로사이즈
	height int(3),										//팝업세로사이즈
	ptop int(3),										//팝업위치(상단여백)
	pleft int(3),										//팝업위치(왼쪽여백)
	ptype tinyint default 1,							//팝업스타일(1:윈도우팝업, 2:레이어팝업)
	content text,										//팝업내용
	bgimg varchar(30),									//팝업배경이미지
	regdt datetime,										//팝업등록일
	primary key(idx)
)

create table sw_popup
(
	idx int(11) unsigned not null auto_increment,
	buse enum('Y','N') default 'Y', 
	title varchar(100) not null, 
	sday varchar(10), 
	eday varchar(10), 
	width int(3), 
	height int(3), 
	ptop int(3), 
	pleft int(3), 
	ptype tinyint default 1, 
	content text, 
	bgimg varchar(30), 
	regdt datetime,
	primary key(idx)
)

### 일정관리 ###
create table sw_calendar 
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//코드
	admid varchar(20) not null,							//관리자 아이디
	cdate date not null,								//check date
	sday date,											//시작일
	eday date,											//종료일
	stime varchar(5),									//시작시간(시:분)
	etime varchar(5),									//종료시간(시:분)
	title varchar(255),									//타이틀
	regdt datetime,										//등록일
	primary key(idx)	
)

create table sw_calendar 
(
	idx int(11) unsigned not null auto_increment, 
	code varchar(20) not null, 
	admid varchar(20) not null, 
	cdate date not null, 
	sday date, 
	eday date, 
	stime varchar(5), 
	etime varchar(5), 
	title varchar(255), 
	regdt datetime, 
	primary key(idx)
)

### 상품 아이콘 관리 ###
create table sw_icon 
(
	idx int(11) unsigned not null auto_increment,		//index
	buse enum('Y', 'N') default 'Y',					//사용여부(Y:사용, N:미사용)
	name varchar(30),									//아이콘명
	img varchar(30) not null,							//이미지
	regdt datetime,										//등록일
	primary key(idx)
)

create table sw_icon 
(
	idx int(11) unsigned not null auto_increment,	
	buse enum('Y', 'N') default 'Y',				
	name varchar(30),								
	img varchar(30) not null, 
	regdt datetime, 
	primary key(idx)
)

### 1:1 문의 ###
create table sw_help 
(
	idx int(11) unsigned not null auto_increment,		//index
	userid varchar(30) not null,						//회원아이디
	name varchar(30) not null,							//회원명
	email varchar(50),									//회원이메일
	category tinyint default 0,							//문의 분류
	title varchar(100),									//문의제목
	content text,										//문의내용
	upfile varchar(30),									//첨부파일
	auserid varchar(30),								//답변자 아이디
	aname varchar(30),									//답변자
	acontent text,										//답변내용
	status tinyint default 0,							//상태
	aregdt datetime,									//답변작성일
	regdt datetime,										//등록일
	primary key(idx),	
	key iidex1(userid), 
	key iidex2(category), 
	foreign key(userid) references sw_member(userid) on delete cascade
)

create table sw_help 
(
	idx int(11) unsigned not null auto_increment, 
	userid varchar(30) not null, 
	name varchar(30) not null, 
	email varchar(50), 
	category tinyint default 0, 
	title varchar(100), 
	content text, 
	upfile varchar(30),
	auserid varchar(30), 
	aname varchar(30), 
	acontent text, 
	status tinyint default 0, 
	aregdt datetime, 
	regdt datetime, 
	primary key(idx), 
	key iidex1(userid), 
	key iidex2(category), 
	foreign key(userid) references sw_member(userid) on delete cascade
)

### 상품문의 ###
create table sw_qna 
(
	idx int(11) unsigned not null auto_increment,		//index
	gidx int(11) not null,								//상품 idx
	bLock enum('Y', 'N') default 'N',					//비밀글 여부
	userid varchar(30) not null,						//회원아이디
	name varchar(30) not null,							//작성자명
	email varchar(50),									//이메일
	category tinyint default 0,							//상품문의 분류
	title varchar(100),									//제목	
	content text,										//문의내용
	ip varchar(20) not null,							//아이피
	upfile varchar(30),									//첨부파일
	auserid varchar(30),								//답변자아이디
	aname varchar(30),									//답변자명
	atitle varchar(100),								//답변 제목
	acontent text,										//답변 내용
	status tinyint default 0,							//상태
	aregdt datetime,									//답변등록일
	regdt datetime,										//작성일
	primary key(idx), 
	key iidex1(userid), 
	key iidex2(category), 
	foreign key(userid) references sw_member(userid) on delete cascade
)

create table sw_qna 
(
	idx int(11) unsigned not null auto_increment, 
	gidx int(11) not null, 
	bLock enum('Y', 'N') default 'N', 
	userid varchar(30) not null, 
	name varchar(30) not null, 
	email varchar(50), 
	category tinyint default 0, 
	title varchar(100), 
	content text, 
	ip varchar(20) not null, 
	upfile varchar(30), 
	auserid varchar(30), 
	aname varchar(30), 
	atitle varchar(100), 
	acontent text, 
	status tinyint default 0, 
	aregdt datetime, 
	regdt datetime, 
	primary key(idx), 
	key iidex1(userid), 
	key iidex2(category), 
	foreign key(userid) references sw_member(userid) on delete cascade
)

### 상품평 ###
create table sw_review
(
	idx int(11) unsigned not null auto_increment,		//index
	gidx int(11) not null,								//상품 idx
	userid varchar(30) not null,						//회원아이디
	point tinyint default 0,							//평점
	name varchar(30) not null,							//작성자
	title varchar(100) not null,						//제목
	content text,										//내용
	ip varchar(20),										//아이피
	status tinyint default 0,							//적립금 적립상태(1:적립완료, 0:미적립)
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(gidx), 
	foreign key(gidx) references sw_goods(idx) on delete cascade, 
	foreign key(userid) references sw_member(userid) on delete cascade 
) 

create table sw_review
(
	idx int(11) unsigned not null auto_increment, 
	gidx int(11) not null, 
	userid varchar(30) not null, 
	point tinyint default 0,
	name varchar(30) not null, 
	title varchar(100) not null, 
	content text, 
	ip varchar(20), 
	status tinyint default 0,
	regdt datetime, 
	primary key(idx), 
	key iidx(gidx), 
	foreign key(gidx) references sw_goods(idx) on delete cascade, 
	foreign key(userid) references sw_member(userid) on delete cascade 
) 

### 적립금 내역 ###
create table sw_emoney 
(
	idx int(11) unsigned not null auto_increment,		//index
	part tinyint not null default 0,					//지급 및 차감 유형
	userid varchar(30) not null,						//회원아이디
	cash int(7) not null,								//적립금(지급, 차감 금액)
	reason varchar(200),								//내역
	regdt datetime,										//발생일
	primary key(idx), 
	key iidx1(part), 
	key iidx2(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

create table sw_emoney 
(
	idx int(11) unsigned not null auto_increment,
	part tinyint not null default 0, 
	userid varchar(30) not null, 
	cash int(7) not null, 
	reason varchar(200), 
	regdt datetime, 
	primary key(idx), 
	key iidx1(part), 
	key iidx2(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

### 쇼핑몰 설정 테이블 ###
create table sw_config
(
	idx int(11) unsigned not null auto_increment,		//index
	jbus enum('Y', 'N') default 'N',					//회원가입시 사용여부
	jcash int(3) default 0,								//회원가입시 적립금
	bbus enum('Y', 'N') default 'N',					//생일 사용여부
	bcash int(3) default 0,								//생일당일 적립금 
	fbus enum('Y', 'N') default 'N',					//첫구매시 사용여부
	fcash int(3) default 0,								//첫구매시 적립금
	obus enum('Y', 'N') default 'N',					//상품구매시 사용여부
	rbus enum('Y', 'N') default 'N',					//상품평 작성시 사용여부
	rcash int(3) default 0,								//상품평 작성시 적립금
	auto_cash datetime,									//자동적립금 지급시간
	auto_sms datetime,									//자동문자발송 시간
	update_sale datetime,								//기획상품(타임세일) 세일기간체크 시간
	updt datetime,										//업데이트 일시
	primary key(idx)
)

create table sw_config
(
	idx int(11) unsigned not null auto_increment, 
	jbuse enum('Y', 'N') default 'N', 
	jcash int(3) default 0, 
	bbuse enum('Y', 'N') default 'N', 
	bcash int(3) default 0, 
	fbuse enum('Y', 'N') default 'N', 
	fcash int(3) default 0, 
	obuse enum('Y', 'N') default 'N', 
	rbuse enum('Y', 'N') default 'N', 
	rcash int(3) default 0, 
	auto_cash datetime, 
	update_sale datetime,
	updt datetime, 
	primary key(idx)
)

### 쿠폰 설정 테이블###
create table sw_coupon_cfg
(
	idx int(11) unsigned not null auto_increment,		//index
	cp_code varchar(20) not null,						//고유코드
	cp_buse tinyint default 0,							//사용여부(0:사용가능, 1:사용불가)
	cp_type tinyint default 0,							//쿠폰유형(1:할인쿠폰, 2:적립쿠폰)
	cp_auto tinyint default 0,							//쿠폰번호 생성형태
	cp_num varchar(20) not null,						//쿠폰번호
	cp_name varchar(100) not null,						//쿠폰명
	cp_cnt int(3) not null,								//쿠폰발행
	cp_overlap int(3) not null default 1,				//중복사용 가능수
	cp_dc int(3) not null,								//할인(적립) 금액
	cp_unit enum('p','w') default 'p',					//할인(적립) 단위
	cp_max int(7) default 0,							//사용조건
	cp_sday varchar(10) not null,						//사용기간(시작일)
	cp_eday varchar(10) not null,						//사용기간(종료일)
	cp_use int(3) default 0,							//사용내역(수)
	cp_status tinyint default 0,						//상태
	regdt datetime,										//생성일
	primary key(idx), 
	key iidx1(cp_code), 
	key iidx2(cp_num)
)

create table sw_coupon_cfg 
(
	idx int(11) unsigned not null auto_increment, 
	cp_code varchar(20) not null,
	cp_type tinyint default 0, 
	cp_auto tinyint default 0, 
	cp_num varchar(20) not null, 
	cp_name varchar(100) not null, 
	cp_cnt int(3) not null, 
	cp_overlap int(3) not null default 1, 
	cp_dc int(3) not null, 
	cp_unit enum('p','w') default 'p', 
	cp_max int(7) default 0, 
	cp_sday varchar(10) not null, 
	cp_eday varchar(10) not null, 
	cp_use int(3) default 0,
	cp_status tinyint default 0, 
	regdt datetime, 
	primary key(idx), 
	key iidx1(cp_code), 
	key iidx2(cp_num)
)

### 쿠폰번호 테이블 ###
create table sw_coupon 
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//쿠폰 고유코드(sw_coupon_cfg cp_code와 동일)
	number varchar(20) not null,						//쿠폰번호
	userid varchar(30),									//지급 회원아이디
	ordcode varchar(20),								//사용주문 코드
	status tinyint default 0,							//상태(0:대기, 1:지급, 2:사용)
	givedt datetime,									//지급일
	usedt datetime,										//사용일
	primary key(idx), 
	key iidx1(code), 
	key iidx2(number), 
	foreign key(code) references sw_coupon_cfg(cp_code) on delete cascade
)

create table sw_coupon 
(
	idx int(11) unsigned not null auto_increment, 
	code varchar(20) not null,
	number varchar(20) not null, 
	userid varchar(30), 
	ordcode varchar(20),
	status tinyint default 0, 
	givedt datetime, 
	usedt datetime, 
	primary key(idx), 
	key iidx1(code), 
	key iidx2(number), 
	foreign key(code) references sw_coupon_cfg(cp_code) on delete cascade
)

### banner group ###
create table sw_banner_grp 
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//그룹코드
	name varchar(100) not null,							//그룹명
	regdt datetime,										//생성일
	primary key(idx) 
)

create table sw_banner_grp 
(
	idx int(11) unsigned not null auto_increment, 
	code varchar(20) not null, 
	name varchar(100) not null, 
	regdt datetime, 
	primary key(idx) 
)

### banner list ###
create table sw_banner 
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//그룹코드
	buse enum('Y','N') default 'N',						//노출여부(Y:노출, N:비노출)
	name varchar(100) not null,							//배너명
	sday varchar(10),									//노출 시작일
	eday varchar(10),									//노출 종료일
	img varchar(30),									//배너이미지
	target varchar(10),									//타켓
	url varchar(100),									//링크
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(code), 
	foreign key(code) references sw_banner_grp(code) on delete cascade
)

create table sw_banner 
(
	idx int(11) unsigned not null auto_increment, 
	code varchar(20) not null, 
	buse enum('Y','N') default 'N', 
	name varchar(100) not null, 
	sday varchar(10), 
	eday varchar(10), 
	img varchar(30),
	target varchar(10), 
	url varchar(100), 
	regdt datetime, 
	primary key(idx), 
	key iidx(code), 
	foreign key(code) references sw_banner_grp(code) on delete cascade
)

### 메인비주얼 이미지 ###
create table sw_visual 
(
	idx int(11) unsigned not null auto_increment,		//index
	buse enum('Y', 'N') default 'Y',					//노출여부
	seq int(3) default 1,								//노출순위
	title varchar(100),									//타이틀
	img varchar(30),									//이미지
	target varchar(10),									//타켓
	url varchar(100),									//링크
	regdt datetime,										//등록일
	primary key(idx)
)

create table sw_visual 
(
	idx int(11) unsigned not null auto_increment,
	buse enum('Y', 'N') default 'Y',
	seq int(3) default 1, 
	title varchar(100), 
	img varchar(30), 
	target varchar(10), 
	url varchar(100), 
	regdt datetime, 
	primary key(idx)
)

### 메인 event 관리 ###
create table sw_event 
(
	idx int(11) unsigned not null auto_increment,		//index
	buse enum('Y', 'N') default 'Y',					//노출여부
	title varchar(100),									//타이틀
	img varchar(30),									//이미지
	target varchar(10),									//타켓
	url varchar(100),									//링크
	regdt datetime,										//등록일
	primary key(idx)
)

create table sw_event 
(
	idx int(11) unsigned not null auto_increment,
	buse enum('Y', 'N') default 'Y',
	title varchar(100), 
	img varchar(30), 
	target varchar(10), 
	url varchar(100), 
	regdt datetime, 
	primary key(idx)
)


### 기획전 ###
create table sw_sale
(
	idx int(11) unsigned not null auto_increment,		//index
	name varchar(100) not null,							//기획전명
	sday varchar(10) not null,							//시작일
	shour tinyint default 0,							//시작시간
	smin tinyint default 0,								//시작분
	eday varchar(10) not null,							//종료일
	ehour tinyint default 0,							//종료시간
	emin tinyint default 0,								//종료분
	gidx int(11) not null,								//상품 idx
	price int(7) not null default 0,					//할인가격
	jcnt int(3) default 0,								//참여인원
	status tinyint default 0,							//진행여부(0:종료, 1:진행중, 2:진행예정)
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(gidx), 
	foreign key(gidx) references sw_goods(idx) on delete cascade
)

create table sw_sale
(
	idx int(11) unsigned not null auto_increment, 
	name varchar(100) not null, 
	sday varchar(10) not null, 
	shour tinyint default 0, 
	smin tinyint default 0,
	eday varchar(10) not null, 
	ehour tinyint default 0, 
	emin tinyint default 0, 
	gidx int(11) not null, 
	price int(7) not null default 0, 
	jcnt int(3) default 0, 
	status tinyint default 0,
	regdt datetime, 
	primary key(idx), 
	key iidx(gidx), 
	foreign key(gidx) references sw_goods(idx) on delete cascade
)

### wishlist ###
create table sw_wish
(
	idx int(11) unsigned not null auto_increment,		//index
	userid varchar(30) not null,						//회원아이디
	gidx int(11) not null,								//상품 idx
	ea int(3) not null,									//수량
	optnm varchar(100),									//옵션명
	optval varchar(100),								//옵션값
	optpay varchar(100),								//옵션가격
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx1(gidx), 
	key iidx2(userid), 
	foreign key(gidx) references sw_goods(idx) on delete cascade, 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

create table sw_wish
(
	idx int(11) unsigned not null auto_increment, 
	userid varchar(30) not null, 
	gidx int(11) not null, 
	ea int(3) not null,
	optnm varchar(100),		
	optval varchar(100),	
	optpay varchar(100),	
	regdt datetime, 
	primary key(idx), 
	key iidx1(gidx), 
	key iidx2(userid), 
	foreign key(gidx) references sw_goods(idx) on delete cascade, 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

### 장바구니 ###
create table sw_cart 
(
	idx int(11) unsigned not null auto_increment,		//index
	userid varchar(30) not null,						//회원아이디
	goods text,											//구매상품정보(gidx, optnm, optval, ea)
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

create table sw_cart 
(
	idx int(11) unsigned not null auto_increment, 
	userid varchar(30) not null, 
	goods text, 
	regdt datetime, 
	primary key(idx), 
	key iidx(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

### 장바구니 선택구매시 임시저장 테이블 ###
create table sw_ordcart 
(
	idx int(11) unsigned not null auto_increment,		//index
	userid varchar(30) not null,						//회원아이디
	guestid varchar(30),								//비회원구매시 랜덤아이디
	goods text,											//구매상품정보(gidx, optnm, optval, ea)
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

create table sw_ordcart 
(
	idx int(11) unsigned not null auto_increment, 
	userid varchar(30) not null, 
	guestid varchar(30), 
	goods text, 
	regdt datetime, 
	primary key(idx), 
	key iidx(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

### 구매임시 테이블 #############################
create table sw_order_tmp
(
	idx int(11) unsigned not null auto_increment,		//index
	ordcode varchar(20) not null,						//주문코드
	userid varchar(30) not null,						//회원아이디
	userfb enum('Y', 'N') default 'N',					//로그인경로(Y:페북, N:사이트)
	name varchar(30) not null,							//주문자명
	tel varchar(20),									//주문자연락처
	hp varchar(20),										//주문자 휴대폰
	email varchar(100),									//주문자 이메일
	zip varchar(7),										//주문자 우편번호
	adr1 varchar(100),									//주문자 주소
	adr2 varchar(100),									//주문자 상세주소
	rname varchar(30),									//수취인명
	rtel varchar(20),									//받는사람 연락처
	rhp varchar(20),									//받는사람 휴대폰
	remail varchar(100),								//받는사람 이메일
	rzip varchar(7),									//배송지 우편번호
	radr1 varchar(100),									//배송지 주소
	radr2 varchar(100),									//배송지 상세주소
	comment text,										//요청사항
	payway varchar(10),									//결제수단
	goods text,											//구매상품정보
	coupon_cd varchar(20),								//쿠폰코드
	coupon varchar(20),									//쿠폰번호
	couponamt int(3) default 0,							//쿠폰할인 금액
	gamt int(7) default 0,								//상품구매금액
	dyamt int(3) default 0,								//배송비
	upoint int(3) default 0,							//사용적립금
	optamt int(3) default 0,							//추가 옵션가격
	ordprice int(7) default 0,							//총결제금액
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx1(ordcode), 
	key iidx2(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

create table sw_order_tmp
(
	idx int(11) unsigned not null auto_increment, 
	ordcode varchar(20) not null, 
	userid varchar(30) not null, 
	userfb enum('Y', 'N') default 'N', 
	name varchar(30) not null, 
	tel varchar(20), 
	hp varchar(20), 
	email varchar(100),
	zip varchar(7), 
	adr1 varchar(100), 
	adr2 varchar(100),
	rname varchar(30), 
	rtel varchar(20), 
	rhp varchar(20), 
	remail varchar(100), 
	rzip varchar(7), 
	radr1 varchar(100), 
	radr2 varchar(100), 
	comment text, 
	payway varchar(10), 
	goods text, 
	coupon_cd varchar(20),	
	coupon varchar(20),		
	couponamt int(3) default 0,
	gamt int(7) default 0, 
	dyamt int(3) default 0, 
	upoint int(3) default 0, 
	optamt int(3) default 0, 
	ordprice int(7) default 0, 
	regdt datetime, 
	primary key(idx), 
	key iidx1(ordcode), 
	key iidx2(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade 
)

### 주문태이블 ###
create table sw_order 
(
	idx int(11) unsigned not null auto_increment,		//index
	ordcode varchar(20) not null,						//주문코드
	userid varchar(30) not null,						//회원아이디
	userfb enum('Y', 'N') default 'N',					//로그인경로(Y:페북, N:사이트)
	name varchar(30) not null,							//주문자명
	tel varchar(20),									//주문자 연락처
	hp varchar(20),										//주문자 휴대폰
	email varchar(100),									//주문자 메일주소
	zip varchar(7),										//주문자 우편번호
	adr1 varchar(100),									//주문자 주소
	adr2 varchar(100),									//주문자 상세주소
	rname varchar(30),									//받는사람명
	rtel varchar(20),									//받는사람 연락처
	rhp varchar(20),									//받는사람 휴대폰
	remail varchar(100),								//받는사람 메일주소
	rzip varchar(7),									//받는사람 우편번호
	radr1 varchar(100),									//받는사람 주소
	radr2 varchar(100),									//받는사람 상세주소
	comment text,										//배송요청
	goods text,											//구매상품정보(직렬화)
	coupon_cd varchar(20),								//쿠폰코드
	coupon varchar(20),									//쿠폰번호
	couponamt int(3) default 0,							//쿠폰할인 금액
	payway varchar(10),									//결제방식
	bankinfo varchar(100),								//무통장계좌정보
	buyer varchar(30),									//입금자명
	buyday varchar(10),									//입금예정일
	bankamt int(7) default 0,							//통장입금액
	card_cd varchar(4),									//kcp 카드번호
	card_name varchar(20), 
	app_no varchar(10),
	bank_code varchar(10), 
	bank_name varchar(30), 
	bankname varchar(30), 
	depositor varchar(10), 
	account varchar(30), 
	va_date varchar(20),
	gamt int(7) default 0,								//구매금액 
	dyamt int(3) default 0,								//배송비
	upoint int(3) default 0,							//사용적립금
	optamt int(3) default 0,							//추가옵션가격
	ordprice int(7) default 0, 
	status int(3) default 0, 
	dycompany varchar(20), 
	dynumber varchar(30), 
	orddate varchar(200), 
	memo text,											//관리자메모
	regdt datetime,										//등록일
	primary key(idx), 
	key iidx1(ordcode), 
	key iidx2(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade
)

create table sw_order 
(
	idx int(11) unsigned not null auto_increment, 
	ordcode varchar(20) not null, 
	userid varchar(30) not null, 
	userfb enum('Y', 'N') default 'N',
	name varchar(30) not null, 
	tel varchar(20), 
	hp varchar(20), 
	email varchar(100),
	zip varchar(7), 
	adr1 varchar(100), 
	adr2 varchar(100),
	rname varchar(30), 
	rtel varchar(20), 
	rhp varchar(20), 
	remail varchar(100), 
	rzip varchar(7), 
	radr1 varchar(100), 
	radr2 varchar(100), 
	comment text, 
	goods text, 
	coupon_cd varchar(20),	
	coupon varchar(20),		
	couponamt int(3) default 0,
	payway varchar(10), 
	bankinfo varchar(100), 
	buyer varchar(30), 
	buyday varchar(10), 
	bankamt int(7) default 0,
	card_cd varchar(4), 
	card_name varchar(20), 
	app_no varchar(10),
	bank_code varchar(10), 
	bank_name varchar(30), 
	bankname varchar(30), 
	depositor varchar(10), 
	account varchar(30), 
	va_date varchar(20),
	gamt int(7) default 0, 
	dyamt int(3) default 0, 
	upoint int(3) default 0,
	optamt int(3) default 0, 
	ordprice int(7) default 0, 
	status int(3) default 0, 
	dycompany varchar(20), 
	dynumber varchar(30), 
	orddate varchar(200),
	ordType varchar(10), 
	regdt datetime, 
	primary key(idx), 
	key iidx1(ordcode), 
	key iidx2(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade
)

### 구매상품 테이블 ###
create table sw_order_item 
(
	idx int(11) unsigned not null auto_increment,		//index
	ordcode varchar(20) not null,						//주문코드
	gidx int(11) not null,								//상품idx
	bsale int(11) default 0,							//타임세일 상품구매시 기획전 idx
	gname varchar(100) not null,						//상품명
	price int(7) not null default 0,					//상품가격
	ea int(3) not null default 0,						//구매수량
	emoney int(3) default 0,							//상품별 적립금
	dyamt int(3) not null default 0,					//배송비(개별배송비)
	optamt int(3) default 0,							//상품별 옵션총금액
	optnm varchar(100),									//상품옵션(key 값)
	optval varchar(100),								//상품옵션(value)
	optpay varchar(100),								//상품옵션(가격)							
	regdt datetime,										//주문일
	primary key(idx), 
	key iidx1(ordcode),
	key iidx2(gidx), 
	foreign key(ordcode) references sw_order(ordcode) on delete cascade
)

create table sw_order_item 
(
	idx int(11) unsigned not null auto_increment, 
	ordcode varchar(20) not null, 
	gidx int(11) not null, 
	bsale int(11) default 0, 
	gname varchar(100) not null, 
	price int(7) not null default 0, 
	ea int(3) not null default 0,
	emoney int(3) default 0,
	dyamt int(3) not null default 0, 
	optamt int(3) default 0, 
	optnm varchar(100), 
	optval varchar(100), 
	optpay varchar(100),
	regdt datetime, 
	primary key(idx), 
	key iidx1(ordcode),
	key iidx2(gidx), 
	foreign key(ordcode) references sw_order(ordcode) on delete cascade
)

### 결제시 에러일 경우 #########################
create table sw_order_err 
(
	idx int(11) unsigned not null auto_increment, 
	ordcode varchar(20) not null, 
	userid varchar(30) not null, 
	name varchar(30) not null, 
	tel varchar(20), 
	hp varchar(20), 
	email varchar(100),
	zip varchar(7), 
	adr1 varchar(100), 
	adr2 varchar(100),
	rname varchar(30), 
	rtel varchar(20), 
	rhp varchar(20), 
	remail varchar(100), 
	rzip varchar(7), 
	radr1 varchar(100), 
	radr2 varchar(100), 
	comment text, 
	goods text, 
	coupon_cd varchar(20),	
	coupon varchar(20),		
	couponamt int(3) default 0,
	payway varchar(10), 
	sbankinfo varchar(100), 
	buyer varchar(30), 
	buyday varchar(10), 
	cardInfo varchar(100), 
	bankInfo varchar(100), 
	vcntInfo varchar(100), 
	gamt int(7) default 0, 
	dyamt int(3) default 0, 
	upoint int(3) default 0,
	optamt int(3) default 0, 
	ordprice int(7) default 0, 
	errmsg text, 
	ecancel tinyint default 0, 
	regdt datetime, 
	primary key(idx), 
	key iidx1(ordcode), 
	key iidx2(userid), 
	foreign key(userid) references sw_member(userid) on delete cascade
)

### admin bookmark ###
create table sw_bookmark 
(
	idx int(11) unsigned not null auto_increment,
	buse tinyint default 0, 
	name varchar(100) not null,
	url varchar(100) not null, 
	rank int(3) default 0, 
	primary key(idx)
)
?>