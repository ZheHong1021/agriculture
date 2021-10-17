@extends('layouts.admin')
@section('content')
<nav>
  <ol id="breadcrumbWhite" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">使用者管理</a></li>
    <li class="breadcrumb-item active" aria-current="page">新增使用者</li>
  </ol>
</nav>
<form method="POST" action="{{route('admin.user.store')}}">
  <div class="list-session col-12">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h5 class="mt-2"><i class="fas fa-edit"></i> 基本資料</h5>
    <hr>
   
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>使用者帳號</label>
        <input type="text" name="acc" class="form-control" placeholder="請輸入使用者帳號" value="{{ old('acc') }}" required autofocus>
        @if($errors->first('acc'))
          <small class="text-danger">{{ $errors->first('acc') }}</small>
        @endif
      </div>

    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>使用者權限</label>
        <select class="form-control" name="authority">
          <option value="2">一般管理者</option>
          <option value="3" selected>訪客</option>
        </select>
        @if ($errors->has('authority'))
          <small class="text-danger">{{ $errors->first('authority') }}</small>
        @endif          
      </div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>使用者密碼</label>
        <input type="password" name="password" class="form-control" placeholder="請輸入密碼" required>
        @if ($errors->has('password'))
          <small class="text-danger">{{ $errors->first('password') }}</small>
        @endif
      </div>
      <div class="form-group col-md-6">
        <label>請再輸入一次密碼</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="請再輸入一次密碼" required>
      </div>
    </div>  
    
    <div class="col-12 mt-5 text-right">
      <button type="submit" class="btn btn-primary">送出</button>
      <a href="{{route('admin.report.index')}}" type="button" class="btn btn-danger" onclick="return confirm('確定要取消這次的新增嗎? 系統將不會儲存您的修改')">取消</a>
    </div>
  </div>
</form>

@endsection
