(function(){
	this.Member || (this.Member = {});

	Member = {
		/**
		* 유효성 및 중복체크 Javascript Handler
		*/
		checkHandler :
		{
			// 아이디 검사 //
			chkUserId : function() {
				if(!$(":input[name='userid']").val())
				{
					alert("아이디를 입력해 주세요.");
					$(":input[name='userid']").focus();
				}
				else
				{
					$(":hidden[name='chk_userid']").val("");
					$.post("./ajax.check.php",
						{
							userid : $(":input[name='userid']").val(),
							mode : "idchk"
						},
						function(data){
							if(data == 001)
							{
								$(":hidden[name='chk_userid']").val("");
								$("#use_message").css("color", "#FF0000");
								$("#use_message").html("※ 공백없이 4~20자의 영문,숫자,_만 사용가능합니다.");
								$(":input[name='userid']").focus();
							}
							else if(data == 002)
							{
								$(":hidden[name='chk_userid']").val("");
								$("#use_message").css("color", "#FF0000");
								$("#use_message").html("※ 중복되는 아이디 입니다.");
							}
							else if(data == 000)
							{
								$(":hidden[name='chk_userid']").val($(":input[name='userid']").val()),
								$("#use_message").css("color", "#3366FF");
								$("#use_message").html("※ 사용가능한 아이디입니다.");
							}
						}
					);
				}
			},
			// 닉넥임 검사 //
			chkNickName : function() {
				if(!$(":input[name='f_nick']").val())
				{
					alert("닉네임을 입력해 주세요.");
					$(":input[name='f_nick']").focus();
				}
				else
				{
					$(":hidden[name='chk_nick']").val("");
					$.post("./ajax.check.php",
						{
							nick : $(":input[name='f_nick']").val(),
							mode : "nick"
						},
						function(data){
							if(data == 001)
							{
								$(":hidden[name='chk_nick']").val("");
								$("#nick_message").css("color", "#FF0000");
								$("#nick_message").html("※ 닉네임은 한글, 영문, 숫자만 입력이 가능합니다.");
								$(":input[name='f_nick']").focus();
							}
							else if(data == 002)
							{
								$(":hidden[name='chk_nick']").val("");
								$("#nick_message").css("color", "#FF0000");
								$("#nick_message").html("※ 이미 사용중인 닉네임 입니다.");
							}
							else if(data == 000)
							{
								$(":hidden[name='chk_nick']").val($(":input[name='nick']").val()),
								$("#nick_message").css("color", "#3366FF");
								$("#nick_message").html("※ 사용가능한 닉네임입니다.");
							}
						}
					);
				}
			},
			// 이메일 검사 //
			chkEmail : function(mode) {
				if(!$(":input[name='email']").val())
				{
					alert("메일주소를 입력해 주세요.");
					$(":input[name='email']").focus();
				}
				else if(!Common.checkFormHandler.checkEmail($(":input[name='email']").val()))
				{
					alert("이메일주소형식이 맞지 않습니다.");
					$(":input[name='email']").val("");
					$(":input[name='email']").focus();
				}
				else
				{
					$(":hidden[name='chk_email']").val("");
					$.post("./ajax.check.php",
						{
							email : $(":input[name='email']").val(),
							mode : (mode == "edit") ? "update_email" : "email",
							encData : $(":hidden[name='encData']").val()
						},
						function(data){
							if(!data)
							{
								$(":hidden[name='chk_email']").val("");
								$("#email_message").css("color", "#FF0000");
								$("#email_message").html("※ 메일유효성 검사도중 오류가 발생하였습니다.");
								$(":input[name='email']").focus();
							}
							else if(data == 001)
							{
								$(":hidden[name='chk_email']").val("");
								$("#email_message").css("color", "#FF0000");
								$("#email_message").html("※ 이메일주소형식이 맞지 않습니다.");
								$(":input[name='email']").focus();
							}
							else if(data == 002)
							{
								$(":hidden[name='chk_email']").val("");
								$("#email_message").css("color", "#FF0000");
								$("#email_message").html("※ 이미 사용중인 이메일주소 입니다.");
							}
							else if(data == "000")
							{
								$(":hidden[name='chk_email']").val($(":input[name='email']").val()),
								$("#email_message").css("color", "#3366FF");
								$("#email_message").html("※ 사용가능한 이메일주소입니다.");
							}
						}
					);
				}
			}
		}
	};
})(window);
