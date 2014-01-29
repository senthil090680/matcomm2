<?php

$DOCROOTPATH = $_SERVER['DOCUMENT_ROOT'];
$DOCROOTBASEPATH = dirname($_SERVER['DOCUMENT_ROOT']);

include_once($DOCROOTBASEPATH."/bmconf/bminit.inc");
include_once($DOCROOTBASEPATH."/bmlib/bmgenericfunctions.inc");
include_once $DOCROOTBASEPATH."/bmlib/bmsqlclass.inc";
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearcharrinc".$ln.".inc");
include_once($DOCROOTBASEPATH."/bmconf/bmvarssearchformarr".$ln.".inc");

$xml_filename = $DOCROOTBASEPATH."/bmconf/bmvarsviewprofilelabel.inc";
include_once "parsexml.php";

$groom_typos_array = array("aale","aales","ale","ales","amle","amles","aoy","aoys","aroom","arooms","ausband","bale","bales","bay","bays","bboy","bboys","bby","bbys","bcy","bcys","bdy","bdys","bey","beys","bfy","bfys","bgy","bgys","bhy","bhys","biy","biys","bjy","bjys","bky","bkys","bly","blys","bmy","bmys","bny","bnys","bo","boas","bobs","bocs","bods","boes","bofs","bogs","bohs","boi","boie","boies","bois","bojs","boks","bols","boms","bons","boos","booy","booys","bops","boqs","bors","bos","boss","bosy","bot","bots","bou","bous","bovs","bows","boxs","boy","boya","boyd","boys","boyss","boyy","boyys","boyz","boz","bozs","bpy","bpys","bqy","bqys","broom","brooms","bry","brys","bsy","bsys","bty","btys","busband","buy","buys","bvy","bvys","bwy","bwys","bxy","bxys","by","byo","byos","bys","byy","byys","bzy","bzys","cale","cales","coy","coys","croom","crooms","cusband","dale","dales","doy","doys","droom","drooms","dusband","eale","eales","eoy","eoys","eroom","erooms","eusband","fale","fales","foy","foys","froom","frooms","fusband","gale","gales","gaoom","gaooms","gboom","gbooms","gcoom","gcooms","gdoom","gdooms","geoom","geooms","gfoom","gfooms","ggoom","ggooms","ggroom","ggrooms","ghoom","ghooms","gioom","giooms","gjoom","gjooms","gkoom","gkooms","gloom","glooms","gmoom","gmooms","gnoom","gnooms","goom","gooms","gooom","goooms","gorom","goroms","goy","goys","gpoom","gpooms","gqoom","gqooms","graom","graoms","grbom","grboms","grcom","grcoms","grdom","grdoms","greom","greoms","grfom","grfoms","grgom","grgoms","grhom","grhoms","griom","grioms","grjom","grjoms","grkom","grkoms","grlom","grloms","grmom","grmoms","grnom","grnoms","groam","groams","grobm","grobms","grocm","grocms","grodm","grodms","groem","groems","grofm","grofms","grogm","grogms","grohm","grohms","groim","groims","grojm","grojms","grokm","grokms","grolm","grolms","grom","gromm","gromms","gromo","gromos","groms","gronm","gronms","groo","grooas","groobs","groocs","groods","grooes","groofs","groogs","groohs","groois","groojs","grooks","grools","groom","grooma","groomd","groomm","groomms","grooms","groomss","groomz","groon","groons","grooom","groooms","grooos","groops","grooqs","groors","groos","groosm","grooss","groots","groous","groovs","groows","grooxs","grooys","groozs","gropm","gropms","groqm","groqms","grorm","grorms","grosm","grosms","grotm","grotms","groum","groums","grovm","grovms","growm","growms","groxm","groxms","groym","groyms","grozm","grozms","grpom","grpoms","grqom","grqoms","grrom","grroms","grroom","grrooms","grsom","grsoms","grtom","grtoms","gruom","gruoms","grvom","grvoms","grwom","grwoms","grxom","grxoms","gryom","gryoms","grzom","grzoms","gsoom","gsooms","gtoom","gtooms","guoom","guooms","gusband","gvoom","gvooms","gwoom","gwooms","gxoom","gxooms","gyoom","gyooms","gzoom","gzooms","hale","hales","hasband","hbsband","hcsband","hdsband","hesband","hfsband","hgsband","hhsband","hhusband","hisband","hjsband","hksband","hlsband","hmsband","hnsband","hosband","hoy","hoys","hpsband","hqsband","hroom","hrooms","hrsband","hsband","hssband","hsuband","htsband","huaband","huband","hubband","hubsand","hucband","hudband","hueband","hufband","hugband","huhband","huiband","hujband","hukband","hulband","humband","hunband","huoband","hupband","huqband","hurband","husaand","husabnd","husand","husbaad","husbaand","husbabd","husbacd","husbad","husbadd","husbadn","husbaed","husbafd","husbagd","husbahd","husbaid","husbajd","husbakd","husbald","husbamd","husban","husband","husbandd","husbanf","husbannd","husbans","husbaod","husbapd","husbaqd","husbard","husbasd","husbatd","husbaud","husbavd","husbawd","husbaxd","husbayd","husbazd","husbband","husbbnd","husbcnd","husbdnd","husbend","husbfnd","husbgnd","husbhnd","husbind","husbjnd","husbknd","husblnd","husbmnd","husbnad","husbnd","husbnnd","husbond","husbpnd","husbqnd","husbrnd","husbsnd","husbtnd","husbund","husbvnd","husbwnd","husbxnd","husbynd","husbznd","huscand","husdand","huseand","husfand","husgand","hushand","husiand","husjand","huskand","husland","husmand","husnand","husoand","huspand","husqand","husrand","hussand","hussband","hustand","husuand","husvand","huswand","husxand","husyand","huszand","hutband","huuband","huusband","huvband","huwband","huxband","huyband","huzband","hvsband","hwsband","hxsband","hysband","hzsband","iale","iales","ioy","ioys","iroom","irooms","iusband","jale","jales","joy","joys","jroom","jrooms","jusband","kale","kales","koy","koys","kroom","krooms","kusband","lale","lales","loy","loys","lroom","lrooms","lusband","maae","maaes","maale","maales","mabe","mabes","mace","maces","made","mades","mae","maee","maees","mael","maels","maes","mafe","mafes","mage","mages","mahe","mahes","maie","maies","maje","majes","make","makes","mal","malas","malbs","malcs","malds","male","malea","maled","malee","malees","males","maless","malez","malfs","malgs","malhs","malis","maljs","malks","malle","malles","malls","malms","malns","malos","malps","malqs","malr","malrs","mals","malse","malss","malts","malus","malvs","malw","malws","malxs","malys","malzs","mame","mames","mane","manes","maoe","maoes","mape","mapes","maqe","maqes","mare","mares","mase","mases","mate","mates","maue","maues","mave","maves","mawe","mawes","maxe","maxes","maye","mayes","maze","mazes","mble","mbles","mcle","mcles","mdle","mdles","mele","meles","mfle","mfles","mgle","mgles","mhle","mhles","mile","miles","mjle","mjles","mkle","mkles","mlae","mlaes","mle","mles","mlle","mlles","mmale","mmales","mmle","mmles","mnle","mnles","mole","moles","moy","moys","mple","mples","mqle","mqles","mrle","mrles","mroom","mrooms","msle","msles","mtle","mtles","mule","mules","musband","mvle","mvles","mwle","mwles","mxle","mxles","myle","myles","mzle","mzles","nale","nales","noy","noys","nroom","nrooms","nusband","oale","oales","oby","obys","ooy","ooys","oroom","orooms","ousband","oy","oys","pale","pales","poy","poys","proom","prooms","pusband","qale","qales","qoy","qoys","qroom","qrooms","qusband","rale","rales","rgoom","rgooms","room","rooms","roy","roys","rroom","rrooms","rusband","sale","sales","soy","soys","sroom","srooms","susband","tale","tales","toy","toys","troom","trooms","tusband","uale","uales","uhsband","uoy","uoys","uroom","urooms","usband","uusband","vale","vales","voy","voys","vroom","vrooms","vusband","wale","wales","woy","woys","wroom","wrooms","wusband","xale","xales","xoy","xoys","xroom","xrooms","xusband","yale","yales","yoy","yoys","yroom","yrooms","yusband","zale","zales","zoy","zoys","zroom","zrooms","zusband");

