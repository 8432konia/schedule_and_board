<?php
require_once("config.php");

class connect{
	function pdo(){
		try{
			$dbh = new PDO(dsn, user, pass);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ($dbh == null){
				echo "接続に失敗しました。";
			}
		}catch(PDOException $e){
			echo 'エラー内容：'.$e->getMessage();
			die();
		}
		return $dbh;
	}

	function dml($SQL,$postdata){
		$element = $this->pdo();
		$stmt = $element->prepare($SQL);
		if($postdata){
			$stmt->execute($postdata);
		}else{
			$stmt->execute();
		}
		if (strpos($SQL, "INSERT") === false) {
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $data;
		}
	}

	function dmlColumn($SQL){
		$element = $this->pdo();
		$stmt = $element->prepare($SQL);
		$stmt->execute();
		$data = $stmt->fetchColumn();
		return $data;
	}

	function dmlAll($SQL,$postdata){
		$element = $this->pdo();
		$stmt = $element->prepare($SQL);
		if($postdata){
			$stmt->execute($postdata);
		}else{
			$stmt->execute();
		}
		if (strpos($SQL, "INSERT") === false) {
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $data;
		}
	}

	function dmlValue($SQL,$postdata){
		$element=$this->pdo();
		$stmt = $element->prepare($SQL);
		foreach($postdata as $key => $value){
			if($key === "plan_id" || $key === "id" || $key === "user_id"){
				$stmt->bindValue(':'.$key,$value, PDO::PARAM_INT);
			}else{
				$stmt->bindValue(':'.$key,$value, PDO::PARAM_STR);
			}
		}
		$stmt->execute();
	}
}
