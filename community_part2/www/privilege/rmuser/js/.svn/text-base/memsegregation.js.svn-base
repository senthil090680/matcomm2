function MemValidation(){		
		
		var memsegregation;
		var div1 = document.getElementById("submitactive");
		var div2 = document.getElementById("submitdisactive");
		
		memsegregation=document.memsegregation;

		if(!isselectChecked(document.getElementById("rmuser"),' Rmuser'))
		return false;	
		
		var selectedvalue = memsegregation.rmuser.options[memsegregation.rmuser.selectedIndex].value;

		var existingcount = document.getElementById(selectedvalue).value;

		if(!isCheckboxChecked(document.getElementsByName('members[]'),' members'))
		return false;

		var checkedcount = isCheckedcount(document.getElementsByName('members[]'));
		
		if(parseInt(existingcount)+parseInt(checkedcount) > 50) {
			alert("Members exceeded 25. Could not segregate to this Rmuser");
			return false;
		}

		div1.style.display = 'none';
		div2.style.display = '';

		return true;
}


function isCheckboxChecked(eleobj,str){	
	var len,flag;
	flag=0;
	for(var cnt=0;cnt<eleobj.length;cnt++)
	{			
		if(eleobj[cnt].checked)
		flag=1;
	}
	if(!flag)
	{
	  alert('please check '+str);		  
	  eleobj[0].focus();
	  return false;
	}
	return true;
}

function isCheckedcount(eleobj){	
	var len,flag;
	flag=0;
	for(var cnt=0;cnt<eleobj.length;cnt++)
	{			
		if(eleobj[cnt].checked)
		flag=1;
	}
	
	return flag;
}
