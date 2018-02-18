<?php
session_start();
$time=time();
//print_r($_SESSION);
if(!isset($_SESSION["icache"])){
$_SESSION["icache"]=0;
}
if(!isset($_SESSION["idata"])){
$_SESSION["idata"]="";
}
if(($_SESSION["icache"]+43200<=$time) or $_SESSION["icache"]=="" or $_SESSION["idata"]==""){
$uri='http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&nc='.time().''.rand(100,999).'&pid=hp&video=1';
unset($_SESSION["idata"]);
unset($_SESSION["icache"]); 
$fi=json_decode(cget($uri),true);
if(!strstr($fi["images"][0]["url"],"http://")){
$fi["images"][0]["url"]="http://www.bing.com".$fi["images"][0]["url"]; 
} 
$_SESSION["idata"]=$fi;
$_SESSION["icache"]=$time; 
}else{

$fi=$_SESSION["idata"];

}
$cg["con"]=$fi["images"][0]["copyright"];
$cg["pic"]=$fi["images"][0]["url"];
echo json_encode($cg);
function cget($url){
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
//curl_setopt($ch,CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4); 	curl_setopt($ch,CURLOPT_USERAGENT,'MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1');
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result=curl_exec($ch);
	curl_close($ch);
	return $result;
} 
?>