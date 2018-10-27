<?php
require_once("../modules/class.php");
require_once("../modules/function.php");

function dbWriteBbs($postdata){
	$SQL = "INSERT INTO bbs(text, user_id, datetime) VALUES (?, ?, ?)";
	$pdo = new connect();
	$pdo->dml($SQL,$postdata);
}


function dbSelectAll($Tmpl,$page,$pagenation){
	$data = $list = $userList = "";
	$pdo = new connect();
	$offset = $pagenation * ($page - 1);
	$SQL = "SELECT * FROM bbs ORDER BY id DESC LIMIT $offset,$pagenation";
	$SQLColumn = "SELECT count(*) FROM bbs";
	$SQLUser = "SELECT name FROM login WHERE id = ?";
	//最大ページ数取得
	$total = $pdo->dmlColumn($SQLColumn);
	$totalPages = ceil($total / $pagenation);
	//全件表示処理
	$data = $pdo->dmlAll($SQL,"");

	foreach ($data as $key => $value) {
		$list = $Tmpl;
		$value = h2($value);
		foreach($value as $tmplKey => $tmplValue){
			//user_id→名前
			if ($tmplKey === "user_id") {
				$tmp = $pdo->dml($SQLUser,array($tmplValue));
				$tmplValue = $tmp["name"];
			}else if($tmplKey === "text") {
				$tmplValue = str_replace("_kaigyou_", "<br>", $tmplValue);
			}
			$list = str_replace("!".$tmplKey."!",$tmplValue,$list);
		}
		$userList .= $list;
	}
	return array($userList,$totalPages);
}
