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
  //   alert(e.name);
}
function snap() {
  if (video.getAttribute("style") != null) {
    video.removeAttribute("style");
    canvas.setAttribute("style", "width:" + "0" + "px;height:" + "0" + "px;");
    // canvas.removeAttribute("style");
    $("#snap").html("拍照");
    is_snap = 0;
  } else {
    canvas.setAttribute(
      "style",
      "width:" + video.clientWidth + "px;height:" + video.clientHeight + "px;"
    );
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    imgData = dataURItoBlob(canvas.toDataURL("image/png"));
    // video.parentNode.removeChild(video);
    video.setAttribute("style", "display:none");
    img_form_data.forEach(function (val, key, fD) {
      // here you can add filtering conditions
      img_form_data.delete(key);
    });
    img_form_data.append("image", imgData);
    $("#snap").html("重新拍照");
    is_snap = 1;
  }
}
$("#identify").click(function () {
  sendToServer("/api/book", img_form_data, "POST");
  img_form_data.get('image')
  callAlert("請稍等")
})
function sendToServer(url, form_data, method) {
  fetch(url, {
    method: method,
    body: form_data,
  })
    .then((response) => {
      return response.json();
    })
    .then((jsonData) => {
      if (jsonData.status_code == 400) {
        callAlert(jsonData.message)
      }
      if (jsonData.status_code == 200) {
        callAlert(jsonData.message)
        console.log(200);
        document
          .getElementById("img")
          .setAttribute("src", "data:image/png;base64," + jsonData.image);
        document.getElementsByTagName("input").name.value = jsonData.name;
        document.getElementsByTagName("input").u_id.value = jsonData.u_id;
        document.getElementsByTagName("input").myclass.value = jsonData.class;
        if (jsonData.staff == "student") {
          document.getElementsByTagName("select").staff.selectedIndex = 1;
        } else {
          document.getElementsByTagName("select").staff.selectedIndex = 2;
        }
        if (jsonData.gender == "M") {
          document.getElementsByTagName("select").gender.selectedIndex = 1;
        } else {
          document.getElementsByTagName("select").gender.selectedIndex = 2;
        }
        setTimeout(function () {
          document
          .getElementById("img")
          .setAttribute("src", "");
        document.getElementsByTagName("input").name.value = ""
        document.getElementsByTagName("input").u_id.value = "";
        document.getElementsByTagName("input").myclass.value = "";
        document.getElementsByTagName("select").staff.selectedIndex = 0;
        document.getElementsByTagName("select").gender.selectedIndex = 0;
        }, 5000);
        copyContent()
      }else{
        callAlert("錯誤")
      }
    })
    .catch((err) => {
      if (typeof err !== "undefined") {
        console.log(err);
      }
    });
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

function copyContent(){
  navigator.clipboard.writeText(document.getElementsByTagName("input").u_id.value)
}

function callAlert(text){
  let deley = 3000
  var alert_timeout = setTimeout(() => {
    // $("#alert").addClass("d-none");
    $("#alert").hide("slow");
  }, deley);
  $("#alert").html(text);
  // $("#alert").removeClass("d-none");
  $("#alert").show("slow");
}