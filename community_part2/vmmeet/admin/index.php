<?php
#=============================================================================================================
# Author 		: Srinivasan.C
# Start Date	: 2010-06-23
# End Date		: 2010-06-30
# Project		: VirtualMatrimonyMeet
# Module		: Login
#=============================================================================================================
ini_set('display_errors',1);
error_reporting(E_ALL);
$varRootBasePath = dirname($_SERVER['DOCUMENT_ROOT']);
//FILE INCLUDES
 
include_once($varRootBasePath."/conf/config.inc");
include_once($varRootBasePath.'/conf/vars.inc');
include_once($varRootBasePath.'/conf/dbinfo.inc');
include_once($varRootBasePath.'/lib/clsDB.php');


//OBJECT DECLARATION
$objSlave = new DB;

//DB CONNECTION
$objSlave-> dbConnect('S',$varDbInfo['DATABASE']);

if(isset($_POST["submit"]))
{


$username  = mysql_escape_string(trim($_POST["username"]));	
$password  = mysql_escape_string(trim($_POST["password"]));


$varCondition		= " where username='$username' AND encryptedPassword='$password'";
$varFields			= array('username','encryptedPassword');
$varMemLoginDet	    = $objSlave->select($varOnlineSwayamvaramDbInfo['DATABASE'].'.'.$varTable['VMMUSERS'],$varFields,$varCondition,1);
$password           = strtolower($password);



if(count($varMemLoginDet)>0)
{
// User found proceed further
$cdomain = $_SERVER['SERVER_NAME'];
$cdomain = str_replace(array("www","bmser"),"",$cdomain);
setcookie("adminusername",$username,0,"/",$cdomain);
setcookie("adminpassword",$password,0,"/",$cdomain);
header("Location: main.php");
exit;
}
else
{
   $ErrMsg = "Username or Password is invalid ";
}
}


$varDomainName = 'communitymatrimony.com';
$domain_logo   = 'http://img.communitymatrimony.com/images/logo/community_logo.gif';

?>
<html>
<head>
<title>VMM Admin</title>
<link rel="stylesheet" href="http://<?=$_SERVER[SERVER_NAME];?>/styles/global-style.css">
<script>
function validate()
{
	var ClassifiedForm = this.document.ClassifiedForm;
	// Check E-mail
	if ( ClassifiedForm.username.value == "" )
	{
	alert( "Please Enter Username" );
	ClassifiedForm.username.focus( );
	return false;
	}

	// Check Password

	if ( ClassifiedForm.password.value == "" )
	{
	alert( "Please type your password." );
	ClassifiedForm.password.focus( );
	return false;
	}
	return true;
}
</script>
</head>
<body>
<center>
<!-- main body starts here -->
<div id="maincontainer" >
	<div id="container">
		<div class="main" >
			    
			    <div class="fleft logodiv">
				<a href="http://www.<?=$varDomainName;?>/"><img src="<?=$domain_logo;?>" alt="<?=$varDomainName;?>" border="0" /></a></div>
				<br clear="all" />
				<div class="innerdiv" >
				<img src="http://meet.communitymatrimony.com/images/headerimg.jpg" vspace="10" /><br><br>
				
				<center>
				<FORM name="ClassifiedForm" action="index.php" method=post onSubmit="return validate();">
                <div class="fright" style="width:771px;border:1px solid #EEEEEE">
     				<div style="padding-top:85px;"><b>Login to the Admin panel</b></div><br>
					<?php
					if(isset($ErrMsg))
					{
					echo "<div style='padding-left:140px;padding-bottom:10px;'><font class='smalltxt clr1'>$ErrMsg</font></div>";
					}
					?>
					
                    <div style="padding-left:102px;padding-bottom:10px;" class="smalltxt"><b>Username</b>&nbsp;&nbsp;<input type="text" class="inputtext" style="width:180px;" name="username" id="username" value="" tabindex="1" onKeyUp=""/></div>
					<div style="padding-left:103px;padding-bottom:10px;" class="smalltxt"><b>Password</b>&nbsp;&nbsp;<input type="password" class="inputtext" style="width:180px;" name="password" id="password" value="" maxlength=8  tabindex="2" size="32"/></div>
					<div style="padding-left:165px;padding-bottom:10px;" class="smalltxt"><img src="images/trans.gif" width="34" height="1" /><input type="submit" class="button" name="submit" value="Submit" tabindex="3"/></div>
				</FORM>
				</div></center>
				
			</div>
			<br clear="all"/><br>
			<div class="footdiv" style="background:url(http://img.<?=$varDomainName;?>/images/footerbg.gif) repeat-x;">
				<div class="footdiv1 padt10"><font class="smalltxt clr">	
					</font>
				</div>
				<div><center><font class="opttxt clr">Copyright &copy; 2010 Consim Info Pvt Ltd. All rights reserved.</font></center></div>
			</div>
		</div>
	</div>
</div>
</center>
</body>
</html>
</center>
</body>
</html>

