<?php
//=======================================================================================
//  DBSchema
//=======================================================================================

### 접속현황 테이블 --- sw_counter ###
create table sw_counter
(
	idx int(11) unsigned not null auto_increment,	//index
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
	device enum('P', 'M') default 'P',				//디바이스(P:pc, M:모바일)
	regdt datetime,									//등록일
	primary key(idx),
	key ip(ip, regdt),
	key brower(brower, regdt),
	key os(os, regdt),
	key rhost(rhost, regdt),
	key brogrp(brogrp, regdt),
	key osgrp(osgrp, regdt)
) ENGINE=INNODB

create table sw_counter
(
	idx bigint(11) unsigned not null auto_increment,
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
	device enum('P', 'M') default 'P',
	regdt datetime,
	primary key(idx),
	key ip(ip, regdt),
	key brower(brower, regdt),
	key os(os, regdt),
	key rhost(rhost, regdt),
	key brogrp(brogrp, regdt),
	key osgrp(osgrp, regdt)
) ENGINE=INNODB

### 관리자 대시보드 접속카운터 속도 문제로 날짜별 counter table 생성 --- kkang(2019-04-22) ###
create table sw_counter_days
(
	idx int(11) unsigned not null auto_increment,		// index
	days date not null,										// 날짜
	pcnt int(11) default 0,									// pc 접속 total
	mcnt int(11) default 0,									// mobile 접속 total
	primary key(idx),
	key days(days)
) ENGINE=INNODB

create table sw_counter_days
(
	idx int(11) unsigned not null auto_increment,
	days date not null,
	pcnt int(11) default 0,
	mcnt int(11) default 0,
	primary key(idx),
	key days(days)
) ENGINE=INNODB

### 게시판 설정테이블 --- sw_board_cnf ###
create table sw_board_cnf
(
	idx int(11) unsigned not null auto_increment,	//index
	code varchar(20) not null,						//게시판코드
	name varchar(50) not null,						//게시판명
	skin varchar(30) not null,						//스킨
	lvl tinyint not null default 0,					//목록보기권한
	lvr tinyint not null default 0,					//상세보기권한
	lvw tinyint not null default 0,					//쓰기권한
	lvc tinyint not null default 0,					//댓글쓰기권한
	bspam enum('Y','N') default 'N',				//스팸코드표시여부
	ipblock text,									//차단ip
	wdblock text,									//불량어금지
	path varchar(100),								//pc경로
	path_mobile varchar(100),						//모바일경로
	cutstr int(3),									//글자수제한(pc|모바일)
	limitcnt int(3),								//페이지당 노출목록수(pc|모바일)
	period_new tinyint default 0,					//new 아이콘 표시일
	bthumb enum('Y','N') default 'N',				//썸네일 생성여부
	thumb_w int(3) default 0,						//썸네일 width
	thumb_h int(3) default 0,						//썸네일 height
	limgcnt tinyint default 0,						//썸네일 이미지 한행 노출수
	imglist tinyint default 0,						//이미지 리스트에만 표시여부
	imgclick tinyint default 0,						//이미지클릭 액션설정
	imgmw int(3) default 0,							//이미지 상세보기의 최대 width
	viewlist tinyint default 0,						//상세페이지 노출타입(0:내용만, 1:내용+이전다음글, 2:내용+리스트)
	hit_adm tinyint default 0,						//관리자모드에서 조회수 허용여부
	bhit tinyint default 0,							//조회수 중복허용여부(0:허용안함, 1:허용함)
	bsort tinyint default 0,						//정렬방식(0:기본, 1:등록일순....)
	bregdt tinyint default 0,						//등록일(0:자동, 1:수동등록가능)
	bip tinyint default 0,							//아이피노출여부
	bcom tinyint default 0,							//댓글기능 사용여부
	breply tinyint default 0,						//답글사용여부
	bdown tinyint default 0,						//다운로드 표시여부
	bsecret tinyint default 0,						//비밀글 설정
	bnotice tinyint default 0,						//공지글 사용여부
	beditor tinyint default 0,						//에디터 사용여부
	bvideo tinyint default 0,						//유튜브 및 동영상 URL 입력란사용여부
	bemail tinyint default 0,						//이메일 사용여부
	bphone tinyint default 0,						//연락처 사용여부
	bevent tinyint default 0,						//이벤트(시작일, 종료일) 사용여부
	bexp tinyint default 0,							//간략설명 사용여부
	bcategory tinyint default 0,					//게시판 분류 사용여부
	filecnt tinyint default 0,						//첨부파일 업로드 수
	hhtml text,										//상단 html
	fhtml text,										//하단 html
	regdt datetime,									//등록일
	updt datetime,									//수정일
	primary key(idx),
	unique key(code),
	key bdcd(code)
) ENGINE=INNODB

