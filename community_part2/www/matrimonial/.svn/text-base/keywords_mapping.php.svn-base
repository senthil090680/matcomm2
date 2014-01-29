<?php 
    
	$cur_url='http://www.'.$arrDomainInfo[$varDomain][2].'matrimony.com/'.'matrimonials/';
    $religion_arr = array('christian','muslim','jain','sikh','buddhist');


	if($url==$cur_url){ 

	$website_heading = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimonials';?>
	<title><?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimonials, Matrimonial, Matrimony - <?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony.com</title>
	<meta name="description" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimonials - <?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony.com, Find Lakhs of <?=ucfirst($arrDomainInfo[$varDomain][2])?> Brides & Grooms globally. No.1 Matrimony site for all <?=ucfirst($arrDomainInfo[$varDomain][2])?> communities. Register FREE">
	<meta name="keywords" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimonials">

	<? }
	//////////////////////CAST PART/////////////////////////////////
	else if(in_array($arrDomainInfo[$varDomain][2],$religion_arr)==0 && $arrDomainInfo[$varDomain][2]!='manglik' && $arrDomainInfo[$varDomain][2]!='divorcee') { 
		
	$website_heading = ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1];
    $gen_srch= 0;
	$desc_2  = 'Brides & Grooms';
	$title_2 = 'Brides & Grooms';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';

	$title_1 = ucfirst($arrDomainInfo[$varDomain][2]);
    if($kwordarr[1]=='Bride'){
	$title_2 = 'Bride, Brides';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Brides';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Brides'){
	$title_2 = 'Brides, Bride';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Brides';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Girl'){
	$title_2 = 'Girl, Brides';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Girls/Brides';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Girls'){
	$title_2 = 'Girls, Bride';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Girls/Brides';
	$gen_srch= 1;
	}
	//////
	if($kwordarr[1]=='Boy'){
	$title_2 = 'Boy, Groom';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Boys/Grooms';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Boys'){
	$title_2 = 'Boys, Groom';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Boys/Grooms';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Groom'){
	$title_2 = 'Groom, Grooms';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Grooms';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Grooms'){
	$title_2 = 'Grooms, Groom';
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	$desc_2  = 'Grooms';
	$gen_srch= 1;
	}

	if($kwordarr[1]=='Matrimonial' || $kwordarr[1]=='Matrimonials' || $kwordarr[1]=='Marriage'){
    $title_2 = $kwordarr[1];
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	}
	if($kwordarr[1]=='Matrimony'){
    $title_2 = $kwordarr[1];
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimonial';
	}
	
	if($kwordarr[1]=='Matrimonial site' || $kwordarr[1]=='Matrimonial sites'){
    $title_2 = $kwordarr[1];
	$title_3 = 'Matrimony';
	}
		
	$title_4 = ucfirst($arrDomainInfo[$varDomain][2]).'Matrimony.com';

	//if($kwordarr[1]!='Matrimony'  && $kwordarr[1]!='Matrimonials'){
	$breadcrumb = "<a class='smalltxt clr1' title='Matrimonial' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/matrimonials'>Matrimonial</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> <a class='smalltxt clr1' title='".ucfirst($arrDomainInfo[$varDomain][2])." Matrimony' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com'>".ucfirst($arrDomainInfo[$varDomain][2])." Matrimony</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> "; 
	if($kwordarr[1]!='Matrimonial' && $kwordarr[1]!='Matrimonials'){
	$breadcrumb .="<a class='smalltxt clr1' title='".ucfirst($arrDomainInfo[$varDomain][2])." Matrimonial' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/matrimonials/".ucfirst($arrDomainInfo[$varDomain][2])."+Matrimonial'>".ucfirst($arrDomainInfo[$varDomain][2])." Matrimonial</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> ";
	}
	
	//}
    
	if($gen_srch==0) 
	$desc_1 = ucfirst($arrDomainInfo[$varDomain][2]).''.$kwordarr[1].' -';
	else
    $desc_1 = 'Looking for '.ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1].'?';
	
	?>
	
    <title><?php 
	
	if($kwordarr[1]=='Matrimonial site' || $kwordarr[1]=='Matrimonial sites'){
	echo $title_1.' '.$title_2.' - '.$title_4;
	}else{
    echo $title_1.' '.$title_2.' - '.$title_3.' - '.$title_4;
	}
		
	?></title>

	<meta name="description" content="<?=$desc_1;?> Find Lakhs of <?=ucfirst($arrDomainInfo[$varDomain][2])?> <?=$desc_2;?> in <?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony.com, a part of CommunityMatrimony - Register FREE">
	<meta name="keywords" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> <?=$kwordarr[1];?>">
	<?}
	//////////////////////RELIGION PART/////////////////////////////////
	elseif(in_array($arrDomainInfo[$varDomain][2],$religion_arr)==1){ 
		
	$website_heading = ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1];
    $gen_srch= 0;
    $desc_2  = 'Brides & Grooms';
	$title_2 = 'Brides & Grooms';
	$title_3 = 'Matrimonial';

	$title_1 = ucfirst($arrDomainInfo[$varDomain][2]);
    if($kwordarr[1]=='Bride'){
	$title_2 = 'Bride, Brides';
	$title_3 = 'Matrimonials';
	$desc_2  = 'Brides/Girls';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Brides'){
	$title_2 = 'Brides, Bride';
	$title_3 = 'Matrimonials';
	$desc_2  = 'Brides/Girls';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Girl'){
	$title_2 = 'Girl, Bride';
	$title_3 = 'Matrimony';
	$desc_2  = 'Girls/Brides';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Girls'){
	$title_2 = 'Girls, Bride';
	$title_3 = 'Matrimony';
	$desc_2  = 'Girls/Brides';
	$gen_srch= 1;
	}
	//////
	if($kwordarr[1]=='Boy'){
	$title_2 = 'Boy, Groom';
	$title_3 = 'Matrimony';
	$desc_2  = 'Boys/Grooms';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Boys'){
	$title_2 = 'Boys, Groom';
	$title_3 = 'Matrimony';
	$desc_2  = 'Grooms';
	$desc_2  = 'Boys/Grooms';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Groom'){
	$title_2 = 'Groom, Grooms';
	$title_3 = 'Matrimonials';
	$desc_2  = 'Grooms/Boys';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Grooms'){
	$title_2 = 'Grooms, Groom';
	$title_3 = 'Matrimonials';
	$desc_2  = 'Grooms/Boys';
	$gen_srch= 1;
	}

	if($kwordarr[1]=='Matrimonial' || $kwordarr[1]=='Matrimonials'){
    $title_2 = $kwordarr[1];
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimony';
	}
	if($kwordarr[1]=='Matrimony'){
    $title_2 = $kwordarr[1];
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimonial';
	}
	if($kwordarr[1]=='Marriage'){
	$title_2 = $kwordarr[1];
	$title_3 = ucfirst($arrDomainInfo[$varDomain][2]).' Matrimonials';
	}
	
	if($kwordarr[1]=='Matrimonial site' || $kwordarr[1]=='Matrimonial sites'){
    $title_2 = $kwordarr[1];
	$title_3 = 'Matrimonials';
	}

    //if($kwordarr[1]!='Matrimony'  && $kwordarr[1]!='Matrimonials'){
	$breadcrumb = "<a class='smalltxt clr1' title='Matrimonial' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/matrimonials'>Matrimonial</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> <a class='smalltxt clr1' title='".ucfirst($arrDomainInfo[$varDomain][2])." Matrimony' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/'>".ucfirst($arrDomainInfo[$varDomain][2])." Matrimony</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> ";
	
	if($kwordarr[1]!='Matrimonial' && $kwordarr[1]!='Matrimonials'){
	$breadcrumb .= "<a class='smalltxt clr1' title='".ucfirst($arrDomainInfo[$varDomain][2])." Matrimonial' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/matrimonials/".ucfirst($arrDomainInfo[$varDomain][2])."+Matrimonial'>".ucfirst($arrDomainInfo[$varDomain][2])." Matrimonial</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> ";
	}
	
	//}
			
	$title_4 = ucfirst($arrDomainInfo[$varDomain][2]).'Matrimony.com';

	if($gen_srch==0 || $gen_srch==1) 
	$desc_1 = ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1].' -';
	else
    $desc_1 = 'Looking for '.ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1].'?';

	
	
	?>
	
    <title><?php echo $title_1.' '.$title_2.' - '.$title_3.' - '.$title_4 ?></title>

	<meta name="description" content="<?=$desc_1;?> Find lakhs of <?=ucfirst($arrDomainInfo[$varDomain][2])?> <?=$desc_2;?> in the No.1 <?=ucfirst($arrDomainInfo[$varDomain][2])?> Matrimony Site for all denominations of <?=ucfirst($arrDomainInfo[$varDomain][2].'s')?> - Register FREE">
	<meta name="keywords" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> <?=$kwordarr[1];?>">

	<?}
	//////////////////////Divorcee PART/////////////////////////////////
	elseif($arrDomainInfo[$varDomain][2]=='manglik' || $arrDomainInfo[$varDomain][2]=='divorcee'){ 
		
	$website_heading = ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1];
    $gen_srch= 0;
	$varDescWord = ucfirst($arrDomainInfo[$varDomain][2]);
    $desc_2  = ($varDescWord=='Manglik') ? 'Manglik Profiles' : 'Divorced Profiles';
	
	$title_2 = 'Brides & Grooms';
	$title_3 = 'Matrimony - Marriage';

	$title_1 = ucfirst($arrDomainInfo[$varDomain][2]);
    if($kwordarr[1]=='Bride'){
	$title_2 = 'Bride, Brides';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = $varDescWord.' Brides/Girls';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Brides'){
	$title_2 = 'Brides, Bride';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = $varDescWord.' Brides/Girls';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Girl'){
	$title_2 = 'Girl, Bride';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = $varDescWord.' Girls/Brides';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Girls'){
	$title_2 = 'Girls, Bride';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = $varDescWord.' Girls/Brides';
	$gen_srch= 1;
	}
	//////
	if($kwordarr[1]=='Boy'){
	$title_2 = 'Boy, Groom';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = $varDescWord.' Boys/Grooms';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Boys'){
	$title_2 = 'Boys, Groom';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = 'Grooms';
	$desc_2  = $varDescWord.' Boys/Grooms';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Groom'){
	$title_2 = 'Groom, Grooms';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = $varDescWord.' Grooms/Boys';
	$gen_srch= 1;
	}
	if($kwordarr[1]=='Grooms'){
	$title_2 = 'Grooms, Groom';
	$title_3 = 'Matrimony - Marriage';
	$desc_2  = $varDescWord.' Grooms/Boys';
	$gen_srch= 1;
	}

	if($kwordarr[1]=='Matrimonial' || $kwordarr[1]=='Matrimonials'){
    $title_2 = $kwordarr[1];
	$title_3 = 'Matrimony - Marriage';
	}
	if($kwordarr[1]=='Matrimony'){
    $title_2 = $kwordarr[1];
	$title_3 = 'Matrimonial - Marriage';
	}
	if($kwordarr[1]=='Marriage'){
	$title_2 = $kwordarr[1];
	$title_3 = 'Matrimonials - Matrimony';
	}
	
	if($kwordarr[1]=='Matrimonial site' || $kwordarr[1]=='Matrimonial sites'){
    $title_2 = $kwordarr[1];
	$title_3 = 'Matrimony';
	}
	
	//if($kwordarr[1]!='Matrimony'  && $kwordarr[1]!='Matrimonials'){
	$breadcrumb = "<a class='smalltxt clr1' title='Matrimonial' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/matrimonials'>Matrimonial</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> <a class='smalltxt clr1' title='".ucfirst($arrDomainInfo[$varDomain][2])." Matrimony' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/'>".ucfirst($arrDomainInfo[$varDomain][2])." Matrimony</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> ";
	if($kwordarr[1]!='Matrimonial' && $kwordarr[1]!='Matrimonials'){
	$breadcrumb .="<a class='smalltxt clr1' title='".ucfirst($arrDomainInfo[$varDomain][2])." Matrimonial' href='http://www.".$arrDomainInfo[$varDomain][2]."matrimony.com/matrimonials/".ucfirst($arrDomainInfo[$varDomain][2])."+Matrimonial'>".ucfirst($arrDomainInfo[$varDomain][2])." Matrimonial</a> <img src='".$confValues['IMGSURL']."/arrow1.gif' height='7' width='4' /> ";
	}
	
	//}
	
	$title_4 = ucfirst($arrDomainInfo[$varDomain][2]).'Matrimony.com';

	if($gen_srch==0) 
	$desc_1 = ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1].' -';
	else
    $desc_1 = ucfirst($arrDomainInfo[$varDomain][2]).' '.$kwordarr[1].' -';

	
	
	?>
	
    <title><?php echo $title_1.' '.$title_2.' - '.$title_3.' - '.$title_4 ?></title>

	<meta name="description" content="<?=$desc_1;?> Find lakhs of <?=$desc_2;?> in <?=ucfirst($arrDomainInfo[$varDomain][2])?>Matrimony.com, the No.1 matrimony site for <?=$arrDomainInfo[$varDomain][2].'s';?>. Register FREE">
	<meta name="keywords" content="<?=ucfirst($arrDomainInfo[$varDomain][2])?> <?=$kwordarr[1];?>">

	<?}?>
	
	<meta name="abstract" content="<?=$confPageValues['ABSTRACT']?>">
	<meta name="Author" content="<?=$confPageValues['AUTHOR']?>">
	<meta name="copyright" content="<?=$confPageValues['COPYRIGHT']?>">
	<meta name="Distribution" content="<?=$confPageValues['DISTRIBUTION']?>">
	<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">
	<link rel="stylesheet" href="<?=$confValues['DOMAINCSSPATH']?>/global.css">
	<script language="javascript" src="<?=$confValues['SERVERURL']?>/template/commonjs.php" ></script>
	<script language="javascript" src="<?=$confValues['JSPATH']?>/global.js" ></script>