<?php
switch($argGroupbyField)
{
	case "Faceting" :			
		$ageArray[$varAgeFrom." yrs to ".$varAgeTo." yrs "] = $varTotCount;
		$heightArray[$arrHeightFeetList[$varHeightFrom]." to ".$arrHeightFeetList[$varHeightTo]] = $varTotCount;
		$facetingArray["Age"]		= $ageArray;
		$facetingArray["Height"]	= $heightArray;
	
	case "Physical_Status" :
	case "Faceting" :
		if($argGroupbyField == "Physical_Status"){
			$s->SetLimits(0,2);
			$s->ResetFilterbyAttr("Physical_Status");
		}else{
			$s->SetLimits(0,2);
		}
		
		$s->ResetGroupby();
		$s->SetGroupBy("Physical_Status",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery, $argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Physical_Status";
		}
		if($argGroupbyField == "Physical_Status")
		{	
			$physicalResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$physicalCount = getCountValue($physicalResult,"Physical_Status");
			$arrSrchProfiles['groupcnt']=$physicalCount;
			break;
		}

	case "Marital_Status" :
	case "Faceting" :
		if($argGroupbyField == "Marital_Status"){
			$s->SetLimits(0,10);
			$s->ResetFilterbyAttr("Marital_Status");
		}else{
			$s->SetLimits(0,6);
		}
		
		$s->ResetGroupby();
		$s->SetGroupBy("Marital_Status",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery, $argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Marital_Status";
		}
		if($argGroupbyField == "Marital_Status")
		{	
			$maritalResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$maritalCount = getCountValue($maritalResult,"Marital_Status");
			unset($maritalCount["Marital_Status"][0]);
			$arrSrchProfiles['groupcnt']=$maritalCount;
			break;
		}
	
	case "Religion" :
	case "Faceting" :
	if($arrFaceting["Religion"]==1 && $arrOption['Religion']==1){
		if($argGroupbyField == "Religion"){
			$s->SetLimits(0,15);
			$s->ResetFilterbyAttr("Religion");
		}else{
			$s->SetLimits(0,6);
		}
		
		$s->ResetGroupby();
		$s->SetGroupBy("Religion",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery, $argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Religion";
		}
		if($argGroupbyField == "Religion")
		{	
			$religionResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$religionCount = getCountValue($religionResult,"Religion");
			unset($religionCount["Religion"][0]);
			$arrSrchProfiles['groupcnt']=$religionCount;
			break;
		}
	}

	case "Denomination" :
	case "Faceting" :
	if($arrFaceting["Denomination"]==1 && $arrOption['Denomination']==1){
		if($argGroupbyField == "Denomination"){
			$s->SetLimits(0,20);
			$s->ResetFilterbyAttr("Denomination");
		}else{
			$s->SetLimits(0,10);
		}
		
		$s->ResetGroupby();
		$s->SetGroupBy("Denomination",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery, $argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Denomination";
		}
		if($argGroupbyField == "Denomination")
		{	
			$denominationResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$denominationCount = getCountValue($denominationResult,"Denomination");
			unset($denominationCount["Denomination"][0]);
			$arrSrchProfiles['groupcnt']=$denominationCount;
			break;
		}
	}

	case "CasteId" :
	case "Faceting" :
	if($arrFaceting["Caste"]==1 && $arrOption['Caste']==1){
		if($argGroupbyField == "CasteId"){
			$s->SetLimits(0,300);
			$s->ResetFilterbyAttr("CasteId");
		}else{
			$s->SetLimits(0,12);
		}
		
		$s->ResetGroupby();
		$s->SetGroupBy("CasteId",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery, $argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "CasteId";
		}
		if($argGroupbyField == "CasteId")
		{	
			$casteResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$casteCount = getCountValue($casteResult,"CasteId");
			unset($casteCount["CasteId"][0]);
			$arrSrchProfiles['groupcnt']=$casteCount;
			break;
		}
	}

	case "SubcasteId" :
	case "Faceting" :
	if($arrFaceting["Subcaste"]==1 && $arrOption['Subcaste']==1){
		if($argGroupbyField == "SubcasteId"){
			$s->SetLimits(0,150);
			$s->ResetFilterbyAttr("SubcasteId");
		}else{
			$s->SetLimits(0,10);
		}
		
		$s->ResetGroupby();
		$s->SetGroupBy("SubcasteId",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery, $argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "SubcasteId";
		}
		if($argGroupbyField == "SubcasteId")
		{	
			$subcasteResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$subcasteCount = getCountValue($subcasteResult,"SubcasteId");
			unset($subcasteCount["SubcasteId"][0]);
			$arrSrchProfiles['groupcnt']=$subcasteCount;
			break;
		}
	}
	
	case "Faceting" :
	if($varAnnualIncome!='' && $varAnnualIncome>0 && $varAnnualIncome1>$varAnnualIncome){
		$s->ResetGroupby();
		$s->SetLimits(0,1);
		$s->setFilterRange("Annual_Income_INR", $varAnnualIncome, $varAnnualIncome1);
		$s->SetGroupBy("Publish",SPH_GROUPBY_ATTR,"@count desc");
		$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
		$facetNameArr[] = "Annual_Income_INR";
	}else{
		$s->ResetGroupby();
		$s->SetLimits(0,1);
		$s->SetFilterRange("Annual_Income_INR",100000,300000);
		$s->SetGroupBy("Publish",SPH_GROUPBY_ATTR,"@count desc");
		$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
		$facetNameArr[] = "Annual_Income_INR1";

		$s->ResetGroupby();	
		$s->ResetFilterbyAttr("Annual_Income_INR");
		$s->SetFilterRange("Annual_Income_INR",300000,500000);
		$s->SetGroupBy("Publish",SPH_GROUPBY_ATTR,"@count desc");
		$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);								
		$facetNameArr[] = "Annual_Income_INR2";

		$s->ResetGroupby();
		$s->ResetFilterbyAttr("Annual_Income_INR");						
		$s->SetFilterRange("Annual_Income_INR",500000,1000000);
		$s->SetGroupBy("Publish",SPH_GROUPBY_ATTR,"@count desc");
		$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);						
		$facetNameArr[] = "Annual_Income_INR3";
		
		$s->ResetGroupby();
		$s->ResetFilterbyAttr("Annual_Income_INR");
	}
	
	case "Mother_TongueId" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,15);
		else
		{
			$s->ResetFilterbyAttr("Mother_TongueId");
			$s->SetLimits(0,70);
		}
		$s->ResetGroupby();
		$s->SetGroupBy("Mother_TongueId",SPH_GROUPBY_ATTR,"@count desc");
		
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);					
			$facetNameArr[] = "Mother_TongueId";
		}
		else
		{
			$motherToungeResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$motherToungeCount  = getCountValue($motherToungeResult,"Mother_TongueId");
			unset($motherToungeCount["Mother_TongueId"][0]);					
			$arrSrchProfiles['groupcnt'] = $motherToungeCount;
			break;
		}
	
	case "GothramId" :
	case "Faceting" :
	if($arrFaceting["Gothram"]==1 && $arrOption['Gothram']==1)
	{
		if($argGroupbyField == "Faceting")
			{$s->SetLimits(0,10);}
		else
		{
			/* Need to reset the query if exist */
			$s->ResetFilterbyAttr("GothramId");
			$s->SetLimits(0,60);
		}

		$s->ResetGroupby();
		$s->SetGroupBy("GothramId",SPH_GROUPBY_ATTR,"@count desc");
		
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							
			$facetNameArr[] = "GothramId";
		}
		else
		{
			$gothramResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							 
			$gothramCount = getCountValue($gothramResult,"GothramId");							
			unset($gothramCount["GothramId"][0]);							
			$arrSrchProfiles['groupcnt'] = $gothramCount;
			break;
		}
	}

	case "Star" :
	case "Faceting" :
	if($arrFaceting["Star"]==1 && $arrOption['Star']==1)
	{
		if($argGroupbyField == "Faceting")
			{$s->SetLimits(0,10);}
		else
		{
			/* Need to reset the query if exist */
			$s->ResetFilterbyAttr("Star");
			$s->SetLimits(0,50);
		}

		$s->ResetGroupby();
		$s->SetGroupBy("Star",SPH_GROUPBY_ATTR,"@count desc");
		
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							
			$facetNameArr[] = "Star";
		}
		else
		{
			$starResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							 
			$starCount = getCountValue($starResult,"Star");							
			$arrSrchProfiles['groupcnt'] = $starCount;
			break;
		}
	}
	
	case "Resident_Status" :
	case "Faceting" :
		if((count($arrCountry)==1 && $arrCountry[0]!=98) || count($arrCountry)>1){
			if($argGroupbyField == "Faceting")
			{ $s->SetLimits(0,6);}
			else
			{
				$s->ResetFilterbyAttr("Resident_Status2");
				$s->SetLimits(0,8);
			}

			$s->ResetGroupby();
			$s->SetGroupBy("Resident_Status2",SPH_GROUPBY_ATTR,"@count desc");
			
			if($argGroupbyField == "Faceting")
			{
				$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							
				$facetNameArr[] = "Resident_Status";
			}
			else
			{
				$residentResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							 
				$residentCount  = getCountValue($residentResult,"Resident_Status");
				$residentCount["Resident_Status"][1] += $residentCount["Resident_Status"][100];
				unset($residentCount["Resident_Status"][100], $residentCount["Resident_Status"][0]);							
				$arrSrchProfiles['groupcnt'] = $residentCount;
				break;
			}
		}	

	case "Profile_Created_By" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
		{ $s->SetLimits(0,6);}
		else
		{
			$s->ResetFilterbyAttr("Profile_Created_By");
			$s->SetLimits(0,8);
		}

		$s->ResetGroupby();
		$s->SetGroupBy("Profile_Created_By",SPH_GROUPBY_ATTR,"@count desc");
		
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							
			$facetNameArr[] = "Profile_Created_By";
		}
		else
		{
			$createdByResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);							 
			$createdByCount  = getCountValue($createdByResult,"Profile_Created_By");							
			unset($createdByCount["Profile_Created_By"][0]);							
			$arrSrchProfiles['groupcnt'] = $createdByCount;
			break;
		}
	
	case "Chevvai_Dosham" :
	case "Faceting" :
	if($arrFaceting['Dosham'] == 1)
	{
		if($argGroupbyField == "Chevvai_Dosham")
		{ $s->ResetFilterbyAttr("Chevvai_Dosham"); }

		$s->ResetGroupby();
		$s->SetGroupBy("Chevvai_Dosham",SPH_GROUPBY_ATTR,"@count desc");
		
		if($argGroupbyField == "Faceting")
		{
			$s->SetLimits(0,5);
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);						
			$facetNameArr[] = "Chevvai_Dosham";
		}
		else
		{
			$s->SetLimits(0,4);
			$doshamResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$doshamCount = getCountValue($doshamResult,"Chevvai_Dosham");
			if($doshamCount["Chevvai_Dosham"][0] > 0)
			{
				$doshamCount["Chevvai_Dosham"][99] = $doshamCount["Chevvai_Dosham"][0];
				unset($doshamCount["Chevvai_Dosham"][0]);
			}
			$arrSrchProfiles['groupcnt'] = $doshamCount;
			break;
		}
	}
	
	case "Education_Category" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,10);
		else
		{
			$s->ResetFilterbyAttr("Education_Category");
			$s->SetLimits(0,30);
		}

		$s->ResetGroupby();
		$s->SetGroupBy("Education_Category",SPH_GROUPBY_ATTR,"@count desc");

		if($argGroupbyField == "Faceting")
		{	
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Education_Category";
		}
		else
		{
			$eduCtResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);					
			$eduCount = getCountValue($eduCtResult,"Education_Category");
			unset($eduCount["Education_Category"][0]);
			$arrSrchProfiles['groupcnt']= $eduCount;
			break;
		}


	case "Employed_In" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,8);
		else
		{
			$s->ResetFilterbyAttr("Employed_In");
			$s->SetLimits(0,10);
		}
		$s->ResetGroupby();
		$s->SetGroupBy("Employed_In",SPH_GROUPBY_ATTR,"@count desc");

		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Employed_In";
		}
		else
		{
			$empinResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$empinCount = getCountValue($empinResult,"Employed_In");
			/* Unset the values of Not Working and Business from employed in as they were included in occupation category */
			unset($empinCount["Employed_In"][0], $empinCount["Employed_In"][4], $empinCount["Employed_In"][5]);
			$arrSrchProfiles['groupcnt']= $empinCount;
			break;
		}
	

	case "Occupation"	:
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,10);
		else
		{
			$s->ResetFilterbyAttr("Occupation");
			$s->SetLimits(0,80);
		}
		$s->ResetGroupby();
		$s->SetGroupBy("Occupation",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Occupation";
		}
		else
		{
			$occupationResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$occupationCount = getCountValue($occupationResult,"Occupation");	
			//Show Not Working as last option				
			if($occupationCount["Occupation"][102] > 0)
			{
				$temOccSel = $occupationCount["Occupation"][102];				
				unset($occupationCount["Occupation"][102]);
				$occupationCount["Occupation"][102] = $temOccSel;
			}					
			unset($occupationCount["Occupation"][0]);
			$arrSrchProfiles['groupcnt']= $occupationCount;
			break;
		}


	case "Body_Type" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,5);
		if($argGroupbyField == "Body_Type")
		{
			$s->ResetFilterbyAttr("Body_Type");
			$s->SetLimits(0,8);
		}
						
		$s->ResetGroupby();
		$s->SetGroupBy("Body_Type",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{				
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Body_Type";
		}
		else
		{
			$bodyResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$bodyCount = getCountValue($bodyResult,"Body_Type");
			if(isset($bodyCount['Body_Type'][0]) && $bodyCount['Body_Type'][0] > 0)
			{
				$bodyCount['Body_Type'][99] = $bodyCount['Body_Type'][0];
				unset($bodyCount['Body_Type'][0]);
			}
			$arrSrchProfiles['groupcnt'] = $bodyCount;
			break;
		}			

	case "Complexion" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,5);
		if($argGroupbyField == "Complexion")
		{
			$s->ResetFilterbyAttr("Complexion");
			$s->SetLimits(0,8);
		}
						
		$s->ResetGroupby();
		$s->SetGroupBy("Complexion",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{				
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Complexion";
		}
		else
		{
			$bodyResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$bodyCount = getCountValue($bodyResult,"Complexion");
			if(isset($bodyCount['Complexion'][0]) && $bodyCount['Complexion'][0] > 0)
			{
				$bodyCount['Complexion'][99] = $bodyCount['Complexion'][0];
				unset($bodyCount['Complexion'][0]);
			}
			$arrSrchProfiles['groupcnt'] = $bodyCount;
			break;
		}

	case "Eating_Habits" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,5);
		if($argGroupbyField == "Eating_Habits")
		{
			$s->ResetFilterbyAttr("Eating_Habits");
			$s->SetLimits(0,6);
		}
						
		$s->ResetGroupby();
		$s->SetGroupBy("Eating_Habits",SPH_GROUPBY_ATTR,"@count desc");
									
		if($argGroupbyField == "Faceting")
		{					
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Eating_Habits";
		}
		else
		{
			$eatResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$eatCount = getCountValue($eatResult,"Eating_Habits");
			if($eatCount['Eating_Habits'][0] > 0)
			{
				$eatCount['Eating_Habits'][99] = $eatCount['Eating_Habits'][0];
				unset($eatCount['Eating_Habits'][0]);
			}					
			$arrSrchProfiles['groupcnt'] = $eatCount;
			break;
		}
	
	case "Smoke" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,5);
		if($argGroupbyField == "Smoke")
		{
			$s->ResetFilterbyAttr("Smoke");
			$s->SetLimits(0,6);
		}
						
		$s->ResetGroupby();
		$s->SetGroupBy("Smoke",SPH_GROUPBY_ATTR,"@count desc");
									
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);					
			$facetNameArr[] = "Smoke";
		}
		else
		{
			$smokeResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$smokeCount = getCountValue($smokeResult,"Smoke");
			if($smokeCount['Smoke'][0] > 0)
			{					
				$smokeCount['Smoke'][99] = $smokeCount['Smoke'][0];
				unset($smokeCount['Smoke'][0]);
			}	
			$arrSrchProfiles['groupcnt'] = $smokeCount;
			break;
		}	

	case "Drink" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,5);
		if($argGroupbyField == "Drink")
		{
			$s->ResetFilterbyAttr("Drink");
			$s->SetLimits(0,6);
		}
						
		$s->ResetGroupby();
		$s->SetGroupBy("Drink",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{					
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Drink";
		}
		else
		{
			$drinkResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$drinkCount = getCountValue($drinkResult,"Drink");
			if($drinkCount['Drink'][0] > 0)
			{
				$drinkCount['Drink'][99] = $drinkCount['Drink'][0];
				unset($drinkCount['Drink'][0]);
			}
			$arrSrchProfiles['groupcnt'] = $drinkCount;
			break;
		}
	
	case "Citizenship" :
	case "Faceting" :
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,5);
		if($argGroupbyField == "Citizenship")
		{
			$s->ResetFilterbyAttr("Citizenship");
			$s->SetLimits(0,250);
		}
						
		$s->ResetGroupby();
		$s->SetGroupBy("Citizenship",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{					
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Citizenship";
		}
		else
		{
			$citizenResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$citizenCount = getCountValue($citizenResult,"Citizenship");
			$arrSrchProfiles['groupcnt'] = $citizenCount;
			break;
		}
	
	case "Country" :
	case "Faceting" :
		
		if($argGroupbyField == "Faceting")
			$s->SetLimits(0,5);
		if($argGroupbyField == "Country")
		{
			$s->ResetFilterbyAttr("Country");
			$s->SetLimits(0,250);
		}
						
		$s->ResetGroupby();
		$s->SetGroupBy("Country",SPH_GROUPBY_ATTR,"@count desc");
						
		if($argGroupbyField == "Faceting")
		{					
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$facetNameArr[] = "Country";
		}
		else
		{
			$countryResult = $s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
			$countryCount = getCountValue($countryResult,"Country");
			$arrSrchProfiles['groupcnt'] = $countryCount;
			break;
		}
	
	case "Residing_State" :
	case "Faceting" :
		if(in_array(98, $arrCountry) || in_array(222, $arrCountry)){
			if($argGroupbyField == "Faceting"){
				$s->SetLimits(0,10);
				$s->ResetGroupby();
				$s->SetGroupBy("Residing_State",SPH_GROUPBY_ATTR,"@count desc");
				
				//To show only the selected state and ignore the setselect.
				$varStateSelect = 0;
				if(count($arrResidingState) > 1 || (count($arrResidingState)==1 && $arrResidingState[0]!=0)){
					$varStateSelect = 1;
					$s->SetFilter("Residing_State",$arrResidingState);
				}

				$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
				
				if($varStateSelect == 1){ $s->ResetFilterbyAttr("Residing_State");}

				$facetNameArr[] = 'Residing_State';	

			}else if($argGroupbyField == "Residing_State"){
				$stateObj = clone $s;
							
				$stateObj->SetSelect("*");
				$stateObj->ResetFilterbyAttr("locationfilter");
				
				$stateObj->ResetFilterByAttr("Country");
				$stateObj->SetFilter("Country", $arrCountry);												
				$stateObj->ResetFilterbyAttr("Residing_State");
				$stateObj->SetLimits(0,100);
				
				$stateObj->ResetGroupby();
				$stateObj->SetGroupBy("Residing_State",SPH_GROUPBY_ATTR,"@count desc");						
				$stateResult=$stateObj->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
				
				$stateCount = getCountValue($stateResult,"Residing_State");
				
				//The state field will be 0 for entries with country not in (98,222)
				unset($stateCount["Residing_State"][0]);
				
				$arrSrchProfiles['groupcnt']= $stateCount;
				break;
				
			}
		}	
		
	case "Residing_District" :
	case "Faceting" :
		global $arrResidingStateList;
		// Use Array intersect function to check if the state selected is an Indian State 
		$compStateArr = array_intersect($arrResidingState,array_keys($arrResidingStateList));
		
		if(count($compStateArr) > 0 && in_array(98, $arrCountry)){
			if($argGroupbyField == "Faceting"){										
				$s->SetLimits(0,10);
				$s->ResetGroupby();
					
				//To show only the selected state and ignore the setselect.
				$varCityEna = 0;
				if(count($arrResidingCity) > 1 || (count($arrResidingCity) == 1 && $arrResidingCity[0] != 0))
				{
					$varCityEna = 1;
					$arrCity = array();
					foreach($arrResidingCity as $key=>$value)
					{
						$cityArr = explode("#",$value);
						$arrCity[] = $cityArr[1]; 	
					}	
					$s->SetFilter("Residing_District",$arrCity);
				}	
				
				$s->SetGroupBy("Residing_District",SPH_GROUPBY_ATTR,"@count desc");
				$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);

				//To show only the selected state and ignore the setselect.
				if($varCityEna == 1)
				$s->ResetFilterbyAttr("Residing_District");
											
				$facetNameArr[] = "Residing_District";

			}else if($argGroupbyField == "Residing_District"){

				$cityObj = clone $s;
				
				$cityObj->SetSelect("*");
				$cityObj->ResetFilterbyAttr("locationfilter");
				
				$cityObj->SetFilter("Residing_State", $arrResidingState);						
				$cityObj->SetLimits(0,700);
				
				$cityObj->ResetGroupby();
				$cityObj->SetGroupBy("Residing_District",SPH_GROUPBY_ATTR,"@count desc");
				$cityResult=$cityObj->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);

				$cityCount = getCountValue($cityResult,"Residing_District");
				
				unset($cityCount["Residing_District"][0]);
				$arrSrchProfiles['groupcnt']= $cityCount;
				break;
				
			}	
	}
		
	case "Profiletype":
	case "Faceting" :
		if($argGroupbyField == "Profiletype")
		{
			$s->ResetFilterbyAttr("Photo_Set_Status");
			$s->ResetFilterbyAttr("Horoscope_Available");
		}	
		$s->SetLimits(0,5);
		$s->ResetGroupby();
		$s->SetGroupBy("Photo_Set_Status",SPH_GROUPBY_ATTR,"@count desc");					
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);						
			$facetNameArr[] = "Photo_Set_Status";	
		}
		else
		{
			$withphotoCtResult=$s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-Photo_Set_Status");
			$withphotoCount = getCountValue($withphotoCtResult,"Photo_Set_Status");	
		}					
		
		$s->SetLimits(0,5);	
		$s->ResetGroupby();
		$s->SetGroupBy("Horoscope_Available",SPH_GROUPBY_ATTR,"@count desc");					
		if($argGroupbyField == "Faceting")
		{
			$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);									
			$facetNameArr[] = "Horoscope_Available";							
		}
		else
		{
			$withhorosCtResult=$s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-Horoscope_Available");
			$withhorosCount = getCountValue($withhorosCtResult,"Horoscope_Available");				
			$profileType["Profiletype"][0] = $withphotoCount["Photo_Set_Status"][1];
			$profileType["Profiletype"][1] = $withhorosCount["Horoscope_Available"][1]+$withhorosCount["Horoscope_Available"][3];
			
			$arrSrchProfiles['groupcnt']=$profileType;
			break;
		}
	
	case "Active" :
	case "Faceting" :
	if($argGroupbyField=='Active'){
		$s->ResetGroupby();
		$s->SetLimits(0,2);
		$s->ResetFilterbyAttr("Last_Login");
		$s->SetFilterRange("Last_Login",0,$currdatetimets);
		$s->SetGroupBy("OnlineStatus",SPH_GROUPBY_ATTR,"@count desc");
		$onlineNowResult=$s->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-OnlineNow");
		$onlineNowCount = getCountValue($onlineNowResult,"onlinenow");
		
		$weekObj = clone $s;
		$weekObj->ResetFilterbyAttr("Last_Login");
		$weekObj->SetFilterRange("Last_Login",$weekts,$currdatetimets);
		$weekObj->SetGroupBy("OnlineStatus",SPH_GROUPBY_ATTR,"@count desc");
		$weekCount=$weekObj->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-1week");
		$weekCount = getCountValue($weekCount,"activeweek");

		$monthObj = clone $s;
		$monthObj->ResetFilterbyAttr("Last_Login");				
		$monthObj->SetFilterRange("Last_Login",$monthts,$currdatetimets);
		$monthObj->SetGroupBy("OnlineStatus",SPH_GROUPBY_ATTR,"@count desc");
		$monthCount=$monthObj->Query($varQuery,$argSphinxIdxName,date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-1month");
		$monthCount = getCountValue($monthCount,"activemonth");
		
		$activeCount["Active"][0] = $onlineNowCount["onlinenow"][1];
		$activeCount["Active"][1] = $weekCount["activeweek"][0]+$weekCount["activeweek"][1];
		$activeCount["Active"][2] = $monthCount["activemonth"][0]+$monthCount["activemonth"][1];
		$activeCount["Active"][3] = $varTotCount;
					
		$arrSrchProfiles['groupcnt']=$activeCount;
		break;
	}else{
		$s->ResetGroupby();
		$s->SetLimits(0,2);
		$s->ResetFilterbyAttr("Last_Login");
		$s->SetFilterRange("Last_Login",0,$currdatetimets);
		$s->SetGroupBy("OnlineStatus",SPH_GROUPBY_ATTR,"@count desc");
		$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
		$facetNameArr[] = "OnlineStatus";
		
		$s->SetLimits(0,2);
		$s->ResetGroupby();
		$s->ResetFilterbyAttr("Last_Login");
		$s->SetFilterRange("Last_Login",$weekts,$currdatetimets);
		$s->SetGroupBy("OnlineStatus",SPH_GROUPBY_ATTR,"@count desc");
		$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
		$facetNameArr[] = "activeweek";

		$s->SetLimits(0,2);
		$s->ResetGroupby();
		$s->ResetFilterbyAttr("Last_Login");				
		$s->SetFilterRange("Last_Login",$monthts,$currdatetimets);
		$s->SetGroupBy("OnlineStatus",SPH_GROUPBY_ATTR,"@count desc");
		$s->AddQuery($varQuery,$argSphinxIdxName, date("d-m-y H:i:s:").substr(microtime(), 2, 4)." - ".$sessMatriId."-".$argGroupbyField);
		$facetNameArr[] = "activemonth";
		
		$s->ResetFilterbyAttr("Last_Login");
		break;
	}

}
?>