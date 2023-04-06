//=======================================================================================
// File Name	:	calendar.js
// Author		:	kkang(sinbiweb)
// Update		:	2011-07-01
// Description	:	Calendar Layer JavaScript 
//=======================================================================================
var now = new Date();
var static_now	= new Date();
var w = new Array("SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT");
var wIdx = new Array(1,2,3,4,5,6,7);
var eTagNm = "";
var eElement = "";
var calOpen = "n";
var thisObj = "";

function Calendar(e)
{
	var event = e || window.event;
	
	if(!appname)
		var appname = navigator.appName.charAt(0);

	if(appname == "M")
		eElement = event.srcElement;
	else
		eElement = event.target;
	
	eTagNm = eElement.tagName;
	var eX = event.clientX;
	var eY = event.clientY;

	if(calOpen == "n")
	{
		var NewDiv = document.createElement("div");
		with(NewDiv.style)
		{
			position = "absolute";
			left = eX+"px";
			top = eY+"px";
			width = "205px";
			height = "170px";
			background = "#ffffff";
			border = "0px"
		}
		NewDiv.id = "_CalId_";
		document.body.appendChild(NewDiv);
		thisObj = NewDiv;
		calOpen = "y";
	}
	else
	{
		thisObj.style.left = eX+"px";
		thisObj.style.top = eY+"px";
	}
	
	var vCal = SetCalendar();
}

function SetCalendar(val)
{
	var new_date = new Date();
	var p;
	var z=0;

	switch(val)
	{
		case 1: 
			now.setFullYear(now.getFullYear()-1);
		break;
		case 2:
			now.setMonth(now.getMonth()-1);
		break;
		case 3:
			now.setMonth(now.getMonth()+1);
		break;
		case 4:
			now.setFullYear(now.getFullYear()+1);
		break;
		case 5:
			now = new_date;
		break;
	}

	var Year = now.getFullYear();
	var Month = now.getMonth();
	var m_infoDate = Year+"/"+Month;

	var Last = new Date(now.getFullYear(), now.getMonth()+1, 1-1);	//해당월 마지막 일자
	var First = new Date(now.getFullYear(), now.getMonth(), 1);		//해당월 처음일자 요일

	var NowYear = now.getFullYear()+"";
	var calHtml = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:4px solid #ffffff;\">";
		calHtml += "<tr><td>";
		calHtml += "<table width=\"245\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"ffffff\" style=\"border:6px solid #78b300;\">";
		calHtml += "<tr height=\"26\" bgcolor=\"ffffff\" align=\"center\"><td style=\"padding-top:3px; padding-left:10px; \"> \n";
		calHtml += "<div class=\"calendarTitleY\">";
		calHtml += "<span onclick=\"SetCalendar(1)\" style='cursor:pointer;'>◀ </span>";
		calHtml += NowYear + "";
		calHtml += "<span onclick=\"SetCalendar(4)\" style='cursor:pointer;'> ▶</span></div> \n";
		calHtml += "<div class=\"calendarTitleM\">";
		calHtml += "<span onclick=\"SetCalendar(2)\" style='cursor:pointer;'>◀ </span>";
		calHtml += (now.getMonth()+1) + ""
		calHtml += "<span onclick=\"SetCalendar(3)\" style='cursor:pointer;'> ▶</span></div> \n";

	for(i=0; i < w.length; i++)
	{
		if(wIdx[i] == 1)
			calHtml += "<div class=\"calendarWeekS\">"+w[i]+"</div> \n";
		else if(wIdx[i] == 7)
			calHtml += "<div class=\"calendarWeekT\">"+w[i]+"</div> \n";
		else
			calHtml += "<div class=\"calendarWeek\">"+w[i]+"</div> \n";
	}

	calHtml += "<div class=\"clearboth\"></div> \n";

	for(i=1; i <= First.getDay(); i++)
		calHtml += "<div class=\"calendarNoDay\">&nbsp;</div> \n";

	z = (i-1);
	var cDay;
	var wCnt = 1;

	for(i=1; i <= Last.getDate(); i++)
	{
		z++;
		p=z%7;

		var pmon = now.getMonth()+1;
		pmon = (pmon < 10) ? "0"+pmon : pmon;
		var day = (i < 10) ? "0"+i : i;
		cDay = now.getFullYear() + "-" + pmon + "-" + day;

		if(i == now.getDate() && now.getFullYear() == static_now.getFullYear() && now.getMonth() == static_now.getMonth())
			calHtml += "<div class=\"calendarToDay\" onclick=\"CalendarIn('"+cDay+"');\">"+day+"</div> \n";
		else if(p == 0) //토요일
			calHtml += "<div class=\"calendarDayT\" onclick=\"CalendarIn('"+cDay+"');\">"+day+"</div> \n";
		else if(p == 1) //일요일
			calHtml += "<div class=\"calendarDayS\" onclick=\"CalendarIn('"+cDay+"');\">"+day+"</div> \n";
		else
			calHtml += "<div class=\"calendarDay\" onclick=\"CalendarIn('"+cDay+"');\">"+day+"</div> \n";

		if(p==0 && Last.getDate() != i)
		{
			calHtml += "<div class=\"clearboth\"></div> \n";
			wCnt++;
		}
	}
	
	if(p != 0)
	{
		for(i=p; i < 7; i++)
			calHtml += "<div class=\"calendarNoDay\">&nbsp;</div> \n";
	}
	
	var addTb1, addTb2;
	if(wCnt != 6)
	{
		for(addTb1=wCnt; addTb1 <6; addTb1++)
		{
			calHtml += "<div class=\"clearboth\"></div> \n";
			
			for(addTb2=0; addTb2 <7; addTb2++)
				calHtml += "<div class=\"calendarNoDay\">&nbsp;</div> \n";
		}
	}
	
	var nowDate = new_date.getFullYear()+ "-" + (100+(new_date.getMonth() + 1)).toString(10).substr(1) + "-" + (100+new_date.getDate()).toString(10).substr(1);
	calHtml += "<div class=\"clearboth\"></div> \n";
	calHtml += "<div class=\"calendarNow\" onclick=\"SetCalendar(5)\" align=\"left\">Today : "+nowDate+" </div> \n";
	calHtml += "<div class=\"calendarClose\" onClick=\"CalendarClose();\" align=\"right\"><font class=ver8><b>X</b></font></div> \n";
	calHtml += "</td></tr></table></td></tr></table> \n";
	
	thisObj.innerHTML = calHtml;
}

function CalendarClose()
{
	calOpen = "n";
	thisObj.parentNode.removeChild(thisObj);
}

function CalendarIn(date)
{
	if(eTagNm == "INPUT") 
		eElement.value = date;
	else
		eElement.innerHTML = date;

	CalendarClose();
}