$bride_typos_array = array("aemale","aemales","aife","airl","airls","aride","arides","baide","baides","bbide","bbides","bbride","bbrides","bcide","bcides","bdide","bdides","beide","beides","bemale","bemales","bfide","bfides","bgide","bgides","bhide","bhides","bide","bides","bife","biide","biides","birde","birdes","birl","birls","bjide","bjides","bkide","bkides","blide","blides","bmide","bmides","bnide","bnides","boide","boides","bpide","bpides","bqide","bqides","brade","brades","brbde","brbdes","brcde","brcdes","brdde","brddes","brde","brdes","brdie","brdies","brede","bredes","brfde","brfdes","brgde","brgdes","brhde","brhdes","briae","briaes","bribe","bribes","brice","brices","brid","bridas","bridbs","bridcs","bridde","briddes","bridds","bride","bridea","brided","bridee","bridees","brides","bridess","bridez","bridfs","bridgs","bridhs","bridis","bridjs","bridks","bridls","bridms","bridns","bridos","bridps","bridqs","bridr","bridrs","brids","bridse","bridss","bridts","bridus","bridvs","bridw","bridws","bridxs","bridys","bridzs","brie","bried","brieds","briee","briees","bries","brife","brifes","brige","briges","brihe","brihes","briide","briides","briie","briies","brije","brijes","brike","brikes","brile","briles","brime","brimes","brine","brines","brioe","brioes","bripe","bripes","briqe","briqes","brire","brires","brise","brises","brite","brites","briue","briues","brive","brives","briwe","briwes","brixe","brixes","briye","briyes","brize","brizes","brjde","brjdes","brkde","brkdes","brlde","brldes","brmde","brmdes","brnde","brndes","brode","brodes","brpde","brpdes","brqde","brqdes","brrde","brrdes","brride","brrides","brsde","brsdes","brtde","brtdes","brude","brudes","brvde","brvdes","brwde","brwdes","brxde","brxdes","bryde","brydes","brzde","brzdes","bside","bsides","btide","btides","buide","buides","bvide","bvides","bwide","bwides","bxide","bxides","byide","byides","bzide","bzides","cemale","cemales","cife","cirl","cirls","cride","crides","demale","demales","dife","dirl","dirls","dride","drides","eemale","eemales","efmale","efmales","eife","eirl","eirls","emale","emales","eride","erides","famale","famales","fbmale","fbmales","fcmale","fcmales","fdmale","fdmales","feaale","feaales","feale","feales","feamle","feamles","febale","febales","fecale","fecales","fedale","fedales","feeale","feeales","feemale","feemales","fefale","fefales","fegale","fegales","fehale","fehales","feiale","feiales","fejale","fejales","fekale","fekales","felale","felales","femaae","femaaes","femaale","femaales","femabe","femabes","femace","femaces","femade","femades","femae","femaee","femaees","femael","femaels","femaes","femafe","femafes","femage","femages","femahe","femahes","femaie","femaies","femaje","femajes","femake","femakes","femal","femalas","femalbs","femalcs","femalds","female","femalea","femaled","females","femaless","femalez","femalfs","femalgs","femalhs","femalis","femaljs","femalks","femalle","femalles","femalls","femalms","femalns","femalos","femalps","femalqs","femalrs","femalse","femalss","femalts","femalus","femalvs","femalws","femalxs","femalys","femalzs","femame","femames","femane","femanes","femaoe","femaoes","femape","femapes","femaqe","femaqes","femare","femares","femase","femases","femate","femates","femaue","femaues","femave","femaves","femawe","femawes","femaxe","femaxes","femaye","femayes","femaze","femazes","femble","fembles","femcle","femcles","femdle","femdles","femele","femeles","femfle","femfles","femgle","femgles","femhle","femhles","femile","femiles","femjle","femjles","femkle","femkles","femlae","femlaes","femle","femles","femlle","femlles","femmale","femmales","femmle","femmles","femnle","femnles","femole","femoles","femple","femples","femqle","femqles","femrle","femrles","femsle","femsles","femtle","femtles","femule","femules","femvle","femvles","femwle","femwles","femxle","femxles","femyle","femyles","femzle","femzles","fenale","fenales","feoale","feoales","fepale","fepales","feqale","feqales","ferale","ferales","fesale","fesales","fetale","fetales","feuale","feuales","fevale","fevales","fewale","fewales","fexale","fexales","feyale","feyales","fezale","fezales","ffemale","ffemales","ffmale","ffmales","fgmale","fgmales","fhmale","fhmales","fife","fimale","fimales","firl","firls","fjmale","fjmales","fkmale","fkmales","flmale","flmales","fmale","fmales","fmeale","fmeales","fmmale","fmmales","fnmale","fnmales","fomale","fomales","fpmale","fpmales","fqmale","fqmales","fride","frides","frmale","frmales","fsmale","fsmales","ftmale","ftmales","fumale","fumales","fvmale","fvmales","fwmale","fwmales","fxmale","fxmales","fymale","fymales","fzmale","fzmales","garl","garls","gbrl","gbrls","gcrl","gcrls","gdrl","gdrls","gemale","gemales","gerl","gerls","gfrl","gfrls","ggirl","ggirls","ggrl","ggrls","ghrl","ghrls","gial","gials","gibl","gibls","gicl","gicls","gidl","gidls","giel","giels","gife","gifl","gifls","gigl","gigls","gihl","gihls","giil","giils","giirl","giirls","gijl","gijls","gikl","gikls","gil","gill","gills","gilr","gilrs","gils","giml","gimls","ginl","ginls","giol","giols","gipl","gipls","giql","giqls","gir","giras","girbs","gircs","girds","gires","girfs","girgs","girhs","giris","girjs","girk","girks","girl","girla","girld","girll","girlls","girls","girlss","girlz","girms","girns","giros","girps","girqs","girrl","girrls","girrs","girs","girsl","girss","girts","girus","girvs","girws","girxs","girys","girzs","gisl","gisls","gitl","gitls","giul","giuls","givl","givls","giwl","giwls","gixl","gixls","giyl","giyls","gizl","gizls","gjrl","gjrls","gkrl","gkrls","glrl","glrls","gmrl","gmrls","gnrl","gnrls","gorl","gorls","gprl","gprls","gqrl","gqrls","gride","grides","gril","grils","grl","grls","grrl","grrls","gsrl","gsrls","gtrl","gtrls","gurl","gurls","gvrl","gvrls","gwrl","gwrls","gxrl","gxrls","gyrl","gyrls","gzrl","gzrls","hemale","hemales","hife","hirl","hirls","hride","hrides","iemale","iemales","ife","igrl","igrls","iife","iirl","iirls","iride","irides","irl","irls","iwfe","jemale","jemales","jife","jirl","jirls","jride","jrides","kemale","kemales","kife","kirl","kirls","kride","krides","lemale","lemales","life","lirl","lirls","lride","lrides","memale","memales","mife","mirl","mirls","mride","mrides","nemale","nemales","nife","nirl","nirls","nride","nrides","oemale","oemales","oife","oirl","oirls","oride","orides","pemale","pemales","phemale","phemales","pife","pirl","pirls","pride","prides","qemale","qemales","qife","qirl","qirls","qride","qrides","rbide","rbides","remale","remales","ride","rides","rife","rirl","rirls","rride","rrides","semale","semales","sife","sirl","sirls","sride","srides","temale","temales","tife","tirl","tirls","tride","trides","uemale","uemales","uife","uirl","uirls","uride","urides","vemale","vemales","vife","virl","virls","vride","vrides","wafe","wbfe","wcfe","wdfe","wefe","wemale","wemales","wfe","wffe","wfie","wgfe","whfe","wiae","wibe","wice","wide","wie","wiee","wief","wif","wife","wifee","wiffe","wifr","wifw","wige","wihe","wiie","wiife","wije","wike","wile","wime","wine","wioe","wipe","wiphe","wiqe","wire","wirl","wirls","wise","wite","wiue","wive","wiwe","wixe","wiye","wize","wjfe","wkfe","wlfe","wmfe","wnfe","wofe","wpfe","wqfe","wrfe","wride","wrides","wsfe","wtfe","wufe","wvfe","wwfe","wwife","wxfe","wyfe","wzfe","xemale","xemales","xife","xirl","xirls","xride","xrides","yemale","yemales","yife","yirl","yirls","yride","yrides","zemale","zemales","zife","zirl","zirls","zride","zrides");

