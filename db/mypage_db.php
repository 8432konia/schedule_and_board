<?php
require_once("../modules/class.php");

function dbSelectMypage($id,$personalInfo){
  $data = "";
  $SQL = "SELECT * FROM login where id = ?";
  $pdo = new connect();
  $data = $pdo->dml($SQL,$id);
  foreach($data as $key => $value){
    $personalInfo = str_replace("!".$key."!",$value, $personalInfo);
  }
  return $personalInfo;
}

function dbUpdate($postdata){
  $postdata['pass'] = password_hash($postdata['pass'], PASSWORD_DEFAULT);
  unset($postdata["mode"]);
  $SQL = "UPDATE login SET name =:name,email =:email,pass =:pass,tel =:tel WHERE id = :id";
  $pdo = new connect();
  $pdo->dmlValue($SQL,$postdata);
}
