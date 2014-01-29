<?php
$varRootBasePath	= dirname($_SERVER['DOCUMENT_ROOT']);

//FILE INCLUDES
include_once($varRootBasePath."/conf/config.inc");

//Random Sucess Story Code Starts
$domainName = str_replace("image.","",$_SERVER[SERVER_NAME]);
if($domainName=='img.agarwalmatrimony.com')
{
	$domainName = str_replace("img.","",$_SERVER[SERVER_NAME]);
}
	$arrPrefixDomainList1	= array_flip($arrPrefixDomainList);
	$domainPrefix			= $arrPrefixDomainList1[$domainName];
	$arrMatriIdPre1			= array_flip($arrMatriIdPre);
	$domainId				= $arrMatriIdPre1[$domainPrefix];
	$folderName				= $arrFolderNames[$domainPrefix];
	$storiesFolderPath		= $varRootBasePath."/www/success/$folderName/stories/";
if($handle = opendir($storiesFolderPath))
	{
		$countFileHandle	= fopen($storiesFolderPath.'count.txt','r+');
		$fileCount			= fread($countFileHandle,filesize($storiesFolderPath.'count.txt'));
		$filesarr			= scandir($storiesFolderPath, 0);
		$cnt				= count($filesarr);
		for($j=0;$j<$cnt;$j++)
		{
			if($filesarr[$j]!='count.txt' && $filesarr[$j]!='..' && $filesarr[$j]!='.' && $filesarr[$j]!='')
			{
				$newFileArr[]	= $filesarr[$j];
			}
		}
		natcasesort($newFileArr);
		$cntt=count($newFileArr);
		foreach($newFileArr as $key=>$value)
			{
				$finalFileArr[$cntt]	= $value;
				$cntt--;
			}
				$varfileCount			= count($finalFileArr);
				sort($finalFileArr);				
	}
	$varFileRand	= $finalFileArr[rand(0, count($finalFileArr)-1)];

	$storiesFilePath=$storiesFolderPath.$varFileRand;

   //Reading Stories File Contents

   $storiesFileHandle  = fopen($storiesFilePath,'r+');
   $storiesContent	   = fread($storiesFileHandle,filesize($storiesFilePath));
   $content_arr		   = explode('|',$storiesContent);
   $MatriId            = $content_arr[0];
   $Bride_Name         = stripslashes($content_arr[1]);
   $Groom_Name		   = stripslashes($content_arr[2]);
   $Success_Message    = $content_arr[3];
   $Success			   = stripslashes(substr($Success_Message,0,40));
   $Marriage_Date	   = $content_arr[4];
   $photoShowStatus	   = $content_arr[5];
   if(($Bride_Name!="")&&($Groom_Name!=""))
	{  
		$varjoin	   = " & "; 
	} 
   $BrideGroomName	   = $Bride_Name.$varjoin.$Groom_Name;

   $BrideGroomCount	   = strlen($BrideGroomName);
   $BrideGroomNameHigh = substr($BrideGroomName,0,34);
   if($Marriage_Date   =='0000-00-00')
	   {
	   $Marriage_Date='--';
	}


    $smallImgPath=$confValues['IMAGEURL'].'/success/'.$folderName.'/smallphotos/'.$MatriId.'_s.jpg';
	//Random Sucess Story Code Ends


	//Random Testimonial  Code Starts

$folderName = $arrFolderNames[$domainPrefix];
	 if(($folderName=='christian')||($folderName=='guptan')||($folderName=='ezhuthachan')){
		  $testimonialFolderPath  = $varRootBasePath."/www/testimonial/$folderName/";
	 } else{		 
		$testimonialFolderPath    = $varRootBasePath."/www/testimonial/common/";
	 }