create table sw_board_cnf
(
	idx int(11) unsigned not null auto_increment,
	code varchar(20) not null,
	name varchar(50) not null,
	skin varchar(30) not null,
	lvl tinyint not null default 0,
	lvr tinyint not null default 0,
	lvw tinyint not null default 0,
	lvc tinyint not null default 0,
	bspam enum('Y','N') default 'N',
	ipblock text,
	wdblock text,
	path varchar(100),
	path_mobile varchar(100),
	cutstr int(3),
	limitcnt int(3),
	period_new tinyint default 0,
	bthumb enum('Y','N') default 'N',
	thumb_w int(3) default 0,
	thumb_h int(3) default 0,
	limgcnt tinyint default 0,
	imglist tinyint default 0,
	imgclick tinyint default 0,
	imgmw int(3) default 0,
	viewlist tinyint default 0,
	hit_adm tinyint default 0,
	bhit tinyint default 0,
	bsort tinyint default 0,
	bregdt tinyint default 0,
	bip tinyint default 0,
	bcom tinyint default 0,
	breply tinyint default 0,
	bdown tinyint default 0,
	bsecret tinyint default 0,
	bnotice tinyint default 0,
	beditor tinyint default 0,
	bvideo tinyint default 0,
	bemail tinyint default 0,
	bphone tinyint default 0,
	bevent tinyint default 0,
	bexp tinyint default 0,
	bcategory tinyint default 0,
	filecnt tinyint default 0,
	hhtml text,
	fhtml text,
	regdt datetime,
	updt datetime,
	primary key(idx),
	unique key(code),
	key bdcd(code)
) ENGINE=INNODB

### 게시판 분류 ###
create table sw_board_cate
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//게시판 코드
	seq tinyint default 0,								//순위
	name varchar(100),									//분류명
	regdt datetime,										//등록일
	primary key(idx),
	key code(code),
	foreign key(code) references sw_board_cnf(code) on delete cascade
) ENGINE=INNODB

create table sw_board_cate
(
	idx int(11) unsigned not null auto_increment,
	code varchar(20) not null,
	seq tinyint default 0,
	name varchar(100),
	regdt datetime,
	primary key(idx),
	key code(code),
	foreign key(code) references sw_board_cnf(code) on delete cascade
) ENGINE=INNODB

### 게시판 data ###
create table sw_board
(
	idx bigint(20) unsigned not null auto_increment,	//index
	code varchar(20) not null,						//게시판코드
	hit int(3) default 0,							//조회수
	isadm tinyint default 0,						//관리자여부
	userid varchar(30),								//회원아이디
	pwd varchar(30),								//비밀번호
	name varchar(30),								//이름
	title varchar(200),								//제목
	sday varchar(20),								//시작일
	eday varchar(20),								//종료일
	email varchar(60),								//이메일
	phone varchar(20),								//연락처
	homepg varchar(100),							//홈페이지주소
	block enum('Y', 'N') default 'N',				//비밀글여부
	lockid varchar(30),								//비밀글작성아이디
	notice enum('Y', 'N') default 'N',				//공지여부
	ip varchar(20),									//아이피
	cate int(11) default 0,							//게시판분류
	ref bigint(11) not null,						//계층형번호
	re_step int(11) not null,						//계층형
	re_level int(11) not null,						//계층형
	content text,									//내용
	status tinyint default 0,						//상태
	regdt datetime,									//등록일
	updt datetime,									//수정일
	primary key(idx),
	key code(code),
	foreign key(code) references sw_board_cnf(code) on delete cascade
) ENGINE=INNODB

create table sw_board
(
	idx bigint(20) unsigned not null auto_increment,
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
	phone varchar(20),
	homepg varchar(100),
	block enum('Y', 'N') default 'N',
	lockid varchar(30),
	notice enum('Y', 'N') default 'N',
	ip varchar(20),
	cate int(11) default 0,
	ref bigint(20) not null,
	re_step int(11) not null,
	re_level int(11) not null,
	content text,
	status tinyint default 0,
	regdt datetime,
	updt datetime,
	primary key(idx),
	key code(code),
	foreign key(code) references sw_board_cnf(code) on delete cascade
) ENGINE=INNODB

### 게시판 첨부파일 ###
create table sw_board_file
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//게시판코드
	bdidx bigint(11) not null,							//게시물 idx
	upfile varchar(30) not null,						//첨부파일명(변경파일명)
	upreal varchar(100),								//원본파일명(변경전 파일명)
	ftype varchar(100),									//파일형식
	fsize int(3),										//파일사이즈
	dcnt int(3),										//다운로드회수(미사용)
	regdt datetime,										//등록일
	primary key(idx),
	key code(code),
	key bdidx(bdidx)
) ENGINE=INNODB

create table sw_board_file
(
	idx int(11) unsigned not null auto_increment,
	code varchar(20) not null,
	bdidx bigint(11) not null,
	upfile varchar(30) not null,
	upreal varchar(100),
	ftype varchar(100),
	fsize int(3),
	dcnt int(3),
	regdt datetime,
	primary key(idx),
	key code(code),
	key bdidx(bdidx)
) ENGINE=INNODB

### 게시판 댓글 ###
create table sw_board_cmt
(
	idx bigint(20) unsigned not null auto_increment,	//index
	code varchar(20) not null,							//게시판 코드
	bdidx bigint(20) not null,							//게시물 idx
	userid varchar(30),									//회원아이디
	pwd varchar(30),									//비밀번호
	name varchar(30) not null,							//작성자
	comment text,										//내용
	ip varchar(20),										//ip
	regdt datetime,										//등록일
	primary key(idx),
	key code(code),
	key bdidx(bdidx)
) ENGINE=INNODB

create table sw_board_cmt
(
	idx bigint(20) unsigned not null auto_increment,
	code varchar(20) not null,
	bdidx bigint(20) not null,
	userid varchar(30),
	pwd varchar(30),
	name varchar(30) not null,
	comment text,
	ip varchar(20),
	regdt datetime,
	primary key(idx),
	key code(code),
	key bdidx(bdidx)
) ENGINE=INNODB


