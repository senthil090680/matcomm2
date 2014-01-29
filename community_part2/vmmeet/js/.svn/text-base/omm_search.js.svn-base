function searchMembers( memberRecord, rQuery, ageQuery, heightQuery, citizenQuery,countryQuery, eduQuery, maritalQuery, wPhotoQuery, subcasteQuery){
	//alert("Religion "+rQuery+"/ Age "+ageQuery+"/ Height "+heightQuery+"/ Citi "+citizenQuery+"/ Coun "+countryQuery+" / Edu "+eduQuery+"/ Marti "+ maritalQuery+"/ Photo "+ wPhotoQuery+"/ Subcaste "+subcasteQuery);
	
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
			
			if( withInRRange( memberRecord[i], rRange, rPosition ) && withInMRange( memberRecord[i], maritalRange, mPosition) && withInAgeRange( memberRecord[i], ageRange, agePosition) && withInHeightRange( memberRecord[i], heightRange, heightPosition) && withInSubcaste( memberRecord[i], subcaste, sPosition ) && withInEduRange( memberRecord[i], eduRange, eduPosition) && withInCtzRange( memberRecord[i], citizenRange, citizenPosition ) && withInCRange( memberRecord[i], countryRange, countryPosition ) && withPhoto( memberRecord[i], wPhoto, pPosition)) 
			{
				endResult[j]=memberRecord[i];
				j++;
				searchStatus = true;
			}

		}
		var t2 = new Date().getTime();

		if (searchStatus == false) endResult= "null";

		//alert(endResult);

		return endResult;
}


function withInCRange( resultRecord, range, elementPosition )
{
			if( range[0].toLowerCase() == "" ) return true;
			
			var memberCountry = getRecordElement( resultRecord, elementPosition );
			
			for ( var i=0; i<range.length; i++ )
			{
				if(memberCountry!="undefined" && memberCountry!="null" && memberCountry!="")
				{if ( memberCountry.toLowerCase() == range[i].toLowerCase() )
				return true; }
			}
			return false;
}

function withInCtzRange( resultRecord, range, elementPosition )
{
			if( range[0].toLowerCase() == "" ) return true;

			var memberCitizen = getRecordElement( resultRecord, elementPosition );
			
			//alert(memberCitizen);

			for ( var i=0; i<range.length; i++ )
			{
				if(memberCitizen!="undefined" && memberCitizen!="null" && memberCitizen!="")
				{if ( memberCitizen.toLowerCase() == range[i].toLowerCase() )
				return true; }
			}
			return false;
}

function withInEduRange( resultRecord, range, elementPosition )
{
	if( range[0].toLowerCase() == "" ) return true;
	var memberEducation = getRecordElement( resultRecord, elementPosition );
	for ( var i=0; i<range.length; i++ )
	{
		if(memberEducation!="undefined" && memberEducation!="null" && memberEducation!="")
		{if ( memberEducation.toLowerCase() == range[i].toLowerCase() )
		return true; }
	}
	return false;
}

function withInMRange( resultRecord, range, elementPosition )
{
			if( range[0].toLowerCase() == "" ) return true;

			var memberMarStatus = getRecordElement( resultRecord, elementPosition );
			
			for ( var i=0; i<range.length; i++ )
			{
				if(memberMarStatus!="undefined" && memberMarStatus!="null" && memberMarStatus!="")
				{if (memberMarStatus.toLowerCase() == range[i].toLowerCase() )
				return true; }
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

	
function withPhoto( resultRecord, wPhoto, pPosition )
{
	if( wPhoto[0].toLowerCase() == "yes")
		if(getRecordElement( resultRecord, pPosition ) == "-")
		return false;
	return true;
}

function withInSubcaste( resultRecord, subcaste, sPosition )
{
	if ( subcaste.toLowerCase() == "" )
	return true;

	var memberSubcaste = getRecordElement( resultRecord, sPosition );
	if( SoundEx( memberSubcaste ) == SoundEx( subcaste ))
	return true;
	return false;
}

function getRecordElement( resultRecord, position)
{	
	var memberDetail = resultRecord.split('~');
	//alert(memberDetail[position]);
	return memberDetail[position];
}
