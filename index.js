var video = document.getElementById("video");
var canvas = document.getElementById("canvas");
var context = canvas.getContext("2d");
var img = document.querySelector("img");
var imgData = null;
var localMediaStream = null;
var user_data;
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
    $("#snap").html("重新拍照");
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
  user_data = {
    name: document.getElementsByTagName("input").name.value,
    account_id: document.getElementsByTagName("input").account_id.value,
    u_id: document.getElementsByTagName("input").u_id.value,
    myclass: document.getElementsByTagName("input").myclass.value,
    gender: document.getElementsByTagName("select").gender.value,
    imaData: imgData,
  };
  sendToServer("http://10.96.26.249:5001/reg");
});

function sendToServer(url) {
  $.ajax({
    type: "POST",
    url: url,
    dataType: "jsonp",
    heads: {
      "content-type": "application/x-www-form-url-lencoded",
    },
    data: {
      name: user_data.name,
      account_id: user_data.account_id,
      u_id: user_data.u_id,
      myclass: user_data.myclass,
      gender: user_data.gender,
      imaData: user_data.imgData,
    },
    success: function () {
      print("work");
    },
  });
}
