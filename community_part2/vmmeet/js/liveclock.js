var myfont_face = "Verdana";
var myfont_size = "10";
var myfont_color = "#000000";
var myback_color = "#FFFFFF";
var mypre_text = "The time is: ";
var mywidth = 300;
var my12_hour = 1;
var myupdate = 1;
var DisplayDate = 0;

var ie4=document.all
var ns4=document.layers
var ns6=document.getElementById&&!document.all

var dn = "";
var mn = "th";
var old = "";

var DaysOfWeek = new Array(7);
DaysOfWeek[0] = "Sunday";
DaysOfWeek[1] = "Monday";
DaysOfWeek[2] = "Tuesday";
DaysOfWeek[3] = "Wednesday";
DaysOfWeek[4] = "Thursday";
DaysOfWeek[5] = "Friday";
DaysOfWeek[6] = "Saturday";

var MonthsOfYear = new Array(12);
		MonthsOfYear[0] = "January";
		MonthsOfYear[1] = "February";
		MonthsOfYear[2] = "March";
		MonthsOfYear[3] = "April";
		MonthsOfYear[4] = "May";
		MonthsOfYear[5] = "June";
		MonthsOfYear[6] = "July";
		MonthsOfYear[7] = "August";
		MonthsOfYear[8] = "September";
		MonthsOfYear[9] = "October";
		MonthsOfYear[10] = "November";
		MonthsOfYear[11] = "December";


	var ClockUpdate = new Array(3);
		ClockUpdate[0] = 0;
		ClockUpdate[1] = 1000;
		ClockUpdate[2] = 60000;

// For Version 4+ browsers, write the appropriate HTML to the
// page for the clock, otherwise, attempt to write a static
// date to the page.
	if (ie4||ns6) { document.write('<span id="LiveClockIE" style="width:'+mywidth+'px; background-color:'+myback_color+'"></span>'); }
	else if (document.layers) { document.write('<ilayer bgColor="'+myback_color+'" id="ClockPosNS" visibility="hide"><layer width="'+mywidth+'" id="LiveClockNS"></layer></ilayer>'); }
	else { old = "true"; show_clock(curday); }


// The main part of the script:
	function show_clock() {
	
		if (old == "die") { return; }
	
	//show clock in NS 4
		if (ns4)
        document.ClockPosNS.visibility="show"
	// Get all our date variables:
		var Digital = new Date(curday);
		
		var day = Digital.getDay();
		
		var mday = Digital.getDate();
		
		var month = Digital.getMonth();
		
		var hours = Digital.getHours();
		//alert(hours)
		var minutes = Digital.getMinutes();
		//alert(minutes)
		var seconds = Digital.getSeconds();
		//alert(seconds)
	
	// Fix the "mn" variable if needed:
		if (mday == 1) { mn = "st"; }
		else if (mday == 2) { mn = "nd"; }
		else if (mday == 3) { mn = "rd"; }
		else if (mday == 21) { mn = "st"; }
		else if (mday == 22) { mn = "nd"; }
		else if (mday == 23) { mn = "rd"; }
		else if (mday == 31) { mn = "st"; }

	// Set up the hours for either 24 or 12 hour display:
		if (my12_hour) {
			dn = "AM";
			if (hours > 12) { dn = "PM"; hours = hours - 12; }
			if (hours == 0) { hours = 12; }
		} else {
			dn = "";
		}
		if (minutes <= 9) { minutes = "0"+minutes; }
		if (seconds <= 9) { seconds = "0"+seconds; }

	// This is the actual HTML of the clock. If you're going to play around
	// with this, be careful to keep all your quotations in tact.
		myclock = '';
		myclock += '<font style="color:'+myfont_color+'; font-family:'+myfont_face+'; font-size:'+myfont_size+'pt;">';
		myclock += mypre_text;
		myclock += hours+':'+minutes;
		if ((myupdate < 2) || (myupdate == 0)) { myclock += ':'+seconds; }
		myclock += ' '+dn;
		if (DisplayDate) { myclock += ' on '+DaysOfWeek[day]+', '+mday+mn+' '+MonthsOfYear[month]; }
		myclock += '</font>';

		if (old == "true") {
			document.write(myclock);
			old = "die";
			return;
		}

	// Write the clock to the layer:
		if (ns4) {
			clockpos = document.ClockPosNS;
			liveclock = clockpos.document.LiveClockNS;
			liveclock.document.write(myclock);
			liveclock.document.close();
		} else if (ie4) {
			LiveClockIE.innerHTML = myclock;
		} else if (ns6){
			document.getElementById("LiveClockIE").innerHTML = myclock;
                }            

	if (myupdate != 0) { setTimeout("show_clock1()",ClockUpdate[myupdate]); }
}

function show_clock1()
{
	show_clock(curday);
}