if($_REQUEST['gender_assign']==0) {
	$_REQUEST['GENDER']=getBrideGroomBasedonKeytext($groom_typos_array,$bride_typos_array,$_REQUEST['keytext']);
}

(trim($_REQUEST['GENDER'])=="") ? $GENDER = "F" : $GENDER = $_REQUEST['GENDER'];
(trim($_REQUEST['RS_STAGE'])=="") ? $RS_STAGE = 20 : $RS_STAGE = $_REQUEST['RS_STAGE'];
(trim($_REQUEST['RS_ENDAGE'])=="") ? $RS_ENDAGE = 40 : $RS_ENDAGE = $_REQUEST['RS_ENDAGE'];
(trim($_REQUEST['RS_STHEIGHT'])=="") ? $RS_STHEIGHT = 0 : $RS_STHEIGHT = $_REQUEST['RS_STHEIGHT'];
(trim($_REQUEST['RS_ENDHEIGHT'])=="") ? $RS_ENDHEIGHT = 37 : $RS_ENDHEIGHT = $_REQUEST['RS_ENDHEIGHT'];
(trim($_REQUEST['wdmatch'])=="") ? $wdmatch = "A" : $wdmatch = $_REQUEST['wdmatch'];
(trim($_REQUEST['DISPLAY_FORMAT'])=="") ? $DISPLAY_FORMAT = "B" : $DISPLAY_FORMAT = $_REQUEST['DISPLAY_FORMAT'];
(trim($_REQUEST['df'])=="") ? $df = "B" : $df = $_REQUEST['df'];
(trim($_REQUEST['keytext'])=="") ? $keytext = "bride groom" : $keytext = $_REQUEST['keytext'];

