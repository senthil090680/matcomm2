var myloc = window.location.href;
var myloc1= myloc;
var myloc2=new Array();
myloc2 = myloc1.split('/');
var myappnd = myloc2[0] +"//"+myloc2[2];

function funBookmark(argMatriId)
{
	var varUrl = myappnd+"/bookmark-add/bookmarkId=" + argMatriId+"/";
	var newpopup=window.open(varUrl, "","top=300,left=300,menubar=no,toolbar=no,location=no,resizable=no,width=350,height=249,status=no,scrollbars=no,titlebar=no;");
	newpopup.focus();
}//funBookmark

function funProtectedPhoto(argMatrId)
{
	var funUrl = myappnd+"/search/protected-photo/" + argMatrId+"/";
	window.open(funUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=660,height=280,status=no,scrollbars=no,titlebar=no;");
}//funProtectedPhoto

function funViewPhoto(argMatrId)
{
	var funUrl = myappnd+"/search/view-photo/" + argMatrId+"/";
	window.open(funUrl, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=660,height=600,status=no,scrollbars=no,titlebar=no;");
}//funViewPhoto

function showbookmark(argUrl) {
	var funUrl =  myappnd+"/list/show-"+argMessage+"/" + argMatrId +"/";
	var newpopup=window.open(funUrl, "","top=300,left=300,menubar=no,toolbar=no,location=no,resizable=no,width=310,height=125,status=no,scrollbars=yes,titlebar=no;");
	newpopup.focus();
}

function funProfileHistoryFace(argMatriId)
{
	var funUrl = myappnd+"/messages/profile-history/" + argMatriId+"/";
	window.open(funUrl,'ProfileHistory','toolbar=no,scrollbars=yes,resizable=yes,width=500,height=200');
}//funProfileHistory

function funOpenDetailFace(argId)
{
	var divId		= 'detail_'+argId;
	var imageName	= 'collapsed'+argId;
	if(document.getElementById(divId).style.display=='none')
	{
		document.getElementById(imageName).src		="../images/expanded.gif";
		document.getElementById(divId).style.display='';
	}
	else if(document.getElementById(divId).style.display=='')
	{
		document.getElementById(imageName).src		="../images/collapsed.gif";
		document.getElementById(divId).style.display='none';
	}
}//funOpenDetail

function declineMessageFace(argMatriId) {
	window.open(myappnd+"/messages/message-decline/" + argFrom + "/" + argTo +"/", "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=415,height=165,top=280,left=300',status=no,scrollbars=yes,titlebar=no;");
}//iconshelppop

function funDisplayMailMessageFace(argMessegeId,argUsername,argFlag)
{
	var funUrl = myappnd+"/messages/my-sent-messege/"+argMessegeId+"/"+argUsername+"/"+argFlag+"/";
	window.open(funUrl, "","top=0,left=0,scrollbars=yes,menubar=no,toolbar=no,location=no,resizable=yes,width=598,height=500,status=no,titlebar=no;");
}//funDisplayMailMessage

function funInterestAcceptFace(frm)
{
	var funFormName = frm.name;
	window.open(myappnd+'/messages/interest-accept/' + funFormName +'/', "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=400,height=80,status=no,scrollbars=yes,titlebar=no;");
}//funInterestAccept

function funInterestDeclineFace(frm)
{
	var funFormName = frm.name;
	window.open(myappnd+'/messages/interest-decline/' + funFormName +'/', "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=520,height=260,status=no,scrollbars=yes,titlebar=no;");
}//funInterestAccept

function funForwardProfileFace(argMatriId)
{
	window.open(myappnd+'/search/profile-forward.php?id=' + argMatriId, "","top=0,left=0,menubar=no,toolbar=no,location=no,resizable=yes,width=583,height=458,status=no,scrollbars=yes,titlebar=no;");
}//funForwardProfile
