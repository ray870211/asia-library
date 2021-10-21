var video = document.getElementById("video");
var canvas = document.getElementById("canvas");
var context = canvas.getContext("2d");
var img = document.querySelector("img");
var imgData = null;
var localMediaStream = null;
var user_data;
var message_data;
var fd = new FormData(document.forms[0]);
var is_snap = 0;
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
    is_snap = 0;
  } else {
    canvas.setAttribute(
      "style",
      "width:" + video.clientWidth + "px;height:" + video.clientHeight + "px"
    );
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    imgData = dataURItoBlob(canvas.toDataURL("image/png"));
    // video.parentNode.removeChild(video);
    video.setAttribute("style", "display:none");
    $("#snap").html("重新拍照");
    $("#alert").addClass("d-none");
    is_snap = 1;
  }
}

$("#register").click(function () {
  if (is_snap == 0) {
    $("#alert").html("請先拍照");
    $("#alert").removeClass("d-none");
  } else {
    user_data = {
      name: document.getElementsByTagName("input").name.value,
      account_id: 1,
      u_id: document.getElementsByTagName("input").u_id.value,
      myclass: document.getElementsByTagName("input").myclass.value,
      gender: document.getElementsByTagName("select").gender.value,
      image: imgData,
    };
    fd.append("name", user_data.name);
    fd.append("account_id", user_data.account_id);
    fd.append("u_id", user_data.u_id);
    fd.append("myclass", user_data.myclass);
    fd.append("gender", user_data.gender);
    fd.append("image", user_data.image);
    sendToServer("/api/reg");
    $("#alert").addClass("d-none");
  }
});

function sendToServer(url) {
  fetch(url, {
    method: "POST",
    body: fd,
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
      $("#alert").html(response.message);
      $("#alert").removeClass("d-none");
      // sendToServer("/api/open");
    }
  }
}

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
