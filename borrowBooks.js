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
      if (typeof jsonData !== "undefined") {
        if (jsonData.status_code == 400) {
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
          document.getElementsByTagName("staff").staff.value = jsonData.staff;
          document.getElementsByTagName("select").gender.value = jsonData.gender;
          //   sendToServer("/api/frontDoor", "", "GET");
          $("#alert").html("辨識成功");
          $("#alert").removeClass("d-none");
          clearInterval(interval);
          $("#camera_status").html("稍等");
          setTimeout(function () {
            document.getElementById("img").setAttribute("src", "");
            document.getElementsByTagName("input").name.value = "";
            document.getElementsByTagName("input").u_id.value = "";
            document.getElementsByTagName("input").myclass.value = "";
            document.getElementsByTagName("staff").staff.value = "";
            document.getElementsByTagName("select").gender.value = "";

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
          }, 10000);
        }
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
// imgData = dataURItoBlob(
//   "data:image/png;base64,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"
// );
// img_form_data.forEach(function (val, key, fD) {
//   // here you can add filtering conditions
//   img_form_data.delete(key);
// });
// img_form_data.append("image", imgData);
// sendToServer("/api/face", img_form_data, "POST");
