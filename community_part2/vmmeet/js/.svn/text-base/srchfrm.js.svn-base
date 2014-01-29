function childlivingstany()
	{	
		if ( MEETSRCH.MARITAL_STATUS[0].checked)
		{
			document.MEETSRCH.MARITAL_STATUS[1].checked=false;					
			document.MEETSRCH.MARITAL_STATUS[2].checked=false;					
			document.MEETSRCH.MARITAL_STATUS[3].checked=false;
			document.MEETSRCH.MARITAL_STATUS[4].checked=false;														
		}	
		else
		{
			if(document.MEETSRCH.MARITAL_STATUS[1].checked==true && document.MEETSRCH.MARITAL_STATUS[2].checked==true && document.MEETSRCH.MARITAL_STATUS[3].checked==true && document.MEETSRCH.MARITAL_STATUS[4].checked==true)
			{
				document.MEETSRCH.MARITAL_STATUS[1].checked=false;					
				document.MEETSRCH.MARITAL_STATUS[2].checked=false;					
				document.MEETSRCH.MARITAL_STATUS[3].checked=false;
				document.MEETSRCH.MARITAL_STATUS[4].checked=false;	
				document.MEETSRCH.MARITAL_STATUS[0].checked=true;					
			}

		}
	}
		
function childlivingst()
{	
		if ( MEETSRCH.MARITAL_STATUS[1].checked)
		{
			document.MEETSRCH.MARITAL_STATUS[0].checked=false;		
		}	
		else if ( MEETSRCH.MARITAL_STATUS[2].checked)
		{
			document.MEETSRCH.MARITAL_STATUS[0].checked=false;					
		}
		else if ( MEETSRCH.MARITAL_STATUS[3].checked)
		{
			document.MEETSRCH.MARITAL_STATUS[0].checked=false;					
		}	
		else if ( MEETSRCH.MARITAL_STATUS[4].checked)
		{
			document.MEETSRCH.MARITAL_STATUS[0].checked=false;					
		}				
		else if ( MEETSRCH.MARITAL_STATUS[0].checked)
		{
			document.MEETSRCH.MARITAL_STATUS[1].checked=false;					
			document.MEETSRCH.MARITAL_STATUS[2].checked=false;					
			document.MEETSRCH.MARITAL_STATUS[3].checked=false;
			document.MEETSRCH.MARITAL_STATUS[4].checked=false;														
		}				
	}

function ValidateNo( NumStr, String ) 
{
	for( var Idx = 0; Idx < NumStr.length; Idx ++ )
{
	 var Char = NumStr.charAt( Idx );
	 var Match = false;
	for( var Idx1 = 0; Idx1 < String.length; Idx1 ++) 
	{
	 if( Char == String.charAt( Idx1 ) ) 
	 Match = true;
	}
	if ( !Match ) 
	return false;
}
	return true;
}

