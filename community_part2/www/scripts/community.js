var religion = [
	"MuslimMatrimony","ChristianMatrimony","SikhMatrimony","JainMatrimony","BuddhistMatrimony"
];

var caste = [
"AddharmiMatrimony","AdidravidarMatrimony","AgarwalMatrimony","AgriMatrimony","AhomMatrimony","AmbalavasiMatrimony",
"AnavilMatrimony","ArekaticaMatrimony","ArunthathiyarMatrimony","AroraMatrimony","AryavysyaMatrimony","AudichyaMatrimony",
"BadagarMatrimony","BaidyaMatrimony","BaishnabMatrimony","BaishyaMatrimony","BalijanaiduMatrimony","BanikMatrimony",
"BaniyaMatrimony","BanjaraMatrimony","BaraiMatrimony","BarendraMatrimony","BariMatrimony","BarujibiMatrimony","BestaMatrimony",
"BhandariMatrimony","BhatiaMatrimony","BhatrajuMatrimony","BhattMatrimony","BhavasarkshatriyaMatrimony","BhoviMatrimony",
"BhumiharMatrimony","BillavaMatrimony","BoyerMatrimony","BrahmbhattMatrimony","BrahminMatrimony","ChambharMatrimony",
"ChandravanshikaharMatrimony","ChasaMatrimony","ChattadasrivaishnavaMatrimony","ChaudaryMatrimony","ChaurasiaMatrimony","ChettiyarMatrimony",
"ChhetriMatrimony","ChippoluMatrimony","CkpMatrimony","CoorgMatrimony","DaivadnyaMatrimony","DanuaMatrimony","DeshasthaMatrimony",
"DevadigaMatrimony","DevandrarMatrimony","DevangaMatrimony","DevangkoshthiMatrimony","DhangharMatrimony","DheevaraMatrimony",
"DhimanMatrimony","DhobaMatrimony","DhobiMatrimony","DravidaMatrimony","DumalMatrimony","DusadhMatrimony","EdigaMatrimony",
"EzhavaMatrimony","EzhuthachanMatrimony","GabitMatrimony","GandlaMatrimony","GanigaMatrimony","GarhwalMatrimony",
"GaurMatrimony","GavaranaiduMatrimony","GawaliMatrimony","GhisadiMatrimony","GhumarMatrimony","GoalaMatrimony",
"GomantakMatrimony","GondhaliMatrimony","GoudMatrimony","GoundarMatrimony","GowdaMatrimony","GramaniMatrimony",
"GudiaMatrimony","GujjarMatrimony","GuptaMatrimony","GuptanMatrimony","GuravMatrimony","GurjarMatrimony","GurukkalMatrimony",
"HaluaMatrimony","HavyakaMatrimony","HugarMatrimony","HoysalaMatrimony","IntercasteMatrimony","IraniMatrimony","IyengarMatrimony",
"IyerMatrimony","JaalariMatrimony","JaiswalMatrimony","JandraMatrimony","JangamMatrimony","JangidMatrimony","JatMatrimony",
"JatavMatrimony","JhaduaMatrimony","JogiMatrimony","KacharaMatrimony","KadavapatelMatrimony","KaibartaMatrimony","KalarMatrimony",
"KalingaMatrimony","KalingavysyaMatrimony","KalitaMatrimony","KalwarMatrimony","KambojMatrimony","KammanaiduMatrimony",
"KansariMatrimony","KanyakubjMatrimony","KapunaiduMatrimony","KaranaMatrimony","KarhadeMatrimony","KarmakarMatrimony",
"KaruneegarMatrimony","KasarMatrimony","KashyapMatrimony","KatiyaMatrimony","KayasthaMatrimony","KhandayatMatrimony","KhandelwalMatrimony",
"KharwarMatrimony","KhatriMatrimony","KoiriMatrimony","KokanasthaMatrimony","KokanasthamarathaMatrimony","KoliMatrimony",
"KonguvellalarMatrimony","KonkanMatrimony","KoriMatrimony","KotaMatrimony","KshatriyaMatrimony","KudumbiMatrimony",
"KulalMatrimony","KulalarMatrimony","KulinMatrimony","KulitaMatrimony","KumawatMatrimony","KumbhakarMatrimony","KumbharMatrimony",
"KumharMatrimony","KummariMatrimony","KumoaniMatrimony","KunbiMatrimony","KuravanMatrimony","KurmiMatrimony","KurmikshatriyaMatrimony",
"KurubaMatrimony","KuruhinashettyMatrimony","KurumbarMatrimony","LambaniMatrimony","LevapatelMatrimony","LevapatilMatrimony",
"LingayathMatrimony","LodhirajputMatrimony","LohanaMatrimony","LubanaMatrimony","MadhvaMatrimony","MadigaMatrimony",
"MahajanMatrimony","MaharMatrimony","MahendraMatrimony","MaheshwariMatrimony","MahishyaMatrimony","MaithilMatrimony",
"MajabiMatrimony","MalaMatrimony","MaliMatrimony","MallaMatrimony","MangaloreanMatrimony","ManipuriMatrimony",
"MapilaMatrimony","MarathaMatrimony","MaruthuvarMatrimony","MatangMatrimony","MathurMatrimony",
"MeenaMatrimony","MeenavarMatrimony","MehraMatrimony","MerudarjiMatrimony","MochiMatrimony","ModakMatrimony","ModhMatrimony",
"MogaveeraMatrimony","MudaliyarMatrimony","MudirajMatrimony","MunnurukapuMatrimony","MuthurajaMatrimony","NadarMatrimony",
"NaagavamsamMatrimony","NagarMatrimony","NagaraluMatrimony","NaiMatrimony","NaickerMatrimony","NaikMatrimony","NairMatrimony",
"NambiarMatrimony","NamboodiriMatrimony","NamosudraMatrimony","NapitMatrimony","NayakaMatrimony","NeeliMatrimony","NepaliMatrimony",
"NhaviMatrimony","NiyogiMatrimony","OswalMatrimony","OtariMatrimony","PadmasaliMatrimony","PalMatrimony","PanchalMatrimony",
"PandaMatrimony","PanditMatrimony","PanickerMatrimony","ParkavakulamMatrimony","PartrajMatrimony","PasiMatrimony","PatelMatrimony",
"PatnaickMatrimony","PatraMatrimony","PerikaMatrimony","PillaiMatrimony","PorwalMatrimony","PrajapatiMatrimony",
"PushkarnaMatrimony","RaigarMatrimony","RajakaMatrimony","RajastaniMatrimony","RajbonshiMatrimony","RajputMatrimony","RamdasiaMatrimony",
"RamgariahMatrimony","RarhiMatrimony","RavidasiaMatrimony","RawatMatrimony","ReddyMatrimony","RelliMatrimony","RigvediMatrimony",
"RudrajMatrimony","SadgopeMatrimony","SahaMatrimony","SahuMatrimony","SainiMatrimony","SakaldwipiMatrimony","SaliyaMatrimony",
"SanadyaMatrimony","SanketiMatrimony","SavjiMatrimony","SaraswatMatrimony","SaryuparinMatrimony","ScMatrimony","SenaithalaivarMatrimony",
"SengunthamudaliyarMatrimony","SettibalijaMatrimony","ShettyMatrimony","ShimpiMatrimony","ShivhalliMatrimony","ShrimaliMatrimony",
"SkpMatrimony","SmarthaMatrimony","SonarMatrimony","SourashtraMatrimony","SozhiyavellalarMatrimony","StMatrimony",
"StanikaMatrimony","SugaliMatrimony","SunariMatrimony","SundhiMatrimony","SutharMatrimony","SwakulasaliMatrimony","TamboliMatrimony",
"TantiMatrimony","TantubaiMatrimony","TelagaMatrimony","TeliMatrimony","ThakkarMatrimony","ThevarMatrimony","ThakurMatrimony",
"ThigalaMatrimony","ThiyyaMatrimony","TiliMatrimony","TogataMatrimony","TonkkshatriyaMatrimony","TurupukapuMatrimony",
"TyagiMatrimony","UpparaMatrimony","UrsMatrimony","VadabalijaMatrimony","VadderaMatrimony","VaidikiMatrimony",
"VaishMatrimony","VaishnavMatrimony","VaishnavaMatrimony","VaishyaMatrimony","VaishyavaniMatrimony","ValluvanMatrimony",
"ValmikiMatrimony","VaniaMatrimony","VaniyaMatrimony","VanjaraMatrimony","VanjariMatrimony","VankarMatrimony","VannarMatrimony",
"VanniyarMatrimony","VariarMatrimony","VeerasaivamMatrimony","VelaanMatrimony","VelanaduMatrimony","VellalarMatrimony","VelamanaiduMatrimony",
"VeluthedathunairMatrimony","VettuvagounderMatrimony","VilakkithalanairMatrimony","VishwakarmaMatrimony","ViswabrahminMatrimony",
"VokkaligaMatrimony","VyasMatrimony","VysyaMatrimony","YadavMatrimony","YellapuMatrimony"
];

var special = [
"40PlusMatrimony","AbilityMatrimony","AnycasteMatrimony","DefenceMatrimony","DivorceeMatrimony","ManglikMatrimony"

];