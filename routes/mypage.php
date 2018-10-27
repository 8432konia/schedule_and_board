<?php
require_once("../modules/function.php");
require_once("../modules/define.php");
require_once("../db/mypage_db.php");
require_once("../db/bbs_db.php");

session_start();
$_SESSION["mode"] = $_POST["mode"];

//登録情報確認画面出力
if($_SESSION["mode"] === "mypage"){
	$personalInfoFile = dbSelectMypage(array($_SESSION["user"]),$personalInfoFile);
	echo $personalInfoFile;
}elseif($_SESSION["mode"] === "personalInfo"){
	//登録情報変更画面出力
	$infoRetouch = dbSelectMypage(array($_SESSION["user"]),$infoRetouch);
	echo $infoRetouch;
}elseif($_SESSION["mode"] === "bbs"){
	//掲示板画面出力
	$bbsFile = str_replace("!id!",$_SESSION["user"], $bbsFile);

	//Page GET処理
	if(isset($_GET["page"])){
		$page = $_GET["page"];
	}else{
		$page = 1;
	}
	$pagenation = 10;
	$userList = dbSelectAll($bbsTmpl,$page,$pagenation);
	$limit = $userList[1];//最大ページ数
	$paging = paging($limit, $page,$pagenation);
	//置き換え
	$bbsFile = str_replace("!paging!",$paging,$bbsFile);
	$bbsFile = str_replace("!tmpl!",$userList[0],$bbsFile);
	echo $bbsFile;
}elseif($_SESSION["mode"] === "schedule"){
	//ログイン者予定画面出力
	$calendarFile = str_replace("!id!",$_SESSION["user"], $calendarFile);
	echo $calendarFile;
}elseif($_SESSION["mode"] === "retouch"){
	//DB登録情報変更
	$_post = h2($_POST);
	unset($_SESSION["mode"]);
	$result = errorCheck($_post,$infoRetouchError,"",0);
	if(!is_array($result)){
		echo $result;
	}else{
		//情報更新
		$result["id"] = intval($result["id"]);
		dbUpdate($result);
		$mypageFile = str_replace("!id!",$_SESSION["user"], $mypageFile);
		echo $mypageFile;
	}
}else{
	header("Location: login.php");
}
