var video = document.getElementById("video");
var canvas = document.getElementById("canvas");
var context = canvas.getContext("2d");
var img = document.querySelector("img");
var imgData = null;
var localMediaStream = null;
var user_data;
var message_data;
var response;
var sensorDelay = 1500;
var img_form_data = new FormData(document.forms[0]);
var date = new Date();

canvas.setAttribute("style", "width:" + "0" + "px;height:" + "0" + "px;");
context.strokeRect(50, 50, 50, 50);
navigator.getUserMedia =
  navigator.getUserMedia ||
  navigator.webkitGetUserMedia ||
  navigator.mozGetUserMedia ||
  navigator.oGetUserMedia ||
  navigator.msGetUserMedia;
if (navigator.getUserMedia) {
  navigator.getUserMedia({ video: true }, streamWebCam, throwError);
}
function streamWebCam(stream) {
  video.srcObject = stream;
  video.play();
}
function throwError(e) {
  alert(e.name);
}

function sendToServer(url) {
  //查看感測器
  fetch(url, {
    method: "GET",
  })
    .then((response) => {
      return response.json();
    })
    .then((jsonData) => {
      if (jsonData.state == 1) {
        clearInterval(interval);
        $("#camera_status").html("辨識中");
        //人臉辨識
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        imgData = canvas.toDataURL("image/png");
        console.log(imgData);
        imgData = dataURItoBlob(imgData);
        img_form_data.forEach(function (val, key, fD) {
          img_form_data.delete(key);
        });
        img_form_data.append("image", imgData);
        fetch("/api/face", {
          method: "POST",
          body: img_form_data
        })
          .then((response) => {
            return response.json();
          })
          .then((jsonData) => {
            if (jsonData.status_code == 200) {
              var datetime = (date.getFullYear() + ("0" + (date.getMonth() + 1)).slice(-2) + ("0" + date.getDate()).slice(-2) + ("0" + date.getHours()).slice(-2) + ("0" + date.getMinutes()).slice(-2) + ("0" + date.getSeconds()).slice(-2));
              let studen_form_data = new FormData(document.forms[0]);
              studen_form_data.append("userid", jsonData.u_id)
              studen_form_data.append("datetime", datetime)
              console.log(datetime)
              console.log(jsonData.u_id)
              if(jsonData.u_id == "920300775"){
                //開門
                fetch("/api/aiDoor", {
                  method: "POST",
                });
                $("#alert").removeClass("d-none");
                $("#alert").removeClass("alert-danger");
                $("#alert").addClass("alert-success");
                $("#alert").html("asdasdasd");
                clearInterval(interval);
                $("#camera_status").html("稍等");
                setTimeout(function () {
                  interval = setInterval(function () {
                    sendToServer("/api/aiDoor");
                    $("#camera_status").html("請將手上至感測器前方");
                    $("#alert").addClass("d-none");
                  }, sensorDelay);
                }, 1500);
              }else{
                //ai工房預約辨識
                fetch("/api/aiRegister", {
                  method: "POST",
                  body: studen_form_data
                })
                  .then((response) => {
                    return response.json();
                  })
                  .then((jsonData) => {
                    if (return_value == 1) {
                      //開門
                      fetch("/api/aiDoor", {
                        method: "POST",
                      });
                    }
                    $("#alert").removeClass("d-none");
                    $("#alert").removeClass("alert-danger");
                    $("#alert").addClass("alert-success");
                    $("#alert").html(jsonData.name.charAt(0) + "*" + jsonData.name.charAt(2) + "謝謝光臨亞洲大學圖書館");
                    clearInterval(interval);
                    $("#camera_status").html("稍等");
                    setTimeout(function () {
                      interval = setInterval(function () {
                        sendToServer("/api/aiDoor");
                        $("#camera_status").html("請將手上至感測器前方");
                        $("#alert").addClass("d-none");
                      }, sensorDelay);
                    }, 1500);
                  })
                  .catch((err) => {
                    $("#alert").removeClass("alert-success");
                    $("#alert").addClass("alert-danger");
                    $("#alert").html(jsonData.message);
                    $("#alert").removeClass("d-none");
                    clearInterval(interval);
                    $("#camera_status").html("稍等");
                    setTimeout(function () {
                      interval = setInterval(function () {
                        sendToServer("/api/aiDoor");
                        $("#camera_status").html("請將手上至感測器前方");
                        $("#camera_status").removeClass("d-none");
                        $("#alert").addClass("d-none");
                      }, sensorDelay);
                    }, 1500);
                  })  
              }
            }
            if (jsonData.status_code == 400) {
              $("#alert").removeClass("alert-success");
              $("#alert").addClass("alert-danger");
              $("#alert").html(jsonData.message);
              $("#alert").removeClass("d-none");
              clearInterval(interval);
              $("#camera_status").html("稍等");
              setTimeout(function () {
                interval = setInterval(function () {
                  sendToServer("/api/aiDoor");
                  $("#camera_status").html("請將手上至感測器前方");
                  $("#camera_status").removeClass("d-none");
                  $("#alert").addClass("d-none");
                }, sensorDelay);
              }, 1500);
            }
            if (jsonData.status_code == 500) {
              $("#alert").removeClass("alert-success");
              $("#alert").addClass("alert-danger");
              $("#alert").html(jsonData.message);
              $("#alert").removeClass("d-none");
              clearInterval(interval);
              $("#camera_status").html("稍等");
              setTimeout(function () {
                interval = setInterval(function () {
                  sendToServer("/api/backDoor");
                  $("#camera_status").html("請將手上至感測器前方");
                  $("#camera_status").removeClass("d-none");
                  $("#alert").addClass("d-none");
                }, sensorDelay);
              }, 1500);
            }
          })
      }
    })
    .catch((err) => {
      $("#alert").removeClass("alert-success");
      $("#alert").addClass("alert-danger");
      //("#alert").html(jsonData.message);
      $("#alert").removeClass("d-none");
      clearInterval(interval);
      $("#camera_status").html("稍等");
      setTimeout(function () {
        interval = setInterval(function () {
          sendToServer("/api/aiDoor");
          $("#camera_status").html("請將手上至感測器前方");
          $("#camera_status").removeClass("d-none");
          $("#alert").addClass("d-none");
        }, sensorDelay);
      }, 1500);
      console.log(err);
    });
}
var interval = setInterval(function () {
  sendToServer("/api/aiDoor");
  $("#camera_status").html("請將手上至感測器前方");
  $("#camera_status").removeClass("d-none");
}, sensorDelay);
function dataURItoBlob(dataURI) {
  // convert base64/URLEncoded data component to raw binary data held in a string
  var byteString;
  if (dataURI.split(",")[0].indexOf("base64") >= 0) byteString = atob(dataURI.split(",")[1]);
  else byteString = unescape(dataURI.split(",")[1]);

  // separate out the mime component
  var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

  // write the bytes of the string to a typed array
  var ia = new Uint8Array(byteString.length);
  for (var i = 0; i < byteString.length; i++) {
    ia[i] = byteString.charCodeAt(i);
  }

  return new Blob([ia], { type: mimeString });
}

