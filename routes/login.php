<?php
require_once("../modules/function.php");
require_once("../modules/define.php");
require_once("../db/login_db.php");

session_start();
if(!isset($_SESSION["user"])){
	//初期ログイン画面表示
	if(!isset($_POST["mode"])){
		//新規、ログイン画面切り替え
		if(isset($_GET["mode"])){
			if($_GET["mode"] === "sign"){
				echo $loginFile;
				exit;
			}elseif($_GET["mode"] === "login"){
				echo $signUpFile;
				exit;
			}
		}
		echo $loginFile;
		exit;
	}else {
		//データ取得
		$_post = h2($_POST);
		if($_post["mode"] === "sign") {
			$sameUser = dbEmailExists(array($_post["email"]));
			if($sameUser === true){
				$signErrorFile = str_replace("!emailerror!","既に使用されているメールアドレスです", $signErrorFile);
				$count = 1;
			}else {
				$count = 0;
			}
			$errorCheck = errorCheck($_post,$signErrorFile,$confFile,$count);
			if(!is_array($errorCheck)){
				echo $errorCheck;
			}else {
				echo $errorCheck[0];
			}
		}elseif ($_post["mode"] === "login") {
			$count = 0;
			$errorCheck = errorCheck($_post,$loginErrorFile,$mypageFile,$count);
			if(!is_array($errorCheck)){
				echo $errorCheck;
			}else {
				$mypageFile = dbSelectLogin(array($errorCheck[1][0]),$errorCheck[1][1],$mypageFile,$loginResult);
				$id = dbSelectId(array($errorCheck[1][0]));
				$_SESSION["user"] = $id;
				$mypageFile = str_replace("!id!",$_SESSION["user"], $mypageFile);
				echo $mypageFile;
			}
		}elseif ($_post["mode"] === "conf") {
			unset($_post["mode"]);
			$arr = array_values($_post);
			dbWrite($arr);
			//マイページ出力
			$id = dbSelectId(array($arr[1]));
			$_SESSION["user"] = $id;
			$mypageFile = str_replace("!id!",$_SESSION["user"], $mypageFile);
			echo $mypageFile;
		}else {
			$signFile = errorCheck($_post,$signConfFile,$signUpFile,0);
			if(!is_array($signFile)){
				echo $signFile;
			}else {
				echo $signFile[0];
			}
		}
	}
}else {
	$mypageFile = str_replace("!id!",$_SESSION["user"], $mypageFile);
	echo $mypageFile;
}
