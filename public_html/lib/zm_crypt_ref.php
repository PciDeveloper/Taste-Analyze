<?php
DEFINE ( "zPwFull" , "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" );
DEFINE ( "zSeed" , "MySeed" );
DEFINE ( "zPwEa" , "6" );

$imgHeight = 30 ;						// �̹��� ����
$fontSize = 18 ;						// �۲� ũ�� (����Ʈ pt ����)
$offsetX = 30 ;						// �̹��� �� �۲� ��ġ (X��ǥ)
$offsetY = 25 ;						// �̹��� �� �۲���ġ (Y��ǥ)
$imgBgColor = "373737" ;			// �̹��� ���� ���� (16����)
$imgLineColor = "C0C2C0" ;		// �̹��� �׵θ� ���� (16����)
$imgFontColor = "A6AEBA" ;		// �̹��� �۲� ���� (16����)
$imgNetColor = "666866" ;			// �� ���� (16����)
$zNetOn = 1 ;							// �� ǥ�� ���� ( 1 : ǥ���� / 0 : ǥ�þ��� )
$zNetTerm = 15 ;						// �� ���� (�ȼ�����)

#
# ����� ���� �κ� �� (�� �Ʒ��� �� �̻� �ǵ帱 �ʿ䰡 �����ϴ�.)
#



DEFINE ( "zSeedLen" , strlen ( zSeed ) ) ;


//
// ��ȣ ����� �Լ�
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
// ��ȣȭ �Լ�
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
// ��ȣȭ �Լ�
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
