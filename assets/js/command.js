var input = [];
var command = "38,39,40,37,37,39,66,65,13";

window.onload=function(){
  window.addEventListener("keyup",function(e){
    input.push(e.keyCode);
    if (input.toString().indexOf(command) === 0) {
      var portTr = document.createElement("tr");
      portTr.innerHTML = "<td colspan='4' align='center'><a id='port' class='portbtn submit l-submit skyblue' style='display: none' href = 'https://first-blogs.herokuapp.com/port'>portfolio</a></td>";
      var bottomBtn = document.getElementById("mybtn");
      bottomBtn.appendChild(portTr);
      fadeIn(document.getElementById("port"));
      input = [];
      input.push("1");
    }
  });
}

function fadeIn(node) {
  if (node.style.display === "none") {
    node.style.display = "";
  } else {
    node.style.display = "block";
  }
  node.style.opacity = start = 0;

  window.requestAnimationFrame(function step(timestamp) {
    start = !start ? timestamp : start;
    var easing = ((timestamp - start) / 1000)** 2;
    node.style.opacity = Math.min(easing, 1);
    if (easing < 1) {
      window.requestAnimationFrame(step);
    } else {
      node.style.opacity = "";
    }
  });
}
