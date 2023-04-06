<?php

include(dirname(__FILE__)."/./zm_crypt_ref.php");

$zPw = ZmDecrypt ( $zCode ) ;
$zPwLen = strlen ( $zPw ) ;

$zPwArr = preg_split( '//' , $zPw , -2 , PREG_SPLIT_NO_EMPTY ) ; // 문자마다 한 칸씩 떼어낸다
$zPwImg = implode ( " " , $zPwArr ) ;

$imgWidth = ($zPwLen * $fontSize ) + ( $zPwLen - 1 ) * 8 + 20 ;

// 이미지 제작
Header ( "Content-type : image/png" ) ;
$im = ImageCreateTrueColor ( $imgWidth , $imgHeight ) ;

// 색상 설정
$imBgColor = ImageColorAllocate ( $im , hexdec ( substr ( $imgBgColor , 0 , 2 ) ) , hexdec ( substr ( $imgBgColor , 2 , 2 ) ) , hexdec ( substr ( $imgBgColor , 4 , 2 ) ) ) ;
$imLineColor = ImageColorAllocate ( $im , hexdec ( substr ( $imgLineColor , 0 , 2 ) ) , hexdec ( substr ( $imgLineColor , 2 , 2 ) ) , hexdec ( substr ( $imgLineColor , 4 , 2 ) ) ) ;
$imFontColor = ImageColorAllocate ( $im , hexdec ( substr ( $imgFontColor , 0 , 2 ) ) , hexdec ( substr ( $imgFontColor , 2 , 2 ) ) , hexdec ( substr ( $imgFontColor , 4 , 2 ) ) ) ;
$imNetColor = ImageColorAllocate ( $im , hexdec ( substr ( $imgNetColor , 0 , 2 ) ) , hexdec ( substr ( $imgNetColor , 2 , 2 ) ) , hexdec ( substr ( $imgNetColor , 4 , 2 ) ) ) ;

// 바탕색 칠함
ImageFilledRectangle($im, 0, 0, $imgWidth , $imgHeight, $imLineColor );

// 테두리 그림
ImageFilledRectangle($im, 1, 1, ( $imgWidth - 2 ) , $imgHeight - 2 , $imBgColor );


//ImageTtfText ( $im , $fontSize , 0 , $offsetX , $offsetY , $imFontColor , "Tahoma.ttf" , $zPwImg ) ;
//ImageTtfText ( $im , $fontSize , 0 , ( $offsetX + 1 ), $offsetY , $imFontColor , "Tahoma.ttf" , $zPwImg ) ;

ImageTtfText ( $im , $fontSize , 0 , $offsetX , $offsetY , $imFontColor , $_SERVER["DOCUMENT_ROOT"].'/lib/font/adler.ttf' , $zPwImg );
ImageTtfText ( $im , $fontSize , 0 , ( $offsetX + 1 ), $offsetY , $imFontColor , $_SERVER["DOCUMENT_ROOT"].'/lib/font/adler.ttf' , $zPwImg );


if ( $zNetOn > 0 ) {
$i = $zNetTerm / 2 + 1 ;
while ( $i < $imgHeight ) {
	ImageLine ( $im , 1 , $i , ( $imgWidth - 2 ) , $i , $imNetColor ) ;
	$i += $zNetTerm ;
}
$i = 6 ;
while ( $i < $imgWidth ) {
	ImageLine ( $im , $i , 1 , $i , ( $imgHeight - 2 ) , $imNetColor ) ;
	$i += $zNetTerm ;
}
}

ImagePng ( $im ) ;
ImageDestroy ( $im ) ;


?>