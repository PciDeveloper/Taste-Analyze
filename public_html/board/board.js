(function(){
	this.Board || (this.Board = {});

	Board = {

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
    }

	};
})(window);
