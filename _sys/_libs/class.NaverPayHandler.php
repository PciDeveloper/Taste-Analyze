<?php
/**
* Naver Pay Handler Class PHP7
*
* @Author		: seob
* @Update		:	2019-08-20
* @Description	:	Naver Pay Class
*/

class NaverPayHandler
{
	var $navarpay = array();

	public function __construct()
	{
		if(!$this->naverpay)
		{
			if(file_exists(dirname(__FILE__)."/../_cfg/cfg.naverpay.php"))
				require_once(dirname(__FILE__)."/../_cfg/cfg.naverpay.php");

			$this->naverpay = $naverpay;
		}
	}

	/**
	* naver pay button set
	*
	* $cnt : 버튼 개수 설정(구매하기 버튼만 있으면(장바구니 페이지) => 1, 장바구니/찜하기 버튼도 있으면(상품상세페이지) => 3)
	* $enable : 품절 등의 이유로 버튼 모음을 비활성화시 'N' 입력
	*/
	public function _get_naverpay_btn($cnt, $enable='Y')
	{
		if(_is_agent_mobile())
		{
			$btn_type = $this->naverpay['button_type_m'];
			if(!strcmp($this->naverpay['nhntest'], "Y"))
				$btn = "<script type=\"text/javascript\" src=\"https://test-pay.naver.com/customer/js/mobile/naverPayButton.js\" charset=\"UTF-8\"></script>";
			else
				$btn = "<script type=\"text/javascript\" src=\"https://pay.naver.com/customer/js/mobile/naverPayButton.js\" charset=\"UTF-8\"></script>";
		}
		else
		{
			$btn_type = $this->naverpay['button_type'];
			if(!strcmp($this->naverpay['nhntest'], "Y"))
				$btn = "<script type=\"text/javascript\" src=\"https://test-pay.naver.com/customer/js/naverPayButton.js\" charset=\"UTF-8\"></script>";
			else
				$btn = "<script type=\"text/javascript\" src=\"https://pay.naver.com/customer/js/naverPayButton.js\" charset=\"UTF-8\"></script>";
		}

		if($cnt == 2)
		{
			if(!strcmp($enable, "Y"))
			{
				if(_is_agent_mobile())
				{
					$wish_script =<<< WISH_SCRIPT
						function nhnWish()
						{
							var f = document.fm;
							f.action = "/naver/naverpay.wish.php";
							f.target = "ifrm";
							f.submit();
							return false;
						}
WISH_SCRIPT;
				}
				else
				{
					$wish_script =<<< WISH_SCRIPT
						function nhnWish()
						{
							var f = document.fm;
							var nvWishWin = window.open("", "nvpay", "scrollbars=yes,width=400,height=267");
							f.action = "/naver/naverpay.wish.php";
							f.target = "nvpay";
							f.submit();
							return false;
						}
WISH_SCRIPT;
				}

				$btn .=<<< SCRIPT
					<script type="text/javascript">
					//<![CDATA[
					function nhnBuy()
					{
						var f = document.fm;
						if($(":hidden[name='item[]']").size() < 1)
						{
							alert("구매하실 제품(옵션)을 선택해 주세요.");
							$("select[name='gopt[]']").eq(0).focus();
							return;
						}
						else
						{
							f.action = "/naver/naverpay.buy.php";
							f.target = "ifrm";
							f.submit();
						}
					}

					{$wish_script}
					//]]>
					</script>
SCRIPT;
			}
			else
			{
				$btn .=<<< SCRIPT
					<script type="text/javascript">
					//<![CDATA[
					function nhnBuy()
					{
						alert("죄송합니다. 네이버페이로 구매가 불가한 상품입니다.");
						return false;
					}

					function nhnWish()
					{
						alert("죄송합니다. 네이버페이로 구매가 불가한 상품입니다.");
						return false;
					}
					//]]>
					</script>
SCRIPT;
			}
			$wish = "WISHLIST_BUTTON_HANDLER:nhnWish,\n";
			if(_is_agent_mobile())
				$wish .= 'WISHLIST_BUTTON_LINK_URL:"'.$cfg['shopurl'].'/m/naver/naverpay.wish.php", ';
			else
				$wish .= 'WISHLIST_BUTTON_LINK_URL:"'.$cfg['shopurl'].'/naver/naverpay.wish.php", ';
		}
		else
		{
			$btn .=<<< SCRIPT
				<script type="text/javascript">
				//<![CDATA[
				function nhnBuy()
				{
					var f = document.fm;
					if($(":checkbox[name='chk[]']:checked").size() < 1)
					{
						alert("구매하실 제품을 선택해 주세요.");
						$(":checkbox[name='chk[]']").eq(0).focus();
						return;
					}
					else
					{
						f.action = "/naver/naverpay.buy.php?mode=basket";
						f.target = "ifrm";
						f.submit();
					}

					// 선택이 아닌 장바구니 전체를 구매시 -- kkang(2020-10-27) //
					//document.ifrm.location.href = "/naver/naverpay.buy.php?mode=basket";
					//document.location.href = "/naver/naverpay.buy.php?mode=basket";
				}
				//]]>
				</script>
SCRIPT;
		}

		$btn .=<<< TAGS
			<script type="text/javascript">
			//<![CDATA[
			naver.NaverPayButton.apply({
			BUTTON_KEY:"{$this->naverpay['button_key']}",		// 체크아웃에서 할당받은 버튼 KEY 를 입력하세요.
			TYPE: "{$btn_type}",								// 템플릿을 확인하시고 원하는 타입의 버튼을 선택
			COLOR: {$this->naverpay['button_color']},			// 버튼의 색 설정
			COUNT: {$cnt},										// 버튼 개수 설정. 구매하기 버튼(장바구니 페이지)만 있으면 1, 장바구니/찜하기 버튼(상품 상세 페이지)과 함께 있으면 2을 입력한다.
			ENABLE: "{$enable}",								// 품절등과 같은 이유에 따라 버튼을 비활성화할 필요가 있을 경우
			BUY_BUTTON_HANDLER: nhnBuy,							// 구매하기 버튼 이벤트 Handler 함수 등록, 품절인 경우 not_buy_nc 함수 사용
			BUY_BUTTON_LINK_URL:"/naver/naverpay.buy.php",		// 링크 주소 (필요한 경우만 사용)
			{$wish}
			"":"" });
			//]]>
			</script>
TAGS;
		return $btn;
	}
}
?>