if(trim($_REQUEST['GENDER'])=="") { $_REQUEST['GENDER'] = "F"; }
if(trim($_REQUEST['RS_STAGE'])=="") { $_REQUEST['RS_STAGE'] = 20; }
if(trim($_REQUEST['RS_ENDAGE'])=="") { $_REQUEST['RS_ENDAGE'] = 40; }
if(trim($_REQUEST['RS_STHEIGHT'])=="") { $_REQUEST['RS_STHEIGHT'] = 0; }
if(trim($_REQUEST['RS_ENDHEIGHT'])=="") { $_REQUEST['RS_ENDHEIGHT'] = 37; }
if(trim($_REQUEST['wdmatch'])=="") { $_REQUEST['wdmatch'] = "E"; }
if(trim($_REQUEST['DISPLAY_FORMAT'])=="") { $_REQUEST['DISPLAY_FORMAT'] = "B"; }
if(trim($_REQUEST['df'])=="") { $_REQUEST['df'] = "B"; }
if(trim($_REQUEST['keytext'])=="") { $_REQUEST['keytext'] = "bride groom"; }


$domainarr=getDomainInfo();
$domainarr['domainnameimgs']="imgs.bharatmatrimony.com";

$_REQUEST['sn'] = "bharat";

ob_start();
include_once('bmsparser.php');
$var_results = ob_get_contents();
ob_end_clean();


$bm_results_decode = json_decode($var_results,true);
$num_rows = $bm_results_decode['profiles']['numFound'];

if($num_rows==0 || $num_rows=="") {
	if(trim($_REQUEST['wdmatch'])=="") { $_REQUEST['wdmatch'] = "A"; }
	ob_start(); 
	include_once('bmsparser.php');
	$var_results = ob_get_contents();
	ob_end_clean();
	$bm_results_decode = json_decode($var_results,true);
	$num_rows = $bm_results_decode['profiles']['numFound'];
	if($num_rows==0 || $num_rows=="") {
		//$redir = "http://search.bharatmatrimony.com/matrimonials/".$_REQUEST['keytext']."/static.html";
		$redir = "http://search.bharatmatrimony.com/matrimonials/".$_REQUEST['keytext']."/static.html?fromwhere=plugin";
//		$redir = "http://search.bharatmatrimony.com/matrimonials/".$_REQUEST['keytext']."/plugin/static.html";
		header("Location: $redir");
		exit;
	}
}

$img_path="http://imgs.bharatmatrimony.com/bmimages/";

$bm_results=getResults($bm_results_decode);

if($_REQUEST['GENDER'] == "F") {
	$bg_color_b="#FBEED6";
	$bg_color_g="#FFFFFF";
} else {
	$bg_color_b="#FFFFFF";
	$bg_color_g="#FBEED6";
}
$jsg_br=getBrowserDetails();
?>

<html>
<head>
<title><?php echo $_REQUEST['keytext'];?>, Register FREE! Search, Chat & Marry</title>
<META NAME="Description" CONTENT=""> 
<link rel="stylesheet" href="http://imgs.bharatmatrimony.com/styles/bmstyle.css">
<link rel="stylesheet" href="http://imgs.bharatmatrimony.com/bmstyles/smartsearchcss.css">
<script src="http://imgs.bharatmatrimony.com/bmjs/pop_up.js" language="javascript"></script>
<script src="http://imgs.bharatmatrimony.com/bmjs/popwindow.js" language="javascript"></script>
<script>
function sub_frm() {
//	document.google_srch_frm.action="http://bmser.bharatmatrimony.com/search/bmssearch.php";

	document.google_srch_frm.action="http://bmser.bharatmatrimony.com/search/bmssearch.php";
	document.google_srch_frm.submit();
}
function sub_ref_frm() {
	if(IsEmpty(document.ref_form.keytext,"text")) {
		alert("please enter the Keyword");
		document.ref_form.keytext.value="";
		document.ref_form.keytext.focus();
		return false;
	} else {
	document.ref_form.action="http://bmser.bharatmatrimony.com/search/bmssearch.php";
	document.ref_form.submit();
	}
}

function sub_gender_frm(v) {
	var frm=document.google_srch_frm;
	document.google_srch_frm.GENDER.value=v;
	document.google_srch_frm.gender_assign.value=1;
	frm.submit();
}

function ph_change(phname,phid) { document.getElementById(phid).src=phname; }

function return_div_object(divname) { var cdiv=document.getElementById(divname); if(cdiv=="[object HTMLDivElement]" || cdiv=="[object]") { return cdiv; } else { return "nodiv"; } }

function getobject(obj) { if(document.getElementById) { return document.getElementById(obj) } else if(document.all) { return document.all[obj] } }

function show_result_div(v) {
	if(v=='G') {
		return_div_object('div_b').style.background="white";
		return_div_object('div_g').style.background="#FBEED6";
		document.google_srch_frm.GENDER.value='M';
	} else {
		return_div_object('div_b').style.background="#FBEED6";
		return_div_object('div_g').style.background="white";
		document.google_srch_frm.GENDER.value='F';
	}
}

function veriPopUp(){sealWin=window.open("https://seal.verisign.com/splash?form_file=fdf/splash.fdf&dn=BHARATMATRIMONY.COM&lang=en","win",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=535,height=450');self.name = "mainWin";}

function bookmark(title){
	var url=window.location.href;
	  if ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4)) {
		window.external.AddFavorite(url,title);
	  } else {
		alert("Press CTRL+D (Netscape) or CTRL+T (Opera) to bookmark");
        }
}

