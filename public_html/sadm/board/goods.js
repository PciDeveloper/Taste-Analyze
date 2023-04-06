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
		* 추가이미지 설정 Javascript Handler
		*/
		imgaddHandler :
		{
			addImg : function() {
				var rowIndex = $("#filebox tr").size()+1;
				if(rowIndex <= 20)
					$("#filebox").append("<tr><td style=\"padding-top:5px;\" class=\"noline\"><input type=\"file\" name=\"upfile"+ rowIndex +"\" class=\"lbox w300\" /></td></tr>");
				else
				{
					alert("추가이미지는 20개까지만 첨부가능합니다.");
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
		}
	};
})(window); 