### 관리자관리 테이블 --- sw_admin ###
create table sw_admin
(
	idx int(11) unsigned not null auto_increment,		//index
	buse enum('Y','N') not null default 'Y',			//사용여부(Y:사용, N:미사용)
	admlv int(3) not null,								//관리자그룹레벨
	admid varchar(30) not null,							//관리자아이디
	admpw varchar(100) not null,						//관리자비번
	name varchar(30) not null,							//관리자명
	phone varchar(20),									//전화번호
	mobile varchar(20),									//핸드폰번호
	email varchar(60),									//메일주소
	logdt datetime,										//최근로그인
	vcnt int(3) default 0,								//방문회수
	memo text,											//메모
	regdt datetime,										//등록일
	primary key(idx)
) ENGINE=INNODB

create table sw_admin
(
	idx int(11) unsigned not null auto_increment,
	buse enum('Y','N') not null default 'Y',
	admlv int(3) not null,
	admid varchar(30) not null,
	admpw varchar(100) not null,
	name varchar(30) not null,
	phone varchar(20),
	mobile varchar(20),
	email varchar(60),
	logdt datetime,
	vcnt int(3) default 0,
	memo text,
	regdt datetime,
	primary key(idx)
) ENGINE=INNODB

insert into sw_admin values (1,'Y',100,'admin','sha256:12000:YiUnmI/x+6udun60wT/rctdVccEsmL+i:YacXwGmOTdfb69L2NM/EvkFwQedCkPDV','','','','',now(),0,'',now());

### 상점 무통장 계좌관리 ###
create table sw_bank
(
	idx int(11) unsigned not null auto_increment,	//index
	buse enum('Y','N') default 'Y',					//사용여부
	banknm varchar(30) not null,					//은행명
	banknum varchar(30) not null,					//계좌번호
	bankown varchar(30) not null,					//예금주
	regdt datetime,									//등록일
	primary key(idx)
) ENGINE=INNODB

create table sw_bank
(
	idx int(11) unsigned not null auto_increment,
	buse enum('Y','N') default 'Y',
	banknm varchar(30) not null,
	banknum varchar(30) not null,
	bankown varchar(30) not null,
	regdt datetime,
	primary key(idx)
) ENGINE=INNODB

### 택배사 정보 ###
create table sw_delivery
(
	idx int(11) unsigned not null auto_increment,		//index
	code varchar(20) not null,							//고유코드
	name varchar(50),									//택배사명
	home varchar(50),									//홈페이지
	phone varchar(20),									//전화번호
	url varchar(200),									//택배사 URL
	regdt datetime,										//등록일
	primary key(idx),
	key iidx(code)
) ENGINE=INNODB

create table sw_delivery
(
	idx int(11) unsigned not null auto_increment,
	code varchar(20) not null,
	name varchar(50),
	home varchar(50),
	phone varchar(20),
	url varchar(200),
	regdt datetime,
	primary key(idx),
	key code(code)
) ENGINE=INNODB


### 카테고리 테이블 ###
create table sw_category
(
	idx int(11) unsigned not null auto_increment,		//index
	pcode char(9),										//부모카테고리
	code char(12) not null,								//카테고리코드
	name varchar(100) not null,							//카테고리명
	buse enum('Y','N') default 'Y',						//사용여부
	bgnb enum('Y','N') default 'Y',						//gnb 메뉴노출여부
	seq int(3) default 0,								//노출순위
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	key code(code)
) ENGINE=INNODB

create table sw_category
(
	idx int(11) unsigned not null auto_increment,
	pcode char(9),
	code char(12) not null,
	name varchar(100) not null,
	buse enum('Y','N') default 'Y',
	bgnb enum('Y','N') default 'Y',
	seq int(3) default 0,
	regdt datetime,
	updt datetime,
	primary key(idx),
	key code(code)
) ENGINE=INNODB

### 상품정보 테이블 ###
create table sw_goods
(
	idx int(11) unsigned not null auto_increment,			//index
	gcode varchar(20) not null,								//상품코드
	seq int(11) not null default 0,							//진열순위
	hit int(3) default 0,									//조회수
	category char(12) not null,								//상품분류
	brand varchar(20),										//브랜드코드
	display enum('Y','N') default 'Y',						//진열여부
	name varchar(100) not null,								//상품명
	icon varchar(10),										//아이콘
	origin varchar(30),										//원산지
	maker varchar(30),										//제조사
	skword varchar(100),									//검색키워드
	nprice int(7) not null default 0,						//정상가격
	dcrate tinyint not null default 0,						//할인률
	price int(7) not null default 0,						//할인판매가격
	blimit tinyint not null default 1,						//재고설정
	glimit int(7),											//재고
	mnea int(3) not null default 0,							//최소구매수량
	mxea int(3) not null default 0,							//최대구매수량
	pointmod tinyint default 0,								//적립금 지급유형
	point int(3) not null default 0,						//개별적립금
	boption enum('Y','N') default 'N',						//상품옵션 사용여부
	imgtype tinyint default 1,								//이미지 등록타입
	img1 varchar(100),										//원본이미지
	img2 varchar(100),										//상세이미지
	img3 varchar(100),										//리스트 이미지
	img4 varchar(100),										//여분
	imgetc varchar(100),									//추가이미지
	etc1 varchar(200),										//추가항목1
	etc2 varchar(200),										//추가항목2
	etc3 varchar(200),										//추가항목3
	simple text,											//간략설명
	content text,											//상세설명
	related varchar(100),									//관련상품
	regdt datetime,											//등록일
	updt datetime,											//수정일
	primary key(idx),
	unique key(gcode),
	key gcd(gcode),
	key category(category)
) ENGINE=INNODB

