<?php
DEFINE ( "zPwFull" , "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" );
DEFINE ( "zSeed" , "MySeed" );
DEFINE ( "zPwEa" , "6" );

$imgHeight = 30 ;						// 이미지 높이
$fontSize = 18 ;						// 글꼴 크기 (포인트 pt 단위)
$offsetX = 30 ;						// 이미지 내 글꼴 위치 (X좌표)
$offsetY = 25 ;						// 이미지 내 글꼴위치 (Y좌표)
$imgBgColor = "373737" ;			// 이미지 바탕 색깔 (16진수)
$imgLineColor = "C0C2C0" ;		// 이미지 테두리 색깔 (16진수)
$imgFontColor = "A6AEBA" ;		// 이미지 글꼴 색깔 (16진수)
$imgNetColor = "666866" ;			// 모눈 색깔 (16진수)
$zNetOn = 1 ;							// 모눈 표시 여부 ( 1 : 표시함 / 0 : 표시안함 )
$zNetTerm = 15 ;						// 모눈 간격 (픽셀단위)

#
# 사용자 설정 부분 끝 (이 아래는 더 이상 건드릴 필요가 없습니다.)
#



DEFINE ( "zSeedLen" , strlen ( zSeed ) ) ;


//
// 암호 만들기 함수
//

function ZmMakePw ()
{
	$zPwFullArr = preg_split( '//' , zPwFull , -1 , PREG_SPLIT_NO_EMPTY ) ;
	shuffle ( $zPwFullArr ) ;
	$zPwFull = implode ( '' , $zPwFullArr ) ;
	$zPw = substr ( $zPwFull , 0 , zPwEa ) ;
	return $zPw ;
}

//
// 암호화 함수
//

function ZmEncrypt ( $zPw )
{
	$zPwArr = preg_split( '//' , $zPw , -1 , PREG_SPLIT_NO_EMPTY ) ;
	$i = 0 ;
	foreach ( $zPwArr as $key => $value )
	{
		if ( $i == zSeedLen ) { $i = 0 ; }
		$zEncrypt .= dechex ( ord ( $value ) + ord ( substr ( zSeed , $i , 1 ) ) ) ;
		$i ++ ;
	}
	return ( $zEncrypt ) ;
}


//
// 복호화 함수
//

function ZmDecrypt ( $zEncrypt )
{
	$zEncryptLen = strlen ( $zEncrypt ) ;
	$i = 0 ; $j = 0 ;
	while ( $i < $zEncryptLen )
	{
		if ( $j == zSeedLen ) { $j = 0 ; }
		$zDecrypt .= chr ( hexdec ( substr ( $zEncrypt , $i , 2 ) ) - ord ( substr ( zSeed , $j , 1 ) ) ) ;
		$i += 2 ; $j ++ ;
	}
	return ( $zDecrypt ) ;
}


?>
