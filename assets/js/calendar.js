window.addEventListener("DOMContentLoaded", function(){
  var year = document.getElementById("js-year");
  var month = document.getElementById("js-month");
  var tbody = document.getElementById("js-calendar-body");

  var reserveForm = document.getElementById("js-reserve");
  var reserveYear = document.getElementById("js-year");
  var reserveMonth = document.getElementById("js-month");
  var userId = document.getElementById("user").value;
  var reserveDay = document.getElementsByClassName("day");
  var plans = document.getElementById("planTable");

  var today = new Date();
  var xhr = new XMLHttpRequest();
  var currentYear = today.getFullYear(),
  currentMonth = today.getMonth();

  const calendar = function () {
    calendarHeading(currentYear, currentMonth);
    calendarBody(currentYear, currentMonth, today);
    clickFunc();
  }

  const calendarHeading = function (y, m){
    year.textContent = y;
    month.textContent = m + 1;
  }

  const calendarBody = function (year, month, today){
    var todayYMFlag = today.getFullYear() === year && today.getMonth() === month ? true : false;
    var startDate = new Date(year, month, 1);
    var endDate  = new Date(year, month + 1 ,0);
    var startDate = startDate.getDay();
    var endDay = endDate.getDate();
    var textSkip = true;
    var textDate = 1;
    var tableBody ="";
    for (var row = 0; row < 6; row++){
      var tr = "<tr>";
      for (var col = 0; col < 7; col++) {
        if (row === 0 && startDate === col){
          textSkip = false;
        }
        if (textDate > endDay) {
          textSkip = true;
        }
        var addClass = todayYMFlag && textDate === today.getDate() ? "isToday" : "";
        var textTd = textSkip ? " " : textDate++;
        var td = "<td class='" + addClass + " day'>" + textTd + "</td>";
        tr += td;
      }
      tr += "</tr>";
      tableBody += tr;
    }
    tbody.innerHTML = tableBody;
    if (reserveForm) {
      selectDay(reserveForm.textContent);
    }
  }

  const clickFunc = function () {
    for (var i = 0; i < reserveDay.length; i++) {
      reserveDay[i].onclick = function () {
        if(this.textContent.match(/\d/)) {
          var select = document.getElementById("select-day");
          if (select) {
            select.removeAttribute("id");
          }
          this.setAttribute("id","select-day");
          reserveForm.innerHTML = reserveMonth.innerHTML + "月"
          + this.innerHTML + "日の予定";
          var monthData = reserveMonth.innerHTML < 10 ? "0" + reserveMonth.innerHTML : reserveMonth.innerHTML;
          var dayData = this.innerHTML < 10 ? "0" + this.innerHTML : this.innerHTML;
          var userData = "user_id=" + userId + "&date=" + reserveYear.innerHTML + "-" + monthData + "-" + dayData;
          // ハンドラ登録
          xhr.open( 'POST', '/db/schedule_async.php', true );
          xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
          xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304) ) {
              planTable(JSON.parse(xhr.responseText));
            }
          };
          xhr.send(userData);
        }
      }
    }
  }

  const planTable = function (data) {
    var deletePlan = "<div class='planChange'><input class='mgR1 mgR10 mg button_kind' type='submit' onclick='formChange(this)' name='delete' value='削除'>";
    var changePlan = "<input type='submit' onclick='formChange(this)' class='button_kind' value='変更'></div>";
    var planBody = "<table id='modeTable' class='planTable'>";
    var planThead = "<thead class='planThead'><tr><th class='planId'></th><th class='planTime'>時間帯</th><th class='planContent'>予定内容</th></tr></thead><tbody class='planTbody'>";
    if(data.length > 0){
      data.forEach(function(element) {
        var planTr = "<tr>"+
        "<td><input type='radio' name='plan_id' value='" + element["id"] + "' ></td>"+
        "<td>" + element["start"].slice(0,-3) + "～" + element["end"].slice(0,-3) + "</td>"+
        "<td>" + element["content"] + "</td>" +
        "</tr>";
        planThead += planTr;
      });
      plans.innerHTML = deletePlan + changePlan + planBody + planThead +"</tbody></table>";
    }else {
      plans.innerHTML = "<p class='noPlan'>予定なし</p>";
    }
  }

  const selectDay = function (day) {
    var dayNum = day.match(/(\d+)\D+(\d+)/);
    if (dayNum) {
      for (var i = 0; i < reserveDay.length; i++) {
        if (dayNum[1] === month.textContent && dayNum[2] === reserveDay[i].textContent) {
          reserveDay[i].setAttribute("id","select-day");
        }
      }
    }
  }

  const prevMonth = function () {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear --;
    } else {
      currentMonth --;
    }
    calendar();
  }

  const nextMonth = function () {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear ++;
    } else {
      currentMonth ++;
    }
    calendar();
  }

  // PC版の月移動
  var prevButton = document.getElementById("prev-month");
  var nextButton = document.getElementById("next-month");

  prevButton.addEventListener("click", function(event) {
    prevMonth();
  });

  nextButton.addEventListener("click", function(event) {
    nextMonth();
  });

  // スマホ版の月移動
  var touchStartX,
  touchStartY,
  touchMoveX,
  touchMoveY;
  var calendarTable = document.getElementById("js-calendar-table");

  calendarTable.addEventListener("touchstart", function(event) {
    touchStartX = event.touches[0].pageX;
    touchStartY = event.touches[0].pageY;
  }, false);

  calendarTable.addEventListener("touchmove", function(event) {
    event.preventDefault();
    touchMoveX = event.changedTouches[0].pageX;
    touchMoveY = event.changedTouches[0].pageY;
  }, false);

  calendarTable.addEventListener("touchend", function() {
    if(touchMoveX){
      if (touchStartX > (touchMoveX + 100)) {
        nextMonth();
        touchMoveX = null;
      } else if ((touchStartX + 100) < touchMoveX) {
        prevMonth();
        touchMoveX = null;
      }
    }
  }, false);

  calendar();
});
