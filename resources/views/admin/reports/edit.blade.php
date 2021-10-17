@extends('layouts.admin')
@section('content')
<nav>
  <ol id="breadcrumbWhite" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.report.index') }}">檢測資料</a></li>
    <li class="breadcrumb-item active">修改檢測資料</li>
  </ol>
</nav>

<form method="POST" action="{{route('admin.report.update', ['id' => $info['id']])}}" enctype="multipart/form-data">
  <div class="list-session col-12">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{ method_field('PATCH') }}
    <h5 class="mt-2"><i class="fas fa-edit"></i> 基本資料</h5>
    <hr>
    <div class="form-row">
      <div class="form-group col-12 col-md-3">
        <label>圖面編號</label>
        <input type="text" name="no" class="form-control" placeholder="請輸入圖面編號" value="{{ $info['no'] }}">
        @if($errors->has('no'))
          <small class="form-text text-danger">請輸入圖面編號</small>
        @else
          <small class="form-text text-muted">目前資料筆數: {{ $reportCount }}</small>
        @endif
      </div>
      <div class="form-group col-md-3">
        <label>場主姓名</label>
        <input type="text" name="name" class="form-control" placeholder="請輸入場主姓名" value="{{ $info['name'] }}">
        @if($errors->has('name'))
          <small class="form-text text-danger">請輸入場主姓名</small>
        @endif
      </div>
      <div class="form-group col-md-3">
        <label>種植種類</label>
        <input type="text" name="species" class="form-control" placeholder="請輸入種植種類" value="{{ $info['species'] }}">
        @if($errors->has('species'))
          <small class="form-text text-danger">請輸入種植種類</small>
        @endif
      </div>
      <div class="form-group col-md-3">
        <label>種植方式</label>
        <input type="text" name="method" class="form-control" placeholder="請輸入種植方式" value="{{ $info['method'] }}">
        @if($errors->has('method'))
          <small class="form-text text-danger">請輸入種植方式</small>
        @endif
      </div>
    </div>
    <div class="form-inline">
      <div class="input-group mt-2 mb-2 mr-sm-2">
          <div class="input-group-prepend">
            <div class="input-group-text">緯度</div>
          </div>
          <input type="text" name="lat" class="form-control" placeholder="請輸入緯度位置" value="{{ $info['lat'] }}">

      </div>
      <div class="input-group mt-2 mb-2 mr-sm-2">
          <div class="input-group-prepend">
            <div class="input-group-text">經度</div>
          </div>
          <input type="text" name="lng" class="form-control" placeholder="請輸入經度位置" value="{{ $info['lng'] }}">
      </div>
     
    </div>
    @if($errors->has('lat') || $errors->has('lng') )
      <div class="form-row">
        <div class="form-group col-12">
          <small class="form-text text-danger">請輸入地理位置</small>
        </div>
      </div>
    @endif
    

    <h5 class="mt-5"><i class="fas fa-edit"></i> 基本測值<small class="pl-2 text-muted">若無測值請留空，不要輸入N/A</small></h5>
    <hr>
    @if($errors->has('basics'))
      <div class="alert alert-danger" role="alert">請輸入格式正確的測值 (數字)</div>
    @endif
    <table class="table table-bordered">
      <thead class="bg-dark text-white">
        <td>土壤深度(公分)</td>
        <td>土壤含水率(%)</td>
        <td>土壤有機質(%)</td>
        <td>酸鹼值(pH)</td>
        <td>電導度(μS/cm)</td>
      </thead>
      <tbody>
        @foreach($basics as $key => $value)
        <tr>
          @foreach($basicsColumns as $basicsColumn)
            <td><input type="text" name="basics[{{$key}}][{{$basicsColumn}}]" placeholder="{{ $basicsChineseColumns[$loop->index] }}" class="form-control" value="{{ $value->$basicsColumn }}"></td>
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
    <h5 class="mt-5"><i class="fas fa-edit"></i> 金屬測值<small class="pl-2 text-muted">若無測值請留空，不要輸入N/A</small></h5>
    <hr>
    @if($errors->has('metal'))
      <div class="alert alert-danger" role="alert">{{ $errors->first('metal') }}</div>
    @endif
    @foreach($metal as $key => $value)
      <table class="table table-bordered">
        <thead class="bg-dark text-white">
          @for($i = 0 ; $i < 7 ; $i++)
            <td>{{ $metalChineseColumns[$i] }} {{ $metalColumns[$i] }}</td>
          @endfor
        </thead>
        <tbody>
          <tr>
            @for($i = 0 ; $i < 7 ; $i++)
              <td><input type="text" class="form-control" placeholder="{{ $metalChineseColumns[$i] }} {{ $metalColumns[$i] }}" name="metal[{{$key}}][{{$metalColumns[$i]}}]" value="{{ $value[$metalColumns[$i]] }}"></td>
            @endfor
          </tr>        
        </tbody>
        <thead class="bg-dark text-white">
          @for($i = 7 ; $i < count($metalColumns) ; $i++)
            <td>{{ $metalChineseColumns[$i] }} {{ $metalColumns[$i] }}</td>
          @endfor
        </thead>
        <tbody>
          <tr>
            @for($i = 7 ; $i < count($metalColumns) ; $i++)
              <td><input type="text" class="form-control" placeholder="{{ $metalChineseColumns[$i] }} {{ $metalColumns[$i] }}" name="metal[{{$key}}][{{$metalColumns[$i]}}]" value="{{ $value[$metalColumns[$i]] }}"></td>
            @endfor
          </tr>        
        </tbody>
      </table>
    @endforeach  
        
        
    <div class="col-12 mt-5 text-right">
      <button type="submit" class="btn btn-primary">送出</button>
      <a href="{{route('admin.report.index')}}" class="btn btn-danger" onclick="return confirm('確定要取消這次的修改嗎? 系統將不會儲存您的修改')">取消</a>
    </div>
  </div>  

</form>
@endsection