function meetsrchvalidate()
{
		var MEETSRCH = this.document.MEETSRCH;
		var FINALAGE = MEETSRCH.ENDAGE.value - MEETSRCH.STAGE.value;		
		var stAge = 0; endAge = 0;
	 	if( MEETSRCH.STAGE.value == "" )
		{
		alert("Enter age range");
		MEETSRCH.STAGE.focus();
		return false;
		}
		else if( MEETSRCH.ENDAGE.value == "" )
		{
		alert("Enter age range");
		MEETSRCH.ENDAGE.focus();
		return false;
		}	
		
		if ( FINALAGE > 20 )
		{
			alert("The difference between a partner's \"From\" and \"To\" age should not exceed 20 years.");
			MEETSRCH.ENDAGE.focus( );
			return false;
		}
				
		//if ( !MEETSRCH.GENDER[0].checked && !MEETSRCH.GENDER[1].checked)
		//{
		//	alert( "Please select Gender" );
		//	MEETSRCH.GENDER[0].focus( );
		//	return false;
		//}

		if ( MEETSRCH.STAGE.value != "" && 
			!ValidateNo( MEETSRCH.STAGE.value, "0123456789" ) )
		{
			alert("Invalid Age " + MEETSRCH.STAGE.value);
			MEETSRCH.STAGE.focus( );
			return false;
		}
		else if ( MEETSRCH.STAGE.value != "" )
		{
			stAge = parseInt( MEETSRCH.STAGE.value );
			if ( stAge < 18 || stAge > 99 )
			{
				alert( "Invalid Age " +  MEETSRCH.STAGE.value + ".  Minimum age allowed is 18 and maximum age is 70" );
				MEETSRCH.STAGE.focus( );
				return false;
			}
		}
		
		if( MEETSRCH.ENDAGE.value != "" &&
			!ValidateNo( MEETSRCH.ENDAGE.value, "0123456789" ) )
		{
			alert("Invalid Age " + MEETSRCH.ENDAGE.value);
			MEETSRCH.ENDAGE.focus( );
			return false;
		}
		else if ( MEETSRCH.ENDAGE.value != "" )
		{
			endAge = parseInt( MEETSRCH.ENDAGE.value );
			if ( endAge < 18 || endAge > 99 )
			{
				alert( "Invalid Age " +  MEETSRCH.ENDAGE.value + ".  Minimum age allowed is 18 and maximum age is 70" );
				MEETSRCH.ENDAGE.focus( );
				return false;
			}

			if ( stAge != 0 && endAge < stAge )
			{
				alert( "Invalid age range. " + stAge + " to " + endAge );
				MEETSRCH.STAGE.focus( );
				return false;
			}
		}

		if (!MEETSRCH.MARITAL_STATUS[0].checked && !MEETSRCH.MARITAL_STATUS[1].checked && !MEETSRCH.MARITAL_STATUS[2].checked && !MEETSRCH.MARITAL_STATUS[3].checked && !MEETSRCH.MARITAL_STATUS[4].checked)
			{
				alert ("Please select the type of person you are looking For");
				MEETSRCH.MARITAL_STATUS[0].focus();
				return false;
			}
		
		if ( MEETSRCH.ENDHEIGHT.selectedIndex  < MEETSRCH.STHEIGHT.selectedIndex )
		{
			alert( "Invalid height range." );
			MEETSRCH.ENDHEIGHT.focus( );
			return false;
		}
		setSearch();
		return true;
}

//function to set the search form element to the hidden variable for ajax posting
function setSearch()
{
var search_string = '';

for(var j=0;j<document.MEETSRCH.MARITAL_STATUS.length;j++)
{
	if(document.MEETSRCH.MARITAL_STATUS[j].checked)
		{
		search_string += "&MARITAL_STATUS="+document.MEETSRCH.MARITAL_STATUS[j].value;
		}
}
search_string += "&STAGE="+document.MEETSRCH.STAGE.value;
search_string += "&ENDAGE="+document.MEETSRCH.ENDAGE.value;
search_string += "&STHEIGHT="+document.MEETSRCH.STHEIGHT.value;
search_string += "&ENDHEIGHT="+document.MEETSRCH.ENDHEIGHT.value;
search_string += "&SUBCASTE="+document.MEETSRCH.SUBCASTE.value;

var selRef = document.getElementById('EDUCATION1');
var edu_str = "";
for (var i=selRef.length-1; i >= 0;i--) {
if (selRef.options[i].selected) {
edu_str += selRef.options[i].value+"~";
}
}
edu_str = edu_str.substr(0,edu_str.length-1)
search_string += "&EDUCATION1="+edu_str;

search_string += "&CITIZENSHIP1="+document.MEETSRCH.CITIZENSHIP1.value;

var selRef = document.getElementById('COUNTRY1');
var con_str = "";
for (var i=selRef.length-1; i >= 0;i--) {
if (selRef.options[i].selected) {
con_str += selRef.options[i].value+"~";
}
}
con_str = con_str.substr(0,con_str.length-1);
search_string += "&COUNTRY1="+con_str;

search_string += "&SEARCH_TYPE="+document.MEETSRCH.SEARCH_TYPE.value;
if(document.MEETSRCH.PHOTO_OPT.checked)
{
	search_string += "&PHOTO_OPT="+document.MEETSRCH.PHOTO_OPT.value;
}
document.frmUserAct.search_con.value = search_string;
document.getElementById('stripFilter').style.display="block";
document.getElementById('memarea').innerHTML = "<font class='normaltxt1'>Refreshing list ... </font>";
MemRequest();
}

//clears the search string set in the hidden value
function showAllList()
{
document.frmUserAct.search_con.value = "";
document.getElementById('stripFilter').style.display="none";
MemRequest();
}