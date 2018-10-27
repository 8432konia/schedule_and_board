<?php
require_once("function.php");
require_once("config.php");

$loginPath = "../assets/views/login/";
$mypagePath = "../assets/views/mypage/";
$bbsPath = "../assets/views/bbs/";
$schedulePath = "../assets/views/schedule/";

$signUpFile = fileread($loginPath."signUp.html");
$signConfFile = fileread($loginPath."signConf.html");
$signErrorFile = fileread($loginPath."signUp_error.html");
$loginFile = fileread($loginPath."login.html");
$loginErrorFile = fileread($loginPath."login_error.html");
$confFile = fileread($loginPath."conf.html");
$loginResult = fileread($loginPath."loginResult.html");

$mypageFile = fileread($mypagePath."mypage.html");
$personalInfoFile = fileread($mypagePath."personalInfo.html");
$infoRetouch = fileread($mypagePath."infoRetouch.html");
$infoRetouchError = fileread($mypagePath."infoRetouchError.html");

$bbsFile = fileread($bbsPath."bbs.html");
$bbsTmpl = fileread($bbsPath."template.tmpl");

$calendarFile = fileread($schedulePath."calendar.html");
$changeFile = fileread($schedulePath."changeData.html");

$scheduleRoute = $homeUrl."routes/schedule.php";
$bbsRoute = $homeUrl."routes/bbs.php";
