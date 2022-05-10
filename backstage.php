<?php
include("php/sql_connect.php");
session_set_cookie_params(0);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>人臉辨識後台管理系統</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="/css/backstage.css" />
    <link
      rel="stylesheet"
      href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"
    />
    <!-- DataTables v1.10.16 -->
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"
    />
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
    <link  rel="stylesheet"
      href="/css/ui-datepicker.css" />
  </head>
  <?php if (isset($_SESSION['session_id'])) : ?>
  <body>
    <header>
      <nav class="navbar navbar-expand navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand title" href="./faceIdentify.html">亞洲大學圖書館後台管理系統</a>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="backstage.php">總覽</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="importData.html">匯入資料</a>
              </li>
            </ul>
            <a class="nav-btn" href="./borrowBooks.html">前台</a>
            <a class="nav-logup-btn" href="./php/signout.php">登出</a>
          </div>
        </div>
      </nav>
    </header>
    <div class="container-fluid my-4 wrap">
      
      <div class="table-box">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button
              class="nav-link active"
              id="nav-home-tab"
              data-bs-toggle="tab"
              data-bs-target="#nav-home"
              type="button"
              role="tab"
              aria-controls="nav-home"
              aria-selected="true"
            >
              帳戶
            </button>
            <button
              class="nav-link"
              id="nav-profile-tab"
              data-bs-toggle="tab"
              data-bs-target="#nav-profile"
              type="button"
              role="tab"
              aria-controls="nav-profile"
              aria-selected="false"
            >
              已註冊人員
            </button>
            <button
              class="nav-link"
              id="nav-contact-tab"
              data-bs-toggle="tab"
              data-bs-target="#nav-contact"
              type="button"
              role="tab"
              aria-controls="nav-contact"
              aria-selected="false"
            >
              紀錄
            </button>
          </div>
        </nav>
        <div
          class="modal fade"
          id="account_modal"
          tabindex="-1"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">帳號</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">密碼</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">創建時間</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">更改時間</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="edit_y"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">is_delete</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-danger"
                  data-bs-dismiss="modal"
                  id="close"
                  onclick=""
                >
                  清空
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                  id="saveChanges"
                  onclick="updateButtonClick()"
                >
                  更新
                </button>
              </div>
            </div>
          </div>
        </div>
        <div
          class="modal fade"
          id="employee_modal"
          tabindex="-1"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <img class = "d-block mx-auto my-1" src="" alt="" id="employee_image" width="120px" height="120px">
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Account ID</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm employee_root">圖片路徑</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">職位</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">科系</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="edit_y"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">姓名</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">學號</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">性別</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">創建時間</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">更改時間</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">is_delete</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-danger"
                  data-bs-dismiss="modal"
                  id="close"
                  onclick=""
                >
                  清空
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                  id="saveChanges"
                  onclick="updateButtonClick()"
                >
                  更新
                </button>
              </div>
            </div>
          </div>
        </div>
        <div
          class="modal fade"
          id="record_modal"
          tabindex="-1"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <img class = "d-block mx-auto my-1" src="" alt="" id="record_image" width="120px" height="120px">
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Account ID</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">圖片路徑</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">職位</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">科系</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="edit_y"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">姓名</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">學號</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">性別</span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">創建時間</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">更改時間</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">is_delete</span>
                  </div>
                  <input
                    type="text"
                    disabled="disabled"
                    class="form-control"
                    aria-label="Small"
                    aria-describedby="inputGroup-sizing-sm"
                    id="text"
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-danger"
                  data-bs-dismiss="modal"
                  id="close"
                  onclick=""
                >
                  清空
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                  id="saveChanges"
                  onclick="updateButtonClick()"
                >
                  更新
                </button>
              </div>
            </div>
          </div>
        </div>
       
          <div class="tab-content" id="nav-tabContent">
            <div
              class="tab-pane fade show active"
              id="nav-home"
              role="tabpanel"
              aria-labelledby="nav-home-tab"
            >
          
              <table class="account_table" id="account_table">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>帳號</th>
                    <th>密碼</th>
                    <th>創建時間</th>
                    <th>更改時間</th>
                    <th>is_delete</th>
                    <th>view</th>
                    <th>delete</th>
                  </tr>
                </thead>
                <tbody id="account_tbody">
                  <td><button type="button" class="btn btn-outline-primary">view</button></td>
                  <td><button type="button" class="btn btn-outline-danger">delete</button></td>
                </tbody>
              </table>
            </div>
            <div
              class="tab-pane fade"
              id="nav-profile"
              role="tabpanel"
              aria-labelledby="nav-profile-tab"
            >
            <div class="form-row d-flex">
              <div id="date_filter" class= "form-group col-3 m-2">
                <span id="date-label-from" class="date-label">From: </span>
                <input class="form-control date_range_filter date" type="text" id="employee_datepicker_from" />
              </div>
               
                <div id="date_filter" class= "form-group col-3 m-2">
                  <span id="date-label-to" class="date-label"></span>To:
                  <input class="form-control date_range_filter date" type="text" id="employee_datepicker_to" />
                </div>
            </div>
              <table class="employee_table" id="employee_table">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>account_id</th>
                    <th>圖片路徑</th>
                    <th>職位</th>
                    <th>系所</th>
                    <th>姓名</th>
                    <th>學號</th>
                    <th>性別</th>
                    <th>註冊時間</th>
                    <th>更改時間</th>
                    <th>is_delete</th>
                    <th>view</th>
                    <th>delete</th>
                  </tr>
                </thead>
                <tbody id="employee_tbody">
                  <td><button type="button" class="btn btn-outline-primary">view</button></td>
                  <td><button type="button" class="btn btn-outline-danger">delete</button></td>
                </tbody>
              </table>
            </div>
            <div
              class="tab-pane fade"
              id="nav-contact"
              role="tabpanel"
              aria-labelledby="nav-contact-tab"
            >
            <div class="form-row d-flex">
              <div id="date_filter" class= "form-group col-3 m-2">
                <span id="date-label-from" class="date-label">From: </span>
                <input class="form-control date_range_filter date" type="text" id="decord_datepicker_from" />
              </div>
               
                <div id="date_filter" class= "form-group col-3 m-2">
                  <span id="date-label-to" class="date-label"></span>To:
                  <input class="form-control date_range_filter date" type="text" id="decord_datepicker_to" />
                </div>
            </div>
          
              <table class="record_table" id="record_table">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>employee_id</th>
                    <th>圖片路徑</th>
                    <th>職位</th>
                    <th>系所</th>
                    <th>姓名</th>
                    <th>學號</th>
                    <th>性別</th>
                    <th>註冊時間</th>
                    <th>更改時間</th>
                    <th>is_delete</th>
                    <th>view</th>
                    <th>delete</th>
                  </tr>
                </thead>
                <tbody id="record_tbody">
                  <td><button type="button" class="btn btn-outline-primary">view</button></td>
                  <td><button type="button" class="btn btn-outline-danger">delete</button></td>
                </tbody>
              </table>
            </div>
          </div>
          <div id="alert" class="alert alert-warning m-auto" role="alert" style="display: none;width: 800px;"></div>
      </div>
      <!-- Modal -->
    </div>
    <footer class="footer">
      <div class="container d-flex justify-content-center">
          <p>Copyright © 2021 Asia University. All rights reserved. 亞洲大學圖書館</p>
      </div>
  </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!--引用dataTables.js-->
    <script
      type="text/javascript"
      src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"
    ></script>
    <script src="./js/backstage.js"></script>
  </body>
  <?php endif?>
  <?php if (empty($_SESSION['session_id'])) : ?>
        <?php
        include('php/login.php');
        ?>
    <?php endif ?>
</html>

