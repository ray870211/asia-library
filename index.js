var video = document.getElementById("video");
var canvas = document.getElementById("canvas");
var context = canvas.getContext("2d");
var img = document.querySelector("img");
var imgData = null;
var localMediaStream = null;
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
function snap() {
  if (video.getAttribute("style") != null) {
    video.removeAttribute("style");
    canvas.removeAttribute("style");
    $("#snap").html("拍照");
  } else {
    canvas.setAttribute(
      "style",
      "width:" + video.clientWidth + "px;height:" + video.clientHeight + "px"
    );
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    imgData = canvas.toDataURL();
    // video.parentNode.removeChild(video);
    video.setAttribute("style", "display:none");
    $("#snap").html("重新拍照");
  }
}

$("#register").click(function () {
  sendToServer("./face_detection.py/reg", imgData);
});

function sendToServer(url, dataURL) {
  $.ajax({
    type: "POST",
    url: url,
    data: {
      imgBase64: dataURL,
    },
    success: function () {
      print("work");
    },
  });
}
