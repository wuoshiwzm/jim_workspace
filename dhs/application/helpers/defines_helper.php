<?php
if (! defined('BASEPATH'))
exit('No direct script access allowed');
class Defines
{
	static $gCity = array("991"=>"乌鲁木齐","990"=>"克拉玛依","992"=>"奎屯","903"=>"和田","995"=>"吐鲁番","902"=>"哈密","994"=>"昌吉","909"=>"博州","996"=>"巴州","997"=>"阿克苏","908"=>"克州","999"=>"伊犁","901"=>"塔城","906"=>"阿勒泰","993"=>"石河子","998"=>"喀什","900"=>"长途传输局","899"=>"云基地");
	static $gCounty = array("992"=>array("9920"=>"奎屯市","9921"=>"车排子"),"903"=>array("9030"=>"和田市","9031"=>"和田县","9032"=>"洛浦县","9033"=>"墨玉县","9034"=>"皮山县","9035"=>"策勒县","9036"=>"于田县","9037"=>"民丰县"),"991"=>array("99116"=>"米东区分局","99114"=>"开发区（头屯河区）分局","99115"=>"天山区分局","99118"=>"乌鲁木齐县分公司","99119"=>"延安路分局","99120"=>"沙依巴克分局","99123"=>"西北路分局","99124"=>"高新区（新市区）分局","99128"=>"达坂城区分局","99126"=>"水磨沟区分局","99129"=>"中山路分局","99130"=>"河北路分局","99131"=>"一枢纽","99132"=>"二枢纽"),"999"=>array("9991"=>"机场区","9990"=>"开发区","9992"=>"伊犁河","9993"=>"伊犁市","9994"=>"中心局","9995"=>"霍尔果斯","9996"=>"察布查尔县","9997"=>"巩留县","9998"=>"霍城县","9999"=>"尼勒克县","10000"=>"新源县","10001"=>"特克斯县","10002"=>"昭苏县","10003"=>"伊宁县"),"996"=>array("9960"=>"库尔勒","9961"=>"和静县","9963"=>"博湖县","9964"=>"焉耆县","9965"=>"和硕县","9966"=>"且末县","9967"=>"若羌县","9968"=>"尉犁县","9962"=>"轮台县"),"995"=>array("9950"=>"吐鲁番","9951"=>"鄯善县","9952"=>"托克逊县"));	
	static $gCountyCode = array("992"=>array("9920"=>"KTS","9921"=>"CPZ"),"903"=>array("9030"=>"HTS","9031"=>"HTX","9032"=>"LPX","9033"=>"MYX","9034"=>"PSX","9035"=>"CLX","9036"=>"YTX","9037"=>"MFX"),"991"=>array("99116"=>"MDQ","99114"=>"KFQ","99115"=>"TSQ","99118"=>"WMX","99119"=>"YAL","99120"=>"SQ0","99123"=>"XBL","99124"=>"GXQ","99128"=>"DBC","99126"=>"SMG","99129"=>"ZSL","99130"=>"HBL","99131"=>"YSN","99132"=>"ESN"),"999"=>array("9991"=>"JCQ","9990"=>"KFQ","9992"=>"YLH","9993"=>"YLS","9994"=>"ZXJ","9995"=>"HEG","9996"=>"CBZ","9997"=>"GLX","9998"=>"HCX","9999"=>"NLK","10000"=>"XYX","10001"=>"TKS","10002"=>"ZSX","10003"=>"YNX"),"996"=>array("9960"=>"KEL","9961"=>"HJX","9963"=>"BHX","9964"=>"YRX","9965"=>"HSX","9966"=>"QMX","9967"=>"RQX","9968"=>"WLX","9962"=>"LTX"),"995"=>array("9950"=>"TLF","9951"=>"SSX","9952"=>"TKX"));
	static $gStation = array("9920"=>array("9930"=>"中心局"));
	static $gRoomType = array("type1"=>"基站","type2"=>"数据中心","type3"=>"接入局所","type4"=>"通信机房","type5"=>"非生产用房");
	static $gRoomSubType = array("type1"=>array("STD"=>"标准","LARGE"=>"宏站","CELL"=>"末梢单元"),"type2"=>array("IT"=>"IT","VAL_ADDED"=>"增值","IDC"=>"IDC"),"type3"=>array("OUTDOOR"=>"室外机柜","FIXED"=>"固网接入点","FIXED_C"=>"固/C共址站","GLOBAL_EYE"=>"全球眼"),"type4"=>array("MAIN"=>"核心","NORMAL"=>"普通"),"type5"=>array("OFFICE"=>"办公用房","BUSSINESS"=>"营业用房","OTHER"=>"其他非生产用房"));
	static $gRervice = array("FIXED"=>"固网业务","MOBILE"=>"移动业务","VAL-ADDED"=>"增值业务","ICT"=>"ICT业务");
	static $gDevModel = array("camera"=>"摄像头","DoorXJL"=>"小精灵门禁","zxdu58-b121v21-ac"=>"ZXDU58-B121V21交流屏电源","zxdu58-b121v21-rc"=>"ZXDU58-B121V21整流屏电源","zxdu58-b121v21-dc"=>"ZXDU58-B121V21直流屏电源","zxdu58-b121v22-ac"=>"ZXDU58-B121V22交流屏电源","zxdu58-b121v22-rc"=>"ZXDU58-B121V22整流屏电源","zxdu58-b121v22-dc"=>"ZXDU58-B121V22直流屏电源","zxdu58-s301-ac"=>"ZXDU58-S301交流屏电源","zxdu58-s301-rc"=>"ZXDU58-S301整流屏电源","zxdu58-s301-dc"=>"ZXDU58-S301直流屏电源","psma-ac"=>"PSM-A交流屏电源(psma,psma10)","psma-rc"=>"PSM-A整流屏电源(psma,psma10)","psma-dc"=>"PSM-A直流屏电源(psma,psma10)","psma9-ac"=>"PSMA9交流屏电源","psma9-rc"=>"PSMA9整流屏电源","psma9-dc"=>"PSMA9直流屏电源","psm15a-ac"=>"PSM15A交流屏电源","psm15a-rc"=>"PSM15A整流屏电源","psm15a-dc"=>"PSM15A直流屏电源","m810g-ac"=>"M810G交流屏电源","m810g-rc"=>"M810G整流屏电源","m810g-dc"=>"M810G直流屏电源","m500f-ac"=>"M500F/S交流屏电源","m500f-rc"=>"M500F/S整流屏电源","m500f-dc"=>"M500F/S直流屏电源","m522s-ac"=>"M522S交流屏电源","m522s-rc"=>"M522S整流屏电源","m522s-dc"=>"M522S直流屏电源","smu06c-ac"=>"SMU06C交流屏电源","smu06c-rc"=>"SMU06C整流屏电源","smu06c-dc"=>"SMU06C直流屏电源","cuc0609h-ac"=>"CUC06-09H交流屏电源","cuc0609h-dc"=>"CUC06-09H直流屏电源","cuc0609h-rc"=>"CUC06-09H整流屏电源","ug40"=>"施耐德空调","water"=>"水浸","temperature"=>"温度","humid"=>"湿度","smoke"=>"烟感","power_302a"=>"D类板载电表","imem_12"=>"智能电表","battery_24"=>"交直流屏电源蓄电池组","battery_32"=>"UPS电源蓄电池组","fresh_air"=>"新风系统","liebert-ups"=>"力博特UPS","liebert-pex"=>"力博特PEX空调","datamate3000"=>"爱默生Datamate300","motivator"=>"油机","smd_device"=>"采集板","motor_battery"=>"油机启动电池","access4000x"=>"威尔逊Access4000油机","aeg-ms10se"=>"AEG低压配电柜","aeg-ms10m"=>"AEG低压补偿柜","vpdu"=>"虚拟低压配电","venv"=>"机房环境量","vcamera"=>"监控设备","vsmddevice"=>"采集设备","battery24_voltage"=>"蓄电池总电压","smart_device"=>"智能设备","dk04"=>"洲际开关电源DK04","dk04c"=>"洲际开关电源DK04C(支持DK04D,DK04E)","psm-6"=>"华为开关电源PSM-6","CMS200"=>"先控捷联CMS-200");
	static $gBrand = array("艾默生"=>array("0"=>"艾默生","1"=>"力博特","2"=>"华为电气","3"=>"安圣","4"=>"克劳瑞德"),"中达"=>array("0"=>"中达电通","1"=>"台达"),"中恒"=>array("0"=>"中恒","1"=>"施威特克","2"=>"侨兴"),"中兴"=>array("0"=>"中兴通讯"),"武汉普天"=>array("0"=>"洲际电源","1"=>"洲际电池"),"珠江"=>array("0"=>"珠江电源"),"动力源"=>array("0"=>"北京动力源"),"易达"=>array("0"=>"东莞易达"),"金威源"=>array("0"=>"深圳金威源"),"通力盛达"=>array("0"=>"北京通力盛达"),"安耐特"=>array("0"=>"深圳安耐特"),"新电元"=>array("0"=>"上海新电元通信设备有限公司"),"双登"=>array("0"=>"江苏双登"),"汤浅"=>array("0"=>"广东汤浅","1"=>"日本汤浅"),"南都"=>array("0"=>"浙江南都"),"圣阳"=>array("0"=>"山东圣阳"),"灯塔"=>array("0"=>"浙江卧龙灯塔"),"光宇"=>array("0"=>"哈尔滨光宇"),"华达"=>array("0"=>"深圳华达","1"=>"艾诺斯华达"),"GNB"=>array("0"=>"美国GNB"),"长光"=>array("0"=>"武汉长光"),"火炬"=>array("0"=>"淄博火炬"),"海霸"=>array("0"=>"山东海霸"),"派能"=>array("0"=>"中兴派能"),"大力神 "=>array("0"=>"大力>神"),"银泰"=>array("0"=>"武汉银泰"),"华日"=>array("0"=>"山东华日"),"丰日"=>array("0"=>"湖南丰日"),"文隆"=>array("0"=>"文隆"),"北京汉铭"=>array("0"=>"北京汉铭"),"联动天翼"=>array("0"=>"北京联动天翼"),"比亚迪"=>array("0"=>"比亚迪"),"汇龙"=>array("0"=>"云南汇龙"),"阳光 "=>array("0"=>"阳光"),"爱克赛"=>array("0"=>">爱克赛"),"施耐德"=>array("0"=>"施耐德","1"=>"梅兰日兰","2"=>"APC"),"GE"=>array("0"=>"美国通用"),"索科曼"=>array("0"=>"索科曼","1"=>"溯高美"),"易事特"=>array("0"=>"广东易事特"),"史图斯 "=>array("0"=>"STULZ"),"能威"=>array("0"=>"瑞士能威"),"西门子"=>array("0"=>"西门子"),"三菱"=>array("0"=>"三菱"),"华为"=>array("0"=>"华为技术"),"海通"=>array("0"=>"江苏海通"),"科士达"=>array("0"=>"科士达"),"科华 "=>array("0"=>"科华"),"爱维达"=>array("0"=>"爱维达"),"伊顿"=>array("0"=>"伊顿","1"=>"Powerware","2"=>"山特"),"志成冠军"=>array("0"=>"广东志成冠军"),"先控"=>array("0"=>"河北先控"),"佳力图 "=>array("0"=>"佳力图"),"海洛斯"=>array("0"=>"海洛斯"),"斯泰科"=>array("0"=>"北京斯泰科"),"格力 "=>array("0"=>"格力"),"海尔 "=>array("0"=>"海尔"),"科龙"=>array("0"=>"广东科龙"),"海信"=>array("0"=>"山东海信"),"志高"=>array("0"=>"志高"),"吉荣"=>array("0"=>"吉>荣"),"登高"=>array("0"=>"登高"),"美的"=>array("0"=>"美的"),"春兰"=>array("0"=>"春兰"),"大金 "=>array("0"=>"大金"),"华凌 "=>array("0"=>"华凌"),"盾安"=>array("0"=>"浙江盾安"),"约顿"=>array("0"=>"上海约顿"),"铨高"=>array("0"=>"珠海铨高"),"融和"=>array("0"=>"北京融和"),"松下"=>array("0"=>"松下"),"优力 "=>array("0"=>"优力"),"阿尔西 "=>array("0"=>"阿尔西"),"阿特拉斯"=>array("0"=>"阿特拉斯"),"艾苏威尔 "=>array("0"=>"艾苏威尔"),"开利 "=>array("0"=>"开利"),"依米康"=>array("0"=>"四川依米康"),"十字军 "=>array("0"=>"十字军"),"康明斯 "=>array("0"=>"康明斯"),"卡特彼勒 "=>array("0"=>"卡特彼勒"),"道依兹  "=>array("0"=>"道依兹"),"劳斯莱斯"=>array("0"=>"劳斯莱斯"),"威尔信"=>array("0"=>"威尔信"),"科泰"=>array("0"=>"上海科泰"),"科技"=>array("0"=>"泰豪科技"),"威能"=>array("0"=>"番禺威能"),"济柴"=>array("0"=>"济南柴油机"),"怡昌"=>array("0"=>"怡昌"),"开普"=>array("0"=>"开普"),"德锋 "=>array("0"=>"德锋"),"南柴"=>array("0"=>"南昌柴油机"),"科勒"=>array("0"=>"含常州科勒"),"BEST "=>array("0"=>"BEST"),"IMV"=>array("0"=>"IMV"),"波利 "=>array("0"=>"波利"),"丹科 "=>array("0"=>"丹科"),"上柴"=>array("0"=>"上海柴油机"),"正和"=>array("0"=>"正和"),"威尔逊"=>array("0"=>"威尔逊"),"辛普森"=>array("0"=>"辛普森"),"福发"=>array("0"=>"福州柴油机"));
	static $gDevModelSystemCode = array("water"=>"18","temperature"=>"18","humid"=>"18","smoke"=>"18","imem_12"=>"16","battery_24"=>"07","battery_32"=>"10","fresh_air"=>"24","psma-ac"=>"06","psma-rc"=>"06","psma-dc"=>"06","m801g-ac"=>"06","m801g-rc"=>"06","m801g-dc"=>"06","liebert-ups"=>"09","liebert-ac"=>"12","motivator"=>"05","smd_device"=>"19","motor_battery"=>"05");
	static $gLiebertUpsRemoteMesureParams = array("0"=>"AB相输出电压","1"=>"BC相输出电压","2"=>"CA相输出电压","3"=>"A相输出电压","4"=>"B相输出电压","5"=>"C相输出电压","6"=>"A相输出电流","7"=>"B相输出电流","8"=>"C相输出电流","9"=>"N相输出电流","10"=>"A相实际输出功率","11"=>"B相实际输出功率","12"=>"C相实际输出功率","13"=>"旁路频率","14"=>"逆变器频率","15"=>"旁路AB相电压","16"=>"旁路BC相电压","17"=>"旁路CA相电压","18"=>"电池电压","19"=>"电池电流","20"=>"A相视在输出功率","21"=>"B相视在输出功率","22"=>"C相视在输出功率","23"=>"A相负载百分比","24"=>"B相负载百分比","25"=>"C相负载百分比","26"=>"电池充电比例","27"=>"电池剩余时间","28"=>"电池温度","29"=>"8000H");
	static $gLiebertUpsRemoteSignalParams = array("0"=>"保留位","1"=>"保留位","2"=>"旁路开关状态","3"=>"输出开关状态","4"=>"整流器开关状态","5"=>"电池开关状态","6"=>"手动旁路开关状态","7"=>"保留位","8"=>"风扇故障","9"=>"保留位","10"=>"旁路无电压告警","11"=>"旁路过压告警","12"=>"旁路欠压告警","13"=>"旁路频率异常","14"=>"旁路相位异常","15"=>"旁路晶闸管故障","16"=>"旁路关闭","17"=>"面板关闭旁路","18"=>"旁路供电","19"=>"旁路过温","20"=>"整流器关闭","21"=>"面板关闭整流器","22"=>"整流器封锁","23"=>"整流器限流","24"=>"整流器过温","25"=>"整流器熔丝故障","26"=>"保留位","27"=>"保留位","28"=>"保留位","29"=>"逆变供电","30"=>"逆变器关闭","31"=>"面板关闭逆变器","32"=>"逆变器封锁","33"=>"逆变器限流","34"=>"逆变器过温","35"=>"逆变器不同步","36"=>"逆变器过压","37"=>"逆变器欠压","38"=>"逆变器熔丝故障","39"=>"输出过压","40"=>"输出欠压","41"=>"输出无电压","42"=>"输出波形异常","43"=>"输出频率异常","44"=>"逆变并机错误","45"=>"接触器故障","46"=>"逆变台数不够","47"=>"并机线未连接","48"=>"一台或多台UPS不工作","49"=>"电池充电故障","50"=>"电池自检中","51"=>"电池自检失败","52"=>"电池供电","53"=>"电池放电结束","54"=>"均充时间超限","55"=>"母线慢速过压","56"=>"电池电压低","57"=>"电池熔丝故障","58"=>"母线快速过压","59"=>"电池接地故障","60"=>"旁路逆变切换次数到","61"=>"UPS过载关机","62"=>"UPS过温关机","63"=>"UPS紧急关机","64"=>"回灌故障","65"=>"保留位","66"=>"UPS过载","67"=>"UPS过载关机","68"=>"保留位","69"=>"保留位","70"=>"容量未设置","71"=>"参数1校验错误","72"=>"参数2校验错误","73"=>"参数3校验错误","74"=>"告警历史校验错误","75"=>"事件历史校验错误","76"=>"内部电池电压低","77"=>"保留位","78"=>"保留位","79"=>"保留位","80"=>"CAN 通讯未响应");
	static $gEnvModelKeys = array("0"=>"temperature","1"=>"humid","2"=>"water","3"=>"smoke","4"=>"access_ctr","5"=>"infrared");
	static $gDevModelKeys = array("0"=>"ac-transformer","1"=>array("0"=>"es","1"=>"m810g-ac","2"=>"m810g-dc","3"=>"m810g-rc","4"=>"psma-ac","5"=>"psma-dc","6"=>"psma-rc"),"2"=>array("0"=>"liebert-ups"),"3"=>"distribution_board","4"=>array("0"=>"battery_24","1"=>"battery_32"),"5"=>"hvpdc","6"=>"lvpdc","7"=>"collector","8"=>"liebert-pex","9"=>"fresh_air","10"=>"access4000x","11"=>array("0"=>"aeg-ms10se","1"=>"aeg-ms10m"));
	static $gPlatform = array("web"=>"网站","app"=>"手机");
	static $signalName = array("battery_24 group_voltage"=>array("00100"=>"整组电压低","07001"=>"蓄电池总电压过高","07002"=>"蓄电池组总电压过低","07003"=>"蓄电池组总电压过高"),"0090"=>array("0"=>"UPS电池总电压过低告警"),"temperature value"=>array("18004"=>"温度","18005"=>"温度"),"smart_device comm_fail"=>array("19001"=>"通信状态"),"water value"=>array("18001"=>"水浸"),"smoke value"=>array("18002"=>"烟感"),"vpdu value"=>array("67890"=>"电流输入停电告警","67891"=>"电源工作状态","67892"=>"交流配电告警","67893"=>"交流输入告警","67894"=>"交流输入经典告警","67895"=>"交流输入市电停电","67896"=>"交流输入停电告警","67897"=>"交流输入状态","67898"=>"市电输入停电告警"));
	static $gDeviceThresholdParams = array("water"=>array("value"=>"当前读数，为1或者0，告警状态要根据常开常闭决定"),"smoke"=>array("value"=>"当前读数，为1或者0，告警状态要根据常开常闭决定"),"temperature"=>array("value"=>"温度"),"humid"=>array("value"=>"当前湿度，例如：40","0"=>"即40%"),"motor_battery"=>array("value"=>"启动电池电压"),"battery_24"=>array("group_voltage"=>"整组电压","group_current"=>"电流","temperature"=>"电池温度","battery_value"=>"单体电压","battery_N_value"=>"第N节电池（N:0-23）"),"battery_32"=>array("group_voltage"=>"整组电压","group_current"=>"电流","temperature"=>"电池温度","battery_value"=>"单体电压","battery_N_value"=>"第N节电池（N:0-31）"),"liebert-ups"=>array("a_0_value"=>"AB相输出电压","a_1_value"=>"BC相输出电压","a_3_value"=>"CA相输出电压","a_4_value"=>"A相输出电压","a_5_value"=>"B相输出电压","a_6_value"=>"C相输出电压","a_7_value"=>"A相输出电流","a_8_value"=>"B相输出电流","a_9_value"=>"C相输出电流","a_10_value"=>"N相输出电流","a_11_value"=>"A相实际输出功率","a_12_value"=>"B相实际输出功率","a_13_value"=>"C相实际输出功率","a_14_value"=>"旁路频率","a_15_value"=>"逆变器频率","a_16_value"=>"旁路AB相电压","a_17_value"=>"旁路BC相电压","a_18_value"=>"旁路CA相电压","a_19_value"=>"电池电压","a_20_value"=>"电池电流","a_21_value"=>"A相视在输出功率","a_22_value"=>"B相视在输出功率","a_23_value"=>"C相视在输出功率","a_24_value"=>"A相负载百分比","a_25_value"=>"B相负载百分比","a_26_value"=>"C相负载百分比","a_27_value"=>"电池充电比例","a_28_value"=>"电池剩余时间","a_29_value"=>"电池温度","d_2_value"=>"旁路开关状态","d_3_value"=>"输出开关状态","d_4_value"=>"整流器开关状态","d_5_value"=>"电池开关状态","d_6_value"=>"手动旁路开关状态","d_8_value"=>"风扇故障","d_10_value"=>"旁路无电压告警","d_11_value"=>"旁路过压告警","d_12_value"=>"旁路欠压告警","d_13_value"=>"旁路频率异常","d_14_value"=>"旁路相位异常","d_15_value"=>"旁路晶闸管故障","d_16_value"=>"旁路关闭","d_17_value"=>"面板关闭旁路","d_18_value"=>"旁路供电","d_19_value"=>"旁路过温","d_20_value"=>"整流器关闭","d_21_value"=>"面板关闭整流器","d_22_value"=>"整流器封锁","d_23_value"=>"整流器限流","d_24_value"=>"整流器过温","d_25_value"=>"整流器熔丝故障","d_29_value"=>"逆变供电","d_30_value"=>"逆变器关闭","d_31_value"=>"面板关闭逆变器","d_32_value"=>"逆变器封锁","d_33_value"=>"逆变器限流","d_34_value"=>"逆变器过温","d_35_value"=>"逆变器不同步","d_36_value"=>"逆变器过压","d_37_value"=>"逆变器欠压","d_38_value"=>"逆变器熔丝故障","d_39_value"=>"输出过压","d_40_value"=>"输出欠压","d_41_value"=>"输出无电压","d_42_value"=>"输出波形异常","d_43_value"=>"输出频率异常","d_44_value"=>"逆变并机错误","d_45_value"=>"接触器故障","d_46_value"=>"逆变台数不够","d_47_value"=>"并机线未连接","d_48_value"=>"一台或多台UPS不工作","d_49_value"=>"电池充电故障","d_50_value"=>"电池自检中","d_51_value"=>"电池自检失败","d_52_value"=>"电池供电","d_53_value"=>"电池放电结束","d_54_value"=>"均充时间超限","d_55_value"=>"母线慢速过压","d_56_value"=>"电池熔丝故障","d_57_value"=>"母线快速过压","d_58_value"=>"电池接地故障","d_59_value"=>"旁路逆变切换次数到","d_60_value"=>"UPS过载关机","d_61_value"=>"UPS过温关机","d_62_value"=>"UPS紧急关机","d_63_value"=>"回灌故障","d_65_value"=>"UPS过载","d_66_value"=>"UPS过载关机","d_69_value"=>"容量未设置","d_70_value"=>"参数1校验错误","d_71_value"=>"参数2校验错误","d_72_value"=>"参数3校验错误","d_73_value"=>"告警历史校验错误","d_74_value"=>"事件历史校验错误","d_75_value"=>"内部电池电压低","d_79_value"=>"CAN"),"psma-ac"=>array("ia"=>"a相电流","ib"=>"b相电流","ic"=>"c相电流","channel_0_a"=>"第一路输入线/相电压AB/A","channel_0_b"=>"第一路输入线/相电压BC/B","channel_0_c"=>"第一路输入线/相电压CA/C","channel_0_f"=>"第一路输入频率","channel_1_a"=>"第二路输入线/相电压AB/A","channel_1_b"=>"第二路输入线/相电压BC/B","channel_1_c"=>"第二路输入线/相电压CA/C","channel_1_f"=>"第二路输入频率"),"smart_device"=>array("comm_fail"=>"智能设备通信异常"));
	static $gDeviceSignal = array("water"=>array("value"=>"浸水"),"temperature"=>array("upper_value"=>"上限","lower_value"=>"下限","threshold"=>"阈值"),"humid"=>array("upper_value"=>"上限","lower_value"=>"下限","threshold"=>"阈值"),"smoke"=>array("value"=>"烟雾"),"battery_24"=>array("group_voltage"=>"整组电压","group_current"=>"电流","temperature"=>"温度"),"battery_32"=>array("group_voltage"=>"整组电压","group_current"=>"电流","temperature"=>"温度"),"liebert-ups"=>array("a_0_value"=>"AB相输出电压","a_1_value"=>"BC相输出电压","a_3_value"=>"CA相输出电压","a_4_value"=>"A相输出电压","a_5_value"=>"B相输出电压","a_6_value"=>"C相输出电压","a_7_value"=>"A相输出电流","a_8_value"=>"B相输出电流","a_9_value"=>"C相输出电流","a_10_value"=>"N相输出电流","a_11_value"=>"A相实际输出功率","a_12_value"=>"B相实际输出功率","a_13_value"=>"C相实际输出功率","a_14_value"=>"旁路频率","a_15_value"=>"逆变器频率","a_16_value"=>"旁路AB相电压","a_17_value"=>"旁路BC相电压","a_18_value"=>"旁路CA相电压","a_19_value"=>"电池电压","a_20_value"=>"电池电流","a_21_value"=>"A相视在输出功率","a_22_value"=>"B相视在输出功率","a_23_value"=>"C相视在输出功率","a_24_value"=>"A相负载百分比","a_25_value"=>"B相负载百分比","a_26_value"=>"C相负载百分比","a_27_value"=>"电池充电比例","a_28_value"=>"电池剩余时间","a_29_value"=>"电池温度","d_2_value"=>"旁路开关状态","d_3_value"=>"输出开关状态","d_4_value"=>"整流器开关状态","d_5_value"=>"电池开关状态","d_6_value"=>"手动旁路开关状态","d_8_value"=>"风扇故障","d_10_value"=>"旁路无电压告警","d_11_value"=>"旁路过压告警","d_12_value"=>"旁路欠压告警","d_13_value"=>"旁路频率异常","d_14_value"=>"旁路相位异常","d_15_value"=>"旁路晶闸管故障","d_16_value"=>"旁路关闭","d_17_value"=>"面板关闭旁路","d_18_value"=>"旁路供电","d_19_value"=>"旁路过温","d_20_value"=>"整流器关闭","d_21_value"=>"面板关闭整流器","d_22_value"=>"整流器封锁","d_23_value"=>"整流器限流","d_24_value"=>"整流器过温","d_25_value"=>"整流器熔丝故障","d_29_value"=>"逆变供电","d_30_value"=>"逆变器关闭","d_31_value"=>"面板关闭逆变器","d_32_value"=>"逆变器封锁","d_33_value"=>"逆变器限流","d_34_value"=>"逆变器过温","d_35_value"=>"逆变器不同步","d_36_value"=>"逆变器过压","d_37_value"=>"逆变器欠压","d_38_value"=>"逆变器熔丝故障","d_39_value"=>"输出过压","d_40_value"=>"输出欠压","d_41_value"=>"输出无电压","d_42_value"=>"输出波形异常","d_43_value"=>"输出频率异常","d_44_value"=>"逆变并机错误","d_45_value"=>"接触器故障","d_46_value"=>"逆变台数不够","d_47_value"=>"并机线未连接","d_48_value"=>"一台或多台UPS不工作","d_49_value"=>"电池充电故障","d_50_value"=>"电池自检中","d_51_value"=>"电池自检失败","d_52_value"=>"电池供电","d_53_value"=>"电池放电结束","d_54_value"=>"均充时间超限","d_55_value"=>"母线慢速过压","d_56_value"=>"电池熔丝故障","d_57_value"=>"母线快速过压","d_58_value"=>"电池接地故障","d_59_value"=>"旁路逆变切换次数到","d_60_value"=>"UPS过载关机","d_61_value"=>"UPS过温关机","d_62_value"=>"UPS紧急关机","d_63_value"=>"回灌故障","d_65_value"=>"UPS过载","d_66_value"=>"UPS过载关机","d_69_value"=>"容量未设置","d_70_value"=>"参数1校验错误","d_71_value"=>"参数2校验错误","d_72_value"=>"参数3校验错误","d_73_value"=>"告警历史校验错误","d_74_value"=>"事件历史校验错误","d_75_value"=>"内部电池电压低","d_79_value"=>"CAN"),"psma-ac"=>array("ia"=>"a相电流","ib"=>"b相电流","ic"=>"c相电流","channel_0_a"=>"第一路输入线/相电压AB/A","channel_0_b"=>"第一路输入线/相电压BC/B","channel_0_c"=>"第一路输入线/相电压CA/C","channel_0_f"=>"第一路输入频率","channel_1_a"=>"第二路输入线/相电压AB/A","channel_1_b"=>"第二路输入线/相电压BC/B","channel_1_c"=>"第二路输入线/相电压CA/C","channel_1_f"=>"第二路输入频率"),"psma-rc"=>array("out_v"=>"总输出电压"),"m810g-ac"=>array("ia"=>"a相电流","ib"=>"b相电流","ic"=>"c相电流","channel_0_a"=>"第一路输入线/相电压AB/A","channel_0_b"=>"第一路输入线/相电压BC/B","channel_0_c"=>"第一路输入线/相电压CA/C","channel_0_f"=>"第一路输入频率","channel_1_a"=>"第二路输入线/相电压AB/A","channel_1_b"=>"第二路输入线/相电压BC/B","channel_1_c"=>"第二路输入线/相电压CA/C","channel_1_f"=>"第二路输入频率"),"m810g-rc"=>array("out_v"=>"总输出电压"),"liebert-pex"=>array("v"=>"直流输出电压","i"=>"总负载电流"),"power_302a"=>array("uaRms"=>"a相电压","ubRms"=>"b相电压","ucRms"=>"c相电压","iaRms"=>"a相电流","ibRms"=>"b相电流","icRms"=>"c相电流"));
	static $gPsmaAc = array("0"=>"交流输入空开跳","1"=>"交流输出空开跳","2"=>"防雷器断","3"=>"交流输入1停电","4"=>"交流输入2停电","5"=>"交流输入3停电","6"=>"市电切换失败","7"=>"交流屏通讯中断");
	static $gPsmaDc = array("0"=>"池组1熔丝断","1"=>"电池组2熔丝断","2"=>"电池组1充电过流","3"=>"电池组2充电过流","4"=>"电池组1保护","5"=>"电池组2保护","6"=>"二次下电","7"=>"电池房过温","8"=>"测点1过温","9"=>"测点2过温","10"=>"直流屏通讯中断","11"=>"电池组1电压异常","12"=>"电池组2电压异常");
	static $gPsmaDcEx = array("0"=>"电池组1电压","1"=>"电池组2电压","2"=>"电池房温度","3"=>"测点1温度","4"=>"测点2温度");
	static $gPsmaRc = array("0"=>"模块保护","1"=>"风扇故障","2"=>"模块过温","3"=>"模块通讯中断");
	static $gM810gAc = array("0"=>"交流输入空开跳","1"=>"交流输出空开跳","2"=>"防雷器断","3"=>"交流输入1停电","4"=>"交流输入2停电","5"=>"交流输入3停电","6"=>"交流屏通讯中断");
	static $gM810gRc = array("0"=>"交流限功率","1"=>"温度限功率","2"=>"风扇全速","3"=>"WALK-In","4"=>"过压脱离");
	static $gM810gDc = array("0"=>"温度1","1"=>"温度2","2"=>"温度3","3"=>"电池组1电压","4"=>"电池组1实际容量百分比","5"=>"电池组2电压","6"=>"电池组2实际容量百分比","7"=>"电池组3电压","8"=>"电池组3实际容量百分比","9"=>"电池组4电压","10"=>"电池组4实际容量百分比");
	static $gM810gDcEx = array("0"=>"LVD1状态","1"=>"LVD2状态","2"=>"温度1告警状态","3"=>"温度2告警状态","4"=>"温度3告警状态","5"=>"直流屏通讯中断","6"=>"温度1传感器故障","7"=>"温度2传感器故障","8"=>"温度3传感器故障","9"=>"电池组1熔丝断","10"=>"电池组1充电过流","11"=>"电池组2熔丝断","12"=>"电池组2充电过流","13"=>"电池组3熔丝断","14"=>"电池组3充电过流","15"=>"电池组4熔丝断","16"=>"电池组4充电过流");
	static $gAccess4000x = array("0"=>"水温","1"=>"油压","2"=>"电池电压","3"=>"运行时长","4"=>"盘车记录次数","5"=>"转速","6"=>"A相相电压","7"=>"B相相电压","8"=>"C相相电压","9"=>"AB相线电压","10"=>"BC相线电压","11"=>"CA相线电压","12"=>"A相相电流","13"=>"B相相电流","14"=>"C相相电流","15"=>"发电频率","16"=>"功率因数","17"=>"总有功功率","18"=>"总视在功率","19"=>"总无功功率","20"=>"总千瓦时(kWh)");
	static $gug40 = array("0"=>"系统运行","1"=>"压缩机1","2"=>"压缩机2","3"=>"压缩机3","4"=>"压缩机4","5"=>"加热器1","6"=>"加热器2","7"=>"热风","8"=>"除湿","9"=>"应急工作","10"=>"错误密码报警","11"=>"高温报警","12"=>"低温报警","13"=>"高湿度报警","14"=>"低湿度报警","15"=>"温湿度传感器","16"=>"过滤器","17"=>"漏水报警","18"=>"气流报警","19"=>"加热器过热","20"=>"高压电路1","21"=>"VSD风机控制使能","22"=>"风机开","23"=>"制冷开","24"=>"自然冷源开","25"=>"热水开","26"=>"电加热开","27"=>"加湿开","28"=>"除湿开","29"=>"告警峰鸣器开","30"=>"风机过载","31"=>"气流丢失","32"=>"水流丢失","33"=>"连续波温度过高对除湿","34"=>"连续波阀故障或水流过低","35"=>"水流报警","36"=>"冷冻水温度高警报","37"=>"室内空气传感器/断开连接失败","38"=>"热水温度传感器/断开连接失败","39"=>"冷冻水温度传感器/断开连接失败","40"=>"室外温度传感器/断开连接失败","41"=>"交付空气温度传感器/断开连接失败","42"=>"房间的湿度传感器/断开连接失败","43"=>"冷冻水出口Temp.Sensor失败/断开连接","44"=>"压缩机1:小时计数器阈值报警","45"=>"压缩机2:小时计数器阈值报警","46"=>"压缩机3:小时计数器阈值报警","47"=>"压缩机4:小时计数器阈值报警","48"=>"空气过滤器:小时计数器阈值报警","49"=>"加热器1:小时计数器阈值报警","50"=>"加热器2:小时计数器阈值报警","51"=>"加湿器:小时计数器阈值报警","52"=>"空调机组:小时计数器阈值报警","53"=>"警报通过数字输入2","54"=>"警报通过数字输入4","55"=>"警报通过数字输入6","56"=>"加湿器通用报警","57"=>"单位在报警","58"=>"单位在旋转报警","59"=>"单位在报警A型","60"=>"单位在报警B型","61"=>"单位在报警C型","62"=>"DX /连续波开关TC单位","63"=>"夏季/冬季开关","64"=>"单位开/关开关","65"=>"蜂鸣器报警单元复位","66"=>"过滤器运行小时重置","67"=>"压缩机运行1小时重置","68"=>"压缩机运行2小时重置","69"=>"压缩机运行3小时重置","70"=>"压缩机运行4小时重置","71"=>"压缩机1开始重置","72"=>"压缩机2开始重置","73"=>"压缩机3开始重置","74"=>"压缩机4开始重置","75"=>"加热器运行1小时重置","76"=>"加热器运行2小时重置","77"=>"加热器1开始重置","78"=>"加热器2开始重置","79"=>"增湿器运行小时重置","80"=>"增湿器开始重置","81"=>"单位运行时间重置","82"=>"挫折模式(睡眠模式)","83"=>"睡眠模式测试 ","84"=>"平均值","85"=>"备用单元","86"=>"第2单元旋转报警","87"=>"第3单元旋转报警","88"=>"第4单元旋转报警","89"=>"第5单元旋转报警","90"=>"第6单元旋转报警","91"=>"第7单元旋转报警","92"=>"第8单元旋转报警","93"=>"第9单元旋转报警","94"=>"第10单元旋转报警","95"=>"房间温度","96"=>"室外温度","97"=>"交付空气温度","98"=>"冷水温度","99"=>"热水温度","100"=>"房间相对湿度","101"=>"出口冷冻水温度","102"=>"电路1蒸发压力","103"=>"电路2蒸发压力","104"=>"电路1吸入温度","105"=>"电路2吸入温度","106"=>"电路1蒸发温度","107"=>"电路2蒸发温度","108"=>"电路1过热","109"=>"电路2过热","110"=>"冷水阀坡道","111"=>"热水出水阀坡道","112"=>"蒸发风扇转速","113"=>"冷却定位点","114"=>"冷却的敏感性","115"=>"第二个冷却定位点","116"=>"加热定位点","117"=>"第二次加热定位点","118"=>"听力敏感性","119"=>"房间温度高报警阈值(1)","120"=>"室温低报警阈值(1)","121"=>"挫折模式:冷却定位点","122"=>"挫折模式:加热定位点","123"=>"连续波选点开始除湿","124"=>"连续波高温报警阈值","125"=>"连续波选点开始连续波操作模式(只有TC单位)","126"=>"Radcooler定位点在节能模式","127"=>"Radcooler定位点在DX模式","128"=>"排气温度下限设定值(1)","129"=>"自动均值/局部转换的三角洲温度","130"=>"串行传输抵消","131"=>"局域网单元二室温","132"=>"局域网单元三室温","133"=>"局域网单元四室温","134"=>"局域网单元五室温","135"=>"局域网单元六室温","136"=>"局域网单元七室温","137"=>"局域网单元八室温","138"=>"局域网单元九室温","139"=>"局域网单元十室温","140"=>"二单元保温室","141"=>"三单元保温室","142"=>"四单元保温室","143"=>"五单元保温室","144"=>"六单元保温室","145"=>"七单元保温室","146"=>"八单元保温室","147"=>"九单元保温室","148"=>"十单元保温室","149"=>"空气过滤器","150"=>"运行单位","151"=>"空压机1运行","152"=>"空压机2运行","153"=>"空压机3运行","154"=>"空压机4运行","155"=>"加热器1运行","156"=>"加热器2运行","157"=>"加湿器运行","158"=>"除湿器支撑带","159"=>"加湿器支撑带","160"=>"高湿度报警阈值","161"=>"低湿度报警阈值","162"=>"除湿定位点","163"=>"除湿定位点逆流模式","164"=>"加湿定位点","165"=>"加湿定位点逆流模式","166"=>"重新启动延迟","167"=>"低压延迟","168"=>"温度/湿度限制告警延迟","169"=>"防震荡常数","170"=>"备用循环基准时间","171"=>"局域网的数量单位","172"=>"电路1电子阀的位置","173"=>"电路2电子阀的位置");
	static $gAMF25 = array("engine_state"=>"引擎状态","breaker_state"=>"刹车状态","run_hours"=>"开机时长","maintainance"=>"维护次数","num_starts"=>"启动次数","genset_kwh"=>"总发电有功电量","genset_kvarh"=>"总发电无功电量","num_estops"=>"紧急停车数","shutdowns"=>"关机数","l1_n"=>"发电机l1-n相电压","l2_n"=>"发电机l2-n相电压","l3_n"=>"发电机l3-n相电压","l1_l2"=>"发电机l1-l2线电压","l2_l3"=>"发电机l2-l3线电压","l3_l1"=>"发电机l3-l1线电压","l1_i"=>"l1负载电流","l2_i"=>"l2负载电流","l3_i"=>"l3负载电流","rpm"=>"转速","freq"=>"频率","p"=>"有功功率","l1_p"=>"L1有功功率","l2_p"=>"L2有功功率","l3_p"=>"L3有功功率","kva"=>"标称视在功率","load_kvar"=>"无功功率","load_kvar_l1"=>"l1无功功率","load_kvar_l2"=>"l2无功功率","load_kvar_13"=>"l3无功功率","pf"=>"总功率因数","l1_pf"=>"l1功率因数","l2_pf"=>"l2功率因数","l3_pf"=>"l3功率因数","load_kva"=>"总视在功率","load_kva_l1"=>"l1视在功率","load_kva_l2"=>"l2视在功率","load_kva_l3"=>"l3视在功率","mains_l1_n"=>"干线l1-n相电压","mains_l2_n"=>"干线l2-n相电压","mains_l3_n"=>"干线l3-n相电压","mains_l1_l2"=>"干线l1-l2线电压","mains_l2_l3"=>"干线l2-l3线电压","mains_l3_l1"=>"干线l3-l1线电压","mains_freq"=>"干线频率","earth_fault"=>"接地故障","battery_voltage"=>"电池电压","dplus"=>"充电电压","oil_presure"=>"油压","engine_temp"=>"引擎温度","bin_inputs"=>"输入反馈","bin_outputs"=>"输出反馈","iom_bin_imp"=>"IOM告警");
	static $gLiebertPexRemoteMesureParams = array("0"=>"星期一睡眠","1"=>"星期二睡眠","2"=>"星期三睡眠","3"=>"星期四睡眠","4"=>"星期五睡眠","5"=>"星期六睡眠","6"=>"星期天睡眠","7"=>"送风温限使能","8"=>"再加热锁定","9"=>"加湿器锁定","10"=>"温度单位","11"=>"定时器运行模式","12"=>"最低冷冻水温度使能","13"=>"压缩机Pump down使能","14"=>"自然冷源和压缩机同时运行使能","15"=>"自动设置使能","16"=>"除湿使能","17"=>"使用热水","18"=>"T/H报警使能","19"=>"传感器A报警使能","20"=>"压缩机锁定","21"=>"VSD风机控制使能","22"=>"风机开","23"=>"制冷开","24"=>"自然冷源开","25"=>"热水开","26"=>"电加热开","28"=>"加湿开","29"=>"除湿开","30"=>"告警峰鸣器开","31"=>"风机过载","32"=>"气流丢失","33"=>"水流丢失","34"=>"压缩机1高压","35"=>"压缩机1低压","36"=>"压缩机1过载","37"=>"压缩机1Pump donw失败","38"=>"压缩机2高压","39"=>"压缩机2低压","40"=>"压缩机2过载","41"=>"压缩机2Pump donw失败","42"=>"数码漩涡1高温","43"=>"数码漩涡2高温","44"=>"烟感报警","45"=>"地板漏水","46"=>"加湿器故障","47"=>"备用乙二醇泵运行","48"=>"备用机组运行","49"=>"冷凝泵高水位","50"=>"室内T/H传感器故障","51"=>"压缩机掉电","52"=>"鼓风机气流丢失","53"=>"加湿器低水位","54"=>"加湿器电流过高","55"=>"高温","56"=>"系统掉电","57"=>"未知告警","58"=>"冷冻水高温","59"=>"室内高温","60"=>"室内低温","61"=>"室内高湿","62"=>"室内低湿","63"=>"传感器A高温","64"=>"传感器A低温","65"=>"传感器A高湿","66"=>"传感器A低湿","67"=>"冷冻水水流流失","68"=>"过滤网堵塞","69"=>"送风传感器故障","70"=>"自然冷源温度传感器故障","71"=>"传感器A故障","72"=>"机组运行超时","73"=>"压缩机1运行超时","74"=>"压缩机2运行超时","75"=>"自然冷源运行超时","76"=>"电加热1运行超时","77"=>"电加热2运行超时","78"=>"电加热3运行超时","79"=>"热水热气运行超时","80"=>"加湿器运行超时","81"=>"除湿器运行超时","82"=>"组网失败","83"=>"无法和机组1连接","84"=>"其他机组没有连接","85"=>"机组码丢失","86"=>"机组码不匹配","87"=>"需要维护","88"=>"自定义输入1报警","89"=>"自定义输入2报警","90"=>"自定义输入3报警","91"=>"自定义输入4报警","92"=>"数码漩涡1传感器失败","93"=>"数码漩涡2传感器失败");
	static $gLiebertPexRemoteSignalParams = array("0"=>"压缩机数","1"=>"电加热数","2"=>"电加热级数","3"=>"Teamwork机组数","4"=>"压缩机运行顺序","5"=>"热气控制","6"=>"再加热控制","7"=>"定时运行","8"=>"室内温差控制","9"=>"湿度控制方式","10"=>"VSD设定点","11"=>"送风温限","12"=>"室内和自然冷源温差","13"=>"最低冷冻水温度","14"=>"温度设定点","15"=>"温度比例带","16"=>"温度死区","17"=>"温度积分时间","18"=>"湿度设定点","19"=>"湿度比例带","20"=>"湿度积分时间","21"=>"湿度死区","22"=>"单机组重启动延时","23"=>"红外冲刷比例","24"=>"温度控制方式","25"=>"睡眠间隔1开始时间","26"=>"睡眠间隔1结束时间","27"=>"睡眠间隔2开始时间","28"=>"睡眠间隔2结束时间","29"=>"定时方式温度死区","30"=>"VSD手动方式定时长度","31"=>"高温报警点","32"=>"低温报警点","33"=>"传感器A高温报警点","34"=>"传感器A低温报警点","35"=>"高湿报警点","36"=>"低湿报警点","37"=>"传感器A高湿报警点","38"=>"传感器A低湿报警点","39"=>"风机运行时间限值","40"=>"压缩机1运行时间限值","41"=>"压缩机2运行时间限值","42"=>"加湿器运行时间限值","43"=>"除湿运行时间限值","44"=>"冷冻死/自然冷源运行时间限值","45"=>"电加热1运行时间限值","46"=>"电加热2运行时间限值","47"=>"电加热3运行时间限值","48"=>"热气/热水运行时间限值","49"=>"运行状态","50"=>"当前告警/时间数量","51"=>"告警状态","52"=>"风机需求","53"=>"制冷需求","54"=>"自然冷源需求","55"=>"加热需求","56"=>"加湿需求","57"=>"除湿需求","58"=>"自然冷源状态","59"=>"回风温度","60"=>"实际温度设定点","61"=>"送风温度","62"=>"实际送风温度设定点","63"=>"自然冷源温度","64"=>"传感器A温度","65"=>"传感器B温度","66"=>"传感器C温度","67"=>"数码涡旋1温度","68"=>"数码涡旋2温度","69"=>"回风湿度","70"=>"实际回风湿度设定点","71"=>"传感器A湿度","72"=>"传感器B湿度","73"=>"传感器C湿度","74"=>"风机运行时间","75"=>"压缩机1运行时间","76"=>"压缩机2运行时间","77"=>"加湿运行时间","78"=>"除湿运行时间","79"=>"自然冷源运行时间","80"=>"电加热1运行时间","81"=>"电加热2运行时间","82"=>"电加热3运行时间","83"=>"热水/热气运行时间","84"=>"当日高温温度","85"=>"当日高温时间","86"=>"当日低温温度","87"=>"当日低温时间","88"=>"当日高湿湿度","89"=>"当日高湿时间","90"=>"当日低湿湿度","91"=>"当日低湿时间");
	static $g302APower = array("0"=>"有功功率（kW）","1"=>"无功功率","2"=>"视在功率","3"=>"电压有效值（V）","4"=>"电流有效值（A）","5"=>"功率因数","6"=>"频率（Hz）","7"=>"有功电能（kWh）");
	static $gCanatal = array("0"=>"开关机状态","1"=>"通用报警","2"=>"风机","3"=>"压缩机");
	static $gUserAuth = array("门禁管理"=>array("0"=>"门禁权限管理","1"=>"用户门禁管理"),"系统配置"=>array("0"=>"分公司配置","1"=>"区域配置","2"=>"局站配置","3"=>"机房配置","4"=>"设备配置","5"=>"信号名称配置"),"人员管理"=>array("0"=>"用户管理","1"=>"监控权限管理","2"=>"模块权限管理","3"=>"在线用户"),"告警管理"=>array("0"=>"所有告警","1"=>"手工下发告警","2"=>"修复告警状态","3"=>"预告警"));
	static $gBaudRate = array("0"=>"1200","1"=>"2400","2"=>"9600","3"=>"19200","4"=>"115200");
	static $gECType = array("0"=>"总用电","1"=>"主设备用电","2"=>"空调用电","3"=>"其他用电");
	static $g302A = array("0"=>"有功功率","1"=>"电压有效值","2"=>"电流有效值","3"=>"功率因数","4"=>"频率","5"=>"有功电能");
	static $gECGroup = array("0"=>"时","1"=>"日","2"=>"月","3"=>"年");
	static $gUserRole = array("door_user"=>"门禁用户","member"=>"普通用户","operator"=>"门禁管理员","noc"=>"网络监控用户","city_admin"=>"分公司管理员","admin"=>"管理员");
	static $gElement = array("0"=>"市电","1"=>"变压器","2"=>"柴油发电机","3"=>"高低压系统","4"=>"配电系统","5"=>"UPS系统","6"=>"开关电源系统","7"=>"蓄电池","8"=>"空调","9"=>"动环监控","10"=>"防雷、接地","11"=>"油机系统","12"=>"机房扩容","13"=>"维护制度","14"=>"绿色行动","15"=>"机房环境");
}