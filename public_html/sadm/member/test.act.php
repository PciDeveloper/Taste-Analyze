<?php
require_once(dirname(__FILE__)."/../_inc/_header.php");
require_once(dirname(__FILE__)."/../../_sys/_libs/libs.pbkdf2.php");

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit;

if($encData)
{
	$encArr = _get_decode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

switch($mode)
{
	case "member" :
		switch($act){
			case "edit" :

			$row = $db->_fetch("select * from seak_user where idx = '".$idx."'");

				if(!empty($_FILES['img1']['name']))
				{
					$imgName1 = _file_upload($_FILES['img1'], $row['cmpynumimg'], $_SERVER[DOCUMENT_ROOT]."/upload/member");
					$imgName2 =  $imgName1;
					/// old thumbnail image delete ///
					_file_delete($row['img1'], $_SERVER[DOCUMENT_ROOT]."/upload/member");

					/// thumbnail image create ///
					_create_image($imgName1, $imgName2, $_SERVER[DOCUMENT_ROOT].'/upload/member', 500, 500, $_SERVER[DOCUMENT_ROOT].'/upload/member', 'ratio', true);
				}
				else
				{
					$imgName1 = $row['cmpynumimg'];
				}

				// 		// 비밀번호 변경시 //
				// 		if(!strcmp($chgpass, "Y"))
				// 			$update_password = sprintf("pass='%s', ", create_hash($_POST['userpw']));
				if($_POST['newpw'] != ""){	//새로운 비밀번호가 있으면

							if($_POST['newpw'] == $_POST['newpwck']){
								$usqry = "update ".SEAK_USER." set
												 cmpynumimg  			= '".$imgName1."',
												 userpw  					= '".create_hash($_POST['newpw'])."',
												 cmpyaddr  				= '".$cmpyaddr."',
												 cmpydetailaddr		= '".$cmpydetailaddr."',
												 cmpytel	  			= '".$cmpytel."',
												 cmpyfax	  			= '".$cmpyfax."',
												 managertel	  		= '".$managertel."',
												 managername	  	= '".$managername."',
												 updt 						= now()
												 where idx = '".$idx."'";
							}else{
									msg("변경하려는 비밀번호가 일치하지 않습니다.", "", true);
							}

				}else{
					//비밀번호 변경이 아니라면
					$usqry = "update ".SEAK_USER." set
									 cmpynumimg  			= '".$imgName1."',
									 cmpyaddr  				= '".$cmpyaddr."',
									 cmpydetailaddr		= '".$cmpydetailaddr."',
									 cmpytel	  			= '".$cmpytel."',
									 cmpyfax	  			= '".$cmpyfax."',
									 managertel	  		= '".$managertel."',
									 managername	  	= '".$managername."',
									 updt 						= now()
									 where idx = '".$idx."'";
				}

					 if($db->_execute($usqry))
						 gourl("/mypage/index.php", "P", "회원정보가 수정되었습니다.");
					 else
						 msg("회원정보 수정도중 오류가 발생하였습니다.\n잠시후 다시 수정부탁드립니다.", "", true);
			break;
		}
	break;
	case "leave" :
		_chk_required($_POST, array('encData'));
		$mb = $db->_fetch("select * from seak_user where idx = '".$idx."'");
		if($mb)
		{
			$usqry = sprintf("update %s set status=4 where idx='%d'", SEAK_USER, $idx);
			if($db->_execute($usqry))
			{
				$isqry = sprintf("insert into %s set userid='%s', cause='10', comment='관리자 강제탈퇴', regdt=now()", SW_LEAVE, $mb['userid']);
				if($db->_execute($isqry))
					gourl("/?encData=".$encData, "P", "해당회원이 탈퇴처리 되었습니다.");
			}
			else
				_show_error($usqry);
		}
	break;
	case "wish" :
		require_once(dirname(__FILE__)."/../../_sys/_libs/class.BasketHandler.php");
		setcookie("is_direct", "", time()-3600, "/");
		$is_direct = ($_POST['act'] == "direct") ? 1 : 0;
		$cart = new BasketHandler($is_direct);

		switch($act)
		{
			case "basket" :
				$cart->_mv_wish_basket($_POST['letter_no']);
			break;
			case "direct" :
				if($cart->_get_wish_stock_item($_POST['letter_no']) === true)
				{
					if($cart->_set_wish_direct($_POST['letter_no']))
						gourl("/order/", "P");
					else
						msg("해당상품을 바로구매 도중오류가 발생하였습니다.\\n잠시후 다시 시도해 주세요.", "", true);
				}
				else
					msg("재고가 부족한 상품이므로 구매가 불가능합니다.", "", true);
			break;
			case "delete" :
				if($cart->_del_wish_item($_POST['letter_no']))
				{
					gourl("/mypage/wish.php", "P", "해당 관심상품이 목록에서 삭제되었습니다.");
					exit;
				}
			break;
			case "sbasket" :
				if($cart->_mv_wish_basket_arr($_POST['chk']))
					gourl("/goods/basket.php", "P");
				else
					msg("재고가 부족한 상품이므로 장바구니에 담을수가 없습니다.", "", true);
			break;
			case "sdelete" :
				if($cart->_del_wish_item_arr($_POST['chk']))
				{
					gourl("/mypage/wish.php", "P", "선택하신 관심상품이 목록에서 삭제되었습니다.");
					exit;
				}
			break;
		}
	break;
	case "order" :
		require_once(dirname(__FILE__)."/../../_sys/_libs/class.SaleHandler.php");
		$sale = new SaleHandler();
		$sale->_get_order_vars($encData);

		switch($act)
		{
			case "cancel" :			// 주문취소 신청
				_chk_required($_POST, array("encData"), false);
				if($sale->_set_status_item($_POST))
					gourl($_SERVER['HTTP_REFERER']."?encData=".$encData, "P", "해당 주문건이 주문취소요청 되었습니다.");
				else
					msg("선택하신 주문상품을 주문취소요청처리 도중 오류가 발생하였습니다.\\n잠시후 다시 시도해 주세요.", "", true);
			break;
			case "exchange" :		// 교환신청
			break;
			case "refund" :			// 환불(반품) 신청
				_chk_required($_POST, array("encData"), false);
				if($sale->_set_status_item($_POST))
					gourl($_SERVER['HTTP_REFERER']."?encData=".$encData, "P", "해당 주문건이 환불(반품)요청 되었습니다.");
				else
					msg("선택하신 주문상품을 환불(반품)처리 도중 오류가 발생하였습니다.\\n잠시후 다시 시도해 주세요.", "", true);
			break;
			case "receive" :		// 상품수령
				_chk_required($_POST, array("encData"), false);
				if($sale->_set_status_item($_POST))
					gourl($_SERVER['HTTP_REFERER']."?encData=".$encData, "P", "해당 주문건을 상품수령해주셔서 대단히 감사합니다.");
				else
					msg("주문건의 상품수령 도중 오류가 발생하였습니다.\\n잠시후 다시 시도해 주세요.", "", true);
			break;
			case "ordok" :			// 구매완료(확정)
				_chk_required($_POST, array("encData"), false);
				if($sale->_set_status_item($_POST))
					gourl($_SERVER['HTTP_REFERER']."?encData=".$encData, "P", "해당 주문건을 구매완료해주셔서 대단히 감사합니다.");
				else
					msg("주문건의 구매완료 도중 오류가 발생하였습니다.\\n잠시후 다시 시도해 주세요.", "", true);
			break;
		}
	break;
}
?>
