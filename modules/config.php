<?php

define("dsn","mysql:host=$_ENV('hostName'); dbname=$_ENV('dbName'); charset=utf8");
define("user",$_ENV('userName'));
define("pass",$_ENV('password'));
$homeUrl = $_ENV('homeUrl');