create table sw_goods
(
	idx int(11) unsigned not null auto_increment,
	gcode varchar(20) not null,
	seq int(11) not null default 0,
	hit int(3) default 0,
	category char(12) not null,
	brand varchar(20),
	display enum('Y','N') default 'Y',
	name varchar(100) not null,
	icon varchar(10),
	origin varchar(30),
	maker varchar(30),
	skword varchar(100),
	nprice int(7) not null default 0,
	dcrate tinyint not null default 0,
	price int(7) not null default 0,
	blimit tinyint not null default 1,
	glimit int(7),
	mnea int(3) not null default 0,
	mxea int(3) not null default 0,
	pointmod tinyint default 0,
	point int(3) not null default 0,
	boption enum('Y','N') default 'N',
	imgtype tinyint default 1,
	img1 varchar(100),
	img2 varchar(100),
	img3 varchar(100),
	img4 varchar(100),
	imgetc varchar(100),
	etc1 varchar(200),
	etc2 varchar(200),
	etc3 varchar(200),
	simple text,
	content text,
	related varchar(100),
	regdt datetime,
	updt datetime,
	primary key(idx),
	unique key(gcode),
	key gcd(gcode),
	key category(category)
) ENGINE=INNODB

### 상품옵션 ###
create table sw_option
(
	idx int(11) unsigned not null auto_increment,		//index
	gcode varchar(20) not null,							//상품코드
	optcd varchar(20) not null,							//옵션코드
	optnm varchar(100) not null,						//옵션명
	optval text,										//옵션 value
	optmark varchar(100),								//옵션 추가금액타입(+, -)
	optpay text,										//옵션가격
	optreq tinyint default 0,							//필수옵션여부
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	key gcode (gcode),
	foreign key(gcode) references sw_goods(gcode) on delete cascade
) ENGINE=INNODB

create table sw_option
(
	idx int(11) unsigned not null auto_increment,
	gcode varchar(20) not null,
	optcd varchar(20) not null,
	optnm varchar(100) not null,
	optval text,
	optmark varchar(100),
	optpay text,
	optreq tinyint default 0,
	regdt datetime,
	updt datetime,
	primary key(idx),
	key gcode (gcode),
	foreign key(gcode) references sw_goods(gcode) on delete cascade
) ENGINE=INNODB



### 회원테이블 --- sw_member ###
create table sw_member
(
	idx int(20) unsigned not null auto_increment,		//index
	userid varchar(30) not null,						//회원아이디
	userlv tinyint default 0,							//회원등급
	pass varchar(100) not null,							//비밀번호
	name varchar(30) not null,							//고객명
	birthday varchar(10),								//생년월일
	sex enum('M','W') default 'M',						//성별
	email varchar(100) not null,						//메일주소
	phone varchar(20),									//일반전화
	mobile varchar(20),									//핸드폰
	zip varchar(7),										//우편번호
	adr1 varchar(100),									//주소
	adr2 varchar(100),									//상세주소
	mailing enum('Y', 'N') default 'Y',					//메일링
	bsms enum('Y', 'N') default 'Y',					//sms
	emoney int(7) unsigned default 0,					//적립금
	di varchar(100),									//실명인증값(개인회원의 중복가입여부)
	ci varchar(100),									//실명인증값(주민번호가 1:1 매칭되는 고유한값)
	memo text,											//메모
	ip varchar(15),										//아이피
	logdt datetime,										//최근로그인
	vcnt int(3) default 0,								//로그인수
	status tinyint default 1,							//상태
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	key userid(userid),
	unique key(userid)
) ENGINE=INNODB

create table sw_member
(
	idx int(11) unsigned not null auto_increment,
	userid varchar(30) not null,
	userlv tinyint default 0,
	pass varchar(100) not null,
	name varchar(30) not null,
	birthday varchar(10),
	sex enum('M','W') default 'M',
	email varchar(100) not null,
	phone varchar(20),
	mobile varchar(20),
	zip varchar(7),
	adr1 varchar(100),
	adr2 varchar(100),
	mailing enum('Y', 'N') default 'Y',
	bsms enum('Y', 'N') default 'Y',
	emoney int(7) unsigned default 0,
	di varchar(100),
	ci varchar(100),
	memo text,
	ip varchar(15),
	logdt datetime,
	vcnt int(3) default 0,
	status tinyint default 1,
	regdt datetime,
	updt datetime,
	primary key(idx),
	key userid(userid),
	unique key(userid)
) ENGINE=INNODB

insert into sw_member set userid='kkang', pass='dddddddd', userlv=10, name='test', email='77kkang@naver.com', regdt=now(), updt=now()

### 탈퇴회원 사유 ###
create table sw_leave
(
	idx int(11) unsigned not null auto_increment,	//index
	userid varchar(30) not null,					//회원아이디
	cause tinyint default 0,						//탈퇴사유
	comment text,									//전할말
	regdt datetime,									//탈퇴일
	primary key(idx),
	key userid(userid)
) ENGINE=INNODB

create table sw_leave
(
	idx int(11) unsigned not null auto_increment,
	userid varchar(30) not null,
	cause tinyint default 0,
	comment text,
	regdt datetime,
	primary key(idx),
	key userid(userid)
) ENGINE=INNODB