if($handle1 = opendir($testimonialFolderPath))
	{
	   $counttestimonialHandle	= fopen($testimonialFolderPath.'counttestimonial.txt','r+');
	   $testimonialCount = fread($counttestimonialHandle,filesize($testimonialFolderPath.'counttestimonial.txt'));
	   $testimonialarr          = scandir($testimonialFolderPath, 0);
	   $tescnt					=count($testimonialarr);
		for($j=0;$j<$tescnt;$j++)
			{
				if($testimonialarr[$j]!='counttestimonial.txt' && $testimonialarr[$j]!='..' && $testimonialarr[$j]!='.' && $testimonialarr[$j]!='')
				{
					$newtestimonialArr[]	= $testimonialarr[$j];
				}
			}	
		natcasesort($newtestimonialArr);
		 $tescntt	= count($newtestimonialArr);
		foreach($newtestimonialArr as $key=>$value){
		$finaltestimonialArr[$tescntt]	= $value;
		$tescntt--;
	  }
		 $vartestimonialCount=count($finaltestimonialArr);
		sort($finaltestimonialArr);
	/*echo "<pre>";
	print_r($finaltestimonialArr);
	echo "</pre>";*/
	}
//$varFileShuffle=shuffle($finalFileArr);
	$vartestimonialRand	= $finaltestimonialArr[rand(0, count($finaltestimonialArr)-1)];
	 $testimonialPath	= $testimonialFolderPath.$vartestimonialRand;

   //Reading Stories File Contents
   $testimonialHandle	  = fopen($testimonialPath,'r+');
   $testimonialContent	  = fread($testimonialHandle,filesize($testimonialPath));
   $content_testimonial	  = explode('|',$testimonialContent);
   $Name                  = $content_testimonial[0];
   $testimonial			  = $content_testimonial[1];
?>
<link rel="stylesheet" href="<?=$confValues['CSSPATH']?>/global-style.css">

<?php if(($varfileCount!=0)||($vartestimonialCount!=0)){
	if($varfileCount!=0){?>
       <div id="succ" class="fright wdth192">
        <div class="fleft bgclr6 wdth192">
            <div class="fleft wdth192 bld fnt16" style="height:28px !important;height:35px;padding-top:10px;"><center>Success Stories</center></div>
            <div class="wdth192 fleft mgnb7" style="height:200px;">
            <div class="wdth178 disline brdclr1 fleft mgnl7 bgclr5">
               <div class="fleft mgnl15 mymgnt5 disline padb10"  style="height:174px !important;height:184px;">
					<div class="wdth150">
					<center><div class="bld smalltxt mgnb7"><?php 
					if($BrideGroomCount < 34){
					echo $BrideGroomName;
					}else{
						echo $BrideGroomNameHigh."...";
					}?></div>
				   <?php if($photoShowStatus==1){?>
				   <div class="bld smalltxt mgnb7">
					<img src="<?php echo $smallImgPath?>" width="120" height="80"/></div><?php }else{?>
					<div class="bld smalltxt mgnb7">
					<img src="<?=$confValues['IMAGEURL']?>/images/success-story-image.gif" width="120" height="80"/></div><?php }?>
					<div class="smalltxt"><?php echo $Success;?><br />
					<a href="http://image.<?=$varDomainPart2?>.com/successstory/index.php?act=successgallery" class="clr1" target="_blank">More>><br></a>
					</div>
					</center></div>
                    </div>
               </div>
                </div>
            </div>
           </div>
    <div class="fright wdth192" style="margin-top:5px;margin-right:10px;display:inline">
        &nbsp;
    </div>
    <br clear="all"/>
	<?php } else {
		if($vartestimonialCount!=0) {?>
    <div class="fright wdth192" style="display:inline;">
        <div class="fleft bgclr6 wdth192">
            <div class="fleft wdth192 bld fnt16" style="height:28px;padding-top:10px;"><center>Testimonials</center></div>
            <div class="wdth192 fleft mgnb7" style="height:200px;">
                <div class="wdth178 disline brdclr1 fleft mgnl7 bgclr5">
                    <div class="fleft mgnl15 mymgnt5 disline padb10" style="height:174px !important;height:184px;">
                        <div class="wdth150">
                        <center><div class="bld smalltxt mgnb7"><?php echo $Name;?></div>
                        <div align="left" class="smalltxt fleft" style="text-align:justify">" <?php echo  $testimonial;?>"<br />
                        </div>

                        </center></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fright wdth192" style="margin-top:5px;margin-right:10px;display:inline">
        &nbsp;
    </div>
	<?php }} }?>