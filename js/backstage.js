var account_col = [[]];
var employee_col = [[]];
var record_col = [[]];
//點擊edit 
var selected_modal;
var selected_id;

$.fn.dataTable.ext.errMode = "none";

function editButtonClick(selectedTable, id) {
  function getImage(img_url) {
    var img_form_data = new FormData();
    img_form_data.append("image_url", img_url);
    fetch("../php/get_image.php", {
      method: "POST",
      body: img_form_data,
    })
      .then((response) => {
        return response.json();
      })
      .then((jsonData) => {
        console.log(jsonData.image)
        $("#"+table_title[selectedTable]+"_image").attr("src", "data:image/png;base64," + jsonData.image)
      })
      .catch((err) => {
        console.log(err);
      });
  }
  getImage(table[selectedTable][id].root)
  selected_modal = selectedTable;
  selected_id = id;
  $("#" + table_title[selectedTable] + "_modal").modal("show");
  for (let i = 0; i < Object.values(table[selectedTable][0]).length; i++) {
    document.getElementsByClassName("modal-body")[selectedTable].querySelectorAll("input")[
      i
    ].value = Object.values(table[selectedTable][id])[i];
  }
  
}
function updateButtonClick() {
  var modal_form_data = new FormData();
  modal_form_data.append(
    "table_title",
    table_title[selected_modal].charAt(0).toUpperCase() + table_title[selected_modal].slice(1)
  );
  for (let i = 0; i < Object.values(table[selected_modal][0]).length; i++) {
    modal_form_data.append(
      Object.keys(table[selected_modal][0])[i],
      document.getElementsByClassName("modal-body")[selected_modal].querySelectorAll("input")[i]
        .value
    );

    //改變table的值
    $("#"+table_title[selected_modal]+[Object.values(table[selected_modal][selected_id])[0]]).children()[i].textContent = document
    .getElementsByClassName("modal-body")
    [selected_modal].querySelectorAll("input")[i].value;
    // console.log($("#"+table_title[selected_modal]+[Object.values(table[selected_modal][id])[0]]).children[i].textContent )
    // $("#" + table_title[selected_modal] + "_tbody").children()[selected_id % 10].children[
    //   i
    // ].textContent = document
    //   .getElementsByClassName("modal-body")
    //   [selected_modal].querySelectorAll("input")[i].value;
  }
  modal_form_data.get("id");
  fetch("../php/update.php", {
    method: "POST",
    body: modal_form_data,
  })
    .then((response) => {
      return response.json();
    })
    .then((jsonData) => {
      if(jsonData.status === 200){
        callAlert("編輯成功")
      }
    })
    .catch((err) => {
      console.log(err);
    });
}

function deleteButtonClick(selectedTable, id) {
  var form_data = new FormData();
  var img_url = new FormData();
  form_data.append(
    "table_title",
    table_title[selectedTable].charAt(0).toUpperCase() + table_title[selectedTable].slice(1)
  ); 
  form_data.append("id", table[selectedTable][id].id);
  form_data.append("u_id", table[selectedTable][id].u_id);
  fetch("../php/delete.php", {
    method: "POST",
    body: form_data,
  })
    .then((response) => {
      return response.json();
    })
    .then((jsonData) => {
      if (jsonData.status === 200) {
        $("#" + table_title[selectedTable] + "_table")
          .DataTable()
          .destroy()
          
        select_data();
        callAlert("刪除成功")
      }
    })
    .catch((err) => {
      console.log(err);
    });

    img_url.append("image_url", table[selectedTable][id].root);
    fetch("../php/delete_image.php", {
      method: "POST",
      body: img_url,
    })
      .then((response) => {
        return response.json();
      })
      .then((jsonData) => {
        if (jsonData.status === 200) {
          $("#" + table_title[selectedTable] + "_table")
        }
      })
      .catch((err) => {
        console.log(err);
      });
}

