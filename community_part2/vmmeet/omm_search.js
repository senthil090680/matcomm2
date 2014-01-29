function searchMembers( memberRecord, rQuery, ageQuery, heightQuery, citizenQuery,countryQuery, eduQuery, maritalQuery, wPhotoQuery, subcasteQuery){

		var endResult = new Array();
		var searchStatus = false;
		var maritalRange = maritalQuery.split('~');
		var mPosition = 1;
		var ageRange = ageQuery.split('~');
		var agePosition = 2;
		var heightRange = heightQuery.split('~');
		var heightPosition = 3;
		var rRange = rQuery.split('~');
		var rPosition = 4;
		var subcaste = subcasteQuery;
		var sPosition = 6;
		var citizenRange = citizenQuery.split('~');
		var citizenPosition = 7;
		var eduRange = eduQuery.split('~');
		var eduPosition = 8;
		var countryRange = countryQuery.split('~');
		var countryPosition = 9;
		var wPhoto = wPhotoQuery.split('~');
		var pPosition = 12;
		var j = 0;
 
		for( var i=0; i<memberRecord.length; i++)
		{
			var t1 = new Date().getTime();
			//if( basicQuery.toLowerCase().indexOf("any") != -1 || memberRecord[i].toLowerCase().indexOf( //basicQuery.toLowerCase() ) != -1 ) 
			if( withInRRange( memberRecord[i], rRange, rPosition ) ) 
			{ 
				if(withInSubcaste( memberRecord[i], subcaste, sPosition ))
				{
					if (withInRange( memberRecord[i], countryRange, countryPosition ))
					{
						if (withInRange( memberRecord[i], citizenRange, citizenPosition ))
						{
							if (withInRange( memberRecord[i], eduRange, eduPosition))
							{
								if (withInRange( memberRecord[i], maritalRange, mPosition))
								{
									if(withInAgeRange( memberRecord[i], ageRange, agePosition) && withInHeightRange( memberRecord[i], heightRange, heightPosition) && withPhoto( memberRecord[i], wPhoto, pPosition) )
										{  
											endResult[j]=i;
											j++;
											searchStatus = true;
										}
								}					
							}				
						}
					}		
				}
			}
		}

		var t2 = new Date().getTime();

		//alert(t2-t1);
		if (searchStatus == false) endResult = "null";
		
		return endResult;
}

function withInRange( resultRecord, range, elementPosition ){

			if( range[0].toLowerCase() == "any" ) return true;
			var memberCountry = getRecordElement( resultRecord, elementPosition );
			for ( var i=0; i<range.length; i++ )
			{
				if ( memberCountry.toLowerCase() == range[i].toLowerCase() )
				return true; 
			}
			return false;
}

function withInRRange( resultRecord, range, elementPosition ){

			if( range[0].toLowerCase() == "any" || range[0].toLowerCase() == "false" ) return true;
			var memberReligion = getRecordElement( resultRecord, elementPosition );
			for ( var i=0; i<range.length; i++ )
			{
				if ( memberReligion.toLowerCase() == range[i].toLowerCase() )
				return true; 
			}
			return false;
}

function withInAgeRange( resultRecord, ageRange, agePosition ){
			
			var memberAge = getRecordElement( resultRecord, agePosition );
			if( memberAge >= parseInt( ageRange[0] ) && memberAge <= parseInt( ageRange[1]))
				return true;
			return false;
}

function withInHeightRange( resultRecord, heightRange, heightPosition ){
			
			var memberHeight = getRecordElement( resultRecord, heightPosition );
		
			if( parseFloat(memberHeight) >= parseFloat( heightRange[0] ) && parseFloat(memberHeight) <= parseFloat( heightRange[1]))
				return true;
			return false;
}

	
function withPhoto( resultRecord, wPhoto, pPosition ){

			if( wPhoto[0].toLowerCase() == "yes")
				if(getRecordElement( resultRecord, pPosition ) == "-")
						return false;
			return true;
	
}

function withInSubcaste( resultRecord, subcaste, sPosition ){
	
	if ( subcaste.toLowerCase() == "any" )
	return true;

	var memberSubcaste = getRecordElement( resultRecord, sPosition );
	if( SoundEx( memberSubcaste ) == SoundEx( subcaste ) )
		return true;
	return false;
	
}

function getRecordElement( resultRecord, position ){
	
			var memberDetail = resultRecord.split('~');
			return memberDetail[position];

}
