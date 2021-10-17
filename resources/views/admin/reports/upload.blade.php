@extends('layouts.admin')
@section('content')
<nav>
  <ol id="breadcrumbWhite" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.report.index') }}">檢測資料</a></li>
    <li class="breadcrumb-item active" aria-current="page">匯入資料</li>
  </ol>
</nav>
<form method="POST" action="{{route('admin.report.storeFile')}}" enctype="multipart/form-data">
  <div class="list-session col-12">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h5 class="mt-2"><i class="fas fa-edit"></i> 匯入資料</h5>
    <hr>
    <div class="form-row">
      <div class="form-group col-12 col-md-3">
        <label>請選擇檔案</label>
        <input accept=".csv" type="file" name="file" class="form-control">
        @if($errors->has('file'))
          <small class="form-text text-danger">請上傳格式正確的檔案(csv)</small>
        @else
          <small class="form-text text-muted">請上傳csv檔案</small>
        @endif
      </div>
    </div>
    <div class="col-12 mt-5 text-right">
      <button type="submit" class="btn btn-primary">送出</button>
      <a href="{{route('admin.report.index')}}" class="btn btn-danger" onclick="return confirm('確定要取消這次的修改嗎? 系統將不會儲存您的修改')">取消</a>
    </div>
  </div>  
</form>

@endsection