function select_data() {
  let url = "../php/select_sql.php";
  fetch(url, {
    method: "POST",
  })
    .then((response) => {
      return response.json();
    })
    .then((jsonData) => {
      account_col = jsonData.Account;
      employee_col = jsonData.Employee;
      record_col = jsonData.Record;
      addToTable();
    })
    .catch((err) => {
      console.log(err);
    });
}

function addToTable() {
  table_title = ["account", "employee", "record"];
  table_name = ["account_tbody", "employee_tbody", "record_tbody"];
  table = [account_col, employee_col, record_col];
  var tableContent
  for (let k = 0; k < 3; k++) {
    id_count = 0;
    //哪個table
    for (let i = 0; i < table[k].length; i++) {
      //哪行資料
      tableContent += "<tr data-id="+ Object.values(table[k][i])[0]+ " id="+table_title[k]+ Object.values(table[k][i])[0]+">";
      for (let j = 0; j < Object.keys(table[k][0]).length; j++) {
        //哪筆資料
        tableContent += "<td>" + Object.values(table[k][i])[j] + "</td>";
      }
      tableContent +=
        "<td><button type='button' class='btn btn-outline-primary' onclick='editButtonClick(" +
        k +
        "," +
        id_count +
        ")'>view</button></td>";
      tableContent +=
        "<td><button type='button' class='btn btn-outline-danger' onclick='deleteButtonClick(" +
        k +
        "," +
        id_count +
        ")'>delete</button></td>"; 
      tableContent += "</tr>";
      id_count++;
    }
    $("#" + table_name[k]).html(tableContent);
    tableContent = ""
  }
  function addDataTable() {
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
      pageLength:10,
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
    var employee_table = $("#employee_table").DataTable({
      "oLanguage": {
        "sSearch": "Filter Data"
      },
      "iDisplayLength": -1,
      "sPaginationType": "full_numbers",
  
    });
   
    $("#employee_datepicker_from").datepicker({
      "onSelect": function(date) {
        minDateFilter = new Date(date).getTime();
        employee_table.draw();
      }
    }).keyup(function() {
      minDateFilter = new Date(this.value).getTime();
      employee_table.draw();
    });
  
    $("#employee_datepicker_to").datepicker({
      "onSelect": function(date) {
        maxDateFilter = new Date(date).getTime();
        employee_table.draw();
      }
    }).keyup(function() {
      maxDateFilter = new Date(this.value).getTime();
      employee_table.draw();
    });
    minDateFilter = "";
    maxDateFilter = "";
    var record_table = $("#record_table").DataTable({
      "oLanguage": {
        "sSearch": "Filter Data"
      },
      "iDisplayLength": -1,
      "sPaginationType": "full_numbers",
  
    });
  
    $("#decord_datepicker_from").datepicker({
      "onSelect": function(date) {
        minDateFilter = new Date(date).getTime();
        record_table.draw();
      }
    }).keyup(function() {
      minDateFilter = new Date(this.value).getTime();
      record_table.draw();
    });
  
    $("#decord_datepicker_to").datepicker({
      "onSelect": function(date) {
        maxDateFilter = new Date(date).getTime();
        record_table.draw();
      }
    }).keyup(function() {
      maxDateFilter = new Date(this.value).getTime();
      record_table.draw();
    });
    minDateFilter = "";
    maxDateFilter = "";
    
    $.fn.dataTableExt.afnFiltering.push(
      function(oSettings, aData, iDataIndex) {
        if (typeof aData._date == 'undefined') {
          aData._date = new Date(aData[8]).getTime();
        }
        if (minDateFilter && !isNaN(minDateFilter)) {
          if (aData._date < minDateFilter) {
            return false;
          }
        }
    
        if (maxDateFilter && !isNaN(maxDateFilter)) {
          if (aData._date > maxDateFilter) {
            return false;
          }
        }
        console.log(aData._date)
        return true;
      }
    );
  }
  
  addDataTable()
}


$(document).ready(function () {
  select_data();
});

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

// Date range filter
