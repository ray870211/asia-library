$("#login").click(function () {
  user_data = {
    account: document.getElementsByTagName("input").account.value,
    password: document.getElementsByTagName("input").password.value,
  };
  sendToServer("/api/login");
});
function sendToServer(url) {
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    heads: {
      "Content-type": "application/x-www-form-url-lencoded",
    },
    data: {
      account: user_data.account,
      password: user_data.password,
    },
    success: function (data) {
      if (data.status_code == "200") {
        location.href = "";
      }
    },
  });
}
