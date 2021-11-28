<?php
include("./php/select_sql.php");
echo $tables['Account']['id'][0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>借書</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
  <link rel="stylesheet" href="./index.css" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- DataTables v1.10.16 -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />


</head>

<body>
  <header>
    <nav class="navbar navbar-expand navbar-light">
      <div class="container-fluid">

        <a class="navbar-brand" href="./faceIdentify.html">亞洲大學圖書館</a>
        <i class="fas fa-home"></i>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.html">人臉註冊</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="faceIdentify.html">辨識</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./borrowBooks.html">借書</a>
            </li>
          </ul>
        </div>
        <a class="login-btn" href="./login.html">登入</a>
      </div>
    </nav>
  </header>
  <div class="container-fluid m-4">

    <!-- Modal -->
    <div class="modal fade" id="account_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
              </div>
              <input type="text" disabled="disabled" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Account</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Password</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">gmt_create</span>
              </div>
              <input type="text" disabled="disabled" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">gmt_update</span>
              </div>
              <input type="text" disabled="disabled" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_y" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">is_delete</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="close" onclick="">
              清空
            </button>
            <button type="button" class="btn btn-primary" id="saveChanges" onclick="">
              更新
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="employee_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
              </div>
              <input type="text" disabled="disabled" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Account ID</span>
              </div>
              <input type="text" disabled="disabled" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Root</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Staff</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">MyClass</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_y" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">u_id</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Gender</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">gmt_create</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">gmt_update</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">is_delete</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="close" onclick="">
              清空
            </button>
            <button type="button" class="btn btn-primary" id="saveChanges" onclick="">
              更新
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="record_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">ID</span>
              </div>
              <input type="text" disabled="disabled" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Account ID</span>
              </div>
              <input type="text" disabled="disabled" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Root</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Staff</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_x" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">MyClass</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="edit_y" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">u_id</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Gender</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">gmt_create</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">gmt_update</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">is_delete</span>
              </div>
              <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="text" autocomplete="off" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="close" onclick="">
              清空
            </button>
            <button type="button" class="btn btn-primary" id="saveChanges" onclick="">
              更新
            </button>
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Account</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Employee</button>
        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Record</button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <table class="account_table" id="account_table">
          <thead>
            <tr>
              <th>id</th>
              <th>account</th>
              <th>password</th>
              <th>gmt_create</th>
              <th>gmt_update</th>
              <th>is_delete</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php for ($i = 0; $i < count($tables['Account']); $i++) : ?>

                <td><?php echo $tables['Account'][$i]['id']; ?></td>
                <td><?php echo $tables['Account'][$i]['account']; ?></td>
                <td><?php echo $tables['Account'][$i]['password']; ?></td>
                <td><?php echo $tables['Account'][$i]['gmt_create']; ?></td>
                <td><?php echo $tables['Account'][$i]['gmt_update']; ?></td>
                <td><?php echo $tables['Account'][$i]['is_delete']; ?></td>
                <td><button type="button" class="btn btn-outline-primary">edit</button></td>
                <td><button type="button" class="btn btn-outline-danger">delete</button></td>
              <?php endfor ?>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <table class="employee_table" id="employee_table">
          <thead>
            <tr>
              <th>id</th>
              <th>account_id</th>
              <th>root</th>
              <th>staff</th>
              <th>myclass</th>
              <th>name</th>
              <th>u_id</th>
              <th>gender</th>
              <th>gmt_create</th>
              <th>gmt_update</th>
              <th>is_delete</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 0; $i < count($tables['Employee']); $i++) : ?>
              <tr>
                <td><?php echo $tables['Employee'][$i]['id']; ?></td>
                <td><?php echo $tables['Employee'][$i]['account_id']; ?></td>
                <td><?php echo $tables['Employee'][$i]['root']; ?></td>
                <td><?php echo $tables['Employee'][$i]['staff']; ?></td>
                <td><?php echo $tables['Employee'][$i]['myclass']; ?></td>
                <td><?php echo $tables['Employee'][$i]['name']; ?></td>
                <td><?php echo $tables['Employee'][$i]['u_id']; ?></td>
                <td><?php echo $tables['Employee'][$i]['gender']; ?></td>
                <td><?php echo $tables['Employee'][$i]['gmt_create']; ?></td>
                <td><?php echo $tables['Employee'][$i]['gmt_update']; ?></td>
                <td><?php echo $tables['Employee'][$i]['is_delete']; ?></td>
                <td><button type="button" class="btn btn-outline-primary">edit</button></td>
                <td><button type="button" class="btn btn-outline-danger">delete</button></td>
              </tr>
            <?php endfor ?>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <table class="record_table" id="record_table">
          <thead>
            <tr>
              <th>id</th>
              <th>employee_id</th>
              <th>root</th>
              <th>staff</th>
              <th>myclass</th>
              <th>name</th>
              <th>u_id</th>
              <th>gender</th>
              <th>gmt_create</th>
              <th>gmt_update</th>
              <th>is_delete</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 0; $i < count($tables['Record']); $i++) : ?>
              <tr>
                <td><?php echo $tables['Record'][$i]['id']; ?></td>
                <td><?php echo $tables['Record'][$i]['account_id']; ?></td>
                <td><?php echo $tables['Record'][$i]['root']; ?></td>
                <td><?php echo $tables['Record'][$i]['staff']; ?></td>
                <td><?php echo $tables['Record'][$i]['myclass']; ?></td>
                <td><?php echo $tables['Record'][$i]['name']; ?></td>
                <td><?php echo $tables['Record'][$i]['u_id']; ?></td>
                <td><?php echo $tables['Record'][$i]['gender']; ?></td>
                <td><?php echo $tables['Record'][$i]['gmt_create']; ?></td>
                <td><?php echo $tables['Record'][$i]['gmt_update']; ?></td>
                <td><?php echo $tables['Record'][$i]['is_delete']; ?></td>
                <td><button type="button" class="btn btn-outline-primary">edit</button></td>
                <td><button type="button" class="btn btn-outline-danger">delete</button></td>
              </tr>
            <?php endfor ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!--引用dataTables.js-->
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script></script>
  <script>
    $("#account_table").DataTable({
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      language: {
        sInfo: "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
        sInfoEmpty: "顯示第 0 至 0 項結果，共 0 項",
        sInfoFiltered: "(由 _MAX_ 項結果過濾)",
        sInfoPostFix: "",
        sSearch: "搜索:",
        sUrl: "",
        oPaginate: {
          sFirst: "首頁",
          sPrevious: "上頁",
          SLast: "末頁",
          sNext: "下頁",
        },
      },
    });
    $("#employee_table").DataTable({
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      language: {
        sInfo: "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
        sInfoEmpty: "顯示第 0 至 0 項結果，共 0 項",
        sInfoFiltered: "(由 _MAX_ 項結果過濾)",
        sInfoPostFix: "",
        sSearch: "搜索:",
        sUrl: "",
        oPaginate: {
          sFirst: "首頁",
          sPrevious: "上頁",
          SLast: "末頁",
          sNext: "下頁",
        },
      },
    });
    $("#record_table").DataTable({
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      language: {
        sInfo: "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
        sInfoEmpty: "顯示第 0 至 0 項結果，共 0 項",
        sInfoFiltered: "(由 _MAX_ 項結果過濾)",
        sInfoPostFix: "",
        sSearch: "搜索:",
        sUrl: "",
        oPaginate: {
          sFirst: "首頁",
          sPrevious: "上頁",
          SLast: "末頁",
          sNext: "下頁",
        },
      },
    });
  </script>
</body>

</html>