var modeChange = function (submit){
	var table = document.getElementById("modeTable");
	var input = document.createElement("input");
	input.setAttribute("name","mode");
	input.setAttribute("type","hidden");
	if(submit.value === "完了"){
		input.setAttribute("value","retouch");
	}else if(submit.value === "前へ戻る" || submit.value === "登録情報確認"){
		input.setAttribute("value","mypage");
	}else if(submit.value === "予定帳"){
		input.setAttribute("value","schedule");
	}else if(submit.value === "掲示板"){
		input.setAttribute("value","bbs");
	}
	table.appendChild(input);
}

var modeAdd = function(submit){
	var table = document.getElementById("modeTable");
	var input = document.createElement("input");
	input.setAttribute("name","change");
	input.setAttribute("type","hidden");
	if(submit.value === "完了"){
		input.setAttribute("value","change");
	}
	table.appendChild(input);
}

var mod = function (submit){
	var table = document.getElementById("modeTable");
	var input = document.createElement("input");
	input.setAttribute("name","login");
	input.setAttribute("value","login");
	table.appendChild(input);
	var mode = document.getElementById("mode");
	mode.setAttribute("value","");
}

var formChange = function (submit){
	var form = document.getElementById("planTable");
	if(submit.value === "変更"){
		form.setAttribute("action","schedule.php?mode=changeData");
	}else if(submit.value === "削除"){
		form.setAttribute("action","schedule.php?mode=schedule");
	}
}
