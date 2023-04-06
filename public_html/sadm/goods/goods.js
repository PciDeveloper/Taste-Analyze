(function(){
	this.Goods || (this.Goods = {});

	Goods = {
		/**
		* 상품카테고리 Javascript Handler
		*/
		categoryHandler :
		{
			addCate : function() {
				var category;
				var arr_cate = new Array();
				var obj = document.forms[0]['cate[]'];

				for(var i=0; i < obj.length; i++)
				{
					if(obj[i].value)
					{
						arr_cate.push(obj[i][obj[i].selectedIndex].text);
						category = obj[i].value;
					}
				}

				if(!category)
				{
					alert("상품분류를 선택해주세요.");
					return;
				}
				else
				{
					$("#strCate").html(arr_cate.join(" > "));
					$("#orgCate").html("<input type=\"hidden\" name=\"category\" value=\"" + category + "\" exp=\"상품분류를 선택해 주세요.\" />");
				}
			}
		},

		/**
		* 상품코드 수동입력시 유효성 검사
		*/
		checkGoodsHandler :
		{
			checkGcode : function()
			{
				$(":radio[name='gcodeWay']").eq(1).attr("checked", true);
				if(!$("input[name='gcode2']").val())
				{
					alert("생성할 상품코드를 입력해 주세요.");
					$("input[name='gcode2']").focus();
				}
				else
				{
					$(":hidden[name='chk_gcode']").val("");
					$.post("./ajax.common.php", {mode : "gcodechk", gcode : $("input[name='gcode2']").val()}, function(data){
						if(data == 001)
						{
							$(":hidden[name='chk_gcode']").val("");
							$("#gcode_message").css("color", "#FF0000");
							$("#gcode_message").html("※ 공백없이 8~20자의 대소문자,숫자만 사용가능합니다.");
							$(":input[name='gcode2']").focus();
						}
						else if(data == 002)
						{
							$(":hidden[name='chk_gcode']").val("");
							$("#gcode_message").css("color", "#FF0000");
							$("#gcode_message").html("※ 중복되는 상품코드 입니다.");
						}
						else if(data == 000)
						{
							$(":hidden[name='chk_gcode']").val($(":input[name='gcode2']").val()),
							$("#gcode_message").css("color", "#3366FF");
							$("#gcode_message").html("※ 사용가능한 상품코드입니다.");
						}
					});
				}
			}
		},

		/**
		* 카테고리 옵션 Javascript Handler
		*/
		cateOptHandler :
		{
			setCateOption : function(category, encData) {
				$.ajax({
					type: "POST",
					dataType: "html",
					async:false,
					url: "./ajax.option.php",
					data: {
						"category" : category,
						"encData" : encData
					},
					beforeSend:function(xhr){},
					success:function(data){
						$("#_copt_").html(data);
					},
					error:function(){
						alert("REVIEW FORM ERROR!!");
					}
				});
			}
		},

		/**
		* 상품사이즈 Javascript Handler
		*/
		sizeHandler :
		{
			add : function() {
				var rowIndex = $("#_tbsize_ tr").size();
				if(rowIndex >= 10)
				{
					alert("10개까지만 등록가능합니다.");
					return false;
				}

				var tr = "";
				tr += "<tr>";
				tr += "	<td height=\"30\">";
				tr += "		<input type=\"text\" name=\"size[]\" class=\"lbox w300\" /> <a href=\"javascript:void(0);\" onclick=\"javascript:Goods.sizeHandler.del(this);\"><img src=\"../img/btn/s_btn_del.gif\" align=\"absmiddle\" /></a>";
				tr += "	</td>";
				tr += "</tr>";

				$("#_tbsize_").append(tr);
			},
			del : function(obj) {

				while(1)
				{
					if(obj.parentNode.nodeName.toLowerCase() == "tr")
					{
						$(obj.parentNode).remove();
						break;
					}
					else
						obj = obj.parentNode;
				}
			}
		},

		/**
		* 상품COLOR Javascript Handler
		*/
		colorHandler :
		{
			add : function() {
				var tb = $("#_tbcolor_ tr");
				if(tb.size() >= 10)
				{
					alert("10개까지만 등록가능합니다.");
					return false;
				}

				var tr = "";
				tr += "<tr>";
				tr += "	<td height=\"30\">";
				tr += "		<input type=\"text\" name=\"color[]\" class=\"lbox w100\" /> ";
				tr += "		<input type=\"file\" name=\"cimg[]\" class=\"lbox w200\" /> ";
				tr += "		<img src=\"../img/btn/s_btn_del.gif\" align=\"absmiddle\" onclick=\"javascript:Goods.colorHandler.del(this);\" />";
				tr += "	</td>";
				tr += "</tr>";

				$("#_tbcolor_").append(tr);
			},
			del : function(obj) {

				while(1)
				{
					if(obj.parentNode.nodeName.toLowerCase() == "tr")
					{
						$(obj.parentNode).remove();
						break;
					}
					else
						obj = obj.parentNode;
				}

				if($("#_tbcolor_ tr").size() < 1)
				{
					var tr = "";
					tr += "<tr>";
					tr += "	<td height=\"30\">";
					tr += "		<input type=\"text\" name=\"color[]\" class=\"lbox w100\" /> ";
					tr += "		<input type=\"file\" name=\"cimg[]\" class=\"lbox w200\" /> ";
					tr += "		<img src=\"../img/btn/s_btn_del.gif\" align=\"absmiddle\" onclick=\"javascript:Goods.colorHandler.del(this);\" />";
					tr += "	</td>";
					tr += "</tr>";

					$("#_tbcolor_").append(tr);
				}
			}
		},

		/**
		* 재고설정 Javascript
		*/
		setGoodsLimit : function()
		{
			if($(":radio[name='blimit']:checked").val() == 1)
			{
				Common.disabledObject($("input[name='glimit']"), true);
			}
			else
			{
				Common.disabledObject($("input[name='glimit']"), false);
			}
		},

		/**
		* 적립금 설정
		*/
		setPointMode : function()
		{
			if($(":radio[name='pointmod']:checked").val() > 1)
				Common.disabledObject($("input[name='point']"), false);
			else
			{
				$("input[name='point']").val('');
				Common.disabledObject($("input[name='point']"), true);
			}
		},

		/**
		* 배송비설정 Javascript
		*/
		deliveryChange : function()
		{
			if($(":radio[name='delivery']:checked").val() == 1)
			{
				$("input[name='dyprice']").attr("disabled", true);
				$("input[name='ndyprice']").attr("disabled", true);
				$("#_deliveryprice_").hide();
			}
			else
			{
				$("input[name='dyprice']").attr("disabled", false);
				$("input[name='ndyprice']").attr("disabled", false);
				$("#_deliveryprice_").show();
			}
		},

		/**
		* 옵션 Javascript Handler
		*/
		optionHandler :
		{
			useOption : function() {
				if($(":radio[name='bopt']:checked").val() == "Y")
					$("#soption").show();
				else
					$("#soption").hide();
			},
			addOption : function() {
				var html = "";
				var rowIndex = $("#_idopt_ tr").size();

				if(rowIndex > 5)
				{
					alert("옵션은 5개까지만 등록 가능합니다.");
					return false;
				}

				html += "<tr bgcolor=\"#ffffff\" align=\"center\">";
				html += "	<td>";
				html += "		<input type=\"text\" name=\"optnm["+ (rowIndex-1) +"]\" class=\"lbox w100\" />";
				html += "		<img src=\"../img/btn/btn_column_add.gif\" class=\"hand middle\" onClick=\"Goods.optionHandler.addItemOption(this);\" />";
				html += "	</td>";
				html += "	<td>";
				html += "		<div style=\"margin-bottom:5px;\">";
				html += "			<input type=\"text\" name=\"item["+ (rowIndex-1) +"][]\" class=\"lbox w300\" /> 선택시 판매금액에 ";
				html += "			<input type=\"text\" name=\"pay["+(rowIndex-1)+"][]\" class=\"rbox w150\" />원 추가</div>";
				html += "	</td>";
				html += "	<td><input type=\"checkbox\" name=\"req[0]\" value=\"1\" /></td>";
				html += "</tr>";

				$("#_idopt_").append(html);
			},
			delOption : function() {
				var rowIndex = $("#_idopt_ tr").size();

				if(rowIndex > 2)  $("#_idopt_ tr:last").remove();

			},
			addItemOption : function(obj) {
				var idx = $(obj.parentNode.parentNode).index("#_idopt_ tr");
				var row = $("#_idopt_ tr").eq(idx).children('td').children('div').size();

				if(row < 10)
				{
					var tr = "";
					tr += "<div style=\"margin-bottom:5px;\">";
					tr += "	<input type=\"text\" name=\"item["+(idx-1)+"][]\" class=\"lbox w300\" />";
					tr += "	선택시 판매금액에 <input type=\"text\" name=\"pay["+(idx-1)+"][]\" class=\"rbox w150\" />원 추가";
					tr += "</div>";
					$("#_idopt_ tr").eq(idx).children('td').eq(1).append(tr);
				}
				else
				{
					alert("항목추가는 최대 10까지만 가능합니다.");
					return;
				}
			}
		},

		/**
		* 상품COLOR Javascript Handler
		*/
		op :
		{
			add : function() {
				var tb = $("#_tbcolor_ tr");
				if(tb.size() >= 10)
				{
					alert("10개까지만 등록가능합니다.");
					return false;
				}

				var tr = "";
				tr += "<tr>";
				tr += "	<td height=\"30\">";
				tr += "		<input type=\"text\" name=\"color[]\" class=\"lbox w100\" /> ";
				tr += "		<input type=\"file\" name=\"cimg[]\" class=\"lbox w200\" /> ";
				tr += "		<img src=\"../img/btn/s_btn_del.gif\" align=\"absmiddle\" onclick=\"javascript:Goods.colorHandler.del(this);\" />";
				tr += "	</td>";
				tr += "</tr>";

				$("#_tbcolor_").append(tr);
			},
			del : function(obj) {

				while(1)
				{
					if(obj.parentNode.nodeName.toLowerCase() == "tr")
					{
						$(obj.parentNode).remove();
						break;
					}
					else
						obj = obj.parentNode;
				}

				if($("#_tbcolor_ tr").size() < 1)
				{
					var tr = "";
					tr += "<tr>";
					tr += "	<td height=\"30\">";
					tr += "		<input type=\"text\" name=\"color[]\" class=\"lbox w100\" /> ";
					tr += "		<input type=\"file\" name=\"cimg[]\" class=\"lbox w200\" /> ";
					tr += "		<img src=\"../img/btn/s_btn_del.gif\" align=\"absmiddle\" onclick=\"javascript:Goods.colorHandler.del(this);\" />";
					tr += "	</td>";
					tr += "</tr>";

					$("#_tbcolor_").append(tr);
				}
			}
		},

		/**
		* 상품이미지 설정 Javascript
		*/
		uploadImgChange : function()
		{
			if($(":radio[name='imgtype']:checked").val() == 1)
			{
				$("input[name='img1']").attr("disabled", false);
				$("input[name='img2']").attr("disabled", true);
				$("input[name='img3']").attr("disabled", true);
				$("input[name='img4']").attr("disabled", true);
			}
			else
			{
				$("input[name='img1']").attr("disabled", false);
				$("input[name='img2']").attr("disabled", false);
				$("input[name='img3']").attr("disabled", false);
				$("input[name='img4']").attr("disabled", false);
			}
		},

		/**
		* 추가이미지 설정 Javascript Handler
		*/
		imgaddHandler :
		{
			addImg : function() {
				var rowIndex = $("#filebox tr").size();

				if(rowIndex < 4)
					$("#filebox").append("<tr><td style=\"padding-top:5px;\" class=\"noline\"><input type=\"file\" name=\"etcimg[]\" class=\"lbox w300\" /></td></tr>");
				else
				{
					alert("추가이미지는 4개까지만 첨부가능합니다.");
					return;
				}
			},
			delImg : function() {
				var rowIndex = $("#filebox tr").size();

				if(rowIndex > 1)
					$("#filebox tr:last").remove();
				else
				{
					alert("추가이미지 한개는 삭제 불가능합니다.");
					return;
				}
			}
		},

		/**
		* 상품등록 Javascript
		*/
		checkRegister : function(obj)
		{
			if(typeof(obj['category']) == "undefined")
			{
				alert("상품분류 선택후 등록버튼을 클릭해 주세요.");
				document.getElementsByName("cate[]")[0].focus();
				return false;
			}

			if($(":radio[name='gcodeWay']").val() == 1 && !obj.gcode2.value)
			{
				alert("상품코드를 입력해 주세요.");
				obj.gcode2.focus();
				return false;
			}

			if(!Common.checkFormHandler.checkForm(obj)) return false;

			return true;
		},

		/**
		* 상품수정
		*/
		checkEdit : function(obj)
		{
			if(typeof(obj['category']) == "undefined")
			{
				alert("상품분류 선택후 등록버튼을 클릭해 주세요.");
				document.getElementsByName("cate[]")[0].focus();
				return false;
			}

			if(!Common.checkFormHandler.checkForm(obj)) return false;

			return true;
		}
	};
})(window);
 