### 메인 비주얼관리 ###
create table sw_visual
(
	idx int(11) unsigned not null auto_increment,	// index
	gbcd enum('P','M') default 'P',						//구분(P:pc, M:mobile)
	buse enum('Y','N') default 'Y',					// 노출여부
	seq int(11) default 0,							// 노출 순위
	title varchar(100) not null,					// 타이틀
	scontent text,									// 내용
	img varchar(30),								// 이미지
	target varchar(10) not null,					// 링크타겟
	url varchar(100),								// 링크 url
	regdt datetime,									// 등록일
	updt datetime,									// 수정일
	primary key(idx)
) ENGINE=INNODB

create table sw_visual
(
	idx int(11) unsigned not null auto_increment,
	gbcd enum('P','M') default 'P',
	buse enum('Y','N') default 'Y',
	seq int(11) default 0,
	title varchar(100) not null,
	scontent text,
	img varchar(30),
	target varchar(10) not null,
	url varchar(100),
	regdt datetime,
	updt datetime,
	primary key(idx)
) ENGINE=INNODB

### 메인 배너관리 ###
create table sw_banner
(
	idx int(11) unsigned not null auto_increment,		// index
	gbcd enum('P','M') default 'P',						//구분(P:pc, M:mobile)
	buse enum('Y','N') default 'Y',						// 노출여부
	seq int(11) default 0,								// 노출순위
	title varchar(100) not null,						// 타이틀
	scontent text,										// 배너내용
	img varchar(30),									// 배너 이미지
	target varchar(10) not null,						// 배너 타켓
	url varchar(100),									// 배너 링크 url
	regdt datetime,										// 등록일
	updt datetime,										// 수정일
	primary key(idx)
) ENGINE=INNODB

create table sw_banner
(
	idx int(11) unsigned not null auto_increment,
	gbcd enum('P','M') default 'P',
	buse enum('Y','N') default 'Y',
	seq int(11) default 0,
	title varchar(100) not null,
	scontent text,
	img varchar(30),
	target varchar(10) not null,
	url varchar(100),
	regdt datetime,
	updt datetime,
	primary key(idx)
) ENGINE=INNODB

### 팝업관리 --- sw_popup ###
create table sw_popup
(
	idx int(11) unsigned not null auto_increment,		//index
	gbcd enum('P','M') default 'P',						//구분(P:PC, M:MOBILE)
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
	updt datetime,										//팝업수정일
	primary key(idx)
) ENGINE=INNODB

create table sw_popup
(
	idx int(11) unsigned not null auto_increment,
	gbcd enum('P','M') default 'P',
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
	updt datetime,
	primary key(idx)
) ENGINE=INNODB

### 상품 리뷰 ###
create table sw_review
(
	idx int(11) unsigned not null auto_increment,		//index
	gidx int(11) not null,								//상품 idx
	userid varchar(30) not null,						//회원아이디
	point tinyint default 0,							//평점
	name varchar(30) not null,							//작성자
	title varchar(100) not null,						//제목
	img varchar(30),									//첨부이미지
	content text,										//내용
	ip varchar(20),										//아이피
	regdt datetime,										//등록일
	primary key(idx),
	key gidx(gidx)
) ENGINE=INNODB

create table sw_review
(
	idx int(11) unsigned not null auto_increment,
	gidx int(11) not null,
	userid varchar(30) not null,
	point tinyint default 0,
	name varchar(30) not null,
	title varchar(100) not null,
	img varchar(30),
	content text,
	ip varchar(20),
	regdt datetime,
	primary key(idx),
	key gidx(gidx)
) ENGINE=INNODB

### 주문 임시테이블 ###
create table sw_order_tmp
(
	idx int(11) unsigned not null auto_increment,		//index
	ordcode varchar(20) not null,						//주문코드
	isuser tinyint default 0,							//회원여부(1:회원, 0:게스트)
	userid varchar(30) not null,						//회원아이디(비회원은 임시 아이디)
	ogoods text not null,								//기본상품정보(장바구니 등록정보)
	goods text not null,								//개별상품정보(쿠폰번호 포함)
	name varchar(30) not null,							//주문자명
	email varchar(50) not null,							//주문자 이메일
	mobile varchar(20) not null,						//주문자 휴대폰
	phone varchar(20),									//주문자 일반전화
	rname varchar(20) not null,							//수취인명
	rzip varchar(7) not null,							//배송지 우편번호
	radr1 varchar(100) not null,						//배송지 주소
	radr2 varchar(100),									//배송지 주소
	rmobile varchar(20) not null,						//수취인 휴대폰번호
	rphone varchar(20),									//수취인 전화번호
	comment varchar(200),								//남기실 말씀
	payway char(10) not null,							//결제수단
	escw enum('Y','N') default 'N',						//실시간계좌이체, 가상계좌 에스크로여부
	uemoney int(3) default 0,							//사용적립금
	refund varchar(100),								//환불계좌정보
	step varchar(10),									//진행스텝
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	unique key(ordcode),
	unique key(userid),
	key ordcd(ordcd),
	key id(userid)
) ENGINE=INNODB

