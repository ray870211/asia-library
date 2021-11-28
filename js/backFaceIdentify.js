var video = document.getElementById("video");
var canvas = document.getElementById("canvas");
var context = canvas.getContext("2d");
var img = document.querySelector("img");
var imgData = null;
var localMediaStream = null;
var user_data;
var message_data;
var response;
var img_form_data = new FormData(document.forms[0]);
// context.rotate((90 * Math.PI) / 180);
// context.translate(-canvas.height / 2, -canvas.width);
canvas.setAttribute("style", "width:" + "0" + "px;height:" + "0" + "px;");
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
  fetch(url, {
    method: "POST",
    body: img_form_data,
  })
    .then((response) => {
      return response.json();
    })
    .then((jsonData) => {
      // console.log(jsonData.name);
      if (jsonData.status_code == 200) {
        fetch("/api/backDoor", {
          method: "POST",
          // body
        });
        $("#alert").removeClass("d-none");
        $("#alert").removeClass("alert-danger");
        $("#alert").addClass("alert-success");
        $("#alert").html("辨識成功");
        clearInterval(interval);
        $("#camera_status").html("稍等");
        setTimeout(function () {
          interval = setInterval(function () {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            imgData = canvas.toDataURL("image/png");
            console.log(imgData);
            imgData = dataURItoBlob(imgData);
            img_form_data.forEach(function (val, key, fD) {
              // here you can add filtering conditions
              img_form_data.delete(key);
            });
            img_form_data.append("image", imgData);
            sendToServer("/api/face", img_form_data, "POST");

            $("#camera_status").html("人臉監測中");
            $("#camera_status").removeClass("d-none");
          }, 3000);
        }, 3000);
      }
      if (jsonData.status_code == 400) {
        $("#alert").removeClass("alert-success");
        $("#alert").addClass("alert-danger");
        $("#alert").html(jsonData.message);
        $("#alert").removeClass("d-none");
      }
    })
    .catch((err) => {
      console.log(err);
    });
  // for (var value of fd.values()) {
  //   console.log(value);
  // }
}
var interval = setInterval(function () {
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  imgData = canvas.toDataURL("image/png");
  console.log(imgData);
  imgData = dataURItoBlob(imgData);
  img_form_data.forEach(function (val, key, fD) {
    // here you can add filtering conditions
    img_form_data.delete(key);
  });
  img_form_data.append("image", imgData);
  sendToServer("/api/face", img_form_data, "POST");

  $("#camera_status").html("人臉監測中");
  $("#camera_status").removeClass("d-none");
}, 3000);
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

