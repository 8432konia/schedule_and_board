<?php
require_once("../modules/function.php");
require_once("../modules/define.php");
require_once("../db/schedule_db.php");

session_start();
$_SESSION["mode"] = $_GET["mode"];

//登録情報確認画面出力
if($_SESSION["mode"] === "schedule"){
	$_post = h2($_POST);
	//ログイン者予定画面出力
	$calendarFile = str_replace("!id!", $_SESSION["user"], $calendarFile);
	if (isset($_post["register"])) {
		// 予定登録
		$_post["user"] = intval($_post["user"]);
		unset($_post["register"]);
		if ($_post["date"] && $_post["start"] && $_post["end"] && $_post["content"]) {
			dbPostSave(array_values($_post));
		}
	}else if (isset($_post["delete"]) && isset($_post["plan_id"])) {
		// 予定削除
		$_post["plan_id"] = intval($_post["plan_id"]);
		unset($_post["delete"]);
		dbPostDelete($_post);
	}else if (isset($_post["change"])) {
		// 予定変更
		$_post["plan_id"] = intval($_post["plan_id"]);
		unset($_post["change"]);
		dbPostUpdate($_post);
	}
	echo $calendarFile;
}elseif($_SESSION["mode"] === "changeData"){
	// 予定変更画面
	if (isset($_POST["plan_id"])) {
		$changeFile = dbSelectSche(array($_POST["plan_id"]), $changeFile);
		echo $changeFile;
	}else {
		$calendarFile = str_replace("!id!",$_SESSION["user"], $calendarFile);
		echo $calendarFile;
	}
}else{
	header("Location:" . $homeUrl);
}