function getHTTPObject() {
	var xmlhttp; try { xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");  } catch (e) { try { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { xmlhttp=false; } } 
	if(!xmlhttp && typeof XMLHttpRequest !=undefined) { try { xmlhttp=new XMLHttpRequest(); } catch (e) { xmlhttp=false; } }
	if(!xmlhttp) { display_error_message(e,"noajax"); return; } else { return xmlhttp; }
}

var jsg_http=new getHTTPObject();

function call_plug() {
	window.external.AddSearchProvider("http://search.bharatmatrimony.com/bmsearch.xml");	
	url="http://search.bharatmatrimony.com/cgi-bin/google_bmsearch_plugin.php?plu=1";	
	jsg_http.open("GET", url, true);	
	jsg_http.onreadystatechange=function() { };
	jsg_http.send(null);
}

</script>
</head>
<BODY topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">

<table border="0" cellpadding="0" cellspacing="0" align="center" width="780" class="maintborder" bgcolor="#ffffff">
<tr>
	<td>	
	<table border="0" cellpadding="0" cellspacing="0" width="778" align="center">
	<tr>
		<td width="200"><img src="http://imgs.communitymatrimony.com/images/logo/community_logo.gif"  alt="<?=$keyword_caps;?> Marriage Site" border="0">
		</td>
		<?php if($jsg_br=="F")
		{?>
		<td class="smalltxtgr" align="right"><font onClick="call_plug()" class="linktxt2 cstyle" >Click here to Add Bharat Matrimony Search Plugin&nbsp;&nbsp;</font></td>
		<?php }?>
	</tr>
	</table>
	</td>
</tr>
<tr>
<td valign="top">
<table width="100%" border="0" align="center">
<tr>
<td valign="top">
<table align="center"  cellpadding="0" cellspacing="0" border="0">
<?php if($num_rows!=0)
{?>
<tr>
<td colspan="2" valign="top">
<div>
<form name="ref_form" method="post" onSubmit="sub_ref_frm();"><?php getHiddenBoxes();?>
<div style="float:left;"><img src="<?=$img_path;?>/trans.gif" width="5" height="1"></div>
<div <?php if($GENDER=='M'){?>onclick="sub_gender_frm('F');" class="cstyle smalltxtgr maintborder"<?php } else {?> class="smalltxtgr maintborder" <?php }?> id="div_b" style="background-color:<?=$bg_color_b;?>;float:left;height:12px;padding-top:5px;padding-bottom:5px;"><font color='#9A440D'>&nbsp;&nbsp;Brides&nbsp;&nbsp;</font>
</div>
<div style="float:left;"><img src="<?=$img_path;?>/trans.gif" width="5" height="1"></div>
<div <?php if($GENDER=='F'){?>onclick="sub_gender_frm('M');" class="cstyle smalltxtgr maintborder" <?php } else {?>class="smalltxtgr maintborder" <?php }?>  id="div_g" style="background-color:<?=$bg_color_g;?>;float:left;height:12px;padding-top:5px;padding-bottom:5px;"><font color='#9A440D' >&nbsp;&nbsp;Grooms&nbsp;&nbsp;</font>
</div>
<div style="float:left;"><img src="<?=$img_path;?>/trans.gif" width="5" height="1"></div>
<div style="float:left;height:20px;padding-bottom:0px;padding-top:2px;text-align:middle;"><font class="smalltxtgr">&nbsp;&nbsp;&nbsp;<a href="http://bmser.bharatmatrimony.com/" class="linktxt2">Bharat Matrimony</a>&nbsp;>&nbsp;<a href="http://bmser.bharatmatrimony.com/search/bmssearchform.php?fromwhere=plugin" class="linktxt2" title="Search, Chat & Marry">Search</a>&nbsp;>&nbsp;</font><font class="smalltxtgr"><b><?=$_REQUEST['keytext'];?></b></font></div>
</div><div style="float:right;">
<script>
		var tit="<?=$_REQUEST['keytext'];?>";
		if(tit==''){
			tit="Bharat";
			}
		tit+=" Matrimony";
		if (navigator.appName == "Netscape" || navigator.appName == "Opera") {document.write("<font style='font: normal 12px arial,verdana;color:#FE7313;'>Press CTRL+D to bookmark</font>");
		}else{
		document.write('<a href="javascript: void(0)"  class="hpnormaltxt" onclick=\'bookmark(tit);\'><font style="font: normal 12px arial,verdana;color:#FE7313;">Bookmark This Page</font></a>');
		}
		</script>&nbsp;&nbsp;</div>
</form>
</td>
</tr>
<tr><td valign="top" bgcolor="#EBDED3" colspan="2" ><img src="<?=$img_path;?>/trans.gif" width="1" height="1"></td></tr>
<?php } ?>
<tr>
	<td valign="top" width="80%">
		<table align="center" width="100%">
		<?php if($num_rows!=0) {
		echo $bm_results;
		?>
		<tr>
		<td align="right"><a href="javascript:sub_frm();" class='smalltxtgr linktxt2'><b>More Profiles</b></font></a><br></td>
		</tr>
		<?
		}  else {
		$redir="http://bmser.bharatmatrimony.com/search/bmssearchform.php?fromwhere=plugin&googl_from=1&keytext=".$_REQUEST['keytext'];
		header("Location: $redir");
		exit;
		 }?>
		</table>
		</td>
		<td valign="top" align="center" width="20%">
		<table align="center">
		<tr>
		<td> 
		<?php include "commquickregister.php"; ?>
		</td>
		</tr>
		<tr>
		<td><font style='font: normal 12px arial,verdana;color:#FE7313;'>Search, Chat & Marry!</font>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
	</td>
	</tr>
<tr>
<td>
<div style="width: 778px;" style="margin: 0pt 0pt 0px 0px;"><img src="<?=$img_path;?>/footer-line.gif" width="778" height="1" alt="" /></div>
<div style="width: 778px;">
		<div style="width: 130px;float: left; padding-top: 5px; text-align: left;">

					<div style="width: 130px; float: left; text-align: left;"><img src="<?=$img_path;?>/footer-isologo-new.gif" width='130' height='69' hspace='8' vspace='3' border='0' alt='ISO Certified Company' /></div>
		</div>
		<div style="width: 525px;float: left; text-align: left;">
					<div style="width: 525px; float: left; text-align: left;">
						<div class="medium" style="float: middle; text-align: middle; margin-left: 100px;" style="color: #666666;">
								<div style="margin: 5pt 0pt 6px 55px;"><a href="http://www.bharatmatrimony.com/termscond.shtml" target="_blank" class="hpnormaltxt" title="Terms and Conditions"><font color="#999999">Terms and Conditions</font></a>&nbsp;|&nbsp;<a href="http://www.bharatmatrimony.com/privacy.shtml" target="_blank" class="hpnormaltxt" title="Privacy Policy"><font color="#999999">Privacy Policy</font></a></div>
						</div>
					</div>
		</div>
		<div style="width: 87px;float: left; text-align: left;"><div style="width: 87px; float: left; text-align: left;"><a href="javascript:veriPopUp()"><img src="<?=$img_path;?>/footer-verisignlogo.gif" width="87" height="58" hspace="8" vspace="3" border="0" alt="VeriSign" /></a></div></div>

</div>
<div style="width: 778px;"><div style="margin: 0pt 0pt 0px 0px;"><img src="<?=$img_path;?>/footer-line.gif" width="778" height="1" alt="" /></div></div>
<div style="margin: 5pt 10pt 5px 1px;text-align:center;" class="hpnormaltxt"><script language="javascript" src="http://imgs.bharatmatrimony.com/bmjs/copyright.js" type="text/javascript"></script></div>
<form name="google_srch_frm" method="post">
<input type="hidden" name="keytext" value="<?=$keytext;?>">
<input type="hidden" name="">
<input type="hidden" name="gender_assign" value=0>
<?php getHiddenBoxes();trackingUrl();?>
</form>

</td>
</tr>
</table>
</body>
</html>

<?php
function getResults($bm_results) {
global $label_array_list ,$l_star,$l_location_informntion,$l_education,$l_occupation,$l_age,$l_height,$l_religion,$domainarr;
foreach($bm_results as $e=>$values) {	
	if(is_array($values)) {
	foreach($values as $e1=>$value) {
		if(is_array($value)) {
		foreach($value as $v=>$val) {
			$i++;
		if($i>5)
			break;

		$xml_MId=$val['MatriId'];		
		$xml_bs_arr=split("\^",$val['BO']); 
		$xml_Photos=$val['P'];
		$jsg_cp=1;
		$xml_UpperIcons=$val['UI'];

		$xml_LastLogin_array=split("\^",$val['LE']);
		$dt_upper_icons=getUpIcons($xml_UpperIcons,$xml_MId,$xml_LastLogin_array);
    	$xml_image=getMainPhotoGoogle($xml_Photos,$xml_MId,$domainarr['domainnameshort'],$xml_LastLogin_array);

		$xml_thumb_img_links=getPhotoLinksGoogle($xml_Photos,$jsg_cp,$xml_MId);
		($xml_thumb_img_links!='') ? $thumb_img_links_div='<div class="newcss8">'.$xml_thumb_img_links.'</div>' : $thumb_img_links_div='<div class="newcss8"></div>';

		$xml_expressinterest_link="<img src='http://imgs.bharatmatrimony.com/bmimages/brown-arrow.gif' width='6' height='7' border='0' align='absmiddle' hspace='3' vspace='5'><a href='http://bmser.bharatmatrimony.com/login/loginform.php?mid=".$xml_MId."&fname=/profiledetail/viewprofile.php?id=".$xml_MId."'	target='_blank' class='linktxt2'>Register FREE to contact this member</a>&nbsp;&nbsp;";
		$Description=explode("-@#$#@-",$val['TD']);

		$xml_Desc=highlightDesc($Description[1]);
		$xml_Title=str_replace("bm_do","<div class='newcss11'><font class='smalltxtgr'>",$Description[0]);
		$xml_Title=str_replace("bm_dc","</font></div>",$xml_Title);		
		$xml_Title=str_replace("bm_la","<b>$l_age</b>",$xml_Title);		
		$xml_Title=str_replace("bm_lh","<b>$l_height</b>",$xml_Title);		
		$xml_Title=str_replace("bm_lr","<b>$l_religion</b>",$xml_Title);		
		$xml_Title=str_replace("bm_ls","<b>$l_star</b>",$xml_Title);
		$xml_Title=str_replace("bm_ll","<b>$l_location_informntion</b>",$xml_Title);
		$xml_Title=str_replace("bm_le","<b>$l_education</b>",$xml_Title);
 		$xml_Title=str_replace("bm_lo","<b>$l_occupation</b>",$xml_Title);

		$xml_Photos=split("\^",$val['P']);

		$xml_viewprofile="<a href='http://bmser.bharatmatrimony.com/profiledetail/viewprofile.php?id=".$xml_MId."' target='_blank' class='linktxt2' >";
		$more_link=$xml_viewprofile."More...</a>";
		$Html.="<tr><td align='left'>";
		$Html.="<table align='left' border='0' cellpadding=0' cellspacing='0' class='".$xml_bs_arr[0]."' width='590' style='table-layout:fixed'><tr><td valign='top' width='126' align='center'><div class='newcss1'><div><div class='tpb'>".$xml_image."</div>".$photogallery_cs."</div>".$xml_Enlarge."</div>".$thumb_img_links_div."<div class='newcss2'>".viewSimilarProfile($xml_MId)."</div>".$online_link_div."</td><td valign='top' width='1' height='100%'><div class='newcss3'><div style='background-color:#CEAE95'>".getTransImage('100%',1,0)."</div></div></td><td valign='top'><div class='newcss4' style='padding-left:5px;'><div style='height:20px;' class='smalltxtgr'><div class='newcss5'>".$xml_viewprofile."<font color='#EF6F1F'><b>".$xml_MId."</b></font></a>".$dt_upper_icons.getTransImage(16,1,0)."</div>".$la_c_div."</div>".$xml_Title.$xml_Desc.$more_link."<br/>".getTransImage(5,1,0)."</td></tr><tr><td valign='top' colspan='3' height='1'><div class='newcss6'><div style='background-color:#CEAE95'>".getTransImage(1,'100%',0)."</div></div></td></tr><tr><td valign='top' colspan='3' bgcolor='#FBEED6'><table border='0' cellpadding='2' cellspacing='0' width='100%'><tr><td valign='middle' width='7'><span style='float:left'>".$xml_matri_cbox."</span></td><td valign='middle' class='smalltxtgr' width='250'>Last Login : ".$xml_LastLogin_array[0].getTransImage(1,3,0).$xml_bbi_icons."</td><td valign='middle' align='right' height='24'>".$xml_expressinterest_link."</td></tr></table></td></tr></table></td></tr><tr><td>&nbsp;</td></tr>";			
		}
		}
	}
	}

}
return $Html;
}
function getTransImage($h,$w,$b) {
return "<img src='http://imgs.bharatmatrimony.com/bmimages/trans.gif' height='".$h."' width='".$w."' border='".$b."'>";
} 

function getUpIcons($xml_UpperIcons,$xml_MId,$xml_LastLogin_array) {
	$xml_ui_arr=split("-",$xml_UpperIcons);

	if($xml_ui_arr[0]==1) {  
		$xml_pv_c ="<a  href=\"javascript:openpop('','http://bmser.bharatmatrimony.com/assuredcontact/assuredphoneverifywork.php?ID=".$xml_MId."','no','yes',560,313);\"><img src='http://imgs.bharatmatrimony.com/bmimages/phone-verified-icon-new.gif' alt='View Phone Number' hspace='5' width='16' height='16' border='0' align='abstop'></a>";
	}
	if($xml_ui_arr[1]!="" && $xml_ui_arr[1]!=0) {	 
		$xml_ha_c="<A href=\"javascript:openpop('','http://img.bharatmatrimony.com/cgi-bin/horoview.php?ID=".$xml_MId."&PID=".$xml_MId."','yes','yes',675,500);\">";

		if($xml_ui_arr[1]==1) { 
			$xml_ha_c.="<img src='http://imgs.bharatmatrimony.com/bmimages/horoscope-icon-new.gif' alt='View Horoscope' hspace='5' width='16' height='16' border='0' align='abstop'></a>";

		} else if($xml_ui_arr[1]==2 || $xml_ui_arr[1]==3) { 
			$xml_ha_c.="<img src='http://imgs.bharatmatrimony.com/bmimages/horo-gen-icon.gif' alt='View Horoscope' hspace='5' width='16' height='16' border='0' align='abstop'></a>";
		}
	}

	if($xml_ui_arr[2]==1) {
	$xml_va_c="<A href=\"javascript:viewvideo('http://bmser.bharamatrimony.com/cgi-bin/viewvideo.cgi?ID=".$xml_MId."');\"><img src='http://imgs.bharatmatrimony.com/bmimages/video-icon-new.gif' alt='View Video' hspace='5' width='16' height='16' border='0' align='abstop'></a>";	
	}

	if($xml_ui_arr[3]!="" && $xml_ui_arr[3]!=0) {
	$xml_ProfileVerified_array=split("\^",$xml_ui_arr[3]);
	switch($xml_ProfileVerified_array[0]) {   
			case 1: $xml_prov_c="<a href=\"javascript:openpop('','http://bmser.bharamatrimony.com/cgi-bin/displayverifieddet.cgi?ID=".$xml_MId."','no','yes',425,497);\"><img src='http://imgs.bharatmatrimony.com/bmimages/profileverified-icon-new.gif' alt='View VeriProfile' hspace='5'  width='16' height='16' border='0' align='abstop'></a>"; break;
			case 5: $xml_prov_c="<a href=\"javascript:openpop('','http://img.bharatmatrimony.com/cgi-bin/stampcard.cgi?ID=".$xml_MId."','no','yes',361,195);\"><img src='http://imgs.bharatmatrimony.com/bmimages/profilestamped-icon-new.gif' alt='Matrimony Stamp' hspace='5'  width='16' height='16' border='0' align='abstop'></a>"; break;
			case 6: $xml_prov_c="<a href=\"javascript:openpop('','http://bmser.bharamatrimony.com/cgi-bin/displayverifieddet.cgi?ID=".$xml_MId."','no','yes',425,497);\"><img src='http://imgs.bharatmatrimony.com/bmimages/profileverified-icon-new.gif' alt='View VeriProfile' hspace='5'  width='16' height='16' border='0' align='abstop'></a><a href=\"javascript:openpop('','http://img.bharatmatrimony.com/cgi-bin/stampcard.cgi?ID=".$xml_MId."','no','yes',361,195);\"><img src='http://imgs.bharatmatrimony.com/bmimages/profilestamped-icon-new.gif' alt='Matrimony Stamp' hspace='5'  width='16' height='16' border='0' align='abstop'></a>"; break;
		}
	}
	if($xml_ui_arr[4]==1) {  
		$xml_vo_c="<A href=\"javascript:openpop('','http://bmser.bharatmatrimony.com/voicematrimony/voicepopup.php?ID=".$xml_MId."',550,500,'no','no');\"><img src='http://imgs.bharatmatrimony.com/bmimages/voiceicon.gif' alt='Hear Voice' hspace='5' width='16' height='16' border='0' align='abstop'></a>"; 
	} 		
	return $xml_pv_c.$xml_va_c.$xml_ha_c.$xml_prov_c.$xml_vo_c;
}

function getPhotoLinksGoogle($xp,$jsg_cp,$xml_MId) {
	$xp_array=split("\^",$xp);
	$xml_photo_length=count($xp_array);
	for($img_arr=0;$img_arr<$xml_photo_length;$img_arr++) {
		if($xml_photo_length>1 && $xp_array[$img_arr]!="" ) {
			$x.="<a style='cursor:pointer;cursor:hand;' onClick=\"javascript:ph_change('".$xp_array[$img_arr]."','".$xml_MId."_n2')\" class='linktxt'><font color='#94663E'><u>".($img_arr+1)."</u></font></a>&nbsp;";
		}
	} return $x;
}

function viewSimilarProfile($xml_MId) {
	global $DISPLAY_FORMAT,$jsg_br;
	//return "<a 					href='http://bmser.bharatmatrimony.com/search/smartsearch.php?smart_query_type=smartsearch&t=S&DISPLAY_FORMAT=".$DISPLAY_FORMAT."&bversion=".$jsg_br."&ID=".$xml_MId."&fromwhere=S&GENDER=".$jsg_gender."' target='_blank' class='linktxt2'>View Similar Profiles</a>"; 
	return "<a href='http://bmser.bharatmatrimony.com/search/dosearch.php?type=viewsimilarprofiles&ID=".$xml_MId."' target='_blank' class='linktxt2'>View Similar Profiles</a>";		
}

function getMainPhotoGoogle($xp,$xml_MId,$domain_n,$xml_LastLogin_array) {
	$xp_array=split("\^",$xp);

	preg_match("/requestphoto75x75.gif/",$xp_array[0],$request_photo);
	preg_match("/protectedphotoimg-75x75.gif/",$xp_array[0],$photo_pro);
	if($request_photo[0]=="") { 
		$common_vp_link="<a href=\"javascript:openpop('','http://img.bharatmatrimony.com/photo/viewphoto.php?ID=".$xml_MId."&PID=".$xml_LastLogin_array[2]."','yes','no',667,650)\">";
	} else {
		$common_vp_link='<a href="http://bmser.bharatmatrimony.com/login/loginform.php?frompg=rp&mid='.$xml_MId.'&fname=/profiledetail/viewprofile.php?id='.$xml_MId.'" target="_blank">';
	}
	return $common_vp_link."<img src='".$xp_array[0]."' border='0' vspace='2' hspace='2' width='75' height='75' id='".$xml_MId."_n2'></a>";
}
 function getHiddenBoxes()
 {
	global $keytext,$RS_STAGE,$RS_ENDAGE,$GENDER,$RS_STHEIGHT,$RS_ENDHEIGHT,$RS_PHOTO_OPT1,$RS_HOROSCOPE_OPT1,$wdmatch,$df,$COMMONVARS;

	if($_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]==$COMMONVARS['SMART_DEBUG_VAL']) { echo '<input type=hidden name="'.$COMMONVARS['SMART_DEBUG_PARAM'].'" value="'.$COMMONVARS['SMART_DEBUG_VAL'].'">'; }
	?>
<input type="hidden" name="RS_STAGE" value="<?=$RS_STAGE;?>">
<input type="hidden" name="RS_ENDAGE" value="<?=$RS_ENDAGE;?>">
<input type="hidden" name="GENDER" value="<?=$GENDER;?>">
<input type="hidden" name="RS_STHEIGHT" value="<?=$RS_STHEIGHT;?>">
<input type="hidden" name="RS_ENDHEIGHT" value="<?=$RS_ENDHEIGHT;?>">
<input type="hidden" name="RS_PHOTO_OPT1" value="<?=$RS_PHOTO_OPT1;?>">
<input type="hidden" name="RS_HOROSCOPE_OPT1" value="<?=$RS_HOROSCOPE_OPT1;?>">
<input type="hidden" name="wdmatch" value="<?=$wdmatch;?>">
<input type="hidden" name="DISPLAY_FORMAT" value="<?=$df;?>">
<input type="hidden" name="goog_land" value=1>
<?php 
		}