create table sw_order_tmp
(
	idx int(11) unsigned not null auto_increment,
	ordcode varchar(20) not null,
	isuser tinyint default 0,
	userid varchar(30) not null,
	ogoods text not null,
	goods text not null,
	name varchar(30) not null,
	email varchar(50) not null,
	mobile varchar(20) not null,
	phone varchar(20),
	rname varchar(20) not null,
	rzip varchar(7) not null,
	radr1 varchar(100) not null,
	radr2 varchar(100),
	rmobile varchar(20) not null,
	rphone varchar(20),
	comment varchar(200),
	payway char(10) not null,
	escw enum('Y','N') default 'N',
	uemoney int(3) default 0,
	refund varchar(100),
	step varchar(10),
	regdt datetime,
	updt datetime,
	primary key(idx),
	unique key(ordcode),
	unique key(userid),
	key ordcd(ordcode),
	key id(userid)
) ENGINE=INNODB

### 장바구니 ###
create table sw_basket
(
	idx int(11) unsigned not null auto_increment,		//index
	userid varchar(30) not null,						//회원아이디
	goods text,											//상품정보(직렬화)
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	unique key(userid),
	key userid(userid),
	foreign key(userid) references sw_member(userid) on delete cascade
) ENGINE=INNODB

create table sw_basket
(
	idx int(11) unsigned not null auto_increment,
	userid varchar(30) not null,
	goods text,
	regdt datetime,
	updt datetime,
	primary key(idx),
	unique key(userid),
	key id(userid),
	foreign key(userid) references sw_member(userid) on delete cascade
) ENGINE=INNODB


### 주문테이블 ###
create table sw_order
(
	idx int(11) unsigned not null auto_increment,			//index
	ordcode varchar(20) not null,							//주문코드
	userid varchar(30),										//회원아이디
	name varchar(30) not null,								//주문자명
	email varchar(50),										//이메일
	mobile varchar(20) not null,							//휴대폰
	phone varchar(20),										//일반전화
	rname varchar(30) not null,								//수취인명
	rmobile varchar(20) not null,							//수취인 휴대폰
	rphone varchar(20),										//수취힌 일반전화
	rzip varchar(10) not null,								//배송지 우편번호
	radr1 varchar(100) not null,							//배송지 주소1
	radr2 varchar(100) not null,							//배송지 주소2
	comment varchar(200),									//남기실말씀
	goods text,												//구매상품정보(직렬화)
	payway char(10),										//결제수단
	escw enum('Y','N') default 'N',							//실시간계좌이체, 가상계좌 에스크로여부
	sbank varchar(100),										//무통장정보
	buyer varchar(30),										//결제자
	buyday varchar(10),										//입금일자
	refund varchar(100),									//환불계좌정보
	tno varchar(30),										//kcp 결제승인번호
	card_cd varchar(10),									//kcp 카드 code
	card_name varchar(20),									//kcp 카드명
	card_no varchar(20),									//kcp 카드번호
	quota tinyint default 0,								//kcp 카드결제 할부개월수
	app_no varchar(10),										//kcp 승인번호
	app_time varchar(30),									//kcp 승인시간
	bank_code varchar(10),									//kcp 계좌이체 은행코드
	bank_name varchar(30),									//kcp 계좌이체 은행명
	bankname varchar(30),									//kcp 가상계좌 은행명
	depositor varchar(10),									//kcp 가상계좌 정보
	account varchar(30),									//kcp 가상계좌번호
	va_date varchar(20),									//kcp 입금마감일
	commid varchar(20),										//kcp 휴대폰결제 통신회사
	mobile_no varchar(20),									//kcp 휴대폰결제 휴대폰번호
	payment enum('Y','N') default 'N',						//결제여부(Y:결제완료, N:미결제)
	gamt int(7) default 0,									//상품가격
	optamt int(7) default 0,								//총옵션금액
	dcamt int(7) default 0,									//할인가격
	dyamt int(3) default 0,									//배송비
	dyfare int(3) default 0,								//추가배송비(도서산간)
	uemoney int(3) default 0,								//사용적립금
	ccamt int(7) default 0,									//취소금액
	amount int(7) default 0,								//총결제금액
	okamt int(7) default 0,									//입금액(가상계좌 및 상점무통장 결제시 사용)
	device enum('P','M') default 'P',						//디바이스 정보
	dycompany varchar(20),									//배송회사
	dynumber varchar(30),									//운송장번호
	status int(3) default 0,								//주문상태
	memo text,												//관리자메모
	regdt datetime,											//등록일
	updt datetime,											//수정일
	primary key(idx),
	unique key(ordcode),
	key ordcd(ordcode),
	key userid(userid)
) ENGINE=INNODB

create table sw_order
(
	idx int(11) unsigned not null auto_increment,
	ordcode varchar(20) not null,
	userid varchar(30),
	name varchar(30) not null,
	email varchar(50),
	mobile varchar(20) not null,
	phone varchar(20),
	rname varchar(30) not null,
	rmobile varchar(20) not null,
	rphone varchar(20),
	rzip varchar(10) not null,
	radr1 varchar(100) not null,
	radr2 varchar(100) not null,
	comment varchar(200),
	goods text,
	payway char(10),
	escw enum('Y','N') default 'N',
	sbank varchar(100),
	buyer varchar(30),
	buyday varchar(10),
	refund varchar(100),
	tno varchar(30),
	card_cd varchar(10),
	card_name varchar(20),
	card_no varchar(20),
	quota tinyint default 0,
	app_no varchar(10),
	app_time varchar(30),
	bank_code varchar(10),
	bank_name varchar(30),
	bankname varchar(30),
	depositor varchar(10),
	account varchar(30),
	va_date varchar(20),
	commid varchar(20),
	mobile_no varchar(20),
	payment enum('Y','N') default 'N',
	gamt int(7) default 0,
	optamt int(7) default 0,
	dcamt int(7) default 0,
	dyamt int(3) default 0,
	dyfare int(3) default 0,
	uemoney int(3) default 0,
	ccamt int(7) default 0,
	amount int(7) default 0,
	okamt int(7) default 0,
	device enum('P','M') default 'P',
	dycompany varchar(20),
	dynumber varchar(30),
	status int(3) default 0,
	memo text,
	regdt datetime,
	updt datetime,
	primary key(idx),
	unique key(ordcode),
	key ordcd(ordcode),
	key userid(userid)
) ENGINE=INNODB

