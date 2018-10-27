<?php
require_once("../modules/class.php");

function dbWrite($postdata){
  $postdata[2] = password_hash($postdata[2], PASSWORD_DEFAULT);
  $SQL = "INSERT INTO login(name, email, pass, tel) VALUES (?, ?, ?, ?)";
  $pdo = new connect();
  $pdo->dml($SQL,$postdata);
}

function dbEmailExists($email){
  $data = "";
  $SQL = "SELECT * FROM login WHERE email = ? LIMIT 1";
  $pdo = new connect();
  $data = $pdo->dml($SQL,$email);
  return $data ? true : false;
}

function dbSelectLogin($email,$password,$mypage,$loginResult){
  $data = "";
  $SQL = "SELECT * FROM login where email = ?";
  $pdo = new connect();
  $data = $pdo->dml($SQL,$email);
  // パスワードの一致を調べる
  if(!password_verify($password, $data["pass"])){
    $miss = "パスワードが正しくありません。";
    $loginResult = str_replace("!miss!",$miss,$loginResult);
    echo $loginResult;
    exit;
  }else {
    return $mypage;
  }
}

function dbSelectId($email){
  $data = $id = "";
  $SQL = "SELECT * FROM login where email = ?";
  $pdo = new connect();
  $data = $pdo->dml($SQL,$email);
  $id = $data["id"];
  return $id;
}
