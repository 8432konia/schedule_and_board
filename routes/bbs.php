<?php
require_once("../modules/function.php");
require_once("../modules/define.php");
require_once("../db/bbs_db.php");

session_start();
$_SESSION["mode"] = $_GET["mode"];

//掲示板画面出力
if($_SESSION["mode"] === "bbs"){
	$bbsFile = str_replace("!id!",$_SESSION["user"], $bbsFile);
	$_post = h2($_POST);
	date_default_timezone_set('Asia/Tokyo');
	$_post["datetime"] = date("Y-n-j H:i:s");
	// 投稿
	if (isset($_post["register"]) && $_post["text"]) {
		unset($_post["mode"],$_post["register"]);
		$_post["user_id"] = intval($_post["user_id"]);
		$personalInfoFile = dbWriteBbs(array_values($_post),$personalInfoFile);
	}

	//ページ取得
	if(isset($_GET["page"])){
		$page = $_GET["page"];
	}else{
		$page = 1;
	}
	$pagenation = 10;

	$userList = dbSelectAll($bbsTmpl,$page,$pagenation);
	$limit = $userList[1];//最大ページ数
	$paging = paging($limit, $page,$pagenation);
	$bbsFile = str_replace("!paging!",$paging,$bbsFile);
	$bbsFile = str_replace("!tmpl!",$userList[0],$bbsFile);
	echo $bbsFile;
}
else{
	header("Location:". $homeUrl);
}
