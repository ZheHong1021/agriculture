var map_height = $(window).height() - $("#user-navbar").height() - 20 - 60;
var map;
var arr_info = 1;

$("#map").css("height" ,map_height);


// function getInfo(){
//   target_path = 'api/report';
//   $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
//   });  
//   $.ajax({
//       url: target_path,
//       type: 'POST',
//       success: function(res) {
//         console.log(res.data.info);
//         arr_info = res.data.info;
//       },
//       error: function(xhr) {
//         alert("系統錯誤，請稍後再試或聯絡網站管理員。");
//         arr_info = [];
//       },
//       async: false
//   });
// }


function initMap (){
  var kaohsiung = {lat: 22.779533, lng: 120.326927};
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: kaohsiung
    });

    // 給特定值(擇一使用)
     map = L.map('map').setView({
        lng: 120.3290285, // longitude(經度)
        lat: 22.7534671, // latitude(緯度)
    }, 17 // zoom(地圖的縮放，值越大->放大；反之縮小)
  );
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var currentIcon = {
      url: 'http://163.18.42.31/agriculture/images/placeholder.png', // url
      scaledSize: new google.maps.Size(40, 40), // scaled size
      origin: new google.maps.Point(0,0), // origin
      anchor: new google.maps.Point(0, 0) // anchor
    };

    var standardIcon = {
      url: 'http://163.18.42.31/agriculture/images/placeholder_red.png', // url
      scaledSize: new google.maps.Size(40, 40), // scaled size
      origin: new google.maps.Point(0,0), // origin
      anchor: new google.maps.Point(0, 0) // anchor
    };


    //取得目前所在的頁數
    var url_string = window.location.href;
    var url = new URL(url_string);
    var currentPage = url.searchParams.get("page");
    if(currentPage === null){
      currentPage = 1;
    }

    getInfo();
    
    for(i = 0 ; i < arr_info.length ; i ++){
      //var content = "<div id='content'><a href="+ arr_info[i]['link'] +">#" + arr_info[i]['no'] + " " + arr_info[i]['name'] + "</a></div>";
      var content = "<div id='location-pop'>" +
        "<small>點位#"+arr_info[i]['no']+"</small><br><br>" +
        "<p><b><a title='前往資料所在的頁數' href="+arr_info[i]['link']+">"+arr_info[i]["name"]+"</a></b></p>" +
        "<p>種植種類: "+arr_info[i]["species"]+"</p>" +
        "<p>種植方式: "+arr_info[i]["method"]+"</p>" +
        "<hr>" +
        "<div class='text-center w-100'>" +
        "<button title='開啟檢測報告' class='btn btn-info' onclick='openReportModal("+arr_info[i]["id"]+")'><i class='far fa-file-alt'></i></button>" +
        "<button title='定位' type='button' class='btn btn-success ml-2' onclick='setCenter("+arr_info[i]["lat"]+", "+arr_info[i]["lng"]+")'><i class='fas fa-map-marker-alt'></i></button>" +
        "</div>" +
        "</div>";
      var myLatlng = new google.maps.LatLng(arr_info[i]['lat'], arr_info[i]['lng']);
      
      var infowindow = new google.maps.InfoWindow({
        content: content
      });

      //取得資料所在的頁數
      var url = new URL(arr_info[i]['link']);
      var dataPage = url.searchParams.get("page");
      
      if(dataPage != currentPage){
        var marker = new google.maps.Marker({
          map: map,
          position: myLatlng,
          title: arr_info[i]['name'],
          icon: standardIcon,
        });
      }else{
        var marker = new google.maps.Marker({
          map: map,
          position: myLatlng,
          title: arr_info[i]['name'],
          icon: currentIcon,
        });
      }
      
      /*
      var infowindow = new google.maps.InfoWindow();
      google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
        return function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
        };
      })(marker,content,infowindow));  
      
      marker.addListener('click', function() {
        infowindow.open(map, marker);
      });*/
      google.maps.event.addListener(marker, 'click', (function(marker,content,infowindow){ 
        return function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
        };
      })(marker, content, infowindow));  
    }
}

function setCenter(lat,lng){
  //alert(lat+" "+lng);
  var myLatlng = new google.maps.LatLng(lat,lng);
  map.setZoom(18);
  map.setCenter(myLatlng);
}
