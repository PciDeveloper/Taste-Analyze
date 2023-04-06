(function(){
	this.Common || (this.Common = {});

	String.prototype.trim = function(){	return this.replace(/(^\s*)|(\s*$)/g, "");}		//Trim
	String.prototype.stripspace = function() { return this.replace(/ /g, ""); }			//공백제거
	String.prototype.getExt = function() {												//파일 확장자 구하기
		var ext = this.substring(this.lastIndexOf(".") + 1, this.length);
		return ext;
	}


	Common = {
	//	$scrollRoot: jQuery(function () { Common.$scrollRoot = jQuery((jQuery.browser.msie || jQuery.browser.mozilla || jQuery.browser.opera) ? 'html' : 'body'); }),

		/**
		* layer popup 띄우기
		*
		* @require	:	iframe url 필요
		* @return	:
		*/
		openLayerPopup: function(url, w, h, bg, scroll)
		{
			if($("#ContentLayer").size() > 0) Common.closeLayerPopup();

			w = (w) ? w : 650;
			h = (h) ? h : 500;
			bg = (bg) ? bg : "#000000";
			scroll = (scroll) ? scroll : "yes";

			var bodyW = Common.$scrollRoot.width();
			var bodyH = Common.$scrollRoot.height();
			//alert(bodyW);

			var layerX = (bodyW-w) / 2;
			var layerY = (bodyH-h) / 2;

			var tTop = Math.max(20, Math.max($(document).scrollTop(), document.body.scrollTop) + Math.floor((Common.getWinHeight()-h)/2));
			var tLeft = (bodyW - w)/2;

			var obj = document.createElement("div");
			with(obj.style)
			{
				position = "absolute";
				left = 0;
				top = 0;
				zIndex = "1000";
				width = "100%";
				//height = document.body.scrollHeight + "px";
				height=(document.body.scrollHeight > document.documentElement.scrollHeight) ? document.body.scrollHeight+"px" : document.documentElement.scrollHeight+"px";
				backgroundColor = bg;
				filter = "Alpha(Opacity=50)";
				opacity = "0.5";
			}
			obj.id = "layerback";
			document.body.appendChild(obj);
			var obj = document.createElement("div");
			with(obj.style)
			{
				position = "absolute";
				zIndex = "1001";
				//left = layerX + document.body.scrollLeft + "px";
				//top = layerY + document.body.scrollTop + "px";
				left = tLeft + "px";
				top = tTop + "px";
				width = w + "px";
				height = h + "px";
				backgroundColor = "#ffffff";
				border = "3px solid #000000";
			}
			obj.id = "ContentLayer";
			document.body.appendChild(obj);

			var btm = document.createElement("div");
			with(btm.style)
			{
				position = "absolute";
				width = "100%";
				height = 25+"px";
				zIndex = "1001";
				left = 0;
				top = (h - 28) + "px";
				padding = "4px 0 0 0";
				textAlign = "center";
				backgroundColor = "#000000";
				color = "#ffffff";
				font = "bold 13px tahoma; letter-spacing:0px";
			}
			btm.innerHTML = "<a href=\"javascript:Common.closeLayerPopup();\" style=\"color:#ffffff;\"> CLOSE </a>";
			obj.appendChild(btm);

			var ifm = document.createElement("iframe");
			with(ifm.style)
			{
				width = w + "px";
				height = (h - 20) + "px";
			}
			ifm.frameBorder = 0;
			ifm.src = url;
			ifm.scrolling = scroll;

			obj.appendChild(ifm);
		},
		closeLayerPopup: function()
		{
			$("#layerback, #ContentLayer").remove();
		},

		/**
		* layer message box
		*/
		layerMessage : function(mode)
		{
			var msgwrap = $("#msgwrap", parent.document);
			var msgbox = $("#msgbox", parent.document);

			if(mode == "o")
			{
				msgwrap.show();
				msgbox.show();

				var win = $(window);
				var body = $(document);
				var mboxLeft = (win.scrollLeft() + (win.width() / 2)) - (msgbox.width() / 2);
				var mboxTop = (win.scrollTop() + (win.height() / 2)) - (msgbox.height() / 2);
				var maxBodyHeight = body.height();

				if(maxBodyHeight >= "3000") maxBodyHeight = 3000;

				//msgwrap.css( { 'width': win.width()+'px', 'height': maxBodyHeight+'px', 'opacity' : '0.5' } );
				msgwrap.css( { 'width':'100%', 'height': maxBodyHeight+'px', 'opacity' : '0.5' } );
				msgbox.css( { 'left': mboxLeft+'px', 'top': mboxTop+'px', 'opacity' : '1.0'} );

				$('#msgbox p.btn a').focus();

				$(document).keydown(function(e){
					if(e.keyCode == '13' || e.keyCode == '32' || e.keyCode == '27'){
						$('#msgbox p.btn a').click();
					}
				});
			}
			else
			{
				$("#msgbox").hide();
				$("#msgwrap").hide();
			}
		},

		layerMessageTest : function(mode)
		{
			var msgwrap = $("#msgwrap", parent.document);
			var msgbox = $("#msgbox", parent.document);

			if(mode == "o")
			{
				msgwrap.show();
				msgbox.show();

				var win = $(window);
				var body = $(document);
				var mboxLeft = (win.scrollLeft() + (win.width() / 2)) - (msgbox.width() / 2);
				var mboxTop = (win.scrollTop() + (win.height() / 2)) - (msgbox.height() / 2);
				var maxBodyHeight = body.height();

				if(maxBodyHeight >= "3000") maxBodyHeight = 3000;

				msgwrap.css( { 'width': win.width()+'px', 'height': maxBodyHeight+'px', 'opacity' : '0.5' } );
				msgbox.css( { 'left': mboxLeft+'px', 'top': mboxTop+'px', 'opacity' : '1.0'} );

				$('#msgbox p.btn a').focus();

				$(document).keydown(function(e){
					if(e.keyCode == '13' || e.keyCode == '32' || e.keyCode == '27'){
						$('#msgbox p.btn a').click();
					}
				});
			}
			else
			{
				$("#msgbox").hide();
				$("#msgwrap").hide();
			}
		},

		/**
		* mobile browser check
		*/
		checkMobile : function()
		{
			if(navigator.userAgent.match(/iPhone|iPad|iPod|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson/i) != null || navigator.userAgent.match(/LG|SAMSUNG|Samsung/) != null)
				return true;
			else
				return false;
		},


		/**
		* layer message box close
		*/
		layerMessageClose : function()
		{
			$("#msgbox").hide();
			$("#msgwrap").hide();
		},

		/**
		* url location
		*/
		goUrl : function(url)
		{
			document.location.href = url;
		},

		/**
		* client height
		*/
		getWinHeight : function()
		{
			return Math.max($(window).height(), document.documentElement.clientHeight, document.body.clientHeight);
		},

		/**
		* height 구하기
		*/
		getDocHeight : function()
		{
			var D = document;
			return Math.max(
				Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
				Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
				Math.max(D.body.clientHeight, D.documentElement.clientHeight)
			);
		},

		/**
		* category select box
		* @require	:	name(select name), cnt(노출 카테고리 차수), val(기존선택 카테고리), type(multiple, 단일), formnm(form 이름)
		*/
		makeCategoryBox: function(name, cnt, val, type, formnm)
		{
			cnt = (cnt) ? cnt : 1;
			if(type == "multiple") type = "multiple style=\"width:160px;height:96px;\"";

			for(var i=0; i < cnt; i++)
			{
				document.write("<select "+ type +" name='"+ name + "' idx=" + i + " onChange='Common.chgCategory(this, "+(i+1)+")'></select>&nbsp;");
			}

			oForm = eval("document.forms['" + formnm + "']");
			if(oForm == null)
				this.oCate = eval("document.forms[0]['" + name +"']");
			else
				this.oCate = eval("document." + oForm.name + "['" + name + "']");

			if(cnt == 1)
				this.oCate = new Array(this.oCate);

			this.CateBoxInit = CateBoxInit;
			this.CateBoxSet = CateBoxSet;
			this.getCate = getCate;
			this.getRequest = getRequest;
			this.chgCategory = chgCategory;
			this.CateBoxInit(0);

			function CateBoxInit()
			{
				this.CateBoxSet();
				this.getCate(this.oCate[0]);
			}

			function CateBoxSet(depth)
			{
				i = (depth) ? depth : 0;

				for(i=0; i < cnt; i++)
				{
					if(this.oCate[i])
					{
						this.oCate[i].options[0] = new Option("-- "+(i+1)+"차 분류 --", "");
						this.oCate[i].selectedIndex = 0;
					}
				}
			}

			function getCate(obj)
			{
				for(i=0; i < cnt; i++)
				{
					this.getRequest(this.oCate[i]);
				}
			}

			function getRequest(obj)
			{
				idx = obj.getAttribute("idx");
				val = (obj.value) ? obj.value : val;

				$.getJSON("/comm/json.category.php?idx="+idx+"&val="+val, function(data){
					if(data)
					{
						$.each(data, function(index, entry){
							Opt = document.createElement("OPTION");
							Opt.text = entry["name"];
							Opt.value = entry["code"];
							obj.options.add(Opt);

							if(entry["selected"])
								obj.selectedIndex = index+1;
						});
					}
				});
			}

			function chgCategory(obj, depth)
			{
				var name = obj.name;
				value = obj.value;
				sObj = this.oCate[depth];

				for(var i = depth; i <= document.getElementsByName(name).length; i++)
				{
					if(this.oCate[i])
					{
						Common.selectRemoveAll(this.oCate[i]);
						this.oCate[i].options[0] = new Option("-- "+(i+1)+"차 분류 --", "");
						this.oCate[i].selectedIndex = 0;
					}
				}

				$.getJSON("/comm/json.category.php?val="+value+"&idx="+depth, function(data){
					if(data)
					{
						$.each(data, function(index, entry){
							Opt = document.createElement("OPTION");
							Opt.text = entry["name"];
							Opt.value = entry["code"];
							sObj.options.add(Opt);

							if(entry["selected"])
								sObj.selectedIndex = index+1;
							else
								sObj.selectedIndex = 0;
						});
					}
				});
			}
		},

		/**
		* selectbox option all remove
		*
		* @require	:	object
		*/
		selectRemoveAll : function(obj)
		{
			for(var i=obj.length-1; i >= 0; i--)
				Common.selectRemoveList(obj, i);
		},

		/**
		* selectbox option one remove
		*
		* @require	:	object, option
		*/
		selectRemoveList : function(obj, i)
		{
			obj.remove(i);
		},

		/**
		* 숫자 및 통화관련 javascript
		*/
		numberHandler :
		{
			toCurrency : function(obj)
			{
				if(obj.disabled) return false;

				var num = obj.value.stripspace();

				if(num == "") return false;

				if(!Common.numberHandler.checkNumber(Common.numberHandler.stripChar(num)))
				{
					num = Common.numberHandler.stripChar(num, false);
					obj.blur();
					obj.focus();
				}

				num = Common.numberHandler.stripChar(Common.numberHandler.stripComma(num), false);
				num = Common.numberHandler.removePreZero(num);
				obj.value = Common.numberHandler.NumberFormat(num);
			},
			checkNumber : function(nNumber)
			{
				var anum=/(^\d+$)|(^\d+\.\d+$)/ ;

				if(anum.test(nNumber))
					return true;
				else
					return false;
			},
			removePreZero : function(str)
			{
				var i, result;

				if(str == "0") return str;

				for(i=0; i < str.length; i++)
					if(str.substr(i,1) != "0") break;

				result = str.substr(i, str.length-i);
				return result;
			},
			stripChar : function(val, isDec)
			{
				var i;
				var minus = "-";
				var number = "1234567890"+((isDec) ? "." : "");
				var result = "";

				for(i=0; i < val.length; i++)
				{
					chkno = val.charAt(i);

					if(i == 0 && chkno == minus)
					{
						result += minus;
					}
					else
					{
						for(j=0; j < number.length; j++)
						{
							if(chkno == number.charAt(j))
							{
								result += number.charAt(j);
								break;
							}
						}
					}
				}
				return result;
			},
			stripComma : function(number)
			{
				var reg = /(,)*/g;
				number = String(number).replace(reg, "");
				return number;
			},
			NumberFormat : function(number)
			{
				var arr = new Array();
				number = String(number);

				for(var i=1; i <= number.length; i++)
				{
					if(i%3)
						arr[number.length-i] = number.charAt(number.length-i);
					else
						arr[number.length-i] = ","+number.charAt(number.length-i);
				}

				return arr.join('').replace(/^,/,'');
			}
		},

		/**
		* object disabled
		*/
		disabledObject : function(obj, bo)
		{
			if(bo)
			{
				if(obj.type == "checkbox")
					obj.checked = false;
				else if(obj.type == "select-one")
					obj.selectedIndex = 0;

				//obj.disabled = true;
				//obj.style.backgroundColor = "#f1f1f1";
				obj.attr("disabled", true);
				obj.css("backgroundColor","#f1f1f1");
			}
			else
			{
				//obj.disabled = false;
				//obj.style.backgroundColor = "#ffffff";
				obj.attr("disabled", false);
				obj.css("backgroundColor", "#ffffff");
			}
		},

		/**
		* check form javascript Handler
		*
		* @params : object
		*/
		checkFormHandler :
		{
			checkForm : function(form) {
				var len = form.elements.length;
				var typenm, tagnm, expstr, ename, e_val, r_ck;

				for(var i=0; i < len; i++)
				{
					var obj = form.elements[i];
					ename = obj.name;
					typenm = obj.type.toUpperCase();
					tagnm = obj.tagName.toUpperCase();
					expstr = obj.getAttribute("exp");
					e_val = obj.value;

					if(expstr != null && expstr != "")
					{
						if(typenm == "SELECT-ONE")	//select
						{
							if(e_val == "")
							{
								alert(expstr + " 선택해 주세요.");
								form.elements[i].focus();
								return false;
								break;
							}
						}
						else if(typenm == "RADIO")	//radio
						{
							r_ck = "N";
							for(var j=0; j < eval("form."+ename).length; j++)
							{
								if(eval("form."+ename)[j].checked == true)
								{
									r_ck = "Y";
									break;
								}
							}

							if(r_ck == "N")
							{
								alert(expstr + " 선택해 주세요.");
								eval("form."+ename)[0].focus();
								return false;
								break;
							}
						}
						else if(typenm == "TEXT" || typenm == "PASSWORD" || typenm == "TEXTAREA" || typenm == "SEARCH")
						{
							if(e_val.replace(/^\s*/,'').replace(/\s*$/, '') == "")
							{
								alert(expstr + " 입력해 주세요.");
								form.elements[i].focus();
								return false;
								break;
							}
						}
						else if(typenm == "HIDDEN")
						{
							if(e_val.replace(/^\s*/,'').replace(/\s*$/, '') == "")
							{
								alert(expstr);
								return false;
								break;
							}
						}
						else if(typenm == "FILE")
						{
							if(e_val != "")
							{
								if(obj.getAttribute("filetype") != null)
								{
									var checkFile = obj.getAttribute("filetype");

									if(!this.chkFileType(form.elements[i], checkFile))
									{
										return false;
										break;
									}
								}
							}
							else
							{
								alert(expstr + "선택해 주세요.");
								form.elements[i].focus();
								return false;
								break;
							}
						}
					}

					if(obj.getAttribute("chktype") != null && obj.value.length > 0)
					{
						var checkType = obj.getAttribute("chktype");
						if(checkType == "id")
						{
							if(!this.checkID(obj))
							{
								alert("아이디형식이 맞지 않습니다.");
								form.elements[i].value = "";
								form.elements[i].focus();
								return false;
								break;
							}
						}
						else if(checkType == "password")
						{
							if(form.pwd.value != form.pwd2.value)
							{
								alert("비밀번호가 맞지 않습니다.");
								form.pwd2.value = "";
								form.pwd2.focus();
								return false;
								break;
							}
						}
						else if(checkType == "passchk" && form.elements[i].value)
						{
							/*
							if(!this.checkPassword(form.elements[i]))
							{
								return false;
								break;
							}
							*/

							if(!this.checkPass(form.elements[i]))
							{
								alert("비밀번호는 공백없이 4자이상 12자이내의 영문, 숫자, _, - 만으로 입력해 주세요.");
								form.elements[i].value = "";
								form.elements[i].focus();
								return false;
								break;
							}


						}
						else if(checkType == "email")
						{
							if(!this.checkEmail(e_val))
							{
								alert("메일주소형식이 맞지 않습니다.");
								form.elements[i].value = "";
								form.elements[i].focus();
								return false;
								break;
							}
						}
						else if(checkType == "alphabet")
						{
							if(!this.checkAlphabet(obj))
							{
								alert("영문 알파벳으로만 입력해 주세요.");
								obj.value = "";
								obj.focus();
								return false;
								break;
							}
						}
						else if(checkType == "number")
						{
							if(!Common.numberHandler.checkNumber(obj.value))
							{
								alert("숫자로만 입력해 주세요.");
								obj.value = "";
								obj.focus();
								return false;
								break;
							}
						}
						else if(checkType == "hangul")
						{
							if(!this.checkHangul(obj))
							{
								alert("한글만 입력 가능합니다.");
								obj.value = "";
								obj.focus();
								return false;
								break;
							}
						}
					}
				}

				if(typeof(myeditor) == "object")
					myeditor.outputBodyHTML();

				if(typeof(myeditor1) == "object")
					myeditor1.outputBodyHTML();

				if(typeof(myeditor2) == "object")
					myeditor2.outputBodyHTML();

				if(typeof(myeditor3) == "object")
					myeditor3.outputBodyHTML();

				return true;
			},
			chkFileType : function(obj, type){
				var ext = obj.value.getExt().toLowerCase();

				if(type == "image")
				{
					if(ext != "gif" && ext != "jpg" && ext != "jpeg" && ext != "png" && ext != "bmp")
					{
						alert("이미지파일(gif, jpg, png, bmp)만 업로드 가능합니다.");
						obj.focus();
						return false;
					}
				}
				else if(type == "swf")
				{
					if(ext != "swf")
					{
						alert("플래쉬파일(swf)만 업로드 가능합니다.");
						obj.focus();
						return false;
					}
				}
				else if(type == "xml")
				{
					if(ext != "xml")
					{
						alert("xml 파일만 업로드 가능합니다.");
						obj.focus();
						return false;
					}
				}
				else if(type == "csv")
				{
					if(ext != "csv")
					{
						alert("csv 파일만 업로드 가능합니다.");
						obj.focus();
						return false;
					}
				}

				return true;
			},
			/// Member ID check ///
			checkID : function(obj)
			{
				var id = obj.value;
				var patten = /^[a-zA-Z0-9]{1}[a-zA-Z0-9_-]{3,19}$/;

				if(!patten.test(id))
					return false;
				else
					return true;
			},
			/// Member Password chekce ///
			checkPass : function(obj)
			{
				var pwd = obj.value;
				var patten = /^[a-zA-Z0-9_]{4,20}$/;

				if(!patten.test(pwd))
					return false;
				else
					return true;
			},
			/// Member Password check2 ///
			checkPassword : function(obj)
			{
				var pw = obj.value;

				if(!/^[a-zA-Z0-9]{10,20}$/.test(pw) || pw.indexOf(' ') > -1)
				{
					alert('비밀번호는 숫자와 영문자 조합으로 10~20자리를 사용해야 합니다.');
					obj.value = "";
					obj.focus();
					return false;
				}

				var chk_num = pw.search(/[0-9]/g);
				var chk_eng = pw.search(/[a-z]/ig);

				if(chk_num < 0 || chk_eng < 0)
				{
					alert('비밀번호는 숫자와 영문자를 혼용하여야 합니다.');
					obj.value = "";
					obj.focus();
					return false;
				}

				if(/(\w)\1\1\1/.test(pw))
				{
					alert('비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.');
					obj.value = "";
					obj.focus();
					return false;
				}
				return true;
			},
			/// check email ///
			checkEmail : function(email)
			{
				if(email.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
					return true;
				else
					return false;
			},
			/// check alphabet ///
			checkAlphabet : function(obj)
			{
				var str = obj.value;

				if(str.length == 0) return false;
				str = str.toUpperCase();

				for(var i=0; i < str.length; i++)
					if(!('A' <= str.charAt(i) && str.charAt(i) <= 'Z')) return false;

				return true;
			},
			/// check hangul ///
			checkHangul : function(obj)
			{
				var str = obj.value;
				var patten = /[가-힣]/;

				if(!patten.test(str))
					return false;
				else
					return true;
			}
		},

		/**
		* checkbox check
		*/
		isChecked : function(obj, msg)
		{
			if(!obj) return;

			if(typeof(obj) != "object")
				obj = document.getElementsByName(obj);

			if(obj)
			{
				for(var i=0; i < obj.length; i++)
					if(obj[i].checked) var isChecked = true;
			}

			if(isChecked)
				return true;
			else
			{
				var msg = (msg) ? msg : "선택된 항목이 없습니다.";
				alert(msg);
				return false;
			}
		},

		/**
		* layer toggle (open & close)
		*
		* @params : id, mode(block, none)
		*/
		layerToggle : function(id, mode)
		{
			if(mode)
				$("#"+id).css("display", mode);
			else
			{
				/*
				if($("#"+id).css("display") != "none")
					$("#"+id).hide();
				else
					$("#"+id).show();
				*/
				$("#"+id).css("display", (($("#"+id).css("display") != "none") ? "none" : "block"));
			}
		},

		/**
		* zipcode window open
		*
		* @params : pos(위치)
		*/
		openZipcode: function(pos)
		{
			window.open("/comm/zipcode/zip2.php?pos="+pos, "zipcode", "width=500, height=442, scrollbars=yes");
		},
		openMobileZip : function(pos)
		{
			window.open("/m/comm/zipcode/zip2.php?pos="+pos, "zipcode", "width=320, height=442, scrollbars=yes");
		},

		/**
		* board password layer
		* @params : mode, code, data
		*/
		layerPassForm : function(mode, code, data)
		{
			var bwidth = $(window).width();
			var bheigh = $(window).height();
			var layerX = (bwidth-300) / 2;
			var layerY = (bheigh-200) / 2;
			var html = '';

			//target=\"ifrm\"

			html = "<form name=\"pwdfm\" action=\"/board/check.pwd.php\" method=\"post\" autocomplete=\"off\" onSubmit=\"return Common.checkFormHandler.checkForm(this);\" target=\"ifrm\">";
			html += "<input type=\"hidden\" name=\"mode\" value=\""+mode+"\" />";
			html += "<input type=\"hidden\" name=\"code\" value=\""+code+"\"/>";
			html += "<input type=\"hidden\" name=\"encData\" value=\""+data+"\"/>";
			html += "<table cellpadding=\"0\" cellspacing=\"0\" class=\"PassLayer\">";
			html += "<colgroup><col width=\"30\" /><col /><col width=\"30\" /></colgroup>";
			html += "<tr>";
			html += "<td><img src=\"/image/layer/ly_top1.gif\" alt=\"\" /></td>";
			html += "<td class=\"bg_top\"></td>";
			html += "<td><img src=\"/image/layer/ly_top2.gif\" alt=\"\" /></td>";
			html += "</tr><tr>";
			html += "<td class=\"bg_left\"></td>";
			html += "<td align=\"center\" valign=\"top\">";
			html += "<h2><img src=\"/image/layer/pass_lay_tit.gif\" alt=\"비밀번호 입력\" /></h2>";
			html += "<dl><dt><img src=\"/image/layer/ly_pwd.gif\" alt=\"비밀번호\"  /></dt>";
			html += "<dd><input type=\"password\" name=\"pwd\" size=\"20\" class=\"lbox\" exp=\"비밀번호를 \" style=\"padding:0px\"/></dd>";
			html += "</dl><input type=\"image\" src=\"/image/layer/btn_layer_ok.gif\" alt=\"입력완료\" />";
			html += "<div class=\"line\"></div></td>";
			html += "<td class=\"bg_right\"></td></tr>";
			html += "<tr><td><img src=\"/image/layer/ly_btm1.gif\" alt=\"\" /></td><td class=\"bg_btm\"></td>";
			html += "<td><img src=\"/image/layer/ly_btm2.gif\" alt=\"레이어닫기\" class=\"hand\" onClick=\"Common.layerPassFormClose();\" /></td></tr></table>";
			html += "</form>";

			var obj = document.createElement("div");
			with (obj.style){
				position = "absolute";
				zIndex = "1000";
				left = 0;
				top = 0;
				width = "100%";
				//height = "100%";
				height=(document.body.scrollHeight > document.documentElement.scrollHeight) ? document.body.scrollHeight+"px" : document.documentElement.scrollHeight+"px";
				//height = document.body.clientHeight;
				backgroundColor = "#000000";
				filter = "Alpha(Opacity=30)";
				opacity = "0.5";
			}
			obj.id = "LayerBg";
			document.body.appendChild(obj);

			var obj = document.createElement("div");
			with (obj.style){
				position = "absolute";
				zIndex = "1001";
				//left = layerX + document.body.scrollLeft+"px";
				//top = layerY + document.body.scrollTop+"px";
				left = "40%";
				top = "40%";
				width = 313;
				height = 167;
				backgroundColor = "#ffffff";
				//obj.style.backgroundImage = "url('/img/qna_bg.gif')";
				//obj.style.backgroundRepeat = "no-repeat";
				border = "3px solid #000000";
			}
			obj.id = "LayerContent";

			document.body.appendChild(obj);
			obj.innerHTML = html;
		},

		/**
		* board password layer
		* @params : mode, code, data
		*/
		layerMobilePassForm : function(mode, code, data)
		{
			html = "<form name=\"pwdfm\" action=\"/m/board/check.pwd.php\" method=\"post\" autocomplete=\"off\" onSubmit=\"return Common.checkFormHandler.checkForm(this);\" target=\"ifrm\">";
			html += "<input type=\"hidden\" name=\"mode\" value=\""+mode+"\" />";
			html += "<input type=\"hidden\" name=\"code\" value=\""+code+"\"/>";
			html += "<input type=\"hidden\" name=\"encData\" value=\""+data+"\"/>";

			html += "<div class=\"passbox\">";
			html += "<div class=\"tips\"><p>이 게시물의 패스워드를 입력해주세요.</p></div>";
			html += "<div class=\"inputbox\">";
			html += "<div class=\"submitcols\">";
			html += "<p class=\"inputnt\"><input type=\"password\" name=\"pwd\" maxlength=\"20\" placeholder=\"비밀번호\" autocomplete=\"off\" exp=\"비밀번호를\" /></p>";
			html += "<p class=\"center\">";
			html += "<button type=\"submit\" class=\"btn_big\"><span>확인</span></button>";
			html += "<button type=\"button\" class=\"btn_big\" onclick=\"Common.layerMessage();\"><span>취소</span></button>";
			html += "</p>";
			html += "</div>";
			html += "</div>";
			html += "</div>";
			html += "</form>";

			setTimeout( function() { $('#msgbox').html(html); Common.layerMessage('o'); }, 300 );
		},

		/**
		* board password layer
		* @params : mode, data
		*/
		layerPassCounsel : function(mode, data)
		{
			var bwidth = $(window).width();
			var bheigh = $(window).height();
			var layerX = (bwidth-300) / 2;
			var layerY = (bheigh-200) / 2;
			var html = '';

			//target=\"ifrm\"

			html = "<form name=\"pwdfm\" action=\"/common/check.pwd.php\" method=\"post\" autocomplete=\"off\" onSubmit=\"return Common.checkFormHandler.checkForm(this);\" target=\"ifrm\">";
			html += "<input type=\"hidden\" name=\"mode\" value=\""+mode+"\" />";
			html += "<input type=\"hidden\" name=\"encData\" value=\""+data+"\"/>";
			html += "<table cellpadding=\"0\" cellspacing=\"0\" class=\"PassLayer\">";
			html += "<colgroup><col width=\"30\" /><col /><col width=\"30\" /></colgroup>";
			html += "<tr>";
			html += "<td><img src=\"/image/layer/ly_top1.gif\" alt=\"\" /></td>";
			html += "<td class=\"bg_top\"></td>";
			html += "<td><img src=\"/image/layer/ly_top2.gif\" alt=\"\" /></td>";
			html += "</tr><tr>";
			html += "<td class=\"bg_left\"></td>";
			html += "<td align=\"center\" valign=\"top\">";
			html += "<h2><img src=\"/image/layer/pass_lay_tit.gif\" alt=\"비밀번호 입력\" /></h2>";
			html += "<dl><dt><img src=\"/image/layer/ly_pwd.gif\" alt=\"비밀번호\"  /></dt>";
			html += "<dd><input type=\"password\" name=\"pwd\" size=\"20\" class=\"lbox\" exp=\"비밀번호를 \"/></dd>";
			html += "</dl><input type=\"image\" src=\"/image/layer/btn_layer_ok.gif\" alt=\"입력완료\" />";
			html += "<div class=\"line\"></div></td>";
			html += "<td class=\"bg_right\"></td></tr>";
			html += "<tr><td><img src=\"/image/layer/ly_btm1.gif\" alt=\"\" /></td><td class=\"bg_btm\"></td>";
			html += "<td><img src=\"/image/layer/ly_btm2.gif\" alt=\"레이어닫기\" class=\"hand\" onClick=\"Common.layerPassFormClose();\" /></td></tr></table>";
			html += "</form>";

			var obj = document.createElement("div");
			with (obj.style){
				position = "absolute";
				zIndex = "1000";
				left = 0;
				top = 0;
				width = "100%";
				//height = "100%";
				height=(document.body.scrollHeight > document.documentElement.scrollHeight) ? document.body.scrollHeight+"px" : document.documentElement.scrollHeight+"px";
				//height = document.body.clientHeight;
				backgroundColor = "#000000";
				filter = "Alpha(Opacity=30)";
				opacity = "0.5";
			}
			obj.id = "LayerBg";
			document.body.appendChild(obj);

			var obj = document.createElement("div");
			with (obj.style){
				position = "absolute";
				zIndex = "1001";
				//left = layerX + document.body.scrollLeft+"px";
				//top = layerY + document.body.scrollTop+"px";
				left = "40%";
				top = "40%";
				width = 313;
				height = 167;
				backgroundColor = "#ffffff";
				//obj.style.backgroundImage = "url('/img/qna_bg.gif')";
				//obj.style.backgroundRepeat = "no-repeat";
				border = "3px solid #000000";
			}
			obj.id = "LayerContent";

			document.body.appendChild(obj);
			obj.innerHTML = html;
		},

		/**
		*  board password layer close
		*/
		layerPassFormClose : function()
		{
			$("#LayerBg, #LayerContent").remove();
			//document.getElementById('LayerBg').parentNode.removeChild(document.getElementById('LayerBg'));
			//document.getElementById('LayerContent').parentNode.removeChild(document.getElementById('LayerContent'));
		},

		/**
		* checkbox all check
		*/
		allCheck : function(field)
		{
			var cbox = document.getElementsByName(field);

			for(var i=0; i < cbox.length; i++)
			{
				if(cbox[i].disabled == false)
					cbox[i].checked = (cbox[i].checked) ? false : true;
			}

		},

		/**
		* board reply password layer open
		*/
		layerReplyPass : function(pobj, code, idx)
		{
			var obj = document.getElementById('CmtPwdLayer');
			if(obj != null) obj.parentNode.removeChild(obj);
			var html = "";
			html = "<form name=\"cmtform\" action=\"../board/board.act.php\" method=\"post\" onSubmit=\"return Common.checkFormHandler.checkForm(this);\" target=\"ifrm\">";
			html += "<input type=\"hidden\" name=\"idx\" value=\""+idx+"\" />";
			html += "<input type=\"hidden\" name=\"mode\" value=\"chkpwd\" />";
			html += "<input type=\"hidden\" name=\"code\" value=\""+code+"\"/>";
			html += "<input type=\"hidden\" name=\"act\" value=\"cmtd\" />";
			html += "<input type=\"password\" id=\"pwd\" name=\"pwd\" class=\"lbox\" align=\"absmiddle\" exp=\"비밀번호를 \"/> ";
			html += "<input type=\"image\" src=\"/images/btn/btn_boa_ok.gif\" title=\"확인\" align=\"absmiddle\" /> ";
			html += "<img src=\"/images/btn/btn_boa_cancel.gif\" alt=\"취소\" align=\"absmiddle\" class=\"hand\" onClick=\"javascript:document.getElementById('CmtPwdLayer').parentNode.removeChild(document.getElementById('CmtPwdLayer'));\" />";
			html += "</form>";

			obj = document.createElement("span");
			obj.id = "CmtPwdLayer";
			obj.style.width = "290px";
			obj.style.border = "#dddddd 1px solid";
			obj.style.padding = "3px";
			obj.style.backgroundColor = "#ffffff";
			obj.style.position = "absolute";
			obj.style.zIndex = "9999999999";

			if(pobj.innerHTML.toLowerCase().indexOf('img') != -1)
			{
				obj.style.marginTop = "0px";
				obj.style.marginLeft = "-290px";

				//obj.style.marginTop = "500px";
				//obj.style.marginLeft = "500px";
			}

			obj.innerHTML = html;
			pobj.parentNode.insertBefore(obj, pobj.previousSibling);
			document.getElementById('pwd').focus();
		},

		/**
		* reserve reply password layer open
		*/
		layerReservePass : function(pobj, idx)
		{
			var obj = document.getElementById('CmtPwdLayer');
			if(obj != null) obj.parentNode.removeChild(obj);
			var html = "";
			html = "<form name=\"cmtform\" action=\"./reserve.act.php\" method=\"post\" onSubmit=\"return Common.checkFormHandler.checkForm(this);\" target=\"ifrm\">";
			html += "<input type=\"hidden\" name=\"idx\" value=\""+idx+"\" />";
			html += "<input type=\"hidden\" name=\"mode\" value=\"chkpwd\" />";
			html += "<input type=\"hidden\" name=\"act\" value=\"cmtd\" />";
			html += "<input type=\"password\" id=\"pwd\" name=\"pwd\" class=\"lbox\" align=\"absmiddle\" exp=\"비밀번호를 \"/> ";
			html += "<input type=\"image\" src=\"/images/btn/btn_boa_ok.gif\" title=\"확인\" align=\"absmiddle\" /> ";
			html += "<img src=\"/images/btn/btn_boa_cancel.gif\" alt=\"취소\" align=\"absmiddle\" class=\"hand\" onClick=\"javascript:document.getElementById('CmtPwdLayer').parentNode.removeChild(document.getElementById('CmtPwdLayer'));\" />";
			html += "</form>";

			obj = document.createElement("span");
			obj.id = "CmtPwdLayer";
			obj.style.width = "290px";
			obj.style.border = "#dddddd 1px solid";
			obj.style.padding = "3px";
			obj.style.backgroundColor = "#ffffff";
			obj.style.position = "absolute";
			obj.style.zIndex = "9999999999";

			if(pobj.innerHTML.toLowerCase().indexOf('img') != -1)
			{
				obj.style.marginTop = "0px";
				obj.style.marginLeft = "-290px";

				//obj.style.marginTop = "500px";
				//obj.style.marginLeft = "500px";
			}

			obj.innerHTML = html;
			pobj.parentNode.insertBefore(obj, pobj.previousSibling);
			document.getElementById('pwd').focus();
		},

		/**
		* hidden add
		* @params : obj : form, name : input 명, val : 값
		*/
		hiddenAdd : function(obj, name, val)
		{
			var input = document.createElement("input");
			input.type = "hidden";
			input.name = name;
			input.value = val;

			obj.appendChild(input);
		},

		/**
		* 자동등록방지 문자
		*/
		getNewCrypt : function()
		{
			document.ifrm.location.href = "/lib/new.crypt.php";
		},

		/**
		* checkbox => radio 타입으로 변환
		*/
		singleCheck : function(obj)
		{
			var allobj = document.getElementsByName(obj.name);

			for(var i=0; i < allobj.length; i++)
			{
				if(allobj[i] == obj)
					allobj[i].checked = (obj.checked) ? true : false;
				else
					allobj[i].checked = false;
			}
		},

		/**
		* set cookie
		*/
		setCookie : function(name, value, expiredays)
		{
			var todayDate = new Date();
			todayDate.setDate(todayDate.getDate() + expiredays);
			document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
		},

		/**
		* get cookie
		*/
		getCookie : function(name)
		{
			var nameOfCookie = name + "=";
			var x = 0;

			while (x <= document.cookie.length)
			{
				var y = (x + nameOfCookie.length);

				if (document.cookie.substring(x, y) == nameOfCookie)
				{
					if((endOfCookie = document.cookie.indexOf(";", y)) == -1)
						endOfCookie = document.cookie.length;

					return unescape( document.cookie.substring( y, endOfCookie ) );
				}

				x = document.cookie.indexOf(" ", x) + 1;

				if(x == 0)
					break;
			}

			return "";
		},

		/**
		* Byte check
		*/
		checkByte : function(content, bytes)
		{
			var conts = $("#"+content);
			var bytes = $("#"+bytes);
			var i = cnt = exceed = 0;
			var ch = "";

			for(i=0; i < conts.val().length; i++)
			{
				ch = conts.val().charAt(i);
				if(escape(ch).length > 4)
					cnt += 2;
				else
					cnt += 1;
			}
			bytes.html(cnt);
		},

		/**
		* Window Open
		*/
		winOpen : function(url, name, opt)
		{
			var popup = window.open(url, name, opt);
			popup.focus();
		},

		winOpen2 : function(url, name, w, h, scroll)
		{
			window.open(url, name, 'width='+w+',height='+h+',scrollbars='+scroll);
		},

		winPopup : function(url, w, h)
		{
			var width = w || 400,
				height = h || 500,
				params = [],
				win;

			params.push('menubar=no');
			params.push('resizable=no');
			params.push('scrollbars=no');
			params.push('status=no');
			params.push('width=' + width);
			params.push('height=' + height);

			var win = window.open(url, '_WINPOPUP_', params.join(','));
			if(win && win.focus) {
				win.focus();
			}
		},

		/**
		* Window Resize
		*/
		winResize : function(w, h)
		{
			var body = document.getElementsByTagName("body")[0];
			var pop_wrap = document.getElementById("pwrap");
			var clintAgent = navigator.userAgent;

			if(h == "")
				var h = pop_wrap.offsetHeight;

			if(clintAgent.indexOf("MSIE") != -1)
				window.resizeBy(w-body.clientWidth, h-body.clientHeight);
			else
				window.resizeBy(w-window.innerWidth, h-body.clientHeight);
		},

		/**
		* Images load Resize (그누보드 참조)
		*/
		loadImgResize : function(mw)
		{
			var obj = document.getElementsByName("objImage[]");
			var imgHeight = 0;

			if(obj)
			{
				for(var i=0; i < obj.length; i++)
				{
					obj[i].tmpW = obj[i].width;
					obj[i].tmpH = obj[i].height;

					if(obj[i].width > mw)
					{
						imgHeight = parseFloat(obj[i].width / obj[i].height);
						obj[i].width = mw;
						obj[i].height = parseInt(mw / imgHeight);
						obj[i].style.width = "";
						obj[i].style.height = "";

					}
				}
			}
		}
	};
})(window);
