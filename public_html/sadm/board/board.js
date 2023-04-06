(function(){
	this.Board || (this.Board = {});

	Board = { 
		/** 
		* 게시판 카테고리 Javascript Handler
		*/ 
		categoryHandler : 
		{
			chkUseCategory : function() {
				if($(":radio[name='bcate']:checked").val() == "Y")
					$("#boardGrp").show();
				else
					$("#boardGrp").hide();
			}, 
			checkCategory : function() {
				if($("select[name='sGroup']").index($("select[name='sGroup']:selected")) < 0)
					return false;

				$("#btnAddGroup").attr("mode", "edit");
				$("#btnAddGroup").val("수정하기");
				$("input[name='newGroup']").val($("select[name='sGroup'] option:selected").text())
			}, 
			addCategory : function() {
				
			}
		}, 
		/**
		* 카테고리 활성 및 비활성 --- old
		*/ 
		categoryShow : function() {
			if($(":radio[name='bcate']:checked").val() == 0)
				Common.disabledObject($("input[name='scate']"), true);
			else
				Common.disabledObject($("input[name='scate']"), false);
		}
	}
})(window);