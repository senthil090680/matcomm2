function funAddPrivilege(param){
      var frmName=document.frmPrivilege
      if(frmName.name.value != '' && frmName.name.value != 'Name' && frmName.phone.value != '' && frmName.phone.value != 'Phone number' && frmName.city.value != '' && frmName.city.value != 'City') {
	  parameters='name='+frmName.name.value+'&phone='+frmName.phone.value+'&city='+frmName.city.value;
      var argUrl='/site/addprivilege.php';
      objAjx=AjaxCall();AjaxPostReq(argUrl,parameters,"ajxRegPriRes",objAjx);
	  }
	  else if(frmName.name.value == '' || frmName.name.value == 'Name') {
		  alert("Please enter your name");
          frmName.name.focus();
	  }
	  else if(frmName.phone.value == '' || frmName.phone.value == 'Phone number') {
		  alert("Please enter phone number");
          frmName.phone.focus();
	  }
	  else {
          alert("Please enter your city");
		  frmName.city.focus();
	  }
}
function ajxRegPriRes(){
    if(objAjx.readyState==4)
	{
	 if(objAjx.status==200){
	   $('resultdiv').style.display='block';
     }else alert('There was a problem with the request.');
	 var frmName=document.frmPrivilege;
     frmName.name.value = 'Name';frmName.phone.value = 'Phone number';frmName.city.value = 'City';
	}
}