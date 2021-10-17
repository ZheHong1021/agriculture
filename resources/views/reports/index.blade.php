@extends('layouts.user')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="container-fluid">
	<div id="addressBox" class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
    @if(count($info) <= 0)
      <center><p class="text-secondary pt-4">目前沒有任何檢測資料</p></center>
    @else
  		<table id="addressTable" class="table mt-4">
  			<thead>
          <th style="border-top: 0;">點位</th>
  				<th style="border-top: 0;">場主</th>
          <th style="border-top: 0;">種植種類</th>
          <th style="border-top: 0;">種植方式</th>
          <th style="border-top: 0;"></th>
  			</thead>
  		    <tbody>
            @for($i = 0; $i < count($info); $i++)
  		    	<tr>
                <td>#{{ $info[$i]['no'] }}</td>
  			        <td>{{ $info[$i]['name'] }}</td>
                <td>{{ $info[$i]['species'] }}</td>
                <td>{{ $info[$i]['method'] }}</td>
  			        <td class="text-center">
                  <button title="開啟檢測報告" class="btn btn-info" onclick="openReportModal({{ $info[$i]['id'] }})"><i class="far fa-file-alt"></i></button>
  			          <button title="定位" type="button" class="btn btn-success" onclick="setCenter({{ $info[$i]['lat'] }}, {{ $info[$i]['lng'] }})"><i class="fas fa-map-marker-alt"></i></button>
  			    	</td>
  			    </tr>
  		    	@endfor
  		    </tbody>
  		  </table>
        <div class="col-12 pr-0">
          @if($info->lastPage() > 1)
            <nav>
              <ul class="pagination justify-content-end">
                @if( $info->currentPage() != 1 )
                  <li class="page-item"><a title="第一頁" class="page-link" href="{{ $info->url(1) }}"> << </a></li>
                  <li class="page-item"><a title="上一頁" class="page-link" href="{{ $info->url($info->currentPage()-1) }}"> < </a></li>
                @endif
                
                @for($i = $startPage ; $i <= $endPage; $i++)
                  <li class="page-item {{ ($info->currentPage() == $i) ? 'active' : '' }}"><a class="page-link" href="{{ $info->url($i) }}">{{ $i }}</a></li>
                @endfor

                @if( $info->currentPage() != $info->lastPage() )
                  <li class="page-item"><a title="下一頁" class="page-link" href="{{ $info->nextPageUrl() }}"> > </a></li>
                  <li class="page-item"><a title="最後一頁" class="page-link" href="{{ $info->url($info->lastPage()) }}"> >> </a></li>
                @endif
              </ul>
            </nav>
          @endif
        </div>
      @endif  
	</div>

  <div class="modal fade" id="report-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>高科大農業環境資訊平台 檢測報告</b></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="info-table" class="table table-bordered">
            <thead>
              <tr class="bg-dark text-white border-only-bottom">
                <th style="border-right: none;">點位</th>
                <th id="column-info-no" class="text-center" colspan="2"><點位></th>
                <th>
              </tr>
              <tr class="bg-dark text-white border-only-bottom">
                <th>第一層</th>
                <th class="text-center" colspan="2">基本資料</th>
                <th>
              </tr>
              <tr>
                <th width="25%">座標</th>
                <th width="25%">種植種類</th>
                <th width="25%">種植方式</th>
                <th width="25%">場主</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td id="column-info-location">lat, lng</td>
                <td id="column-info-species">species</td>
                <td id="column-info-method">method</td>
                <td id="column-info-name">name</td>
              </tr>
            </tbody>
          </table>
          <table id="report-table" class="table table-bordered">
            <thead>
              <tr class="bg-dark text-white border-only-bottom">
                <th>第二層</th>
                <th class="text-center" colspan="3">基本測值</th>
                <th>
              </tr>
              <tr class="text-center">
                <th width="20%">土壤<br>深度(公分)</th>
                <th width="20%">土壤<br>含水率(%)</th>
                <th width="20%">土壤<br>有機質(%)</th>
                <th width="20%">酸鹼度<br>pH</th>
                <th width="20%">電導度(土/水=1/5)<br>μS/cm</th>
              </tr>
            </thead>
            <tbody id="basics-table" class="text-right">
            </tbody>
            <thead>
              <tr>
                <th colspan="5" id="column-average-n"></th>
              </tr>
              <tr class="text-center">
                <th width="20%">土壤<br>深度(公分)</th>
                <th width="20%">土壤<br>含水率(%)</th>
                <th width="20%">土壤<br>有機質(%)</th>
                <th width="20%">酸鹼度<br>pH</th>
                <th width="20%">電導度(土/水=1/5)<br>μS/cm</th>
              </tr>
            </thead>
            <tbody id="average-table">
            </tbody>
          </table>
          <div id="metal-section">
            <table class="table table-bordered">
              <thead class="bg-dark text-white">
                <tr class="border-only-bottom">
                  <th>第三層</th>
                  <th class="text-center" colspan="11">其他測值</th>
                  <th></th>
                </tr>
                <tr id="metal-table-key">
                </tr>
              </thead>
              <tbody id="metal-table-value" class="text-right">

              </tbody>
            </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>
<div id="map" class="jumbotron jumbotron-fluid mb-0">
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('js/map.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/report.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJpUelShEKxbqbPvaF2D8TZNn7lYmYJKs&callback=initMap"></script>
@endsection