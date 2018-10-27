var btn = document.getElementById("btn");
var pass = document.getElementById("pass");
btn.addEventListener("click",function(){
	if(pass.getAttribute("type") === "text"){
		btn.setAttribute("value","表示");
		pass.setAttribute("type","password");
	}else{
		btn.setAttribute("value","隠す");
		pass.setAttribute("type","text");
	}
});