function getBrideGroomBasedonKeytext($groom_typos_array,$bride_typos_array,$keytext) {
	$groom=0; $bride=0;
	$keytext=strtolower(urldecode($keytext));
	$keytext_array = explode(" ",$keytext);

	foreach($keytext_array as $k) {
		if(in_array($k, $groom_typos_array)) {
			$groom++;
		}
		if(in_array($k, $bride_typos_array)) {			
			$bride++;
		}
	}
	if($bride<$groom) {
		return "M"; 
	} else {
		return "F";
	}
}
function highlightDesc($org_str) {
	$str=removeSpaces($org_str);
	$str_arr=split(" ",$str);
	if($str_arr) {
		if(in_array($_REQUEST['keytext'],$str_arr)) {
			foreach($str_arr as $i=>$val) {
				if($val==$_REQUEST['keytext']) {				
					$ind=$i;
					break;
				}
			}		
		}
	}
	$count=count($str_arr);
	$dif=$count-$ind;
	if($dif<6) {
		$ind=$ind-10;
	} else {
		$ind--;
	}

	if($ind>0) {
		$stval=$str_arr[$ind];
	}

	$pos = strpos($org_str, $stval);
	$end=100+$pos;
	$re_str = str_replace($_REQUEST['keytext'], "<b>".$_REQUEST['keytext']."</b>", $org_str);
	return substr($re_str,$pos ,$end);
}

