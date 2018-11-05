<?php
function h2($_postdata){
	$_post = array();
	foreach ($_postdata as $key => $value) {
		if(is_array($value)){
			$value = implode(" ", $value);
		}
		//文字コードをUTF-8に統一
		$enc = mb_detect_encoding($value);
		$value = mb_convert_encoding($value, "UTF-8", $enc);

		//クロスサイトスクリプティング対策
		$value = htmlentities($value, ENT_QUOTES, "UTF-8");

		//改行コード処理
		$value = str_replace("\r\n", "_kaigyou_", $value);
		$value = str_replace("\n", "_kaigyou_", $value);
		$value = str_replace("\r", "_kaigyou_", $value);
		$_post += array($key => $value);
	}
	return $_post;
}

function fileread($f){
	$file = fopen($f,"a+");
	flock($file,LOCK_EX);
	$size = filesize($f);
	$data = fread($file, $size);
	flock($file,LOCK_UN);
	fclose($file);
	return $data;
}

//入力の際にエラーチェック
function errorCheck($_postdata,$error,$conf,$count){
	$arrValue = array();
	$count = $count === 0 ? 0 : 1;
	foreach ($_postdata as $key => $value) {
		$count++;
		$error = str_replace("!".$key."!", $value, $error);
		if($conf){
			$conf = str_replace("!".$key."!", $value, $conf);
		}
		if(!$value){
			$errorSentence = "未入力です";
			$error = str_replace("!".$key."error!", $errorSentence, $error);
		}
		else{
			if($key === "email"){
				if(filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
					$error = str_replace("!".$key."error!", "メールアドレスが無効です", $error);
					continue;
				}
			}
			if($key === "tel"){
				if(!preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $value)){
					$error = str_replace("!".$key."error!", "携帯番号が無効です", $error);
					continue;
				}
			}
			$error = str_replace("!".$key."error!", "", $error);
			if($conf){
				array_push($arrValue,$value);
			}else{
				$arrValue = array_merge($arrValue,array($key => $value));
			}
		}
	}
	if(count($arrValue) === $count){
		return $result = !empty($conf) ? array($conf, $arrValue) : $arrValue;
	}
	else{
		return $error;
	}
}

// ページング
function paging($limit, $page, $pagenation){
	$paging = "";
	$pageUrl = "/routes/bbs.php?mode=bbs&page=";
	$next = $page + 1;
	$prev = $page - 1;

	//ページ番号リンク用
	$start =  ($page > 1) ? $page : 1;//始点
	$end =  ($start > 1) ? $start + 4 : 5;//終点
	if(intval($page) !== 1) {
		$paging .= '<a href="'.$pageUrl.$prev.'" class="darkgray">&laquo; 前へ</a>';
	}
	if($start > 3){
		$paging .= '<a href="'.$pageUrl.'1" class="darkgray">1</a>';
		if($start > 4){
			$paging .= "...";
		}
	}
	// ページリンクの表示
	for($i= $start - 2; $i <= $end - 2; $i++){
		$class = ($page == $i) ? 'class="darkgray current"':'class="darkgray"';
		if($i <= $limit && $i > 0){
			$paging .= '<a href="'.$pageUrl.$i.'"'.$class.'>'.$i.'</a>';
		}
	}

	//最後のページへのリンク
	if($limit > $end - 2){
		if($limit-1 > $end ){
			$paging .= "...";
		}
		$paging .= '<a href="'.$pageUrl.$limit.'" class="darkgray">'.$limit.'</a>';
	}
	//次へリンク
	if($page < $limit){
		$paging .= '<a href="'.$pageUrl.$next.'" class="darkgray">次へ &raquo;</a>';
	}
	return $paging;
}

