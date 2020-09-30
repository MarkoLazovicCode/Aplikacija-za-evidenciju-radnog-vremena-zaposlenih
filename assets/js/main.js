function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('clock').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
  }

  function checkTime(i) {
    if (i < 10) {i = "0" + i};
    return i;
  }

  function setFocus() {
    document.getElementById("input").focus();
}

function getRecords() {
  var dateMin = document.getElementById('dateMin').value;
  var dateMax = document.getElementById('dateMax').value;
  var url = 'http://localhost/api/profile/' + dateMin +"=" + dateMax;
  fetch(url)
  .then((resp) => resp.json())
  .then(function(data) {
    showReceivedData(data);
  });   
}
function showReceivedData(data){
  drawTable(data);
}
function drawTable(data) {
  $("#table > tbody").html("");
  for (var i = 0; i < data.records.length; i++) {
    addRow(data.records[i]);  
  }
}

function addRow(record) {
  var tableRef = document.getElementById('table').getElementsByTagName('tbody')[0];
  var newRow   = tableRef.insertRow(tableRef.rows.length);

  var cretedAtCell  = newRow.insertCell(0);
  var nameCell  = newRow.insertCell(1);
  var lastNameCell  = newRow.insertCell(2);
  var statusCell  = newRow.insertCell(3);


  var cretedAtValue = document.createTextNode(record.creted_at);
  var nameValue  = document.createTextNode(record.name);
  var lastNameValue  = document.createTextNode(record.lastname);
  var statusValue  = document.createTextNode(record.status);

  cretedAtCell.appendChild(cretedAtValue);
  nameCell.appendChild(nameValue);
  lastNameCell.appendChild(lastNameValue);
  statusCell.appendChild(statusValue);
}

function getTotalTimeByDateRange(){
  var url = window.location.pathname;
  var id = url.substring(url.lastIndexOf('/') + 1);

  var dateMin = document.getElementById('dateMin').value;
  var dateMax = document.getElementById('dateMax').value;
  var url = 'http://localhost/api/employee/'+ id+ "=" + dateMin +"=" + dateMax;
  fetch(url)
  .then((resp) => resp.json())
  .then(function(data) {
    $("#table > tbody").html("");
    for (var i = 0; i < data.records.length; i++) {
      changeToltalTimeTable(data.records[i]);  
    }
  });
  sumTimes();
}

function sumTimes(){
  var table = document.getElementById("table");
                          var hour=0;
                          var minute=0;
                          var second=0;
                          
                          for(var i = 1; i < table.rows.length; i++)
                          {
                            var time = table.rows[i].cells[2].innerHTML;
                            var splitTime1= time.split(':');
                              hour = hour + parseInt(splitTime1[0]);
                              minute = minute + parseInt(splitTime1[1]);
                              second = second + parseInt(splitTime1[2]);
                          }
                          minute =Math.trunc(minute + second/60);
                          second =Math.trunc(second%60);
                          hour = Math.trunc(hour + minute/60);
                          minute = Math.trunc(minute%60);

                          document.getElementById("total").innerHTML = "Total = " +hour + ":" + minute +":" + second;   
}

function changeToltalTimeTable(record) {
  var tableRef = document.getElementById('table').getElementsByTagName('tbody')[0];
  var newRow   = tableRef.insertRow(tableRef.rows.length);

  var loginTimeCell  = newRow.insertCell(0);
  var logoutTimeCell  = newRow.insertCell(1);
  var loggedInTimeCell  = newRow.insertCell(2);
  
  var loginTimeValue = document.createTextNode(record.login_time);
  var logoutTimeValue  = document.createTextNode(record.logout_time);
  var loggedInTimeValue  = document.createTextNode(record.logged_in_time);

  loginTimeCell.appendChild(loginTimeValue);
  logoutTimeCell.appendChild(logoutTimeValue);
  loggedInTimeCell.appendChild(loggedInTimeValue);
}
