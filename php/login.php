<?php
include('./php/sql_connect.php');
// session_start();
$account =$_POST['account'];
$password = $_POST['password'];
// $secretKey='6LcprpAbAAAAAE6aG9Vvbh1golhU10xrWMvbNsmL';
if(isset($_POST["account"])){
  $login_sql = "SELECT * FROM `Account` WHERE account='$account' AND password='$password'";
  $login_query= mysqli_query($connection,$login_sql);
  $item = mysqli_fetch_assoc($login_query);
  if(isset($item) and $item['password']==$password){
    $hash = password_hash($item['account'], PASSWORD_DEFAULT);
    // if(password_verify($password, $hash)){
    //   echo "123";
    // };
    
    $_SESSION['session_id']=$hash;
    header("Location:../backstage.php");
    echo $hash;
  } else{
    $GLOBALS["error_message"]="登入失敗";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>登入</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/index.css" />
    <link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="./faceIdentify.html">亞洲大學圖書館</a>

          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="faceIdentify.html">辨識</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./borrowBooks.html">借書</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="container-fluid mt-2">
      <div class="row">
        <div class="col-8 m-auto">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">登入</h5>
              <div class="card-text table-group">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input
                  class="form-control form-control-lg m-2 student-input"
                  type="text"
                  placeholder="帳號"
                  aria-label=".form-control-lg example"
                  name="account"
                />
                <input
                  class="form-control form-control-lg m-2 student-input"
                  type="password"
                  placeholder="密碼"
                  aria-label=".form-control-lg example"
                  name="password"
                />
              </div>
              <button class="card-btn" id="login">登入</button>
                </form>
                
            </div>
            <div id="alert" class="alert alert-warning d-none" role="alert">
              This is a warning alert—check it out!
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.login-card-body -->
    <?php if(isset($error_message)):?>
            <div class="alert alert-danger m-2" role="alert">
                <?php echo $error_message;?>
            </div>
        </div>
        <?php endif?>
    <footer class="footer">
      <div class="container d-flex justify-content-center">
          <p>Copyright © 2021 Asia University. All rights reserved. 亞洲大學圖書館</p>
      </div>
  </footer>
    <script
      src="https://code.jquery.com/jquery-3.6.0.js"
      integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
    <script src="../js/login.js"></script>
  </body>
</html>
