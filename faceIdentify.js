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

function sendToServer(url, form_data, method) {
  fetch(url, {
    method: method,
    body: form_data,
  })
    .then((response) => {
      response = response;
      console.log(response);
      return response.json();
    })
    .then((jsonData) => {
      response = jsonData;
      console.log(jsonData);
    })
    .catch((err) => {
      response = ree;
      console.log(err);
    });
  // for (var value of fd.values()) {
  //   console.log(value);
  // }
  if (typeof response !== "undefined") {
    if (response.status_code == 400) {
      $("#alert").html(response.message);
      $("#alert").removeClass("d-none");
    }
    if (response.status_code == 200) {
      // sendToServer("/api/frontDoor", "", "GET");
      $("#alert").html(response.message);
      $("#alert").removeClass("d-none");
    }
  }
}
var interval = setInterval(function () {
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  imgData = canvas.toDataURL("image/png");
  imgData = dataURItoBlob(canvas.toDataURL("image/png"));
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