### 주문상품테이블 ###
create table sw_order_item
(
	idx int(11) unsigned not null auto_increment,		//index
	ordcode varchar(20) not null,						//주문코드
	gidx int(11) not null,								//상품idx
	gname varchar(100) not null,						//상품명
	gopt varchar(200),									//상품옵션
	gea varchar(50),									//수량
	gprice int(7) default 0,							//상품가격
	goptamt int(7) default 0,							//추가옵션 금액
	gpoint int(7) default 0,							//적립금
	sumamt int(7) default 0,							//총합계
	status int(3) default 0,							//개별주문상태
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	key ordcode(ordcode),
	key gidx(gidx),
	foreign key(ordcode) references sw_order(ordcode) on delete cascade
) ENGINE=INNODB

create table sw_order_item
(
	idx int(11) unsigned not null auto_increment,
	ordcode varchar(20) not null,
	gidx int(11) not null,
	gname varchar(100) not null,
	gopt varchar(200),
	gea varchar(50),
	gprice int(7) default 0,
	goptamt int(7) default 0,
	gpoint int(7) default 0,
	sumamt int(7) default 0,
	status int(3) default 0,
	regdt datetime,
	updt datetime,
	primary key(idx),
	key ordcode(ordcode),
	key gidx(gidx),
	foreign key(ordcode) references sw_order(ordcode) on delete cascade
) ENGINE=INNODB

### 주문상태 로그 테이블 ###
create table sw_order_log
(
	idx int(11) unsigned not null auto_increment,		// index
	ordcode varchar(20) not null,						// 주문코드
	status int(3) not null,								// 주문상태
	isuser tinyint default 1,							// 1:유저, 2:관리자
	userid varchar(30),									// 변경 아이디
	updt datetime,										// 수정일
	primary key(idx),
	key ordcode(ordcode),
	foreign key(ordcode) references sw_order(ordcode) on delete cascade
) ENGINE=INNODB

create table sw_order_log
(
	idx int(11) unsigned not null auto_increment,
	ordcode varchar(20) not null,
	status int(3) not null,
	isuser tinyint default 1,
	userid varchar(30),
	updt datetime,
	primary key(idx),
	key ordcode(ordcode),
	foreign key(ordcode) references sw_order(ordcode) on delete cascade
) ENGINE=INNODB

### wish ###
create table sw_wish
(
	idx int(11) unsigned not null auto_increment,		//index
	userid varchar(30) not null,						//회원아이디
	goods text not null,								//상품정보
	regdt datetime,										//등록일
	updt datetime,										//수정일
	primary key(idx),
	unique key(userid),
	key id(userid),
	foreign key(userid) references sw_member(userid) on delete cascade
) ENGINE=INNODB

create table sw_wish
(
	idx int(11) unsigned not null auto_increment,
	userid varchar(30) not null,
	goods text not null,
	regdt datetime,
	updt datetime,
	primary key(idx),
	unique key(userid),
	key id(userid),
	foreign key(userid) references sw_member(userid) on delete cascade
) ENGINE=INNODB

### 적립금 내역 ###
create table sw_emoney
(
	idx int(11) unsigned not null auto_increment,		//index
	part tinyint not null default 0,					//지급 및 차감 유형
	userid varchar(30) not null,						//회원아이디
	cash int(7) not null,								//적립금(지급, 차감 금액)
	reason varchar(200),								//내역
	sumcash int(7) not null default 0,					//적립금 잔고
	regdt datetime,										//발생일
	primary key(idx),
	key iidx1(part),
	key iidx2(userid),
	foreign key(userid) references sw_member(userid) on delete cascade
) ENGINE=INNODB

create table sw_emoney
(
	idx int(11) unsigned not null auto_increment,
	part tinyint not null default 0,
	userid varchar(30) not null,
	cash int(7) not null,
	reason varchar(200),
	sumcash int(7) not null default 0,
	regdt datetime,
	primary key(idx),
	key part(part),
	key userid(userid),
	foreign key(userid) references sw_member(userid) on delete cascade
) ENGINE=INNODB

### 상품문의 ###
create table sw_goods_qna
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
	key gidx(gidx),
	key userid(userid)
) ENGINE=INNODB

create table sw_goods_qna
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
	key gidx(gidx),
	key userid(userid)
) ENGINE=INNODB

### 문자발송 내역 ###
create table sw_sms_log
(
	idx int(11) unsigned not null auto_increment,	//index
	part tinyint default 0,								//발송유형
	s_id varchar(30),									//발송아이디
	r_id varchar(30),									//수신아이디
	s_mobile varchar(20) not null,						//발송번호
	r_mobile varchar(20) not null,						//수신번호
	message text,										//메세지
	rescd varchar(10),									//결과코드
	resmsg varchar(30),									//결과메세지
	msg_id varchar(10),									//메세지 아이디
	msg_type varchar(10),								//SMS(단문) , LMS(장문), MMS(그림문자)
	regdt datetime,										//발송일
	primary key(idx),
	key part(part)
) ENGINE=INNODB

