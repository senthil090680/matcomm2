function Validationphonelog(){		
		
		var rmuseraddition;
		
		rmuseraddition=document.rmuseraddition;

		if(!isselectChecked(document.getElementById("rmuser"),' Rmuser'))
		return false;	
		
		if(!isNoEmpty(document.getElementById("fromdate"),' fromdate'))
		return false;	

		if(!isNoEmpty(document.getElementById("todate"),' todate'))
		return false;		

		return true;
}