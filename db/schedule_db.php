<?php
require_once("../modules/class.php");

function dbPostSave($postdata){
	$SQL = "INSERT INTO post(date, start, end, content, user_id) VALUES (?, ?, ?, ?, ?)";
	$pdo = new connect();
	$pdo->dml($SQL,$postdata);
}

function dbPostDelete($postdata){
	$SQL = "DELETE FROM post WHERE id = :plan_id";
	$pdo = new connect();
	$pdo->dmlValue($SQL,$postdata);
}

function dbSelectSche($postdata,$personalInfo){
	$data = "";
	$SQL = "SELECT * FROM post where id = ?";
	$pdo = new connect();
	$data = $pdo->dml($SQL,$postdata);
	foreach($data as $key => $value){
		$personalInfo = str_replace("!".$key."!",$value, $personalInfo);
	}
	return $personalInfo;
}

function dbPostUpdate($postdata) {
	$SQL = "UPDATE post SET date =:date,start =:start,end =:end,content =:content where id = :plan_id";
	$pdo = new connect();
	$pdo->dmlValue($SQL,$postdata);
}