create table sw_sms_log
(
	idx int(11) unsigned not null auto_increment,
	part tinyint default 0,
	s_id varchar(30),
	r_id varchar(30),
	s_mobile varchar(20) not null,
	r_mobile varchar(20) not null,
	message text,
	rescd varchar(10),
	resmsg varchar(30),
	msg_id varchar(10),
	msg_type varchar(10),
	regdt datetime,
	primary key(idx),
	key part(part)
) ENGINE=INNODB


### 도서산간 추가운임비 ###
create table sw_delivery_fare
(
	idx int(11) unsigned not null auto_increment,		// index
	zipcode varchar(5) not null,						// 우편번호
	address varchar(100) not null,						// 주소
	fare int(3) default 0,								// 추가금액
	regdt datetime,										// 등록일
	updt datetime,										// 수정일
	primary key(idx),
	key zipcode(zipcode)
) ENGINE=INNODB

create table sw_delivery_fare
(
	idx int(11) unsigned not null auto_increment,
	zipcode varchar(5) not null,
	address varchar(100) not null,
	fare int(3) default 0,
	regdt datetime,
	updt datetime,
	primary key(idx),
	key zipcode(zipcode)
) ENGINE=INNODB

//언어셋
create table sw_language
(
	idx int(11) unsigned not null auto_increment,
	lang_esp enum('Y','N') default 'N',
	lang_chn enum('Y','N') default 'N',
	lang_kor enum('Y','N') default 'N',
	primary key(idx)
) ENGINE=INNODB

//메뉴 정렬 옵션
create table sw_memu_orderby
(
	idx int(11) unsigned not null auto_increment,
	featured enum('Y','N') default 'N',
	newmenu enum('Y','N') default 'N',
	pricelow enum('Y','N') default 'N',
	pricehigh enum('Y','N') default 'N',
	primary key(idx)
) ENGINE=INNODB


//직원호출
create table sw_employee_call
(
	idx int(11) unsigned not null auto_increment,
	kor_name varchar(30) not null,
	eng_name  varchar(100),
	chn_name  varchar(100),
	esp_name  varchar(100),
	regdt datetime,
	updt datetime,
	primary key(idx)
) ENGINE=INNODB

//직원호출 history
create table sw_call_history
(
	idx int(11) unsigned not null auto_increment,
	name varchar(30) not null,
	gea  int(11) default 0,
	regdt datetime,
	updt datetime,
	primary key(idx)
) ENGINE=INNODB


//이벤트 관리
create table sw_event
(
	idx int(11) unsigned not null auto_increment,
	coupon_title1 varchar(100) not null,
	coupon_content1 text,
	coupon_goods1 int(11) default 0,
	coupon_title2 varchar(100) not null,
	coupon_content2 text,
	coupon_goods2 int(11) default 0,
	coupon_title3 varchar(100) not null,
	coupon_content3 text,
	coupon_goods3 int(11) default 0,
	disabled enum('Y','N') default 'N',
	content text,
	regdt datetime,
	updt datetime,
	primary key(idx)
) ENGINE=INNODB


//테이블 비밀번호 설정
create table sw_table_setting
(
	idx int(11) unsigned not null auto_increment,
	pass varchar(100) not null,						//비밀번호
	regdt datetime,
	updt datetime,
	primary key(idx)
) ENGINE=INNODB

//사용자 테이블 번호 저장
create table sw_user_table
(
	idx int(11) unsigned not null auto_increment,
	device_token varchar(255) not null,
	tableNo  varchar(30)
	regdt datetime,
	updt datetime,
	primary key(idx)
) ENGINE=INNODB

//장바구니
create table sw_cart
(
	idx int(11) unsigned not null auto_increment,
	tableNo varchar(30) not null comment '테이블 번호',
	gea  int(11) default 0 comment '개수',
	opt  text comment '옵션',
	price int(11) default 0 '가격',
	regdt datetime,
	updt datetime,
	primary key(idx)
)

//테마
create table sw_thema
(
	idx int(11) unsigned not null auto_increment,
	theme_color enum('W','B') default 'W',
	bgimg varchar(100),
	regdt datetime,
	updt datetime,
	primary key(idx)
)

create table sw_setting
(
	idx int(11) unsigned not null auto_increment,
	storeNm varchar(100),
	regdt datetime,
	updt datetime,
	primary key(idx)
)

//주문하기

create table sw_order_new
(
	idx int(11) unsigned not null auto_increment,
	ordcode varchar(20) not null,
	tableNo varchar(30),
	gamt int(7) default 0,
	optamt int(7) default 0,
	amount int(7) default 0,
	ispos tinyint(3) default 0,
	isprint tinyint(3) default 0,
	iscompleted tinyint(3) default 0,
	memo text,
	regdt datetime,
	updt datetime,
	primary key(idx)
)


### 추천 상품  ###
create table sw_related
(
	idx int(11) unsigned not null auto_increment,		//index
	pidx int(11) default 0,							//부모 idx
	gidx int(11) default 0,								//순위
	regdt datetime,										//등록일
	primary key(idx),
	foreign key(idx) references sw_goods(idx) on delete cascade
) ENGINE=INNODB

create table sw_related
(
	idx int(11) unsigned not null auto_increment,
	gidx int(11) default 0,
	regdt datetime,
	primary key(idx),
	foreign key(idx) references sw_goods(idx) on delete cascade
) ENGINE=INNODB
?>
