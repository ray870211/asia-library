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
        $("#alert").removeClass("alert-success");
        $("#alert").addClass("alert-danger");
        $("#alert").html(jsonData.message);
        $("#alert").removeClass("d-none");
      }
      if (jsonData.status_code == 200) {
        console.log(200);
        document
          .getElementById("img")
          .setAttribute("src", "data:image/png;base64," + jsonData.image);
        document.getElementsByTagName("input").name.value = jsonData.name;
        document.getElementsByTagName("input").u_id.value = jsonData.u_id;
        document.getElementsByTagName("input").myclass.value = jsonData.class;
        if (jsonData.staff == "Male") {
          document.getElementsByTagName("select").staff.selectedIndex = 1;
        } else {
          document.getElementsByTagName("select").staff.selectedIndex = 2;
        }
        if (jsonData.gender == "Male") {
          document.getElementsByTagName("select").gender.selectedIndex = 1;
        } else {
          document.getElementsByTagName("select").gender.selectedIndex = 1;
        }

        //   sendToServer("/api/frontDoor", "", "GET");
        $("#alert").removeClass("d-none");
        $("#alert").removeClass("alert-danger");
        $("#alert").addClass("alert-success");
        $("#alert").html("辨識成功");
        $("#alert").removeClass("d-none");
        clearInterval(interval);
        $("#camera_status").html("稍等");
        setTimeout(function () {
          document.getElementById("img").setAttribute("src", "");
          document.getElementsByTagName("input").name.value = "";
          document.getElementsByTagName("input").u_id.value = "";
          document.getElementsByTagName("input").myclass.value = "";
          document.getElementsByTagName("select").staff.selectedIndex = 0;
          document.getElementsByTagName("select").gender.selectedIndex = 0;

          interval = setInterval(function () {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            imgData = canvas.toDataURL("image/png");
            imgData = dataURItoBlob(canvas.toDataURL("image/png"));
            img_form_data.forEach(function (val, key, fD) {
              // here you can add filtering conditions
              img_form_data.delete(key);
            });
            img_form_data.append("image", imgData);
            $("#camera_status").html("監測中");
            $("#camera_status").removeClass("d-none");
            sendToServer("/api/face", img_form_data, "POST");
          }, 3000);
        }, 3000);
      }
    })
    .catch((err) => {
      if (typeof err !== "undefined") {
        console.log(err);
      }
    });
}
var interval = setInterval(function () {
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  imgData = canvas.toDataURL("image/png");
  imgData = dataURItoBlob(canvas.toDataURL("image/png"));
  img_form_data.forEach(function (val, key, fD) {
    // here you can add filtering conditions
    img_form_data.delete(key);
  });
  img_form_data.append("image", imgData);
  $("#camera_status").html("監測中");
  $("#camera_status").removeClass("d-none");
  sendToServer("/api/face", img_form_data, "POST");
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