function removeSpaces($word) {    $pattern=array("~","`","!","@","$","%","^","&","*","(",")","-","_","+","=","|","\\","{","}","[","]",":",";","\"","'","<",",",">",".","?","\/");
	$word=str_replace($pattern, " ", $word);	
	return preg_replace('/\s\s+/', ' ', trim($word));
}

function trackingUrl() {
	global $COMMONVARS;
	if($_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]==$COMMONVARS['SMART_DEBUG_VAL'] && $_REQUEST[$COMMONVARS['SMART_DEBUG_PARAM']]!="") {
		print_r($_REQUEST);
	}
	if($_REQUEST['referredby']!="") {			
	 ?>
	 <img width=0 height=0 src="http://server.bharatmatrimony.com/campaign/tracking.php?section=globalgoogle&domain=15&creative=<?=$_REQUEST['keytext'];?>&position=<?=$_REQUEST['adgroupid'];?>&landing=<?=$_REQUEST['campaignid'];?>&referredby=<?=$_REQUEST['referredby'];?>">
	<?
	} else if($_SERVER['HTTP_REFERER']=="" && $_REQUEST['referredby']=="") { ?><img src="http://server.bharatmatrimony.com/campaign/tracking.php?section=Google_Bookmark&siteurlsite=google_text_track&domain=15&landing=www.bharatmatrimony.com&creative=bookmark&referredby=74210000" width="0" height="0" border='0'><? 
	} else if($_REQUEST['fromwhere']=="plugin" && $_REQUEST['referredby']=="") { ?><img src="http://server.bharatmatrimony.com/campaign/tracking.php?section=google_plugin&siteurlsite=google_nri_contexual&domain=15&landing=googlelanding.shtml&creative=bm_google_plugin_13feb08&referredby=73900001" width="0" height="0" border='0'><? 
	} else { 
		 $referredby=50000000;			
		?><img width=0 height=0 src="http://server.bharatmatrimony.com/campaign/tracking.php?section=globalgoogle&domain=15&creative=<?=$_REQUEST['keytext'];?>&position=<?=$_REQUEST['adgroupid'];?>&landing=<?=$_REQUEST['campaignid'];?>&referredby=<?=$referredby;?>">		
 <? }
}
?>