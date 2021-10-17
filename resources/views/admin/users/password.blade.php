@extends('layouts.admin')
@section('content')
<nav>
  <ol id="breadcrumbWhite" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">首頁</a></li>
    <li class="breadcrumb-item active" aria-current="page">修改密碼</li>
  </ol>
</nav>
<form method="POST" action="{{route('admin.user.password.update')}}">
  <div class="list-session col-12">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{ method_field('PATCH') }}
    <h5 class="mt-2"><i class="fas fa-edit"></i> 修改密碼</h5>
    <hr>
   
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>舊密碼</label>
        <input type="password" name="oldPassword" class="form-control" placeholder="請輸入目前的密碼" required autofocus>
        @if($errors->first('oldPassword'))
          <small class="text-danger">{{ $errors->first('oldPassword') }}</small>
        @endif
      </div>

    </div>
    
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>新密碼</label>
        <input type="password" name="password" class="form-control" placeholder="請輸入新密碼" required>
        @if ($errors->has('password'))
          <small class="text-danger">{{ $errors->first('password') }}</small>
        @else
          <small class="text-danger">密碼最少要6位數 更新成功後須重新登入</small>
        @endif
      </div>
      <div class="form-group col-md-6">
        <label>請再輸入一次新密碼</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="請再輸入一次新密碼" required>

      </div>
    </div>  
    
    <div class="col-12 mt-5 text-right">
      <button type="submit" class="btn btn-primary">送出</button>
      <a href="{{route('admin.report.index')}}" type="button" class="btn btn-danger" onclick="return confirm('確定要取消這次的新增嗎? 系統將不會儲存您的修改')">取消</a>
    </div>
  </div>
</form>

@endsection
