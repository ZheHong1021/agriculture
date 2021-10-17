function getReportData(info_id){
  target_path = 'api/report/' + info_id;
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });  
  $.ajax({
      url: target_path,
      type: 'POST',
      success: function(res) {
        writeReportModal(res);
      },
      error: function(xhr) {
        alert("系統錯誤，請稍後再試或聯絡網站管理員。");
      }
  });
}

function openReportModal(info_id){
  getReportData(info_id);
}

function writeReportModal(res){
  console.log(res);

  //info
  $("#column-info-no").text(res.data.info.no);
  $("#column-info-location").text(res.data.info.lat + ", " + res.data.info.lng);
  $("#column-info-species").text(res.data.info.species);
  $("#column-info-method").text(res.data.info.method);
  $("#column-info-name").text(res.data.info.name);

  //basics
  $("#basics-table").html("");
  for(i = 0; i < res['data']['basics'].length ; i++){
    $("#basics-table").append("<tr>");
    //console.log(res['data']['basics'][i]);
    for(x = 0 ; x < res['data']['basicsColumns'].length ; x++){
      key = res['data']['basicsColumns'][x];
      $("#basics-table").append("<td>" + res['data']['basics'][i][key] + "</td>");
    }   
    $("#basics-table").append("</tr>");
  }

  //average
  $("#column-average-n").text("全部測點平均值(n=" + res['data']['average'][0]['n'] + ")");
  $("#average-table").html("");
  for(i = 0; i < res['data']['average'].length ; i++){
    $("#average-table").append("<tr>");
    for(x = 0 ; x < res['data']['basicsColumns'].length ; x++){
      key = res['data']['basicsColumns'][x];
      $("#average-table").append("<td class='text-right'>" + res['data']['average'][i][key] + "</td>");
    } 
    $("#average-table").append("</tr>");
  }

  //metal
  $("#metal-section").css("display", "block");
  $("#metal-table-key").html("");
  $("#metal-table-value").html("");
  if( res['data']['metal'].length >= 1){

    for(i = 0 ; i < res['data']['metalColumns'].length ; i++ ){
      $("#metal-table-key").append("<th>" + res['data']['metalColumns'][i] + "</th>");
    }

    //index = res['data']['metal'].length - 1;
    for(x = 0 ; x < res['data']['metal'].length ; x ++){
      $("#metal-table-value").append("<tr>");
      for(i = 0 ; i < res['data']['metalColumns'].length ; i++ ){
        key = res['data']['metalColumns'][i];
        value = (res['data']['metal'][x][key] == null) ? "-" : res['data']['metal'][x][key] ;
        $("#metal-table-value").append("<td>" + value + "</td>");
        
      }
      $("#metal-table-value").append("</tr>");
    }
    
  }else{
    $("#metal-section").css("display", "none");
  }

  $('#report-modal').modal('show');
}